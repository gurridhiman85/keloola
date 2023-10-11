<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewsVideos extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['id','title','date','description'];

    public function attachment(){
        return $this->hasMany(Attachment::class,'type_id','id')->where('attachment_type','News_Videos');
    }
}
