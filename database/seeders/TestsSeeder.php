<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Test;
use Illuminate\Database\Seeder;

class TestsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        foreach ($this->testsArray() as $testDetails) {

            $answers = collect([]);
            $questions = [];

            foreach ($testDetails['questions'] as $questionTitle => $answersArray) {

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

            $test = Test::factory()->create($testDetails['test']);
            $test->questions()->sync($questions);
        }

    }

    private function testsArray(): array
    {
        return [
            'personality_test' => [
                'test' => [
                    'title' => 'Test: Are you an introvert or an extrovert?',
                    'excerpt' => 'So do you consider yourself more of an introvert or an extrovert? Take this test, put together with input from psychoanalyst Sandrine Dury, and find out',
                    'description' => 'At work, is it you who gets noticed first or perhaps the other people around you? Do you feel compelled to take centre-stage or are you more comfortable back-stage? If it’s the former, then you are eager for contact — warm and happy human relations. If it’s the latter, then solitude suits and stimulates you more and hell is often other people…',
                    'slug' => 'personality-test',
                    'image' => 'introvert_or_extrovert.jpg',
                    'classification' => [
                        ',-8' => [
                            'title' => 'You are very introvert',
                            'description' => app(\Faker\Generator::class)->paragraphs(5, true)
                        ],
                        '-7,-1' => [
                            'title' => 'You are a bit introvert',
                            'description' => app(\Faker\Generator::class)->paragraphs(5, true)
                        ],
                        '0,0' => [
                            'title' => 'You can be both',
                            'description' => app(\Faker\Generator::class)->paragraphs(5, true)
                        ],
                        '1,7' => [
                            'title' => 'You are a bit extrovert',
                            'description' => app(\Faker\Generator::class)->paragraphs(5, true)
                        ],
                        '8,' => [
                            'title' => 'You are very extrovert',
                            'description' => app(\Faker\Generator::class)->paragraphs(5, true)
                        ],
                    ]
                ],
                'questions' => [
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
                        'Hang around you all evening' => -1,
                        'Talk privately between themselves' => 1,
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
                ],
            ],
            'kindness_test' => [
                'test' => [
                    'title' => 'Test: How kind are you?',
                    'excerpt' => 'Kindness opens our capacity for thoughtfulness, helping to enrich our relationships and bring peace to the communities we live in. Who wouldn’t want more of that? So, how open are you to kindness? Take our test and find out',
                    'description' => '',
                    'slug' => 'how-kind-are-you',
                    'image' => 'test_how_kind_are_you.jpg',
                    'classification' => [
                        ',-8' => [
                            'title' => 'You are very kind',
                            'description' => app(\Faker\Generator::class)->paragraphs(5, true)
                        ],
                        '-7,-1' => [
                            'title' => 'You are not kind enough',
                            'description' => app(\Faker\Generator::class)->paragraphs(5, true)
                        ],
                        '0,0' => [
                            'title' => 'You are somewhere in the middle',
                            'description' => app(\Faker\Generator::class)->paragraphs(5, true)
                        ],
                        '1,7' => [
                            'title' => 'You are kind enough',
                            'description' => app(\Faker\Generator::class)->paragraphs(5, true)
                        ],
                        '8,' => [
                            'title' => 'You are very kind',
                            'description' => app(\Faker\Generator::class)->paragraphs(5, true)
                        ],
                    ]
                ],
                'questions' => [
                    'You are stopped on the street by a charity volunteer asking you to donate. You think…' => [
                        'How annoying!' => -3,
                        'You do not agree with the cause, and you tell them so' => -1,
                        'It’s a pain, but it’s for a good cause' => 1,
                        'Good for them; they’re really making an effort to raise funds' => 3
                    ],
                    'After waiting for the lift, it finally arrives. You get in and see someone else approaching. You:' => [
                        'Press the button: door closing...' => -3,
                        'Pretend not to see them and press the button for your floor' => -1,
                        'Pray that the door closes before the person gets in' => 1,
                        'Hold the door open until they get in' => 3
                    ],
                    'Your finances are in the red, but it’s your partner’s birthday tomorrow. You think:' => [
                        'You give them a token gift, just as a gesture' => -3,
                        'You’ll write them an IOU for a gift and get it when you can afford it' => -1,
                        'Oh dear, you’re going to go even more in the red now to get them a great gift' => 1,
                        'It’s not a problem – you buy their gifts months in advance anyway' => 3
                    ],
                    'At the queue in the post office, a foreign woman doesn’t understand what the assistant is saying. You:' => [
                        'Demand that they speed things up' => -3,
                        'Intervene and ask if you can help' => -1,
                        'Leave them to it – you’ll come back for what you need at a quieter time' => 1,
                        'See if you know the woman’s native language and volunteer to be her interpreter, or find someone else in the queue who might be able to help' => 3
                    ],
                    'Your best friend is moving home, but she’s saving money and not using a removal firm. You:' => [
                        'Really don’t want to carry boxes around all day. And you think it’s a stupid idea not to use a removal firm!' => -3,
                        'Lend a hand, if she asks for your help. Otherwise, you won’t offer' => -1,
                        'Tell her you’ll be there to help' => 1,
                        'Mobilise the maximum number of friends to help her out' => 3
                    ],
                    'Your colleague talks very loudly on the phone. You:' => [
                        'Constantly ask them to keep the volume down' => -3,
                        'Leave your desk when they make phonecalls, if you can' => -1,
                        'Put your headphones on to drown them out' => 1,
                        'Think that they can\'t really help having a loud voice, and you’re glad you don’t have his problem' => 3
                    ],
                    'The traffic lights change and the car behind you starts beeping furiously. You:' => [
                        'Stick two fingers up at them' => -3,
                        'Call them every name under the sun' => -1,
                        'Think, ‘there’s yet another super-stressed person in the world…’' => 1,
                        'Think, ‘this person must be in a hurry’, and hit the accelerator' => 3
                    ],
                ],
            ],
            'body_happiness_test' => [
                'test' => [
                    'title' => 'Test: How happy are you in your body?',
                    'excerpt' => 'Body confidence means more than liking what you see in the mirror. It’s about respecting what your body does and accepting how it looks. But, are you truly comfortable in your body? Take this test by psychotherapist, Sally Brown, to find out',
                    'description' => '',
                    'slug' => 'how-happy-are-you-with-your-body',
                    'image' => 'how_happy_are_you_with_your_body.jpg',
                    'classification' => [
                        ',-8' => [
                            'title' => 'You are very unhappy with your body',
                            'description' => app(\Faker\Generator::class)->paragraphs(5, true)
                        ],
                        '-7,-1' => [
                            'title' => 'You are a bit unhappy with your body',
                            'description' => app(\Faker\Generator::class)->paragraphs(5, true)
                        ],
                        '0,0' => [
                            'title' => 'You have mixed feelings about your body',
                            'description' => app(\Faker\Generator::class)->paragraphs(5, true)
                        ],
                        '1,7' => [
                            'title' => 'You are a happy enough with your body',
                            'description' => app(\Faker\Generator::class)->paragraphs(5, true)
                        ],
                        '8,' => [
                            'title' => 'You are very happy with your body',
                            'description' => app(\Faker\Generator::class)->paragraphs(5, true)
                        ],
                    ]
                ],
                'questions' => [
                    'Your colleagues are always moaning about their weight or bodies. How do you react?' => [
                        'Join in - you also have plenty to moan about' => -3,
                        'Point out their positive qualities to help them feel better' => -1,
                        'Encourage them to join you in an exercise class after work' => 1,
                        'Tune it out because you find it all a bit tedious' => 3
                    ],
                    'When you look in a full-length mirror, your gaze is drawn to…' => [
                        'Parts of your body you are proud of' => -3,
                        'Your hair or face, not your body' => -1,
                        'Your overall appearance' => 1,
                        'Parts of your body you dislike most' => 3
                    ],
                    'You get a party invitation saying \'dress fabulous\'. You…' => [
                        'Think of excuses not to go' => -3,
                        'Buy a new, figure-hugging outfit' => -1,
                        'Wear your trusty LBD and accessorise with statement jewellery and great shoes' => 1,
                        'Wear whatever is clean on the night' => 3
                    ],
                    'Growing up, your relationship with your body was…' => [
                        'Something you made a conscious effort to work at' => -3,
                        'Up and down, like your weight' => -1,
                        'Not something you thought about' => 1,
                        'Pretty good most of the time' => 3
                    ],
                    'How do you feel about media images of ‘perfect’ bodies?' => [
                        'You\'re drawn to them, even though they can ruin your day' => -3,
                        'They inspire you to stay in shape' => -1,
                        'You don\'t even register them' => 1,
                        'They\'re posed and Photoshopped; they don\'t even look like real people' => 3
                    ],
                    'Which statement sums up your attitude to looks and ageing?' => [
                        'It is harder to stay slim as you age' => -3,
                        'Good skin and a great haircut count' => -1,
                        'With good diet and exercise, you don\'t have to look old' => 1,
                        'Staying healthy is more important' => 3
                    ],
                    'Everyone is on the dance floor at a wedding. You:' => [
                        'Hold back; part of you would love to join in but you would feel too exposed' => -3,
                        'Hold back because you wouldn\'t have a clue what to do' => -1,
                        'Join in enthusiastically and get grannies and nephews to join in, too' => 1,
                        'Are right there in the middle of it all. You\'re a confident dancer' => 3
                    ],
                ],
            ],
            'confidence_test' => [
                'test' => [
                    'title' => 'Test: How confident are you?',
                    'excerpt' => 'How confident do you feel on a day-to-day basis? Are you always putting yourself down or perhaps others see you as arrogant? Here are 25 questions to assess how you come across. Test by Philip Carter and Ken Russell for Psychologies (France). Translated by Nora Mahony',
                    'description' => '',
                    'slug' => 'how-confident-are-you',
                    'image' => 'how_confident_are_you.jpg',
                    'classification' => [
                        ',-8' => [
                            'title' => 'You are not very confident',
                            'description' => app(\Faker\Generator::class)->paragraphs(5, true)
                        ],
                        '-7,-1' => [
                            'title' => 'You are not confident enough',
                            'description' => app(\Faker\Generator::class)->paragraphs(5, true)
                        ],
                        '0,0' => [
                            'title' => 'You are somewhere in the middle',
                            'description' => app(\Faker\Generator::class)->paragraphs(5, true)
                        ],
                        '1,7' => [
                            'title' => 'You are confident enough',
                            'description' => app(\Faker\Generator::class)->paragraphs(5, true)
                        ],
                        '8,' => [
                            'title' => 'You are very confident',
                            'description' => app(\Faker\Generator::class)->paragraphs(5, true)
                        ],
                    ]
                ],
                'questions' => [
                    'Would you consider appearing on a television game show?' => [
                        'No' => -3,
                        'I don’t know' => 0,
                        'Yes' => 3
                    ],
                    'Would giving a long speech at your best friend’s wedding completely embarrass you?' => [
                        'Yes' => -3,
                        'A little' => 0,
                        'No' => 3
                    ],
                    'Do you think that you are a particularly positive person?' => [
                        'No' => -3,
                        'Sometimes' => 0,
                        'Yes' => 3
                    ],
                    'Would you like to be the pilot on a plane?' => [
                        'No' => -3,
                        'I don’t know' => 0,
                        'Yes' => 3
                    ],
                    'Would you be interested in meeting royalty?' => [
                        'No' => -3,
                        'I’m not bothered' => 0,
                        'Yes' => 3
                    ],
                    'Have you ever disagreed with your boss at work?' => [
                        'No' => -3,
                        'Once or twice' => 0,
                        'Yes' => 3
                    ],
                    'Does being naked in front of your friends bother you?' => [
                        'Yes' => -3,
                        'Depends who' => 0,
                        'No' => 3
                    ],
                ],
            ],
            'hard_on_yourself_test' => [
                'test' => [
                    'title' => 'Test: Are you too hard on yourself?',
                    'excerpt' => 'Some people always judge themselves harshly, while others are more tolerant of their own faults. Do you punish yourself? Take our quick test by Christophe André and find out how forgiving you are about your own perceived and real shortcomings or errors',
                    'description' => '',
                    'slug' => 'are-you-too-hard-on-yourself',
                    'image' => 'are_you_too_hard_on_yourself.jpg',
                    'classification' => [
                        ',-8' => [
                            'title' => 'You are very lenient to yourself',
                            'description' => app(\Faker\Generator::class)->paragraphs(5, true)
                        ],
                        '-7,-1' => [
                            'title' => 'You are mostly lenient to yourself',
                            'description' => app(\Faker\Generator::class)->paragraphs(5, true)
                        ],
                        '0,0' => [
                            'title' => 'It depends on the occasion.',
                            'description' => app(\Faker\Generator::class)->paragraphs(5, true)
                        ],
                        '1,7' => [
                            'title' => 'You are quite hard on yourself',
                            'description' => app(\Faker\Generator::class)->paragraphs(5, true)
                        ],
                        '8,' => [
                            'title' => 'You are too hard on yourself',
                            'description' => app(\Faker\Generator::class)->paragraphs(5, true)
                        ],
                    ]
                ],
                'questions' => [
                    'You have been part of a team in which everyone worked hard — except for you (you had good reasons for this, but even so…). Your main worry is:' => [
                        'Over the final outcome: it would be bad if the project failed because some people hadn’t pulled their weight.' => -3,
                        'What others will now think of you: you would hate it if anyone drew attention to the fact that you didn’t really participate.' => 0,
                        'The pain you might have caused those who gave their all: you would feel awful if they failed because of you.' => 3
                    ],
                    'You have reserved a table at a restaurant. Something comes up at the last minute that means you can’t go, but you don’t cancel your booking. You’re thinking:' => [
                        'Not to worry. Someone will have called in on the off chance and will have been pleased to find that there was a table.' => -3,
                        'I should have cancelled it. They probably held the table for us and lost money.' => 0,
                        'I should have cancelled it. We’ll go and eat there some other time to make up for it.' => 3
                    ],
                    'How do you feel when you are happy, but everyone around you seems depressed?' => [
                        'You can’t help it. What can you do? Pretending to be unhappy won’t help anyone.' => -3,
                        'ou feel a bit guilty and try to keep your good mood under wraps.' => 0,
                        'It’s a real problem. You sometimes feel ashamed to be so happy when so much of the world lives in misery.' => 3
                    ],
                    'You’re at a party and having a good time, but one of the guests, who doesn’t seem to know anybody, is sitting alone in a corner, looking depressed…' => [
                        'That’s their problem. You’re not there to look after people, but to see friends and enjoy yourself.' => -3,
                        'You feel sorry for them and, several times during the evening, mean to go over and speak to them.' => 0,
                        'When you get home you feel ashamed of yourself because you ate, drank and had fun without having spoken to or cheered up that person.' => 3
                    ],

                    'You’ve forgotten your niece’s birthday and haven’t bought her a present. She bursts into tears. You:' => [
                        'You understand why she feels upset. You wish you could make her feel better.' => -3,
                        'Feel like crying. You are wondering if she’ll ever forgive you.' => 0,
                        'You feel like the lowest of the low, and wish you could disappear. How will you ever forgive yourself?' => 3
                    ],
                    'If a child gets tooth decay, whose fault is it?' => [
                        'It’s the fault of the dentists and doctors, who should work harder to educate people about health issues and get parents involved. And it’s partly the child’s fault – it should have listened to its parents.' => -3,
                        'It’s the fault of the parents, who didn’t do their job watching what the child ate.' => 0,
                        'It’s the fault of society, which allows the advertising of sweets, cakes and sugary drinks to children.' => 3
                    ],
                    'You get an invite to a party you’re not interested in going to. What do you do?' => [
                        'Say ‘no’ straightaway. What would be the point in going if you didn’t want to be there and your host knew you didn’t want to be there?' => -3,
                        'You would feel uncomfortable going so you invent an excuse to get out of it.' => 0,
                        'You would have real difficulty turning it down. You usually say ‘yes’ to invitations, even if you really don’t want to be there.' => 3
                    ],
                ],
            ],
            'do_your_thoughts_limit_your_sleep_test' => [
                'test' => [
                    'title' => 'Test: Do your thoughts limit your sleep?',
                    'excerpt' => 'Your beliefs can have as big an influence on the quantity and quality of your sleep as your lifestyle habits. Take our quiz by psychotherapist Sally Brown to find out more',
                    'description' => '',
                    'slug' => 'do-your-thoughts-limit-your-sleep',
                    'image' => 'do_your_thoughts_limit_your_sleep.jpg',
                    'classification' => [
                        ',-8' => [
                            'title' => 'Your thoughts can never limit your sleep',
                            'description' => app(\Faker\Generator::class)->paragraphs(5, true)
                        ],
                        '-7,-1' => [
                            'title' => 'You rarely stay awake because of your thoughts',
                            'description' => app(\Faker\Generator::class)->paragraphs(5, true)
                        ],
                        '0,0' => [
                            'title' => 'Your thoughts tend to limit your sleep but you are working on it',
                            'description' => app(\Faker\Generator::class)->paragraphs(5, true)
                        ],
                        '1,7' => [
                            'title' => 'Your thoughts frequently limit your sleep',
                            'description' => app(\Faker\Generator::class)->paragraphs(5, true)
                        ],
                        '8,' => [
                            'title' => 'Your thoughts highly limit your sleep',
                            'description' => app(\Faker\Generator::class)->paragraphs(5, true)
                        ],
                    ]
                ],
                'questions' => [
                    'You wake in the middle of the night. What’s your reaction?' => [
                        "‘Is it too early to get up?’" => -3,
                        "'Here we go again’" => -1,
                        "‘Tomorrow I’ll be so tired’" => 1,
                        "‘I feel like I’m having a panic attack’" => 3
                    ],
                    'The night before an important meeting, what do you do?' => [
                        "Have a glass of wine to relax" => -3,
                        "Stay up late, preparing" => -1,
                        "Go to bed an hour early, to make sure you get enough sleep" => 1,
                        "Feel so anxious about not sleeping that you find it hard to drop off" => 3
                    ],
                    'A budget airline flight for a weekend away involves getting to the airport for 5am. Do you:' => [
                        "Book it – it’s a bargain" => -3,
                        "Go to bed early, but not really expect to get much sleep" => -1,
                        "Worry so much about oversleeping you probably don’t sleep at all" => 1,
                        "Not even think about going as exhaustion outweighs any enjoyment" => 3
                    ],
                    "What’s your usual bedtime routine?" => [
                        "There is no routine; you always go to bed later than you planned" => -3,
                        "Go to bed with books or music to occupy you if you can’t sleep" => -1,
                        "Stick to a set time and wind down at least half an hour before" => 1,
                        "Wait until you’re exhausted" => 3
                    ],
                    "How do you feel about weekend lie-ins?" => [
                        "You’d rather be up and about" => -3,
                        "Not something you do – the later you get to bed, the earlier you wake" => -1,
                        "They’re a lifesaver and the highlight of your weekend" => 1,
                        "Essential – worrying has disturbed your sleep during the week" => 3
                    ],
                    "What one change would improve your sleep quality?" => [
                        "Not setting an alarm and sleeping as long as you want" => -3,
                        "Not having so much to do, so you could get to bed earlier" => -1,
                        "Feeling confident you could sleep well most nights" => 1,
                        "Being able to switch off your mind" => 3
                    ],
                    "How would you describe your daily energy levels?" => [
                        "You’re buzzing on adrenaline" => -3,
                        "Fine – as long as you’ve had your usual eight hours’ sleep" => -1,
                        "Up and down – depending on stress" => 1,
                        "Being tired has become normal" => 3
                    ],
                ],
            ]
        ];
    }
}
