<?php

namespace App\Http\Controllers;

use App\Models\ReferenceProject;
use App\Models\Segment;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $segments = Segment::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $segmentSlug = $request->query('segment');
        $activeSource = $request->query('kaynak'); // 'digalpa' | 'akemi' | null = tümü
        $activeSegment = null;

        $query = ReferenceProject::where('is_active', true)
            ->with('segment')
            ->orderBy('sort_order');

        if ($segmentSlug) {
            $activeSegment = Segment::where('slug', $segmentSlug)->first();
            if ($activeSegment) {
                $query->where('segment_id', $activeSegment->id);
            }
        }

        if ($activeSource) {
            $query->where('source', $activeSource);
        }

        $projects = $query->paginate(12)->withQueryString();

        return view('projects.index', compact('segments', 'projects', 'activeSegment', 'activeSource'));
    }

    public function show(string $slug)
    {
        $project = ReferenceProject::where('slug', $slug)
            ->where('is_active', true)
            ->with('segment')
            ->firstOrFail();

        return view('projects.show', compact('project'));
    }
}
