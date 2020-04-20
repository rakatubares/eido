<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CovidBarang extends Model
{
    protected $table = 'covid_bebas_barang';

    public function covid()
    {
        return $this->belongsTo('App\CovidHeader', 'idTanggap', 'idTanggap');
    }
}
