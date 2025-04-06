<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    //
    public function markAsCompleted($saleId)
    {
        $sale = Sale::findOrFail($saleId);

        if (auth()->user()->id == $sale->userId && $sale->status == 'delivering') {
            $sale->status = 'completed';
            $sale->save();

            return redirect()->back()->with('success', 'Sale marked as completed.');
        }

        return redirect()->back()->with('error', 'You cannot update this sale.');
    }
}
