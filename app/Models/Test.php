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
        'slug',
        'classification'
    ];

    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class)->withPivot('order_column');
    }

    public function result(int $points)
    {
        return $this->resolveStatus($points);
    }

    public function getClassificationAttribute($classification): array
    {
        $ranges = [];

        foreach (json_decode($classification) as $range => $label) {
            $limits = explode(',', $range);
            $ranges[$label] = [
                'min' => $limits[0] ?? '',
                'max' => $limits[1] ?? ''
            ];
        }

        return $ranges;
    }

    private function resolveStatus(int $points): string
    {

        foreach ($this->classification as $label => $range) {

            $min = $range['min'] === '' ? -INF : $range['min'];
            $max = $range['max'] === '' ? INF : $range['max'];

            if ($points < $min || $points > $max) continue;

            return $label;
        }

        throw new \Exception('Classification not found');
    }
}
