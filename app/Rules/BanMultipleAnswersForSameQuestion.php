<?php

namespace App\Rules;

use App\Models\Answer;
use Illuminate\Contracts\Validation\Rule;

class BanMultipleAnswersForSameQuestion implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $answersArray)
    {
        $distinctQuestionsCount = Answer::whereIn('id',$answersArray)
            ->distinct('question_id')
            ->count('question_id');

        return $distinctQuestionsCount === count($answersArray);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute cannot have multiple answers for same question.';
    }
}
