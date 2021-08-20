<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Test;
use Illuminate\Database\Seeder;

class QuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $answers = collect([]);
        $questions = [];
        foreach ($this->questionsArray() as $questionTitle => $answersArray) {

            $question = Question::factory()->create(['title' => $questionTitle]);
            $questions[$question->id] = ['order_column' => $question->id];

            foreach ($answersArray as $answer => $value) {
                $answers->push([
                    'label' => $answer,
                    'value' => $value,
                    'question_id' => $question->id
                ]);
            }
        }

        Answer::insert($answers->toArray());

        $personalityTest = Test::factory()->create([
            'title' => 'Test: Are you an introvert or an extrovert?',
            'description' => 'So do you consider yourself more of an introvert or an extrovert? Take this test, put together with input from psychoanalyst Sandrine Dury, and find out',
            'slug' => 'personality-test'
        ]);
        $personalityTest->questions()->sync($questions);
    }

    private function questionsArray(): array
    {
        return [
            'You’re really busy at work and a colleague is telling you their life story and personal woes. You:' => [
                'Don’t dare to interrupt them' => -3,
                'Think it’s more important to give them some of your time; work can wait' => -1,
                'Listen, but with only with half an ear' => 1,
                'Interrupt and explain that you are really busy at the moment' => 3
            ],
            'You’ve been sitting in the doctor’s waiting room for more than 25 minutes. You:' => [
                'Look at your watch every two minutes' => -3,
                'Bubble with inner anger, but keep quiet' => -1,
                'Explain to other equally impatient people in the room that the doctor is always running late' => 1,
                'Complain in a loud voice, while tapping your foot impatiently' => 3
            ],
            'You’re having an animated discussion with a colleague regarding a project that you’re in charge of. You:' => [
                'Don’t dare contradict them' => -3,
                'Think that they are obviously right' => -1,
                'Defend your own point of view, tooth and nail' => 1,
                'Continuously interrupt your colleague' => 3
            ],
            'You are taking part in a guided tour of a museum. You:' => [
                'Are a bit too far towards the back so don’t really hear what the guide is saying' => -3,
                'Follow the group without question' => -1,
                'Make sure that everyone is able to hear properly' => 1,
                'Are right up the front, adding your own comments in a loud voice' => 3
            ],
            'During dinner parties at your home, you have a hard time with people who:' => [
                'Ask you to tell a story in front of everyone else' => -3,
                'Talk privately between themselves' => -1,
                'Hang around you all evening' => 1,
                'Always drag the conversation back to themselves' => 3
            ],
            'You crack a joke at work, but nobody seems to have noticed. You:' => [
                'Think it’s for the best — it was a lame joke anyway' => -3,
                'Wait to share it with your friends after work' => -1,
                'Try again a bit later with one of your colleagues' => 1,
                'Keep telling it until they pay attention' => 3
            ],
            'This morning, your agenda seems to be free. You:' => [
                'Know that somebody will find a reason to come and bother you' => -3,
                'Heave a sigh of relief and look forward to a day without stress' => -1,
                'Question your colleagues about a project that’s been worrying you' => 1,
                'Pick up the phone and start filling up your agenda with meetings' => 3
            ],
        ];
    }
}
