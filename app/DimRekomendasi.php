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
}
