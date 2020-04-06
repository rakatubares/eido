<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Impor;

class DimStatus extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dim_status';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kd_status', 'ur_status',
    ];

    /**
     * Get the docs for a status.
     */
    public function importasi()
    {
        return $this->hasMany(Impor::class, 'status_terakhir', 'kd_status');
    }
}
