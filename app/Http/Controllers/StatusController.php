<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Status;
use App\Impor;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:status-list|status-create', ['only' => ['list','store']]);
         $this->middleware('permission:status-create', ['only' => ['store']]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request, $idImpor)
    {
        // Validation
        $this->validate($request, [
            'kd_status' => 'required|numeric',
        ]);

        $input = $request->all();
        $input['impor_id'] = $idImpor;
        
        Status::create($input);

        $impor = Impor::find($idImpor);
        if ($input['kd_status'] == 22) {
            if (
                $impor->check_nib == 1 &&
                $impor->check_lartas == 1 &&
                (
                    $impor->bebas == 0 ||
                    $impor->bebas == 1 && $impor->check_bebas == 1
                )
            ) {
                Status::create(['impor_id' => $idImpor, 'kd_status' => 40]);

                $impor->status_terakhir = 40;
                $impor->save();
            } else {
                Status::create(['impor_id' => $idImpor, 'kd_status' => 30]);

                $impor->status_terakhir = 30;
                $impor->save();
            }
        } else {
            $impor->status_terakhir = $input['kd_status'];
            $impor->save();
        }
    }

    public function list(Request $request, $idImpor)
    {
        $histories = Status::where('impor_id',$idImpor)->get();
        for ($i=0; $i < count($histories); $i++) { 
            $histories[$i]->time = $histories[$i]->created_at->timezone('Asia/Jakarta')->format('d-m-Y H:i:s');
            $histories[$i]->status = $histories[$i]->uraian_status->ur_status;
        }

        $status = Impor::find($idImpor)->status->ur_status;
        return ['status' => $status, 'histories' => $histories];
    }
}
