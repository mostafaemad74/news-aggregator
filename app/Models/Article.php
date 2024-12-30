<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        "source",
        "author",
        "title",
        "category",
        "description",
        "url",
        "url_to_image",
        "published_at",
        "content"
    ];
}
