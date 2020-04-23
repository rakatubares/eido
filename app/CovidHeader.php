<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CovidHeader extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'covid_bebas_header';

    public function importasi()
    {
        return $this->hasOne('App\Impor', 'idTanggap', 'idTanggap');
    }

    public function validasi()
    {
        return $this->hasMany('App\CovidValidasi', 'idTanggap', 'idTanggap');
    }

    public function barang()
    {
        return $this->hasMany('App\CovidBarang', 'idTanggap', 'idTanggap');
    }

    public function dokumen()
    {
        return $this->hasMany('App\CovidDokumen', 'idTanggap', 'idTanggap');
    }

    public function status()
    {
        return $this->hasMany('App\CovidStatus', 'idTanggap', 'idTanggap');
    }

    public function latest_status()
    {
        return $this->hasOne('App\CovidStatus', 'idTanggap', 'idTanggap')->latest('waktu');
    }

    public function scopeDetails($query)
    {
        return $query->with(
            'validasi:id,idTanggap,keterangan',
            'barang:id,idTanggap,seri_barang,uraian_barang,kategori_barang,kategori_lain,jumlah_barang,berat,volume,nilai_perkiraan',
            'dokumen:id,idTanggap,seri_dokumen,no_dokumen,tgl_dokumen,keterangan,link',
            'status:id,idTanggap,seri_status,kode_status,keterangan,waktu',
            'importasi:id,idTanggap'
        );
    }
}
