<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Trade;
use Illuminate\Http\Request;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;
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

    return view('admin.dashboard', [
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

        // ✅ NEW ACCOUNTS TODAY
        'newAccountsToday' => User::whereDate('created_at', $today)
            ->orderBy('created_at', 'desc')
            ->get(),

        // ✅ NEW JOBS TODAY
        'newJobsToday' => Job::with(['client', 'trade'])
            ->whereDate('created_at', $today)
            ->latest()
            ->get(),
    ]);
}


    // Pending accounts
    public function pendingAccounts(Request $request)
    {
        $status = $request->query('status', 'pending');
        $users = User::where('status', $status)->orderBy('created_at', 'desc')->get();
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

    // Store new trade
    public function storeTrade(Request $request)
    {
    

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Trade::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.trades')->with('success', 'Trade added successfully!');
    }

    // Delete trade
    public function deleteTrade($id)
{
    $trade = Trade::findOrFail($id);
    $trade->delete();

    return redirect()->route('admin.trades')
        ->with('success', 'Trade deleted successfully!');
}

    // Update trade
    public function updateTrade(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $trade = Trade::findOrFail($id);
        $trade->name = $request->name;
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

    if ($user->status === 'active') {
        $user->status = 'deactivate';
    } else {
        $user->status = 'active';
    }

    $user->save();

    return back()->with('success', 'Client status updated successfully.');
}


public function updateClient(Request $request, $id)
{
    $request->validate([
        'name'   => 'required|string|max:255',
        'email'  => 'required|email|max:255|unique:users,email,' . $id,
        'status' => 'required|in:active,deactivate',

    ]);

    $user = User::where('role', 'client')->findOrFail($id);

    $user->name   = $request->name;
    $user->email  = $request->email;
    $user->status = $request->status;

    $user->save();

    return back()->with('success', 'Client updated successfully.');
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

        'jobs' => Job::with(['client', 'trade'])->latest()->get(),

        // ✅ Pass all trades for the edit modal dropdown
        'trades' => Trade::orderBy('name')->get(),
    ]);
}

public function storeAnnouncement(Request $request)
{
    // Only allow admins
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
        'user_id' => Auth::id(), // uses your users table correctly
    ]);

    return back()->with('success', 'Announcement posted successfully.');
}
    
}
