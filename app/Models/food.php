<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Food extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'expiry_date',
        'quantity',
    ];

    protected $table = 'foods';

    public function donors(): MorphToMany
    {
        return $this->morphedByMany(Donor::class, 'foodable');
    }

    public function recipients(): MorphToMany
    {
        return $this->morphedByMany(Recipient::class, 'foodable');
    }
}
