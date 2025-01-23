<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    protected $fillable = ['title', 'body', 'summary', 'user_id', 'category_id', 'image', 'is_breaking_news', 'is_editor_selected'];

    protected function casts() : array{
        return [
            'image' => 'array'
        ];
    }

    public function user() : BelongsTo{
        return $this->belongsTo(User::class);
    }
    public function category() : BelongsTo{
        return $this->belongsTo(Category::class);
    }
}
