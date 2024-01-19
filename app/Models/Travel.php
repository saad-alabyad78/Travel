<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\Tour;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Travel extends Model
{
    use HasFactory , Sluggable,HasUuids;

    protected $table = 'travels' ;

    protected $fillable = [
        'name' ,
        'is_public',
        'description',
        'slug',
        'number_of_days',
    ];

    public function Tours(): HasMany
    {
        return $this->hasMany(Tour::class);
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name' ,
                'firstUniqueSuffix'  => 2,
                'separator' => '-'
            ]
        ];
    }

    public function numberOfNights(): Attribute
    {
        return Attribute::make(
            get: fn ($value , $attributes) => $attributes['number_of_days'] - 1
        );
    }
}
