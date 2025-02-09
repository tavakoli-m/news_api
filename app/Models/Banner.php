<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = ['url', 'image'];

    protected function casts() : array{
        return [
            'image' => 'array'
        ];
    }
}
