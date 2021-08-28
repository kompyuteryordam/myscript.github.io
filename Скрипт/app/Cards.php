<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cards extends Model
{
    protected $table = 'cards';
	protected $fillable = ['name','cost','image', 'item_image','chance'];
}
