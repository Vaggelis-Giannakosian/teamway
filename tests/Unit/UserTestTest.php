<?php

namespace Tests\Unit;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Test;
use App\Models\UserTest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class UserTestTest extends TestCase
{

    use RefreshDatabase;

    private UserTest $userTest;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userTest = UserTest::factory()->create();
    }


    public function test_test_relation()
    {
        $this->assertInstanceOf(BelongsTo::class,$this->userTest->test());
        $this->assertInstanceOf(Test::class,$this->userTest->test);
    }


    public function test_questions_relation()
    {
        $question = Question::factory()->create();
        $this->userTest->questions()->attach($question);

        $this->assertInstanceOf(BelongsToMany::class,$this->userTest->questions());
        $this->assertInstanceOf(Collection::class,$this->userTest->questions);
        $this->assertCount(1,$this->userTest->questions);
        $this->assertEquals($question->id,$this->userTest->questions()->first()->id);
    }


    public function test_questionsCount_method()
    {
        $question = Question::factory()->create();
        $this->userTest->questions()->attach($question);

        $this->assertEquals(1,$this->userTest->questionsCount());

        $newQuestion = Question::factory()->create();
        $this->userTest->questions()->attach($newQuestion);

        $this->assertEquals(2,$this->userTest->questionsCount());
    }


    public function test_answers_relation()
    {
        $answer = Answer::factory()->create();
        $this->userTest->questions()->attach($answer->question);

        $this->userTest->answers()->sync([$answer->id]);

        $this->assertInstanceOf(BelongsToMany::class,$this->userTest->answers());
        $this->assertInstanceOf(Collection::class,$this->userTest->answers);
        $this->assertCount(1,$this->userTest->answers);
        $this->assertEquals($answer->id,$this->userTest->answers()->first()->id);
    }


    public function test_syncAnswers_method()
    {
        $answer = Answer::factory()->create();
        $this->userTest->questions()->attach($answer->question);

        $this->userTest->syncAnswers([$answer->id]);

        $this->assertCount(1,$this->userTest->answers);

        $this->userTest->syncAnswers([]);

        $this->assertCount(0,$this->userTest->fresh()->answers);
    }


    public function test_isCompleted_method()
    {
        $answer = Answer::factory()->create();
        $this->userTest->questions()->attach($answer->question);

        $this->assertFalse($this->userTest->isCompleted());

        $this->userTest->syncAnswers([$answer->id]);

        $this->assertTrue($this->userTest->isCompleted());
    }

    public function test_result_method_throws_exception_if_not_completed()
    {

        $this->userTest->questions()->attach(Question::factory()->create());

        $this->assertFalse($this->userTest->isCompleted());
        $this->expectException(\Exception::class);

        $this->userTest->result();
    }

    public function test_result_method()
    {

        $answer = Answer::factory()->create();
        $this->userTest->questions()->attach($answer->question);
        $this->userTest->syncAnswers([$answer->id]);

        $this->userTest->test->update(['classification'=>[
            ',-1' => [
                'title'=> 'First Title',
                'description' => 'First Description'
            ],
            '0,0' => [
                'title'=> 'Second Title',
                'description' => 'Second Description'
            ],
            '1,' => [
                'title'=> 'Third Title',
                'description' => 'Third Description'
            ],
        ]]);

        $this->assertTrue($this->userTest->isCompleted());

        $this->assertEquals(
            $this->userTest->result(),
            $this->userTest->test->result($this->userTest->answers()->sum('value'))
        );
    }

}
