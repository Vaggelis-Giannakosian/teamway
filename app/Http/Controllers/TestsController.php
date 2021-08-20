<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Test;
use App\Models\UserTest;
use App\Repositories\TestsRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TestsController extends Controller
{

    public function index(Request $request, Test $test, TestsRepository $testsRepo)
    {
        $userTest = $testsRepo->getActiveTestOrCreateNew($test);
        $userTest->setRelation('test',$test);
        $userTest->loadMissing('test.questions.answers');

        return view('test', [
            'userTest' => $userTest
        ]);
    }

    public function show(Request $request, Test $test, TestsRepository $testsRepo)
    {
        $userTest = $testsRepo->getActiveTest($test);

        if (!$userTest) {
            return redirect()->route('home');
        }

        if (!$userTest->isCompleted()) {
            flash('You first have to complete this test', 'danger');
            return redirect()->route('tests.index', $test);
        }

        return $userTest->result();
    }


    public function store(Request $request, Test $test, Answer $answer, TestsRepository $testsRepo)
    {
        $userTest = $testsRepo->getActiveTest($test);

        if (!$userTest) {
            return response('', Response::HTTP_BAD_REQUEST);
        }

        $result = $userTest->addAnswer($answer);

        if ($result) {
            return response([], Response::HTTP_CREATED);
        }

        return response([
            'message' => 'There was an unexpected error. Please try again.'
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
