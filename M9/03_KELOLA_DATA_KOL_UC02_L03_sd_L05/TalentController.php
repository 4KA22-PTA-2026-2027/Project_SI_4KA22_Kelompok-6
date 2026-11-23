<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KolProfile;
use App\Models\TalentCategory;

class TalentController extends Controller
{
    public function index(Request $request)
    {
        $category_id = $request->input('category');
        $search = $request->input('search');
        $min_followers = $request->input('min_followers');
        $max_followers = $request->input('max_followers');
        $min_rate = $request->input('min_rate');
        $max_rate = $request->input('max_rate');

        $kols = KolProfile::with('user', 'category')
            ->when($category_id, fn($q) => $q->where('talent_category_id', $category_id))
            ->when($search, function($q) use ($search) {
                $q->whereHas('user', fn($uq) => $uq->where('name', 'like', "%{$search}%"))
                  ->orWhere('bio', 'like', "%{$search}%");
            })
            ->when($min_followers, fn($q) => $q->where('followers', '>=', (int)$min_followers))
            ->when($max_followers, fn($q) => $q->where('followers', '<=', (int)$max_followers))
            ->when($min_rate, fn($q) => $q->where('rate', '>=', (float)$min_rate))
            ->when($max_rate, fn($q) => $q->where('rate', '<=', (float)$max_rate))
            ->orderBy('followers', 'desc')
            ->get();

        $categories = TalentCategory::all();
        return view('talents.index', compact('kols', 'categories', 'category_id', 'search', 'min_followers', 'max_followers', 'min_rate', 'max_rate'));
    }

    public function show($id)
    {
        $kol = KolProfile::with('user', 'category')->findOrFail($id);
        return view('talents.show', compact('kol'));
    }

    public function hire(Request $request, $id)
    {
        $request->validate([
            'campaign_title' => 'required|string|max:255',
            'platform' => 'required|string',
            'compensation' => 'required|numeric',
            'brief' => 'required|string',
            'deadline' => 'nullable|date',
        ]);

        $kol = KolProfile::findOrFail($id);

        $job = \App\Models\Job::create([
            'brand_id' => \Illuminate\Support\Facades\Auth::id(),
            'talent_category_id' => $kol->talent_category_id ?? 1,
            'title' => $request->campaign_title,
            'description' => $request->brief,
            'platform' => $request->platform,
            'compensation' => $request->compensation,
            'deadline' => $request->deadline ?? now()->addDays(14),
            'status' => 'open',
        ]);

        \App\Models\JobApplication::create([
            'job_id' => $job->id,
            'kol_id' => $kol->user_id,
            'status' => 'pending',
            'message' => 'Penawaran langsung dari ' . (\Illuminate\Support\Facades\Auth::user()->brandProfile->company_name ?? \Illuminate\Support\Facades\Auth::user()->name) . ': ' . $request->brief,
        ]);

        return back()->with('hire_success', [
            'kol_name' => $kol->user->name,
            'campaign_title' => $request->campaign_title,
            'compensation' => $request->compensation,
        ]);
    }
}
