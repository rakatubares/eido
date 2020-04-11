<?php

namespace App\Http\Controllers;

use Redirect;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\DimJenisImportir;
use App\DimRekomendasi;
use App\DimStatus;
use App\Impor;
use App\Status;
use App\UploadFiles;

class ImporController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:impor-list|impor-create|impor-edit|impor-delete', ['only' => ['index','store','list','show','detail']]);
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
            'ket_lampiran.*.required_with' => 'Cantumkan keterangan lampiran'
        ];

        Validator::make(
            $request->all(), 
            [
                'awb' => ['required','string','max:64','regex:/(^[A-Za-z0-9]+$)+/'],
                'tgl_awb' => 'required|date',
                'importir' => ['required','string','max:64'],
                'npwp' => ['nullable','string','regex:/^[0-9]+$/'],
                'lampiran' => ['nullable','array'],
                'lampiran.*' => ['nullable','file','max:10000','mimes:jpg,jpeg,png,pdf,rar,zip'],
                'ket_lampiran' => ['nullable','required_with:lampiran','array'],
                'ket_lampiran.*' => ['nullable','required_with:lampiran.*','string','max:32']
            ], 
            $customMessages
        )->validate();
    
        $input = $request->all();
        unset($input['lampiran']);

        // Convert tgl AWB
        $input['tgl_awb'] = DateTime::createFromFormat('d-m-Y', $input['tgl_awb'])->format('Y-m-d');

        // Convert perkiraan waktu clearance
        if (isset($input['tgl_clearance']) && $input['tgl_clearance'] != "") {
            $input['tgl_clearance'] = DateTime::createFromFormat('d-m-Y', $input['tgl_clearance'])->format('Y-m-d');
        } else {
            $input['tgl_clearance'] = null;
            $input['wkt_clearance'] = null;
        }
        
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
		Status::create(['impor_id' => $impor->id, 'kd_status' => 10]);
        Status::create(['impor_id' => $impor->id, 'kd_status' => $input['status_terakhir']]);
        if (isset($request->lampiran)) {
            for ($i=0; $i < count($request->lampiran); $i++) { 
                $path = Storage::putFile('public', $request->file("lampiran.$i"));
                UploadFiles::create(['impor_id' => $impor->id, 'filename' => $path, 'comment' => $request->ket_lampiran[$i]]);
            }
        }
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
        if ($importasi->tgl_clearance != null) {
            $importasi->tgl_clearance = DateTime::createFromFormat('Y-m-d', $importasi->tgl_clearance)->format('d-m-Y');
		}
		
		// Get document history
        $histories = Status::where('impor_id',$id)->get();
        
        // Get attachments
        $attachments = UploadFiles::where('impor_id',$id)->get();

        // Get reference for edit form
        $jnsImportir = DimJenisImportir::All();
        $rekomendasi = DimRekomendasi::All();
        $statOptions = DimStatus::whereIn('kd_status', [21, 22, 41, 50])->orderBy('kd_status')->get();

        return view('impor.show',compact('importasi','jnsImportir','rekomendasi','histories','statOptions','attachments'));
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

		if (isset($input['tgl_clearance']) && $input['tgl_clearance'] != "") {
            $input['tgl_clearance'] = DateTime::createFromFormat('d-m-Y', $input['tgl_clearance'])->format('Y-m-d');
        } else {
            $input['tgl_clearance'] = null;
            $input['wkt_clearance'] = null;
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
            'ket_lampiran.*.required_with' => 'Cantumkan keterangan lampiran',
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
                'wkt_clearance' => ['nullable', 'date_format:G:i'],
                'lampiran' => ['nullable','array'],
                'lampiran.*' => ['nullable','file','max:10000','mimes:jpg,jpeg,png,pdf,rar,zip'],
                'ket_lampiran' => ['nullable','required_with:lampiran','array'],
                'ket_lampiran.*' => ['nullable','required_with:lampiran.*','string','max:32'],
            ], 
            $customMessages
        )->validate();

        // Save lampiran
        if (isset($request->lampiran)) {
            $test = [];
            foreach ($request->lampiran as $key => $value) {
                $test[] = [$key, $value];
                $path = Storage::putFile('public', $request->file("lampiran.$key"));
                UploadFiles::create(['impor_id' => $id, 'filename' => $path, 'comment' => $request->ket_lampiran[$key]]);
            }
            unset($input['lampiran'],$input['ket_lampiran']);
        } else {
            unset($input['ket_lampiran']);
        }

        // Delete lampiran
        if (isset($request->del_lampiran)) {
            foreach ($request->del_lampiran as $del_lampiran) {
                UploadFiles::destroy($del_lampiran);
            }
            unset($input['del_lampiran']);
        }

        // Get impor model
        $impor = Impor::find($id);
        
        // Check status change
        if ($impor->status_terakhir == 30) {
            if (
                ($input['check_nib'] == 1 && $input['check_lartas'] == 1 && $input['bebas'] == 0) ||
                ($input['check_nib'] == 1 && $input['check_lartas'] == 1 && $input['bebas'] == 1 && $input['check_bebas'] == 1)
            ) {
                $dok_ready = true;
                $input['status_terakhir'] = 40;
            }
        }

        // Update data impor
        foreach ($input as $key => $value) {
            if (!in_array($key,['_method', '_token'])) {
                $impor->$key = $value;
            }
        }
        $impor->save();

        // Update status
        if (isset($dok_ready) && $dok_ready == true) {
            Status::create(['impor_id' => $impor->id, 'kd_status' => 40]);
        }
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
        if ($importasi->tgl_clearance != null) {
            $importasi->tgl_clearance = DateTime::createFromFormat('Y-m-d', $importasi->tgl_clearance)->format('d-m-Y');
        }
        if ($importasi->wkt_clearance != null) {
            $importasi->wkt_clearance = DateTime::createFromFormat('H:i:s', $importasi->wkt_clearance)->format('H:i');
		}
    
        return $importasi;
    }
}
