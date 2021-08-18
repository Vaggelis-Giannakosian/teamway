<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Test extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id'
    ];

    public function answers(): BelongsToMany
    {
        return $this->belongsToMany(Answer::class);
    }


    public function addAnswer(Answer $answer): bool
    {
        if ($oldAnswer = $this->questionAlreadyAnswered($answer)) {
            $this->answers()->detach($oldAnswer);
        }

        $result = $this->answers()->syncWithoutDetaching($answer);
        return count($result['attached'] ?? []);
    }

    private function questionAlreadyAnswered(Answer $answer): ?Answer
    {
        return $this->answers()->where('question_id', $answer->question_id)->first();
    }

    public function result(): string
    {
        return $this->resolveTestResult(
            $this->answers()->sum('value')
        );
    }

    public function resolveTestResult(int $totalPoints): string
    {
        switch (true) {
            case $totalPoints < -5:
                return 'You are very introvert';
            case in_array($totalPoints,range(-5,-1)):
                return 'You are a bit introvert';
            case $totalPoints === 0:
                return 'You can be both';
            case in_array($totalPoints,range(1,5)):
                return 'You are a bit extrovert';
            case $totalPoints > 5:
                return 'You are very extrovert';
        }
    }
}
