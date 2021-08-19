<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Repositories\PersonalityTestRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PersonalityTestController extends Controller
{


    public function index(Request $request, PersonalityTestRepository $personalityTestRepository)
    {
        $personalityTest = $personalityTestRepository->getActiveTestOrCreateNew();

        return $personalityTest;
    }

    public function show(Request $request,PersonalityTestRepository $personalityTestRepository)
    {
        $personalityTest = $personalityTestRepository->getActiveTest();

        if (!$personalityTest) {
            return response('', Response::HTTP_BAD_REQUEST);
        }

        if (!$personalityTest->isCompleted()) {
            return response('', Response::HTTP_BAD_REQUEST);
        }

        return $personalityTest->result();
    }


    public function store(Request $request, Answer $answer, PersonalityTestRepository $personalityTestRepository)
    {
        $personalityTest = $personalityTestRepository->getActiveTest();

        if (!$personalityTest) {
            return response('', Response::HTTP_BAD_REQUEST);
        }

        $result = $personalityTest->addAnswer($answer);

        if ($result) {
            return response([], Response::HTTP_CREATED);
        }

        return response([
            'message' => 'There was an unexpected error. Please try again.'
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
