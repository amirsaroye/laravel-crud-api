<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Recipient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'contact_info',
    ];

    public function foods(): MorphToMany {
        return $this->morphToMany(Food::class,'foodable');
    }
}
