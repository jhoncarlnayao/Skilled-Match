<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Trade;


class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalWorkers' => User::where('role', 'worker')->count(),

            'pendingWorkers' => User::where('role', 'worker')
                ->where('status', 'pending')
                ->count(),

            'newWorkersThisMonth' => User::where('role', 'worker')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
        ]);
    }

    // ✅ PENDING ACCOUNTS PAGE
    public function pendingAccounts(Request $request)
{
    $status = $request->query('status', 'pending'); // default = pending

    $users = User::where('status', $status)
        ->orderBy('created_at', 'desc')
        ->get();

    return view('admin.pending_accounts', compact('users', 'status'));
}

    // ✅ APPROVE
    public function approve($id)
    {
        User::where('id', $id)->update(['status' => 'approved']);
        return back()->with('success', 'User approved successfully.');
    }

    // ✅ REJECT
    public function reject($id)
    {
        User::where('id', $id)->delete();
        return back()->with('success', 'User rejected.');
    }



    public function trades()
{
    $trades = Trade::orderBy('name')->get();

    return view('admin.trade_list', compact('trades'));
}

public function storeTrade(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
    ]);

    Trade::create([
        'name' => $request->name,
        'description' => $request->description ?? '',
    ]);

    return redirect()->back()->with('success', 'Trade added successfully!');
}

 public function updateTrade(Request $request, $id)
    {
        // Validate input
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Find the trade by ID
        $trade = Trade::findOrFail($id);

        // Update trade fields
        $trade->name = $request->name;
        $trade->description = $request->description;
        $trade->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'Trade updated successfully!');
    }


}
