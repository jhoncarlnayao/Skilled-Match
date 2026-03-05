<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Announcement;
use Illuminate\Support\Facades\Storage;


class JobController extends Controller
{
   public function workerJobs(Request $request)
{
    $user = $request->user();

    $worker = \App\Models\Worker::where('user_id', $user->id)->first();

    if (!$worker) {
        return response()->json(['message' => 'Worker profile not found'], 404);
    }

    $job = Job::where('trade_id', $worker->trade_id)
        ->where('status', 'open')
        ->latest()
        ->first();

    return response()->json($job);
}


public function acceptJob(Request $request, $id)
{
    $user = $request->user();
    $worker = \App\Models\Worker::where('user_id', $user->id)->first();

    if (!$worker) {
        return response()->json(['message' => 'Worker not found'], 404);
    }

    $job = Job::where('id', $id)
        ->where('status', 'open')
        ->first();

    if (!$job) {
        return response()->json(['message' => 'Job not available'], 400);
    }

    $job->worker_id = $worker->id;
    $job->status = 'assigned';
    $job->save();

    return response()->json(['message' => 'Job accepted successfully']);
}

  public function index()
    {
        $announcements = Announcement::latest()
            ->select('id', 'title', 'content', 'created_at')
            ->get();

        return response()->json($announcements);
    }

public function myJobs(Request $request)
{
    $user = $request->user();

    $worker = \App\Models\Worker::where('user_id', $user->id)->first();

    if (!$worker) {
        return response()->json([]);
    }

    $jobs = \App\Models\Job::where('worker_id', $worker->id)
        ->whereIn('status', ['assigned', 'completed'])
        ->latest()
        ->get();

    return response()->json($jobs);
}

public function updateProfile(Request $request)
{
    $user = $request->user();

    $validated = $request->validate([
        'first_name'  => 'required|string|max:255',
        'middle_name' => 'nullable|string|max:255',
        'last_name'   => 'required|string|max:255',
        'email'       => 'required|email|unique:users,email,' . $user->id,
        'phone'       => 'nullable|string|max:20',
        'username'    => 'nullable|string|max:255|unique:users,username,' . $user->id,
        'password'    => 'nullable|string|min:8|confirmed',

    ]);

    $user->update([
        'first_name'  => $validated['first_name'],
        'middle_name' => $validated['middle_name'] ?? null,
        'last_name'   => $validated['last_name'],
        'email'       => $validated['email'],
        'phone'       => $validated['phone'] ?? null,
        'username'    => $validated['username'] ?? null,
        'password'    => !empty($validated['password']) ? bcrypt($validated['password']) : $user->password,
    ]);

    return response()->json($user->fresh());
}


 // ── UPDATE PROFILE PICTURE ────────────────────────────────
public function updateProfilePicture(Request $request)
{
    $request->validate([
        'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $worker = $request->user();

    // Delete old picture if exists
    if ($worker->profile_picture) {
        $oldPath = str_replace(asset('storage') . '/', '', $worker->profile_picture);
        Storage::disk('public')->delete($oldPath);
    }

    // Store new picture
    $path = $request->file('profile_picture')->store('profile_pictures', 'public');
    $url = asset('storage/' . $path);

    $worker->update(['profile_picture' => $url]);

    return response()->json(['profile_picture' => $url]);
}

    // ── EARNINGS ─────────────────────────────────────────────
    public function getEarnings(Request $request)
    {
        $user   = $request->user();
        $worker = \App\Models\Worker::where('user_id', $user->id)->first();

        if (!$worker) {
            return response()->json(['total' => 0, 'monthly' => 0, 'weekly' => 0, 'jobs_count' => 0]);
        }

        $completedJobs = Job::where('worker_id', $worker->id)
            ->where('status', 'completed')
            ->get();

        $now     = now();
        $total   = $completedJobs->sum('budget');

        $monthly = $completedJobs
            ->filter(fn($j) => $j->completed_at
                && $j->completed_at->month === $now->month
                && $j->completed_at->year  === $now->year)
            ->sum('budget');

        $weekly = $completedJobs
            ->filter(fn($j) => $j->completed_at
                && $j->completed_at->greaterThanOrEqualTo($now->copy()->subDays(7)))
            ->sum('budget');

        return response()->json([
            'total'      => (float) $total,
            'monthly'    => (float) $monthly,
            'weekly'     => (float) $weekly,
            'jobs_count' => $completedJobs->count(),
        ]);
    }
}