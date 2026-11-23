<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\KolProfile;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalKols = User::where('role', 'kol')->count();
        $totalBrands = User::where('role', 'brand')->count();
        $totalJobs = Job::count();
        $totalApplications = JobApplication::count();
        $pendingApplications = JobApplication::where('status', 'pending')->count();
        $recentJobs = Job::with('brand', 'category')->latest()->take(5)->get();
        $recentApplications = JobApplication::with('job.brand', 'kol')->latest()->take(5)->get();
        $categories = \App\Models\TalentCategory::all();
        $brands = User::where('role', 'brand')->get();
        return view('admin.dashboard', compact('totalKols', 'totalBrands', 'totalJobs', 'totalApplications', 'pendingApplications', 'recentJobs', 'recentApplications', 'categories', 'brands'));
    }

    public function jobs()
    {
        $jobs = Job::with('brand', 'category', 'applications')->latest()->get();
        $categories = \App\Models\TalentCategory::all();
        $brands = User::where('role', 'brand')->get();
        return view('admin.jobs', compact('jobs', 'categories', 'brands'));
    }

    public function createJob()
    {
        $categories = \App\Models\TalentCategory::all();
        $brands = User::where('role', 'brand')->get();
        return view('admin.create-job', compact('categories', 'brands'));
    }

    public function notifications()
    {
        $pendingApplications = JobApplication::with('job.brand', 'kol.kolProfile')->where('status', 'pending')->latest()->get();
        $recentKols = User::where('role', 'kol')->with('kolProfile')->latest()->take(5)->get();
        $recentJobs = Job::with('brand')->latest()->take(5)->get();
        return view('admin.notifications', compact('pendingApplications', 'recentKols', 'recentJobs'));
    }

    public function storeJob(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'brand_id' => 'required|exists:users,id',
            'talent_category_id' => 'required|exists:talent_categories,id',
            'description' => 'required|string',
            'platform' => 'required|string',
            'compensation' => 'required|numeric',
            'deadline' => 'nullable|date',
        ]);

        Job::create([
            'brand_id' => $request->brand_id,
            'talent_category_id' => $request->talent_category_id,
            'title' => $request->title,
            'description' => $request->description,
            'platform' => $request->platform,
            'compensation' => $request->compensation,
            'deadline' => $request->deadline ?? now()->addDays(14),
            'status' => 'open',
        ]);

        return back()->with('success', 'Job baru berhasil ditambahkan.');
    }

    public function requests()
    {
        $applications = JobApplication::with('job.brand', 'kol.kolProfile')->latest()->get();
        return view('admin.requests', compact('applications'));
    }

    public function showKol($id)
    {
        $kol = KolProfile::with('user', 'category')->findOrFail($id);
        $applications = JobApplication::where('kol_id', $kol->user_id)->with('job')->latest()->get();
        return view('admin.kol-detail', compact('kol', 'applications'));
    }

    public function updateJobStatus(Request $request, $id)
    {
        $job = Job::findOrFail($id);
        $request->validate(['status' => 'required|in:open,closed,completed']);
        $job->update(['status' => $request->status]);
        return back()->with('success', 'Status job berhasil diperbarui.');
    }

    public function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function kols()
    {
        $kols = KolProfile::with('user', 'category')->get();
        return view('admin.kols', compact('kols'));
    }

    public function brands()
    {
        $brands = User::where('role', 'brand')->with('brandProfile')->get();
        return view('admin.brands', compact('brands'));
    }

    public function updateApplicationStatus(Request $request, $id)
    {
        $application = JobApplication::findOrFail($id);
        $request->validate(['status' => 'required|in:pending,accepted,rejected']);
        $application->update(['status' => $request->status]);
        return back()->with('success', 'Status lamaran berhasil diperbarui.');
    }
}
