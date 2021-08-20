<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class UserTest extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'test_id',
        'user_id'
    ];

    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class);
    }

    public function questions(): BelongsToMany
    {
        return $this->test->questions();
    }

    public function questionsCount()
    {
        return $this->questions()->count();
    }

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

    public function nextRemainingQuestion(): ?Question
    {
        $questionsAlreadyAnswered = $this->answers->count() ? $this->answers->pluck('question_id') : [];

        return Question::whereNotIn('id', $questionsAlreadyAnswered)
            ->orderBy('id')
            ->select('id')
            ->first();
    }

    public function isCompleted(): bool
    {
        return $this->questionsCount() === $this->answers()->count();
    }

    private function questionAlreadyAnswered(Answer $answer): ?Answer
    {
        return $this->answers()
            ->where('question_id', $answer->question_id)
            ->first();
    }

    public function result(): string
    {
        if (!$this->isCompleted()) throw new \Exception('Test is not completed yet');

        return $this->test->result(
            $this->answers()->sum('value')
        );
    }
}
