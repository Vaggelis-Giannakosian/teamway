<?php

namespace Tests\Feature;

use App\Models\Test;
use Database\Seeders\TestsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeRouteTest extends TestCase
{

    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(TestsSeeder::class);
    }

    public function test_home_route()
    {
        $tests = Test::all();

        $this->assertCount(6,$tests);

        $this->get(route('home'))
            ->assertStatus(200)
            ->assertViewHas('tests',$tests);
    }

}
