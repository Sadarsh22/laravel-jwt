<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\SoftDeletes;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;


class Post extends Model implements JWTSubject
{
    use HasFactory,UUID,SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'image',
        'user_id',
        'category',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
     /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
