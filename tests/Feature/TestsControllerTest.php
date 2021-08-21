<?php

namespace Tests\Feature;

use App\Models\Test;
use App\Models\UserTest;
use App\Repositories\TestsRepository;
use Database\Seeders\TestsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class TestsControllerTest extends TestCase
{

    use RefreshDatabase;

    private Test $test;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(TestsSeeder::class);
        $this->get('/');
        $this->test = Test::first();
    }


    public function test_show_test_view()
    {
        $activeTest = app(TestsRepository::class)->getActiveTestOrCreateNewIfCompleted($this->test);

        $this->get(route('tests.show', $this->test))
            ->assertStatus(Response::HTTP_OK)
            ->assertViewHas('userTest', $activeTest)
            ->assertSeeText($activeTest->title)
            ->assertSeeText($activeTest->excerpt)
            ->assertSeeText($activeTest->description);
    }


    public function test_user_gets_redirected_when_accesses_test_result_and_it_is_not_completed()
    {
        $activeTest = app(TestsRepository::class)->getActiveTestOrCreateNewIfCompleted($this->test);

        $this->assertFalse($activeTest->isCompleted());

        $this->get(route('tests.result', $this->test))
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect(route('tests.show', $this->test));
    }

    public function test_user_can_visit_test_result_view()
    {
        $activeTest = app(TestsRepository::class)->getActiveTestOrCreateNewIfCompleted($this->test);
        $answers = $activeTest->questions()->with('answers')->get()->map(fn($question) => $question->answers->first());
        $activeTest->syncAnswers($answers->pluck('id')->toArray());

        $this->assertTrue($activeTest->fresh()->isCompleted());

        $this->get(route('tests.result', $this->test))
            ->assertStatus(Response::HTTP_OK)
            ->assertSeeText($activeTest->title)
            ->assertSeeText($activeTest->excerpt)
            ->assertSeeText($activeTest->description)
            ->assertSeeText($activeTest->result()['title'])
            ->assertSeeText($activeTest->result()['description']);
    }

    public function test_completion_test_validation()
    {
        $activeTest = app(TestsRepository::class)->getActiveTestOrCreateNewIfCompleted($this->test);
        $validAnswersArray = $this->getValidAnswersArray($activeTest);

        //missing answers array
        $this->put(route('tests.complete', $this->test))
            ->assertSessionHasErrors('answers');

        //empty answers array
        $this->put(route('tests.complete', $this->test), [
            'answers' => []
        ])->assertSessionHasErrors('answers');

        //invalid answers array count
        $this->put(route('tests.complete', $this->test), [
            'answers' => range(1, $activeTest->questionsCount() + 1)
        ])->assertSessionHasErrors('answers');

        //multiple answers for same question
        $this->put(route('tests.complete', $this->test), [
            'answers' => range(1, $activeTest->questionsCount())
        ])->assertSessionHasErrors('answers');

        //single answer must be integer
        $this->put(route('tests.complete', $this->test), [
            'answers' => ['string']
        ])->assertSessionHasErrors('answers.0');

        //single answer cannot be empty
        $this->put(route('tests.complete', $this->test), [
            'answers' => ['', '2']
        ])->assertSessionHasErrors('answers.0');

        //single answer cannot belong to another test
        $answerFromAnotherTest = Test::with('questions.answers')->find(2)->questions->first()->answers->first();
        $this->put(route('tests.complete', $this->test), [
            'answers' => [$answerFromAnotherTest->id]
        ])->assertSessionHasErrors('answers.0');

        //successful validation
        $this->put(route('tests.complete', $this->test), [
            'answers' => $validAnswersArray
        ])->assertSessionMissing('answers');
    }


    public function test_user_can_complete_test()
    {
        $activeTest = app(TestsRepository::class)->getActiveTestOrCreateNewIfCompleted($this->test);
        $validAnswersArray = $this->getValidAnswersArray($activeTest);

        $this->get(route('tests.result', $this->test))->assertStatus(Response::HTTP_FOUND);

        $this->put(route('tests.complete', $this->test), [
            'answers' => $validAnswersArray
        ])->assertStatus(Response::HTTP_OK);

        $this->assertTrue($activeTest->isCompleted());
        $this->get(route('tests.result', $this->test))->assertStatus(Response::HTTP_OK);
    }

    /**
     * @param \App\Models\UserTest $activeTest
     * @return array
     */
    private function getValidAnswersArray(UserTest $activeTest): array
    {
        return $activeTest->questions()
            ->with('answers')
            ->get()
            ->map(fn($q) => $q->answers->first())
            ->pluck('id')
            ->toArray();
    }

}
