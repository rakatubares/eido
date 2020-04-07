<?php

namespace App\Http\Controllers;

use Redirect;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get impor data
        $importasi = Impor::detail()->find($id);
        $importasi->tgl_awb = DateTime::createFromFormat('Y-m-d', $importasi->tgl_awb)->format('d-m-Y');
        if ($importasi->perkiraan_clearance != null) {
            $importasi->tgl_clearance = DateTime::createFromFormat('Y-m-d H:i:s', $importasi->perkiraan_clearance)->format('d-m-Y');
            $importasi->wkt_clearance = DateTime::createFromFormat('Y-m-d H:i:s', $importasi->perkiraan_clearance)->format('H:i');
        }

        // Get reference for edit form
        $jnsImportir = DimJenisImportir::All();
        $rekomendasi = DimRekomendasi::All();

        return view('impor.show',compact('importasi','jnsImportir','rekomendasi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
		// Convert data
        $input = $request->all();

		$input['tgl_awb'] = DateTime::createFromFormat('d-m-Y', $input['tgl_awb'])->format('Y-m-d');

		if ($input['tgl_clearance'] != "") {
			$tglClearance = DateTime::createFromFormat('d-m-Y', $input['tgl_clearance'])->format('Y-m-d');

			if ($input['wkt_clearance'] != "") {
				$input['perkiraan_clearance'] = $tglClearance . ' ' . $input['wkt_clearance'];
			} else {
				$input['perkiraan_clearance'] = $tglClearance;
			}
		}

		$input['check_nib'] = isset($input['check_nib']) ? $input['check_nib'] : 0;
		$input['dok_nib'] = isset($input['dok_nib']) ? $input['dok_nib'] : null;

		$input['check_lartas'] = isset($input['check_lartas']) ? $input['check_lartas'] : 0;
		$input['dok_lartas'] = isset($input['dok_lartas']) ? $input['dok_lartas'] : null;

		$input['rekomendasi_bebas'] = isset($input['rekomendasi_bebas']) ? $input['rekomendasi_bebas'] : 0;
		$input['dok_rekomendasi_bebas'] = isset($input['dok_rekomendasi_bebas']) ? $input['dok_rekomendasi_bebas'] : null;

		$input['check_bebas'] = isset($input['check_bebas']) ? $input['check_bebas'] : 0;
		$input['dok_bebas'] = isset($input['dok_bebas']) ? $input['dok_bebas'] : null;

		// Validation
		$awb = $input['awb'];
		$tgl_awb = $input['tgl_awb'];
		
        $customMessages = [
            'awb.regex' => 'Only numbers and letters are allowed in awb.',
            'npwp.regex' => 'Only numbers are allowed in npwp.',
            'hp_pic.regex' => 'Only numbers are allowed phone number.',
            'awb.unique' => 'No AWB dan tanggal AWB sudah ada di database',
            'tgl_awb.unique' => 'No AWB dan tanggal AWB sudah ada di database',
        ];
        
        Validator::make(
            $input, 
            [
                'awb' => 
                    [
                        'required',
                        'string',
                        'max:64',
                        'regex:/(^[A-Za-z0-9]+$)+/',
                        Rule::unique('impor')->where(function ($query) use($awb,$tgl_awb) {
                            return $query->where('awb', $awb)
                            ->where('tgl_awb', $tgl_awb);
                        })->ignore($id)
                    ],
                'tgl_awb' => 
                    [
                        'required',
                        'date',
                        Rule::unique('impor')->where(function ($query) use($awb,$tgl_awb) {
                            return $query->where('awb', $awb)
                            ->where('tgl_awb', $tgl_awb);
                        })->ignore($id)
                    ],
                'importir' => ['required','string','max:64'],
                'npwp' => ['nullable','string','regex:/^[0-9]+$/'],
                'hp_pic' => ['nullable','regex:/(^[0-9]+$)+/'],
                'email_pic' => ['nullable','email'],
                'tgl_clearance' => ['nullable', 'date'],
                'wkt_clearance' => ['nullable', 'date_format:G:i']
            ], 
            $customMessages
        )->validate();

        // Get impor model
        $impor = Impor::find($id);
        foreach ($input as $key => $value) {
            if (!in_array($key,['_method', '_token', 'tgl_clearance', 'wkt_clearance'])) {
                $impor->$key = $value;
            }
        }
        $impor->save();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     */
    public function detail($id)
    {
        // Get impor data
        $importasi = Impor::detail()->find($id);
        $importasi->tgl_awb = DateTime::createFromFormat('Y-m-d', $importasi->tgl_awb)->format('d-m-Y');
        if ($importasi->perkiraan_clearance != null) {
            $importasi->tgl_clearance = DateTime::createFromFormat('Y-m-d H:i:s', $importasi->perkiraan_clearance)->format('d-m-Y');
            $importasi->wkt_clearance = DateTime::createFromFormat('Y-m-d H:i:s', $importasi->perkiraan_clearance)->format('H:i');
        }
    
        return $importasi;
    }
}
