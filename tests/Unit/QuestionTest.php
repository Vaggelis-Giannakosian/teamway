<?php

namespace Tests\Unit;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class QuestionTest extends TestCase
{

    use RefreshDatabase;


    public function test_answers_relation()
    {
        $question = Question::factory()->create();
        Answer::factory()->create(['question_id'=>$question->id]);

        $this->assertInstanceOf(Collection::class,$question->answers);
        $this->assertInstanceOf(HasMany::class,$question->answers());
        $this->assertInstanceOf(Answer::class,$question->answers()->first());
    }
}
