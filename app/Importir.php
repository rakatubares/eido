<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Importir extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'importir';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama', 'npwp',
    ];
}
