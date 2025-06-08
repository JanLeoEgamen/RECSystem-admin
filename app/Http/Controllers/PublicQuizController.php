<?php

namespace App\Http\Controllers;

use App\Mail\QuizResults;
use App\Models\Member;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\QuizQuestion;
use App\Models\QuizAttemptAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PublicQuizController extends Controller
{
    public function show($link)
    {
        $quiz = Quiz::with(['questions', 'questions.answers'])
            ->where('link', $link)
            ->firstOrFail();

        // Check if member is already logged in or needs to provide name/email
        return view('quizzes.take', compact('quiz'));
    }

    public function submit(Request $request, $link)
    {
        $quiz = Quiz::with('questions')->where('link', $link)->firstOrFail();
        
        // Validate member info if needed
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);

        // Create or find member (you might need to adjust this based on your member system)
        $member = Member::firstOrCreate(
            ['email_address' => $request->email],
            ['first_name' => $request->name, 'last_name' => '']
        );

        // Create quiz attempt
        $attempt = new QuizAttempt();
        $attempt->quiz_id = $quiz->id;
        $attempt->member_id = $member->id;
        $attempt->started_at = now();
        $attempt->save();

        // Process answers and calculate score
        $score = 0;
        
        foreach ($quiz->questions as $question) {
            $answerKey = 'question_' . $question->id;
            
            if (!$request->has($answerKey)) {
                continue;
            }
            
            $userAnswer = $request->input($answerKey);
            $pointsEarned = 0;
            
            // Check answer based on question type
            switch ($question->type) {
                case 'multiple_choice':
                    $correctAnswer = $question->answers->where('is_correct', true)->first();
                    if ($correctAnswer && $userAnswer == $correctAnswer->id) {
                        $pointsEarned = $question->points;
                    }
                    break;
                    
                case 'identification':
                    $correctAnswer = $question->answers->first();
                    if (strtolower(trim($userAnswer)) == strtolower(trim($correctAnswer->answer))) {
                        $pointsEarned = $question->points;
                    }
                    break;
                    
                case 'enumeration':
                    $correctAnswers = $question->answers->pluck('answer')->map(function($item) {
                        return strtolower(trim($item));
                    })->toArray();
                    
                    $userAnswers = is_array($userAnswer) ? $userAnswer : [$userAnswer];
                    $userAnswers = array_map(function($item) {
                        return strtolower(trim($item));
                    }, $userAnswers);
                    
                    $correctCount = count(array_intersect($userAnswers, $correctAnswers));
                    $pointsEarned = ($correctCount / count($correctAnswers)) * $question->points;
                    break;
                    
                case 'essay':
                    // Essay questions are not auto-graded
                    $pointsEarned = 0;
                    break;
            }
            
            $score += $pointsEarned;
            
            // Save attempt answer
            $attemptAnswer = new QuizAttemptAnswer();
            $attemptAnswer->attempt_id = $attempt->id;
            $attemptAnswer->question_id = $question->id;
            $attemptAnswer->answer = is_array($userAnswer) ? json_encode($userAnswer) : $userAnswer;
            $attemptAnswer->points_earned = $pointsEarned;
            $attemptAnswer->save();
        }
        
        // Update attempt with score and completion time
        $attempt->score = $score;
        $attempt->completed_at = now();
        $attempt->save();
        
        // Send results email
        Mail::to($member->email_address)->send(new QuizResults($quiz, $member, $attempt));
        
        return redirect()->route('quiz.results', $attempt->id);
    }

    public function results($attemptId)
    {
        $attempt = QuizAttempt::with([
            'quiz.questions.answers', // Need question answers for correct answers display
            'answers.question'       // Need to connect attempt answers to their questions
        ])->findOrFail($attemptId);

        return view('quizzes.results', compact('attempt'));
    }
}