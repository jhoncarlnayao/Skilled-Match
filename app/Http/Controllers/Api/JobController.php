<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Announcement;
use Illuminate\Support\Facades\Storage;

class JobController extends Controller
{
    // ── FIND JOBS (swipe card) ────────────────────────────────
    public function workerJobs(Request $request)
    {
        $user   = $request->user();
        $worker = \App\Models\Worker::where('user_id', $user->id)->first();

        if (!$worker) {
            return response()->json(['message' => 'Worker profile not found'], 404);
        }

        $job = Job::with('client')
            ->where('trade_id', $worker->trade_id)
            ->where('status', 'open')
            ->latest()
            ->first();

        if (!$job) {
            return response()->json(null);
        }

        return response()->json([
            'id'          => $job->id,
            'title'       => $job->title,
            'description' => $job->description,
            'budget'      => $job->budget,
            'location'    => $job->location,
            'status'      => $job->status,
            'trade_id'    => $job->trade_id,
            'client_id'   => $job->client_id,
            'created_at'  => $job->created_at,
            'client_name' => $job->client
                ? trim($job->client->first_name . ' ' . $job->client->last_name)
                : 'Anonymous Client',
        ]);
    }

    // ── ACCEPT JOB ───────────────────────────────────────────
    public function acceptJob(Request $request, $id)
    {
        $user   = $request->user();
        // jobs.worker_id = workers.id (1), NOT users.id (2)
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

        $job->worker_id = $worker->id;   // workers.id = 1
        $job->status    = 'assigned';
        $job->save();

        return response()->json(['message' => 'Job accepted successfully']);
    }

    // ── MY JOBS ───────────────────────────────────────────────
    public function myJobs(Request $request)
    {
        $user   = $request->user();
        $worker = \App\Models\Worker::where('user_id', $user->id)->first();

        if (!$worker) {
            return response()->json([]);
        }

        $jobs = Job::with('client')
            ->where('worker_id', $worker->id)
            ->whereIn('status', ['assigned', 'in_progress', 'completed'])
            ->latest()
            ->get();

        return response()->json(
            $jobs->map(fn($job) => [
                'id'          => $job->id,
                'title'       => $job->title,
                'description' => $job->description,
                'budget'      => $job->budget,
                'location'    => $job->location,
                'status'      => $job->status,
                'trade_id'    => $job->trade_id,
                'client_id'   => $job->client_id,
                'created_at'  => $job->created_at,
                'completed_at'=> $job->completed_at,
                'client_name' => $job->client
                    ? trim($job->client->first_name . ' ' . $job->client->last_name)
                    : 'Unknown Client',
            ])
        );
    }

    // ── UPDATE JOB STATUS ─────────────────────────────────────
    public function updateJobStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:in_progress,completed',
        ]);

        $user   = $request->user();
        $worker = \App\Models\Worker::where('user_id', $user->id)->first();

        if (!$worker) {
            return response()->json(['message' => 'Worker not found'], 404);
        }

        $job = Job::where('id', $id)
            ->where('worker_id', $worker->id)
            ->first();

        if (!$job) {
            return response()->json(['message' => 'Job not found'], 404);
        }

        if ($job->status === 'completed') {
            return response()->json(['message' => 'Job is already completed'], 400);
        }

        $job->status = $request->status;

        if ($request->status === 'completed') {
            $job->completed_at = now();
        }

        $job->save();

        return response()->json([
            'message' => 'Job status updated',
            'job'     => $job->fresh(),
        ]);
    }

    // ── ANNOUNCEMENTS ─────────────────────────────────────────
    public function index()
    {
        $announcements = Announcement::latest()
            ->select('id', 'title', 'content', 'created_at')
            ->get();

        return response()->json($announcements);
    }

    // ── GET PROFILE ───────────────────────────────────────────
    public function getProfile(Request $request)
    {
        $user   = $request->user();
        $worker = \App\Models\Worker::with('trade')
            ->where('user_id', $user->id)
            ->first();

        return response()->json([
            'id'               => $user->id,
            'first_name'       => $user->first_name,
            'middle_name'      => $user->middle_name,
            'last_name'        => $user->last_name,
            'username'         => $user->username,
            'email'            => $user->email,
            'phone'            => $user->phone ?? $worker?->phone,
            'role'             => $user->role,
            'status'           => $user->status,
            'created_at'       => $user->created_at,
            // Full URL — React Native Image works directly with this
            'profile_picture'  => $user->profile_picture
                ? asset('storage/' . $user->profile_picture)
                : null,
            // From workers + trades join
            'trade'            => $worker?->trade?->name ?? null,
            'experience_years' => $worker?->experience_years ?? null,
        ]);
    }

    // ── UPDATE PROFILE ────────────────────────────────────────
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
            'password'    => !empty($validated['password'])
                ? bcrypt($validated['password'])
                : $user->password,
        ]);

        return $this->getProfile($request);
    }

    // ── UPDATE PROFILE PICTURE ────────────────────────────────
    public function updateProfilePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $user = $request->user();

        // Delete old file so storage doesn't pile up
        if ($user->profile_picture) {
            Storage::disk('public')->delete($user->profile_picture);
        }

        $path = $request->file('profile_picture')->store(
            'profile_pictures/' . $user->id,
            'public'
        );

        $user->update(['profile_picture' => $path]);

        return response()->json([
            'message'         => 'Profile picture updated',
            'profile_picture' => asset('storage/' . $path),
        ]);
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

    // ── WORKER COMPLAINTS ─────────────────────────────────────────────

    /**
     * List all complaints filed by this worker.
     */
    public function myComplaints(Request $request)
    {
      $user = $request->user();

if (!$user) {
    return response()->json(['message' => 'Unauthenticated'], 401);
}

$worker = \App\Models\Worker::where('user_id', $user->id)->first();
        if (!$worker) return response()->json(['complaints' => []]);

        $complaints = \App\Models\Complaint::where('worker_id', $worker->id)
            ->latest()
            ->get()
            ->map(fn($c) => [
                'id'          => $c->id,
                'fullname'    => $c->fullname,
                'reason'      => $c->reason,
                'subject'     => $c->subject,
                'description' => $c->description,
                'status'      => $c->status,
                'admin_notes' => $c->admin_notes,
                'created_at'  => $c->created_at->toDateString(),
            ]);

        return response()->json(['complaints' => $complaints]);
    }

    /**
     * Worker files a new complaint against a client.
     */
    public function storeWorkerComplaint(Request $request)
    {
        $request->validate([
            'client_name' => 'required|string|max:255',
            'reason'      => 'required|in:non_payment,false_info,harassment,unsafe_condition,scope_creep,other',
            'subject'     => 'required|string|max:120',
            'description' => 'required|string|max:1000',
            'screenshot'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

    $user = $request->user();

if (!$user) {
    return response()->json(['message' => 'Unauthenticated'], 401);
}

$worker = \App\Models\Worker::where('user_id', $user->id)->first();
        if (!$worker) return response()->json(['message' => 'Worker profile not found.'], 403);

        $screenshotPath = null;
        if ($request->hasFile('screenshot')) {
            $screenshotPath = $request->file('screenshot')->store('complaints', 'public');
        }

        \App\Models\Complaint::create([
            'client_id'  => null,
            'worker_id'  => $worker->id,
            'fullname'   => $request->client_name,
            'filed_by'   => 'worker',
            'reason'     => $request->reason,
            'subject'    => $request->subject,
            'description'=> $request->description,
            'screenshot' => $screenshotPath,
            'status'     => 'pending',
        ]);

        return response()->json(['message' => 'Complaint submitted successfully.']);
    }
}