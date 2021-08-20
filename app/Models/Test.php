<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

class Test extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'slug'
    ];

    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class)->withPivot('order_column');
    }

    public function userTests()
    {

    }

}
