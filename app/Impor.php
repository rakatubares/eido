<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\DimJenisImportir;
use App\DimRekomendasi;
use App\DimStatus;
use App\Status;
use App\UploadFiles;

class Impor extends Model
{
    use SoftDeletes;

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
        'awb', 'tgl_awb', 'no_permohonan', 'tgl_permohonan',
        'importir', 'npwp', 'status_importir',
        'pic', 'hp_pic', 'email_pic', 'tgl_clearance', 'wkt_clearance',
        'check_rekomendasi', 'dok_rekomendasi', 'tgl_rekomendasi',
        'bebas', 'check_bebas', 'dok_bebas', 'tgl_bebas',
        'rekomendasi_clearance', 'status_terakhir', 'officer_id',
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

        // create a event to happen on deleting
        static::deleting(function($table)  {
            $table->deleted_by = Auth::user()->id;
            $table->save();
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
        return $this->belongsTo(User::class, 'officer_id');
    }

    /**
     * Get docs' history.
     */
    public function history()
    {
        return $this->hasMany(Status::class, 'impor_id');
    }

    /**
     * Get docs' attachments.
     */
    public function attachments()
    {
        return $this->hasMany(UploadFiles::class, 'impor_id');
    }

    /**
     * Get importasi detail with reference description
     */
    public function scopeDetail($query)
    {
        return $query->with(
            'jenis_importir:id,jns_importir', 
            'status:id,kd_status,ur_status', 
            'rekomendasi_impor:id,rekomendasi', 
            'attachments:id,impor_id,filename,comment',
            'officer:id,name'
        );
    }
}
