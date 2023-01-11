<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'slug', 'name'];

    public function note()
    {
        return $this->hasMany(Note::class);
    }
}
