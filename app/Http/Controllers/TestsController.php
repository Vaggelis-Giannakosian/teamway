<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Repositories\TestsRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TestsController extends Controller
{


    public function index(Request $request, TestsRepository $testsRepo)
    {
        $userTest = $testsRepo->getActiveTestOrCreateNew();

        return $userTest;
    }

    public function show(Request $request,TestsRepository $testsRepo)
    {
        $test = $testsRepo->getActiveTest();

        if (!$test) {
            abort(Response::HTTP_NOT_FOUND);
        }

        if (!$test->isCompleted()) {
            //TODO: redirect back to test
            return response('', Response::HTTP_BAD_REQUEST);
        }

        return $test->result();
    }


    public function store(Request $request, Answer $answer, TestsRepository $testsRepo)
    {
        $test = $testsRepo->getActiveTest();

        if (!$test) {
            return response('', Response::HTTP_BAD_REQUEST);
        }

        $result = $test->addAnswer($answer);

        if ($result) {
            return response([], Response::HTTP_CREATED);
        }

        return response([
            'message' => 'There was an unexpected error. Please try again.'
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
