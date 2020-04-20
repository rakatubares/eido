<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CovidSoetta;

class CovidSoettaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // function __construct()
    // {
    //      $this->middleware('permission:covid-soetta-list|covid-soetta-edit|covid-soetta-delete', ['only' => ['index','list','show','detail']]);
    //      $this->middleware('permission:covid-soetta-edit', ['only' => ['edit','update']]);
    //      $this->middleware('permission:covid-soetta-delete', ['only' => ['destroy']]);
    // }

    /**
     * Display page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('covid.index');
    }

    // Get data list
    public function list()
    {
        $covids = CovidSoetta::list();
        return $covids;
    }

    // Get data by id
    public function show($id)
    {
        $covid = CovidSoetta::show($id);
        return view('covid.show',compact('covid'));
    }
}
