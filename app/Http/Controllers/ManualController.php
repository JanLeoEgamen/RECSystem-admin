<?php

namespace App\Http\Controllers;

use App\Models\ManualContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ManualController extends Controller
{
    /**
     * Display the manual view page (public view for users)
     */
    public function view()
    {
        $tutorialVideos = ManualContent::active()
            ->byType(ManualContent::TYPE_TUTORIAL_VIDEO)
            ->ordered()
            ->get();

        $faqs = ManualContent::active()
            ->byType(ManualContent::TYPE_FAQ)
            ->ordered()
            ->get();

        $userGuides = ManualContent::active()
            ->byType(ManualContent::TYPE_USER_GUIDE)
            ->ordered()
            ->get();

        $supportContacts = ManualContent::active()
            ->byType(ManualContent::TYPE_SUPPORT)
            ->ordered()
            ->get();

        return view('manual.view', compact('tutorialVideos', 'faqs', 'userGuides', 'supportContacts'));
    }

    /**
     * Display the manual management list (admin list page)
     */
    public function index(Request $request)
    {
        $query = ManualContent::query();

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Filter by type
        if ($request->has('type') && !empty($request->type)) {
            $query->byType($request->type);
        }

        // Sorting
        $sortBy = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');
        $query->orderBy($sortBy, $direction);

        $perPage = $request->get('perPage', 10);
        $manualContents = $query->paginate($perPage);

        if ($request->ajax()) {
            return response()->json([
                'data' => $manualContents->items(),
                'current_page' => $manualContents->currentPage(),
                'last_page' => $manualContents->lastPage(),
                'per_page' => $manualContents->perPage(),
                'total' => $manualContents->total(),
                'from' => $manualContents->firstItem(),
                'to' => $manualContents->lastItem()
            ]);
        }

        return view('manual.list', compact('manualContents'));
    }

    /**
     * Show the form for creating a new manual content
     */
    public function create()
    {
        $types = ManualContent::getTypes();
        return view('manual.create', compact('types'));
    }

    /**
     * Store a newly created manual content
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:tutorial_video,faq,user_guide,support',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0'
        ];

        // Add type-specific validation
        switch ($request->type) {
            case 'tutorial_video':
                $rules['video_url'] = 'required|url';
                break;
            case 'faq':
                $rules['content'] = 'required|string';
                break;
            case 'user_guide':
                $rules['steps'] = 'required|array|min:1';
                $rules['steps.*'] = 'required|string';
                break;
            case 'support':
                $rules['contact_email'] = 'required|email';
                $rules['contact_phone'] = 'nullable|string';
                $rules['contact_hours'] = 'nullable|string';
                break;
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->only([
            'title', 'description', 'type', 'content', 'video_url',
            'contact_email', 'contact_phone', 'contact_hours', 'is_active', 'sort_order'
        ]);

        if ($request->type === 'user_guide' && $request->has('steps')) {
            $data['steps'] = array_filter($request->steps);
        }

        $data['is_active'] = $request->has('is_active') ? true : false;
        $data['sort_order'] = $request->sort_order ?? 0;

        ManualContent::create($data);

        return redirect()->route('manual.index')
            ->with('success', 'Manual content created successfully.');
    }

    /**
     * Show the form for editing manual content
     */
    public function edit(ManualContent $manual)
    {
        $types = ManualContent::getTypes();
        return view('manual.edit', compact('manual', 'types'));
    }

    /**
     * Update the specified manual content
     */
    public function update(Request $request, ManualContent $manual)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:tutorial_video,faq,user_guide,support',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0'
        ];

        // Add type-specific validation
        switch ($request->type) {
            case 'tutorial_video':
                $rules['video_url'] = 'required|url';
                break;
            case 'faq':
                $rules['content'] = 'required|string';
                break;
            case 'user_guide':
                $rules['steps'] = 'required|array|min:1';
                $rules['steps.*'] = 'required|string';
                break;
            case 'support':
                $rules['contact_email'] = 'required|email';
                $rules['contact_phone'] = 'nullable|string';
                $rules['contact_hours'] = 'nullable|string';
                break;
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->only([
            'title', 'description', 'type', 'content', 'video_url',
            'contact_email', 'contact_phone', 'contact_hours', 'is_active', 'sort_order'
        ]);

        if ($request->type === 'user_guide' && $request->has('steps')) {
            $data['steps'] = array_filter($request->steps);
        }

        $data['is_active'] = $request->has('is_active') ? true : false;
        $data['sort_order'] = $request->sort_order ?? 0;

        $manual->update($data);

        return redirect()->route('manual.index')
            ->with('success', 'Manual content updated successfully.');
    }

    /**
     * Remove the specified manual content
     */
    public function destroy(Request $request)
    {
        try {
            $manual = ManualContent::findOrFail($request->id);
            $manual->delete();

            return response()->json([
                'status' => true,
                'message' => 'Manual content deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error deleting manual content: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Search FAQ items (for public search)
     */
    public function searchFaq(Request $request)
    {
        $query = $request->get('query');
        
        $faqs = ManualContent::active()
            ->byType(ManualContent::TYPE_FAQ)
            ->where(function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('content', 'like', "%{$query}%");
            })
            ->ordered()
            ->get();

        return response()->json($faqs);
    }
}