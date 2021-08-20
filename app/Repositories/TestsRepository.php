<?php

namespace App\Repositories;

use App\Models\Test;
use App\Models\UserTest;

class TestsRepository
{

    public function __construct()
    {
        $this->sessionUUID = session()->get('uuid');
    }

    public function getActiveTestOrCreateNew(Test $test): UserTest
    {
        return $this->getActiveTest($test) ?? $this->createNewTest($test);
    }

    public function getActiveTest(Test $test): ?UserTest
    {
        return UserTest::where(['session_id' => $this->sessionUUID, 'test_id' => $test->id])->first();
    }

    public function createNewTest(Test $test): UserTest
    {
        return UserTest::create(['session_id' => $this->sessionUUID, 'test_id' => $test->id]);
    }

    public function destroyActiveTest(Test $test): bool
    {
        $activeTest = $this->getActiveTest($test);

        if ($activeTest) {
            return $activeTest->delete();
        }

        throw new \Exception('Test not found');
    }
}
