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
        ]);
    }


    // Pending accounts
    public function pendingAccounts(Request $request)
    {
        $status = $request->query('status', 'pending');

        $query = User::where('role', 'worker')
            ->orderBy('created_at', 'desc');

        if ($status === 'approved') {
            // Show both approved AND deactivated
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
        'first_name'  => 'required|string|max:255',
        'middle_name' => 'nullable|string|max:255',
        'last_name'   => 'required|string|max:255',
        'username'    => 'required|string|max:255|unique:users,username,' . $id,
        'email'       => 'required|email|max:255|unique:users,email,' . $id,
        'address'     => 'nullable|string|max:500',
        'city'        => 'nullable|string|max:255',
        'postal_code' => 'nullable|string|max:255',
        'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $user = User::where('role', 'client')->findOrFail($id);

    $user->first_name  = $request->first_name;
    $user->middle_name = $request->middle_name;
    $user->last_name   = $request->last_name;
    $user->username    = $request->username;
    $user->email       = $request->email;
    $user->address     = $request->address;
    $user->city        = $request->city;
    $user->postal_code = $request->postal_code;

    // Handle profile picture
    if ($request->hasFile('profile_picture')) {
        $path = $request->file('profile_picture')
                        ->store('profiles', 'public');

        $user->profile_picture = $path;
    }

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
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Announcement::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => Auth::id(), // uses your users table correctly
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

        $user->status = 'approved'; // back to approved worker
        $user->save();

        return back()->with('success', 'User activated successfully.');
    }


    


}
