<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CovidDokumen extends Model
{
    protected $table = 'covid_bebas_dokumen';

    public function covid()
    {
        return $this->belongsTo('App\CovidHeader', 'idTanggap', 'idTanggap');
    }
}
