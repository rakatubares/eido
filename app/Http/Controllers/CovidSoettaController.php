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
    function __construct()
    {
         $this->middleware('permission:covid-list|covid-edit|covid-delete', ['only' => ['index','list','show','monitor','index_all','list_all']]);
         $this->middleware('permission:covid-edit', ['only' => ['show','monitor']]);
         $this->middleware('permission:covid-delete', ['only' => ['destroy']]);
    }

    /**
     * Display page.aju covid baru
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
        $covid = CovidSoetta::get($id);
        return view('covid.show',compact('covid'));
    }

    // Monitor aju covid ke tabel importasi
    public function monitor($id)
    {
        $test = CovidSoetta::monitor($id);
        return $test;
    }

    /**
     * Display page.semua aju covid
     *
     * @return \Illuminate\Http\Response
     */
    public function index_all(Request $request)
    {
        return view('covid.all');
    }

    // Get entire data list
    public function list_all()
    {
        $covids = CovidSoetta::list_all();
        return $covids;
    }
}
