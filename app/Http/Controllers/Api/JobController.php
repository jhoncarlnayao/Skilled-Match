<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Announcement;

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
    ]);

    $user->update($validated);

    return response()->json($user);
}
}