<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;
use App\DimJenisImportir;
use App\DimRekomendasi;
use App\DimStatus;
use App\Status;

class Impor extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'impor';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'awb', 'tgl_awb', 
        'importir', 'npwp', 'check_nib', 'dok_nib', 'status_importir', 'pengirim',
        'pic', 'hp_pic', 'email_pic', 'tgl_clearance', 'wkt_clearance',
        'check_lartas', 'dok_lartas',
        'bebas', 'rekomendasi_bebas', 'dok_rekomendasi_bebas', 'check_bebas', 'dok_bebas',
        'rekomendasi_clearance', 'status_terakhir',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    // protected $casts = [
    //     'tgl_awb' => 'date',
    //     'perkiraan_clearance' => 'datetime',
    // ];

    /**
     * Records user id at data manipulation
     */
    public static function boot() {
        parent::boot();

        // create a event to happen on updating
        static::updating(function($table)  {
            $table->updated_by = Auth::user()->id;
        });

        // create a event to happen on saving
        static::creating(function($table)  {
            $table->created_by = Auth::user()->id;
        });
    }

    /**
     * Get importer status description.
     */
    public function jenis_importir()
    {
        return $this->belongsTo(DimJenisImportir::class, 'status_importir');
    }

    /**
     * Get import recommendation description.
     */
    public function rekomendasi_impor()
    {
        return $this->belongsTo(DimRekomendasi::class, 'rekomendasi_clearance');
    }

    /**
     * Get status description.
     */
    public function status()
    {
        return $this->belongsTo(DimStatus::class, 'status_terakhir', 'kd_status');
    }

    /**
     * Get license officers' name.
     */
    public function officer()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the docs for each officer.
     */
    public function history()
    {
        return $this->hasMany(Status::class, 'impor_id');
    }

    /**
     * Get importasi detail with reference description
     */
    public function scopeDetail($query)
    {
        return $query->with('jenis_importir:id,jns_importir', 'status:id,kd_status,ur_status', 'rekomendasi_impor:id,rekomendasi');
    }
}
