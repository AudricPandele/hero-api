<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Powerstats extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'powerstats';

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
