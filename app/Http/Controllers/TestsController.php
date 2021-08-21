<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Test;
use App\Models\UserTest;
use App\Repositories\TestsRepository;
use App\Rules\BanMultipleAnswersForSameQuestion;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class TestsController extends Controller
{

    public function show(Request $request, Test $test, TestsRepository $testsRepo)
    {
        $userTest = $testsRepo->getActiveTestOrCreateNewIfCompleted($test);
        $userTest->setRelation('test', $test);
        $userTest->loadMissing('answers:id,question_id', 'test.questions.answers');

        return view('tests.show', [
            'userTest' => $userTest
        ]);
    }

    public function result(Request $request, Test $test, TestsRepository $testsRepo)
    {
        $userTest = $testsRepo->getActiveTest($test);

        if (!$userTest) {
            return redirect()->route('home');
        }

        if (!$userTest->isCompleted()) {
            flash('You first have to complete this test', 'danger');
            return redirect()->route('tests.show', $test);
        }

        $userTest->setRelation('test', $test);
        return view('tests.result', [
            'userTest' => $userTest,
            'result' => $userTest->result()
        ]);

    }


    public function complete(Request $request, Test $test, TestsRepository $testsRepo)
    {
        $validatedData = $request->validate([
            'answers' => [
                'array',
                'required',
                'size:' . $test->questions()->count(),
                new BanMultipleAnswersForSameQuestion()
            ],
            'answers.*' => [
                'required',
                'integer',
                Rule::in($test->availableAnswers()->pluck('id')->toArray()),
            ]
        ]);

        $userTest = $testsRepo->getActiveTest($test);

        if (!$userTest) {
            return response('', Response::HTTP_BAD_REQUEST);
        }

        $result = $userTest->syncAnswers($validatedData['answers']);

        if ($result) {
            return response([], Response::HTTP_CREATED);
        }

        return response([
            'message' => 'There was an unexpected error. Please try again.'
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
