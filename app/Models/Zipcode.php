<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zipcode extends Model
{
    use HasFactory,UUID;

    protected $table = 'zipcode';
    protected $fillable=['city_id','zipcode'];
}
