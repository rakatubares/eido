<?php

namespace App\Http\Controllers;

use DateTime;
use DatePeriod;
use DateInterval;
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
            $impor->created_date = $impor->created_at->format('Y-m-d');
            $impor->updated_date = $impor->updated_at->format('Y-m-d');
        }
        $total['outstanding'] = $lsImpor->where('status.ur_status', '!=', 'SELESAI')->count();
        $total['selesai'] = $lsImpor->where('status.ur_status', 'SELESAI')->count();

        // total by status
        $statusAgg = $lsImpor->where('status.ur_status', '!=', 'SELESAI')->groupBy('status.ur_status');

        // total new and completed documents by date
        $minDate = $lsImpor->min('created_at')->format('Y-m-d');
        $maxDateNew = $lsImpor->max('created_at')->format('Y-m-d');
        $maxDateComplete = $lsImpor->where('status.ur_status', 'SELESAI')->max('updated_at')->format('Y-m-d');
        $maxDate = max($maxDateNew, $maxDateComplete);

        $minDate = new DateTime($minDate);
        $maxDate = new DateTime($maxDate);
        $maxDate->modify('+1 day');

        $period = new DatePeriod(
            $minDate,
            new DateInterval('P1D'),
            $maxDate
        );
        $dateRange = [];
        foreach ($period as $p) {
            $dateRange[] = $p->format('Y-m-d');
        }

        $dateAgg['new'] = $lsImpor->groupBy('created_date');
        $dateAgg['complete'] = $lsImpor->where('status.ur_status', 'SELESAI')->groupBy('updated_date');

        $neCoChart = [];
        foreach ($dateRange as $d) {
            $neCoChart[] = [
                $d, 
                (isset($dateAgg['new'][$d]) ? ($dateAgg['new'][$d])->count() : null), 
                (isset($dateAgg['complete'][$d]) ? ($dateAgg['complete'][$d])->count() : null)
            ];
        }

        return view('dashboard',compact('total','statusAgg','dateAgg','dateRange','neCoChart'));
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
