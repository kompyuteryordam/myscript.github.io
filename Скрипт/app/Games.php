<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Games extends Model
{
    protected $table = 'games';
	protected $fillable = ['user','drop_item', 'card'];
}
