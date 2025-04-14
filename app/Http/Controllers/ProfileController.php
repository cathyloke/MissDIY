<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Sale;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.show');
    }

    public function edit()
    {
        return view('profile.edit');
    }

    public function update(Request $request)
    {
        $user = User::find(Auth::id());

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'contact_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'gender' => 'nullable|in:male,female,other',
        ]);

        $user->update($validated);

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
    }

    public function orders()
    {
        $user = Auth::user();

        if($user->isCustomer()){
            $orders = $user->sales()->latest()->get()->filter(fn($order)=>$user->can('view', $order));
            // $orders = $user->sales()->latest()->get();
            // return $orders;
            return view('profile.orders', compact('orders'));
        }

        $this->authorize('viewAny', Sale::class);
        $pendingOrders = Sale::where('status', 'pending')->latest()->get();
        $deliveringOrders = Sale::where('status', 'delivering')->latest()->get();
        $completedOrders = Sale::where('status', 'completed')->latest()->get();

        return view('profile.orders', compact('pendingOrders', 'deliveringOrders', 'completedOrders'));
    }
}
