<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizAnswer;
use App\Models\QuizResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\QuizCompletionConfirmation;

class MemberQuizController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(['auth', 'verified', 'role:Member']),
        ];
    }

    public function quizzes()
    {
        $member = auth()->user()->member;
        $quizzes = $member->quizzes()
            ->where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('member.quizzes', compact('quizzes'));
    }

    public function takeQuiz($id)
    {
        $quiz = Quiz::with('questions')->findOrFail($id);
        
        if (!$quiz->is_published) {
            abort(404);
        }
        
        return view('member.take-quiz', compact('quiz'));
    }

    public function submitQuiz(Request $request, $id)
    {
        $quiz = Quiz::with('questions')->findOrFail($id);
        $member = auth()->user()->member;
        $user = auth()->user();
        
        // Check if already submitted
        if ($quiz->responses()->where('member_id', $member->id)->exists()) {
            logQuizSurveyActivity(
                $member,
                'quiz',
                $quiz,
                'duplicate_attempt',
                "Attempted to submit quiz {$quiz->id} again"
            );
            
            return redirect()->route('member.quizzes')
                ->with('error', 'You have already submitted this quiz.');
        }
        
        // Validate answers
        $rules = [];
        foreach ($quiz->questions as $question) {
            $rules["answers.{$question->id}"] = 'required';
            if ($question->type === 'checkbox') {
                $rules["answers.{$question->id}"] = 'array';
                $rules["answers.{$question->id}.*"] = 'in:'.implode(',', $question->options);
            } elseif ($question->type === 'multiple-choice') {
                $rules["answers.{$question->id}"] = 'in:'.implode(',', $question->options);
            } elseif ($question->type === 'true-false') {
                $rules["answers.{$question->id}"] = 'in:true,false';
            }
        }
        
        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            logQuizSurveyActivity(
                $member,
                'quiz',
                $quiz,
                'validation_failed',
                "Failed validation for quiz {$quiz->id}",
                ['errors' => $validator->errors()->all()]
            );
            
            return redirect()->route('member.take-quiz', $id)
                ->withErrors($validator)
                ->withInput();
        }
        
        // Create response
        $response = QuizResponse::create([
            'quiz_id' => $quiz->id,
            'member_id' => $member->id,
            'total_score' => 0,
        ]);
        
        $totalScore = 0;
        
        // Save answers and calculate score
        foreach ($quiz->questions as $question) {
            $answer = $request->input("answers.{$question->id}");
            $isCorrect = false;
            $score = 0;
            
            // Check if answer is correct
            if ($question->type === 'checkbox') {
                $correctAnswers = $question->correct_answers ?? [];
                $userAnswers = is_array($answer) ? $answer : [];
                sort($correctAnswers);
                sort($userAnswers);
                $isCorrect = $correctAnswers == $userAnswers;
            } else {
                $correctAnswer = $question->correct_answers[0] ?? null;
                $isCorrect = strtolower(trim($answer)) == strtolower(trim($correctAnswer));
            }
            
            if ($isCorrect) {
                $score = $question->points;
                $totalScore += $score;
            }
            
            if ($question->type === 'checkbox' && is_array($answer)) {
                $answer = json_encode($answer);
            }
            
            QuizAnswer::create([
                'response_id' => $response->id,
                'question_id' => $question->id,
                'answer' => $answer,
                'score' => $score,
                'is_correct' => $isCorrect,
            ]);
        }
        
        // Update total score
        $response->update(['total_score' => $totalScore]);
        
        $scorePercentage = ($totalScore / $quiz->questions->sum('points')) * 100;
        
        /***** CRITICAL LOGGING *****/
        logQuizSurveyActivity(
            $member,
            'quiz',
            $quiz,
            'completed',
            "Quiz completed with score: {$totalScore}/{$quiz->questions->sum('points')} ({$scorePercentage}%)",
            [
                'score' => $totalScore,
                'total_possible' => $quiz->questions->sum('points'),
                'percentage' => $scorePercentage,
                'response_id' => $response->id
            ]
        );
        
        /***** EMAIL CONFIRMATION *****/
        Mail::to($user->email)->send(new QuizCompletionConfirmation(
            $user->name ?? $user->email ?? 'Member',
            $quiz->title,
            $totalScore,
            $quiz->questions->sum('points'),
            $scorePercentage,
            now()->format('F j, Y g:i a'),
            route('member.quiz-result', $response->id)
        ));
        
        return redirect()->route('member.quiz-result', $response->id);
    }

    public function quizResult($id)
    {
        $response = QuizResponse::with(['quiz.questions', 'answers.question'])->findOrFail($id);
        
        if ($response->member_id !== auth()->user()->member->id) {
            abort(403);
        }
        
        return view('member.quiz-result', compact('response'));
    }
}
