<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BarkirBarangPenetapan extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'barkir_barang_penetapan';

    public function barkir()
    {
        return $this->belongsTo('App\BarkirHeader', 'barkir_id', 'id');
    }
}
