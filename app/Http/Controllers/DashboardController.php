<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Impor;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // total documents
        $lsImpor = Impor::All();
        $total['all'] = $lsImpor->count();
        foreach ($lsImpor as $impor) {
            $impor->status();
            $impor->date_created = $impor->created_at->format('d-m-Y');
        }
        $total['outstanding'] = $lsImpor->where('status.ur_status', '!=', 'SELESAI')->count();
        $total['selesai'] = $lsImpor->where('status.ur_status', 'SELESAI')->count();

        // total by status
        $statusAgg = $lsImpor->where('status.ur_status', '!=', 'SELESAI')->groupBy('status.ur_status');

        // total new and completed documents by date
        $dateAgg['new'] = $lsImpor->groupBy('date_created');
        $dateAgg['complete'] = $lsImpor->where('status.ur_status', 'SELESAI')->groupBy(DB::raw('Date(updated_at)'));

        return view('dashboard',compact('total','statusAgg','dateAgg'));
    }

    /**
     * Display documents' total
     */
    public function total(Request $request)
    {
        $total = [];
        $total['all'] = Impor::All()->count();
        $total['outstanding'] = Impor::status()->where('ur_terakhir', '!=', 'SELESAI')->count();
        $total['selesai'] = Impor::status()->where('ur_terakhir', 'SELESAI')->count();
        return $total;
    }
}
