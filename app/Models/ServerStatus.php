<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class ServerStatus extends Model
{
    use HasFactory;
    use softDeletes;
    protected $table = 'server_status';
    protected $fillable = ['id','server_status'];
}
