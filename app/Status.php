<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\DimStatus;
use App\Impor;

class Status extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'status';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'impor_id', 'kd_status', 'jns_dok_impor', 'no_dok_impor', 'tgl_dok_impor', 'detail',
    ];

    /**
     * Get document.
     */
    public function importasi()
    {
        return $this->belongsTo(Impor::class, 'impor_id');
    }

    /**
     * Get status description.
     */
    public function uraian_status()
    {
        return $this->belongsTo(DimStatus::class, 'kd_status', 'kd_status');
    }
}
