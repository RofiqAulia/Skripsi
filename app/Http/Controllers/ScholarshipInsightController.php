<?php

namespace App\Http\Controllers;

use App\Models\ScholarshipInsight;
use Illuminate\Http\Request;

class ScholarshipInsightController extends Controller
{
    /**
     * Listing page — all published insights, paginated, filterable by category.
     */
    public function index(Request $request)
    {
        $category = $request->query('category');

        $insights = ScholarshipInsight::published()
            ->when($category, fn ($q) => $q->where('category', $category))
            ->paginate(9)
            ->withQueryString();

        $categories = ScholarshipInsight::CATEGORIES;

        return view('landing.insights.index', compact('insights', 'categories', 'category'));
    }

    /**
     * Detail page — single article by slug.
     */
    public function show(string $slug)
    {
        $insight = ScholarshipInsight::published()
            ->where('slug', $slug)
            ->firstOrFail();

        // Related: same category, excluding current
        $related = ScholarshipInsight::published()
            ->where('category', $insight->category)
            ->where('id', '!=', $insight->id)
            ->limit(3)
            ->get();

        return view('landing.insights.show', compact('insight', 'related'));
    }
}
