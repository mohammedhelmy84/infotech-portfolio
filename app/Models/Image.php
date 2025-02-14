<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $fillable = [
    'image',
    'project_id',
];


public function project_img()
{
    return $this->BelongsTo(Project::class);
}
}
