<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Biography extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'biography';

    protected $fillable = [];

    protected $dates = [];

    public static $rules = [
        // Validation rules
    ];

    // Relationships
    public function hero()
    {
        return $this->belongsTo('App\Hero');
    }
}
