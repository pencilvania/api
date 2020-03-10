<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Affiliations extends Model
{

    public static $createRules = [
        'hero_id' => 'required',
        'name' => 'required|max:200'
    ];

    protected $fillable = [
        'name','hero_id',
    ];

    public function heros()
    {
        return $this->belongsTo('App\Superheros', 'hero_id');
    }

}
