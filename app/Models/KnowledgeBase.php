<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class KnowledgeBase extends Model
{
    use HasFactory;
    use softDeletes;

    protected $fillable = ['id','title','question','answer','description'];
}
