<?php

namespace Tests\Unit;


use App\Models\Answer;
use App\Models\Test;
use App\Models\UserTest;
use App\Repositories\TestsRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class TestRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private TestsRepository $testRepo;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->testRepo = app(TestsRepository::class);
    }

    public function test_count_method()
    {
        Test::factory()->count($randomInt = random_int(1, 10))->create();

        $this->assertEquals($randomInt, $this->testRepo->count());
    }

    public function test_all_method()
    {
        $all = Test::factory()->count($randomInt = random_int(1, 10))->create();

        $this->assertEquals($all->pluck('id'), $this->testRepo->all()->pluck('id'));
    }

    public function test_user_can_get_active_instance_for_specific_test()
    {
        //hit an endpoint to create session uuid key
        $this->get('/');
        $activeTest = UserTest::factory()->create(['session_id' => session()->get('uuid')]);
        $this->testRepo->refreshSessionId();

        $this->assertTrue($activeTest->is($this->testRepo->getActiveTest($activeTest->test)));
    }

    public function test_user_can_create_new_instance_for_specific_test()
    {
        //hit an endpoint to create session uuid key
        $this->get('/');
        $test = Test::factory()->create();
        $answer = Answer::factory()->create();
        $test->questions()->attach($answer->question);
        $this->testRepo->refreshSessionId();

        //create new test
        $firstTest = $this->testRepo->getActiveTestOrCreateNewIfCompleted($test);

        $this->assertInstanceOf(UserTest::class,$firstTest);
        $this->assertFalse($firstTest->isCompleted());

        //get same test again
        $this->assertTrue($firstTest->is($this->testRepo->getActiveTestOrCreateNewIfCompleted($test)));

        //complete this test
        $firstTest->syncAnswers([$answer->id]);
        $this->assertTrue($firstTest->isCompleted());

        //get a new instance while removing the old one
        $currentActiveTest = $this->testRepo->getActiveTestOrCreateNewIfCompleted($test);
        $this->assertFalse($firstTest->is($currentActiveTest));
        $this->assertDatabaseMissing('user_tests',$firstTest->toArray());
    }
}
