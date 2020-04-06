<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pic extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pic';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama', 'no_hp', 'email',
    ];
}
