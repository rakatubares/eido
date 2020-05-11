<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BarkirHeader extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'barkir_header';

    // protected $appends = ['nilai_pabean'];

    public function barang_penetapan()
    {
        return $this->hasMany('App\BarkirBarangPenetapan', 'barkir_id', 'id');
    }

    public function importasi()
    {
        return $this->hasMany('App\Impor', 'barkir_id');
    }

    public function getNilaiPabeanAttribute()
    {
        $nilai_pabean = $this->ndpbm_penetapan * $this->cif_penetapan;
        return "{$nilai_pabean}";
    }
}
