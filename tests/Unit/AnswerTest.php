<?php

namespace Tests\Unit;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class AnswerTest extends TestCase
{
    use RefreshDatabase;

    public function test_question_relation()
    {
        $answer = Answer::factory()->create();

        $this->assertInstanceOf(Question::class,$answer->question);
        $this->assertInstanceOf(BelongsTo::class,$answer->question());
    }
}
