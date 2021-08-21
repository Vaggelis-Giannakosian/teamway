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
        'excerpt',
        'description',
        'slug',
        'classification',
        'image'
    ];

    protected $casts = [
        'classification' => 'array'
    ];

    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class)->withPivot('order_column');
    }

    public function availableAnswers(): Collection
    {
        return $this->questions()->with('answers')->get()->flatMap->answers;
    }

    public function result(int $points): array
    {
        return $this->resolveStatus($points);
    }

    public function getClassificationAttribute($classification): array
    {
        $ranges = [];

        foreach (json_decode($classification) as $range => $label) {

            $limits = explode(',', $range);

            $ranges[$label->title] = [
                'range' => [
                    'min' => $limits[0] ?? '',
                    'max' => $limits[1] ?? ''
                ],
                'description' => $label->description,
            ];
        }

        return $ranges;
    }

    private function resolveStatus(int $points): array
    {

        foreach ($this->classification as $label => $details) {
            $description = $details['description'];
            $range = $details['range'];

            $min = $range['min'] === '' ? -INF : $range['min'];
            $max = $range['max'] === '' ? INF : $range['max'];

            if ($points < $min || $points > $max) continue;

            return compact('label','description');
        }

        throw new \Exception('Classification not found');
    }

    public function imageUrl()
    {
        return asset('test-images/' . $this->image);
    }

    public function thumbUrl()
    {
        return asset('test-images/thumbs/' . $this->image);
    }
}
