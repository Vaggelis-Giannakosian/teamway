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

    public function getActiveTestOrCreateNewIfCompleted(Test $test): UserTest
    {
        $activeTest = $this->getActiveTest($test);

        if ($activeTest) {
            return $activeTest->isCompleted() ? $this->destroyActiveTestAndCreateNew($test) : $activeTest;
        }

        return $this->createNewTest($test);
    }

    public function getActiveTest(Test $test): ?UserTest
    {
        return UserTest::where(['session_id' => $this->sessionUUID, 'test_id' => $test->id])->first();
    }

    private function createNewTest(Test $test): UserTest
    {
        return UserTest::create(['session_id' => $this->sessionUUID, 'test_id' => $test->id]);
    }

    private function destroyActiveTestAndCreateNew(Test $test): UserTest
    {
        $activeTest = $this->getActiveTest($test);

        if ($activeTest) {
            $activeTest->delete();
        }

        return $this->createNewTest($test);
    }
}
