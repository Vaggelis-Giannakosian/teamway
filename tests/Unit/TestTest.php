<?php

namespace Tests\Unit;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Test;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class TestTest extends TestCase
{

    use RefreshDatabase;

    private Test $test;

    protected function setUp(): void
    {
        parent::setUp();
        $this->test = Test::factory()->create();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_questions_relation()
    {
        $question = Question::factory()->create();
        $this->test->questions()->attach($question);

        $this->assertInstanceOf(BelongsToMany::class, $this->test->questions());
        $this->assertInstanceOf(Collection::class, $this->test->questions);
        $this->assertInstanceOf(Question::class, $this->test->questions()->first());
    }

    public function test_can_get_available_answers_collection()
    {
        $validAnswer = Answer::factory()->create();
        $this->test->questions()->attach($validAnswer->question);

        $invalidAnswer = Answer::factory()->create();


        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $this->test->availableAnswers());
        $this->assertTrue($this->test->availableAnswers()->pluck('id')->contains($validAnswer->id));
        $this->assertFalse($this->test->availableAnswers()->pluck('id')->contains($invalidAnswer->id));
    }


    public function test_result_functionality()
    {
        $this->test->update([
            'classification' => [
                ',-1' => [
                    'title' => 'First Title',
                    'description' => 'First Description'
                ],
                '0,0' => [
                    'title' => 'Second Title',
                    'description' => 'Second Description'
                ],
                '1,' => [
                    'title' => 'Third Title',
                    'description' => 'Third Description'
                ],
            ]
        ]);


        $this->assertEquals([
            'title' => 'First Title',
            'description' => 'First Description'
        ], $this->test->result(-5));

        $this->assertEquals([
            'title' => 'First Title',
            'description' => 'First Description'
        ], $this->test->result(-1));

        $this->assertEquals([
            'title' => 'Second Title',
            'description' => 'Second Description'
        ], $this->test->result(0));

        $this->assertEquals([
            'title' => 'Third Title',
            'description' => 'Third Description'
        ], $this->test->result(1));

        $this->assertEquals([
            'title' => 'Third Title',
            'description' => 'Third Description'
        ], $this->test->result(15));

        $this->expectException(\ArgumentCountError::class);

        $this->assertEquals([
            'title' => 'First Title',
            'description' => 'First Description'
        ], $this->test->result());
    }

    public function test_test_image()
    {
        $this->assertEquals(asset(Test::IMAGES_FOLDER . $this->test->image), $this->test->imageUrl());
    }

    public function test_test_image_thumb()
    {
        $this->assertEquals(asset(Test::THUMBS_FOLDER . $this->test->image), $this->test->thumbUrl());
    }

}
