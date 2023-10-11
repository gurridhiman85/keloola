<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Safelink extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function master_product(){
        return $this->hasOne(MasterProduct::class, 'id', 'product_id');
    }
}
