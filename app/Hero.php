<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hero extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'hero';

    protected $fillable = ['name', 'images', 'rarity', 'color'];

    protected $dates = [];

    public static $rules = [
        // Validation rules
    ];

    // Relationships
    public function powerstats()
    {
        return $this->hasOne('App\Powerstats');
    }

    public function biography()
    {
        return $this->hasOne('App\Biography');
    }
}
