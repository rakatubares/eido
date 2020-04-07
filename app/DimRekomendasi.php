<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DimRekomendasi extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dim_rekomendasi';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rekomendasi',
    ];

    /**
     * Get the docs for a status.
     */
    public function importasi()
    {
        return $this->hasMany(Impor::class, 'rekomendasi_clearance', 'id');
    }
}
