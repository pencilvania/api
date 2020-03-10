<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Superheros extends Model
{

    public static $createRules = [
        'heroname' => 'required|string',
        'realname' => 'required|string',
        'publisher' => 'required|string',
        'affiliations' => 'present'
    ];

    public static $updateRules = [
        'heroname' => 'required|string',
        'realname' => 'required|string',
        'publisher' => 'required|string',
        'fadate' => 'required|date'
    ];

    protected $fillable = [
        'realname', 'heroname','publisher','fadate',
    ];

    public function affiliations()
    {
        return $this->hasMany('App\Affiliations' ,'hero_id', 'id');
    }


}
