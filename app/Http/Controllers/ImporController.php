<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\DimJenisImportir;
use App\DimRekomendasi;
use App\Impor;

class ImporController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:impor-list|impor-create|impor-edit|impor-delete', ['only' => ['index','store']]);
         $this->middleware('permission:impor-create', ['only' => ['create','store']]);
         $this->middleware('permission:impor-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:impor-delete', ['only' => ['destroy']]);
    }

    /**
     * Display page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $jnsImportir = DimJenisImportir::All();
        $rekomendasi = DimRekomendasi::All();
        return view('impor.index',compact('jnsImportir','rekomendasi'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $importasi = Impor::select('id','awb','tgl_awb','importir','status_terakhir')->with('status:id,kd_status,ur_status')->get();
 
        return $importasi;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation
        $customMessages = [
            'awb.regex' => 'Only numbers and letters are allowed in awb.',
            'npwp.regex' => 'Only numbers are allowed in npwp.',
        ];

        Validator::make(
            $request->all(), 
            [
                'awb' => ['required','string','max:64','regex:/(^[A-Za-z0-9]+$)+/'],
                'tgl_awb' => 'required|date',
                'importir' => ['required','string','max:64'],
                'npwp' => ['nullable','string','regex:/^[0-9]+$/'],
            ], 
            $customMessages
        )->validate();
    
        $input = $request->all();

        // Convert tgl AWB
        $input['tgl_awb'] = DateTime::createFromFormat('d-m-Y', $input['tgl_awb'])->format('Y-m-d');

        // Convert perkiraan waktu clearance
        if ($input['tgl_clearance'] != "") {
            $tglClearance = DateTime::createFromFormat('d-m-Y', $input['tgl_clearance'])->format('Y-m-d');

            if ($input['wkt_clearance'] != "") {
                $input['perkiraan_clearance'] = $tglClearance . ' ' . $input['wkt_clearance'];
            } else {
                $input['perkiraan_clearance'] = $tglClearance;
            }
        }
        unset($input['tgl_clearance'], $input['wkt_clearance']);
        
        // Determine importation status
        if ($input['rekomendasi_clearance'] == 1) {
            $input['status_terakhir'] = 20;
        } else {
            if (
                (isset($input['check_nib']) && $input['check_nib'] == '1') && 
                (isset($input['check_lartas']) && $input['check_lartas'] == '1') && (
                    $input['bebas'] == '0' || (
                        $input['bebas'] == '1' && 
                        (isset($input['rekomendasi_bebas']) && $input['rekomendasi_bebas'] == '1') && 
                        (isset($input['check_bebas']) && $input['check_bebas'] == '1')
                    )
                )
            ) {
                $input['status_terakhir'] = 40;
            } else {
                $input['status_terakhir'] = 30;
            }
        }

        // Save data
        $impor = Impor::create($input);

        // return $impor;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $importasi = Impor::with('rekomendasiImpor:id,rekomendasi')->get()->find($id);
        $importasi = Impor::detail()->find($id);
        // $importasi = Impor::Find($id);
        return view('impor.show',compact('importasi'));
    }
}
