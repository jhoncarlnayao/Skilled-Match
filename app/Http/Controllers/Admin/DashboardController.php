<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Trade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return view('admin.dashboard', [
            'totalWorkers' => User::where('role', 'worker')->count(),
            'pendingWorkers' => User::where('role', 'worker')->where('status', 'pending')->count(),
            'newWorkersThisMonth' => User::where('role', 'worker')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
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


public function getClientAccounts(Request $request)
{
    // Get status from URL (default = pending)
    $status = $request->get('status', 'active');

    // Get ONLY CLIENT accounts
    $users = User::where('role', 'client')
                ->where('status', $status)
                ->orderBy('created_at', 'desc')
                ->get();

    return view('admin.client_accounts', compact('users', 'status'));
}

    
}
