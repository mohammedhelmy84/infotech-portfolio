<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'descriptions',
        'url',
        'image',
        'tool',
        'hidden',
        'category_id',
    ];

    
    public function category()
    {
        return $this->BelongsTo(Category::class);
    }
   
    public function images()
    {
        return $this->hasMany(Image::class);
    }
   
}
