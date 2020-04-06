<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DimJenisImportir extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dim_jenis_importir';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'jns_importir',
    ];
}
