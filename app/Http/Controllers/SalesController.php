<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalesController extends Controller
{
    //
    public function markAsCompleted($saleId)
    {
        $sale = Sale::findOrFail($saleId);

        if (Auth::user()->id == $sale->userId && $sale->status == 'delivering') {
            $sale->status = 'completed';
            $sale->save();

            return redirect()->back()->with('success', 'Sale marked as completed.');
        }

        return redirect()->back()->with('error', 'You cannot update this sale.');
    }

    public function markAsDelivering($saleId)
    {
        $sale = Sale::findOrFail($saleId);

        if(Auth::user()->isAdmin() && $sale->status == 'pending'){
            $sale->status = 'delivering';
            $sale->save();

            return redirect()->back()->with('success', 'Sale marked as delivering.');
        }

        return redirect()->back()->with('error', 'You cannot update this sale.');
    }
}
