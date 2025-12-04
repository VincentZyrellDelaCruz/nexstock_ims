<?php

namespace App\Http\Controllers;

use App\Models\Pending;
use App\Models\Defect;
use App\Models\RestockConfirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendingController extends Controller
{
    public function index()
    {
        if (Auth::user()->role !== 'admin') {
            return redirect('/dashboard')->with('error', 'Unauthorized');
        }

        $pendings = Pending::where('status', 'pending')
            ->with(['creator', 'reference'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pending.index', compact('pendings'));
    }

    public function show(Pending $pending)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect('/dashboard')->with('error', 'Unauthorized');
        }

        $pending->load(['creator']);

        $reference = null;
        if ($pending->type === 'defect') {
            $reference = Defect::with(['product', 'reporter', 'reviewer', 'supplier'])
                ->find($pending->reference_id);
        } elseif ($pending->type === 'restock') {
            $reference = RestockConfirmation::with(['product', 'warehouse', 'requester', 'supplier', 'reviewer'])
                ->find($pending->reference_id);
        }

        return view('pending.show', compact('pending', 'reference'));
    }

    public function count()
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json(['count' => 0]);
        }

        $count = Pending::where('status', 'pending')->count();
        return response()->json(['count' => $count]);
    }
}

