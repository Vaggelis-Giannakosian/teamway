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

    public function syncAnswers(array $answers): bool
    {
        $this->answers()->detach();

        $result = $this->answers()->sync($answers);
        return count($result['attached'] ?? []);
    }

    public function isCompleted(): bool
    {
        return $this->questionsCount() === $this->answers()->count();
    }


    public function result(): array
    {
        if (!$this->isCompleted()) throw new \Exception('Test is not completed yet');

        return $this->test->result(
            $this->answers()->sum('value')
        );
    }
}
