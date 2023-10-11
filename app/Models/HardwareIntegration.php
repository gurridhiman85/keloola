<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HardwareIntegration extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['id','title','description','url'];

    public function attachment(){
        return $this->hasOne(Attachment::class,'type_id','id')->where('attachment_type','Hardware_Integrations');
    }
}
