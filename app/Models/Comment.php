<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Article; // импорт модели

class Comment extends Model
{
    use HasFactory;

    public function article () {
        // belongTo означает обратную связь, 
        // принадлежность к другой модели
        return $this->belongsTo(Article::class);
    }
}
