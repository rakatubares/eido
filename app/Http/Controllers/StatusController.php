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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $idImpor)
    {
        // Validation
        $this->validate($request, [
            'impor_id' => 'required|numeric',
            'kd_status' => 'required|numeric',
        ]);

        $input = $request->all();
        $input['impor_id'] = $idImpor;
        
        Status::create($input);

        $impor = Impor::find($idImpor);
        if ($input['kd_status'] == 22) {
            $statusDokImpor = $input;
            if (
                $impor->check_nib == 1 &&
                $impor->check_lartas == 1 &&
                (
                    $impor->bebas == 1 ||
                    $impor->bebas == 0 && $impor->check_bebas == 1
                )
            ) {
                $statusDokImpor['kd_status'] = 40;
                Status::create($statusDokImpor);

                $impor->status_terakhir = 40;
                $impor->save();
            } else {
                $statusDokImpor['kd_status'] = 30;
                Status::create($statusDokImpor);

                $impor->status_terakhir = 40;
                $impor->save();
            }
        } else {
            $impor->status_terakhir = $input['kd_status'];
            $impor->save();
        }
    }
}
