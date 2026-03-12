<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Trade;
use Illuminate\Http\Request;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;
use App\Models\Complaint;
use App\Models\Announcement;

class DashboardController extends Controller
{
    // Enforce authentication on all admin functions
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Admin dashboard
    public function index()
    {
        $today = now()->toDateString();

        $activeJobs = Job::where('status', '!=', 'completed')->count();

        return view('admin.dashboard', [
            'totalWorkers' => User::where('role', 'worker')
                ->where('status', 'approved')
                ->count(),
            'pendingWorkers' => User::where('role', 'worker')->where('status', 'pending')->count(),
            'newWorkersThisMonth' => User::where('role', 'worker')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
            'totalClients' => User::where('role', 'client')->count(),
            'newClientsThisMonth' => User::where('role', 'client')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
            'newAccountsToday' => User::whereDate('created_at', $today)
                ->orderBy('created_at', 'desc')
                ->get(),
            'newJobsToday' => Job::with(['client', 'trade'])
                ->whereDate('created_at', $today)
                ->latest()
                ->get(),
            'announcements' => Announcement::latest()->get(),
            'activeJobs' => $activeJobs,
        ]);
    }

    // Pending accounts
    public function pendingAccounts(Request $request)
    {
        $status = $request->query('status', 'pending');

        $query = User::where('role', 'worker')
            ->orderBy('created_at', 'desc');

        if ($status === 'approved') {
            $query->whereIn('status', ['approved', 'deactivate']);
        } else {
            $query->where('status', $status);
        }

        $users = $query->get();

        return view('admin.pending_accounts', compact('users', 'status'));
    }

    public function approve($id)
    {
        $user = User::where('id', $id)->where('role', 'worker')->where('status', 'pending')->firstOrFail();
        $user->status = 'approved';
        $user->save();

        return redirect()->route('admin.pending.accounts')->with('success', 'Worker approved successfully.');
    }

    public function reject($id)
    {
        User::where('id', $id)->delete();
        return redirect()->route('admin.pending.accounts')->with('success', 'User rejected successfully.');
    }

    // Trades list
    public function trades()
    {
        $trades = Trade::orderBy('name')->get();
        return view('admin.trade_list', compact('trades'));
    }

