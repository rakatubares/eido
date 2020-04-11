<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Impor;

class UploadFiles extends Model
{
    use SoftDeletes;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'impor_id', 'filename', 'comment',
    ];

    /**
     * Get import document.
     */
    public function importasi()
    {
        return $this->belongsTo(Impor::class, 'impor_id');
    }
}
