<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CovidValidasi extends Model
{
    protected $table = 'covid_bebas_validasi';

    public function covid()
    {
        return $this->belongsTo('App\CovidHeader', 'idTanggap', 'idTanggap');
    }
}