    public function storeTrade(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Trade::create([
            'name'        => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.trades')->with('success', 'Trade added successfully!');
    }

    public function deleteTrade($id)
    {
        Trade::findOrFail($id)->delete();
        return redirect()->route('admin.trades')->with('success', 'Trade deleted successfully!');
    }

    public function updateTrade(Request $request, $id)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $trade = Trade::findOrFail($id);
        $trade->name        = $request->name;
        $trade->description = $request->description;
        $trade->save();

        return redirect()->back()->with('success', 'Trade updated successfully!');
    }

    public function getClientAccounts()
    {
        $users = User::where('role', 'client')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.client_accounts', compact('users'));
    }

    public function toggleClientStatus($id)
    {
        $user = User::where('role', 'client')->findOrFail($id);
        $user->status = $user->status === 'active' ? 'deactivate' : 'active';
        $user->save();

        return back()->with('success', 'Client status updated successfully.');
    }

    public function ShowJobs()
    {
        return view('admin.jobs_list', [
            'totalWorkers' => User::where('role', 'worker')->count(),
            'pendingWorkers' => User::where('role', 'worker')->where('status', 'pending')->count(),
            'newWorkersThisMonth' => User::where('role', 'worker')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
            'totalClients' => User::where('role', 'client')->count(),
            'newClientsThisMonth' => User::where('role', 'client')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
            'jobs'   => Job::with(['client', 'trade'])->latest()->get(),
            'trades' => Trade::orderBy('name')->get(),
        ]);
    }

    public function storeAnnouncement(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Announcement::create([
            'title'   => $request->title,
            'content' => $request->content,
            'user_id' => Auth::id(),
        ]);

        return back()->with('success', 'Announcement posted successfully.');
    }

    public function deactivate($id)
    {
        $user = User::findOrFail($id);

        if (strtolower($user->status) !== 'approved') {
            return back()->with('error', 'Only approved users can be deactivated.');
        }

        $user->status = 'deactivate';
        $user->save();

        return back()->with('success', 'User deactivated successfully.');
    }

    public function activate($id)
    {
        $user = User::findOrFail($id);

        if ($user->status !== 'deactivate') {
            return back()->with('error', 'Only deactivated users can be activated.');
        }

        $user->status = 'approved';
        $user->save();

        return back()->with('success', 'User activated successfully.');
    }

    public function updateWorker(Request $request, $id)
    {
        $user = User::where('role', 'worker')->findOrFail($id);

        $request->validate([
            'first_name'      => 'required|string|max:255',
            'middle_name'     => 'nullable|string|max:255',
            'last_name'       => 'required|string|max:255',
            'username'        => 'required|string|max:255',
            'email'           => 'required|email|max:255',
            'address'         => 'nullable|string|max:255',
            'city'            => 'nullable|string|max:255',
            'postal_code'     => 'nullable|string|max:50',
            'profile_picture' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('profile_picture')) {
            $user->profile_picture = $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        $user->update([
            'first_name'  => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name'   => $request->last_name,
            'username'    => $request->username,
            'email'       => $request->email,
            'address'     => $request->address,
            'city'        => $request->city,
            'postal_code' => $request->postal_code,
        ]);

        return back()->with('success', 'Worker updated successfully.');
    }

    public function updateClient(Request $request, $id)
    {
        $user = User::where('role', 'client')->findOrFail($id);

        $request->validate([
            'first_name'      => 'required|string|max:255',
            'middle_name'     => 'nullable|string|max:255',
            'last_name'       => 'required|string|max:255',
            'username'        => 'required|string|max:255',
            'email'           => 'required|email|max:255',
            'address'         => 'nullable|string|max:255',
            'city'            => 'nullable|string|max:255',
            'postal_code'     => 'nullable|string|max:50',
            'profile_picture' => 'nullable|image|max:2048',
            'status'          => 'required|in:active,deactivate,pending',
        ]);

        if ($request->hasFile('profile_picture')) {
            $user->profile_picture = $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        $user->update([
            'first_name'  => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name'   => $request->last_name,
            'username'    => $request->username,
            'email'       => $request->email,
            'address'     => $request->address,
            'city'        => $request->city,
            'postal_code' => $request->postal_code,
            'status'      => $request->status,
        ]);

        return back()->with('success', 'Client updated successfully.');
    }

    public function updateJob(Request $request, $id)
    {
        $job = Job::findOrFail($id);

        if ($job->status === 'completed' && $request->remove_worker == 1) {
            return redirect()->back()->with('error', 'Cannot remove worker from a completed job.');
        }

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'budget'      => 'required|numeric',
            'trade_id'    => 'required|exists:trades,id',
            'status'      => 'required|in:open,assigned,completed',
        ]);

        $job->title       = $request->title;
        $job->description = $request->description;
        $job->budget      = $request->budget;
        $job->trade_id    = $request->trade_id;
        $job->status      = $request->status;

        if ($request->remove_worker == 1 && $job->status !== 'completed') {
            $job->worker_id = null;
            $job->status    = 'open';
        }

        $job->save();

        return redirect()->back()->with('success', 'Job updated successfully.');
    }

    public function deleteJob($id)
    {
        $job = Job::findOrFail($id);

        if (in_array($job->status, ['assigned', 'completed'])) {
            return back()->with('error', 'Cannot delete assigned or completed jobs.');
        }

        $job->delete();

        return back()->with('success', 'Job deleted successfully.');
    }

    // ── COMPLAINTS ────────────────────────────────────────────────────

    public function complaints(Request $request)
    {
        $status = $request->query('status', 'all');

        /*
         * IMPORTANT: eager-load worker.user so that when filed_by = 'worker'
         * the blade can access $complaint->worker->user->first_name etc.
         * Without 'worker.user' the worker filer name will always be blank.
         */
        $query = Complaint::with(['client', 'worker.user'])->latest();

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $complaints   = $query->paginate(15);
        $pendingCount = Complaint::where('status', 'pending')->count();

        return view('admin.complaints', [
            'complaints'   => $complaints,
            'pendingCount' => $pendingCount,
            'status'       => $status,
        ]);
    }

    public function updateComplaint(Request $request, $id)
    {
        $complaint = Complaint::findOrFail($id);

        $request->validate([
            'status'      => 'required|in:pending,reviewed,resolved,dismissed',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $complaint->update([
            'status'      => $request->status,
            'admin_notes' => $request->admin_notes,
        ]);

        return back()->with('success', 'Complaint updated successfully.');
    }

    public function deleteComplaint($id)
    {
        Complaint::findOrFail($id)->delete();
        return back()->with('success', 'Complaint deleted.');
    }
}