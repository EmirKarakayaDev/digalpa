<?php

namespace App\Http\Controllers;

use App\Models\FinderNode;
use App\Models\Segment;
use Illuminate\Http\Request;

class FinderController extends Controller
{
    public function index(Request $request)
    {
        $segments = Segment::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $activeSegment = $request->filled('segment')
            ? $segments->firstWhere('slug', $request->query('segment'))
            : null;

        $rootNodes = FinderNode::where('depth', 1)
            ->where('is_active', true)
            ->when($activeSegment, fn ($q) => $q->where('segment_id', $activeSegment->id))
            ->orderBy('sort_order')
            ->with('segment')
            ->get();

        return view('finder.index', compact('segments', 'rootNodes', 'activeSegment'));
    }

    public function step(string $slug)
    {
        $node = FinderNode::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        if ($node->isLeaf()) {
            $products = $node->products()
                ->where('is_active', true)
                ->orderByPivot('sort_order')
                ->get();

            return view('finder.result', compact('node', 'products'));
        }

        $children = FinderNode::where('parent_id', $node->id)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $breadcrumb = $this->buildBreadcrumb($node);

        return view('finder.step', compact('node', 'children', 'breadcrumb'));
    }

    private function buildBreadcrumb(FinderNode $node): array
    {
        $crumbs = [];
        $current = $node;

        while ($current) {
            array_unshift($crumbs, $current);
            $current = $current->parent;
        }

        return $crumbs;
    }
}
