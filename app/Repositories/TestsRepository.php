<?php

namespace App\Repositories;

use App\Models\Test;

class TestsRepository
{

    public function __construct()
    {
        $this->sessionUUID = session()->get('uuid');
    }

    public function getActiveTestOrCreateNew():Test
    {
        return $this->getActiveTest() ?? $this->createNewTest();
    }

    public function getActiveTest(): ?Test
    {
        return Test::where('uuid', $this->sessionUUID)->first();
    }

    public function createNewTest(): Test
    {
        return Test::create(['uuid' => $this->sessionUUID]);
    }

    public function destroyActiveTest(): bool
    {
        $activeTest = $this->getActiveTest();

        if($activeTest){
            return $activeTest->delete();
        }

        throw new \Exception('Test not found');
    }
}
