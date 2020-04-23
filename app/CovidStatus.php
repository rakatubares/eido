<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CovidStatus extends Model
{
    protected $table = 'covid_bebas_status';

    public function covid()
    {
        return $this->belongsTo('App\CovidHeader', 'idTanggap', 'idTanggap');
    }
}
