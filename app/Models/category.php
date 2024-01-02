<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $fillable = [
        'cat_id',
        'description',
        'categoryTitle',
        'parentCategory',
        'slug',
        'status',
        // Add other fields as needed
    ];
}
