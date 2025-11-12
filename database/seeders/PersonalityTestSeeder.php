<?php

namespace Database\Seeders;

use App\Models\PersonalityTest;
use Illuminate\Database\Seeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PersonalityTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $personalityQuestion = [
            // Openness (1–10)
            ['number' => 'Question 1',  'traits' => 'Openness', 'question' => 'Believe in the importance of art.', 'name' => 'question_1'],
            ['number' => 'Question 2',  'traits' => 'Openness', 'question' => 'Have a vivid imagination.', 'name' => 'question_2'],
            ['number' => 'Question 3',  'traits' => 'Openness', 'question' => 'Tend to vote for liberal political candidates.', 'name' => 'question_3'],
            ['number' => 'Question 4',  'traits' => 'Openness', 'question' => 'Carry the conversation to a higher level.', 'name' => 'question_4'],
            ['number' => 'Question 5',  'traits' => 'Openness', 'question' => 'Enjoy hearing new ideas.', 'name' => 'question_5'],
            ['number' => 'Question 6',  'traits' => 'Openness', 'question' => 'Enjoy thinking about things.', 'name' => 'question_6'],
            ['number' => 'Question 7',  'traits' => 'Openness', 'question' => 'Can say things beautifully.', 'name' => 'question_7'],
            ['number' => 'Question 8',  'traits' => 'Openness', 'question' => 'Enjoy wild flights of fantasy.', 'name' => 'question_8'],
            ['number' => 'Question 9',  'traits' => 'Openness', 'question' => 'Get excited by new ideas.', 'name' => 'question_9'],
            ['number' => 'Question 10', 'traits' => 'Openness', 'question' => 'Have a rich vocabulary.', 'name' => 'question_10'],

            // Conscientiousness (11–20)
            ['number' => 'Question 11', 'traits' => 'Conscientiousness', 'question' => 'Am always prepared.', 'name' => 'question_11'],
            ['number' => 'Question 12', 'traits' => 'Conscientiousness', 'question' => 'Pay attention to details.', 'name' => 'question_12'],
            ['number' => 'Question 13', 'traits' => 'Conscientiousness', 'question' => 'Get chores done right away.', 'name' => 'question_13'],
            ['number' => 'Question 14', 'traits' => 'Conscientiousness', 'question' => 'Carry out my plans.', 'name' => 'question_14'],
            ['number' => 'Question 15', 'traits' => 'Conscientiousness', 'question' => 'Make plans and stick to them.', 'name' => 'question_15'],
            ['number' => 'Question 16', 'traits' => 'Conscientiousness', 'question' => 'Complete tasks successfully.', 'name' => 'question_16'],
            ['number' => 'Question 17', 'traits' => 'Conscientiousness', 'question' => 'Do things according to a plan.', 'name' => 'question_17'],
            ['number' => 'Question 18', 'traits' => 'Conscientiousness', 'question' => 'Am exacting in my work.', 'name' => 'question_18'],
            ['number' => 'Question 19', 'traits' => 'Conscientiousness', 'question' => 'Finish what I start.', 'name' => 'question_19'],
            ['number' => 'Question 20', 'traits' => 'Conscientiousness', 'question' => 'Follow through with my plans.', 'name' => 'question_20'],

            // Extraversion (21–30)
            ['number' => 'Question 21', 'traits' => 'Extraversion', 'question' => 'Feel comfortable around people.', 'name' => 'question_21'],
            ['number' => 'Question 22', 'traits' => 'Extraversion', 'question' => 'Make friends easily.', 'name' => 'question_22'],
            ['number' => 'Question 23', 'traits' => 'Extraversion', 'question' => 'Am skilled in handling social situations.', 'name' => 'question_23'],
            ['number' => 'Question 24', 'traits' => 'Extraversion', 'question' => 'Am the life of the party.', 'name' => 'question_24'],
            ['number' => 'Question 25', 'traits' => 'Extraversion', 'question' => 'Know how to captivate people.', 'name' => 'question_25'],
            ['number' => 'Question 26', 'traits' => 'Extraversion', 'question' => 'Start conversations.', 'name' => 'question_26'],
            ['number' => 'Question 27', 'traits' => 'Extraversion', 'question' => 'Warm up quickly to others.', 'name' => 'question_27'],
            ['number' => 'Question 28', 'traits' => 'Extraversion', 'question' => 'Talk to a lot of different people at parties.', 'name' => 'question_28'],
            ['number' => 'Question 29', 'traits' => 'Extraversion', 'question' => "Don't mind being the center of attention.", 'name' => 'question_29'],
            ['number' => 'Question 30', 'traits' => 'Extraversion', 'question' => 'Cheer people up.', 'name' => 'question_30'],

            // Agreeableness (31–40)
            ['number' => 'Question 31', 'traits' => 'Agreeableness', 'question' => 'Have a good word for everyone.', 'name' => 'question_31'],
            ['number' => 'Question 32', 'traits' => 'Agreeableness', 'question' => 'Believe that others have good intentions.', 'name' => 'question_32'],
            ['number' => 'Question 33', 'traits' => 'Agreeableness', 'question' => 'Respect others.', 'name' => 'question_33'],
            ['number' => 'Question 34', 'traits' => 'Agreeableness', 'question' => 'Accept people as they are.', 'name' => 'question_34'],
            ['number' => 'Question 35', 'traits' => 'Agreeableness', 'question' => 'Make people feel at ease.', 'name' => 'question_35'],
            ['number' => 'Question 36', 'traits' => 'Agreeableness', 'question' => 'Am concerned about others.', 'name' => 'question_36'],
            ['number' => 'Question 37', 'traits' => 'Agreeableness', 'question' => 'Trust what people say.', 'name' => 'question_37'],
            ['number' => 'Question 38', 'traits' => 'Agreeableness', 'question' => "Sympathize with others' feelings.", 'name' => 'question_38'],
            ['number' => 'Question 39', 'traits' => 'Agreeableness', 'question' => 'Am easy to satisfy.', 'name' => 'question_39'],
            ['number' => 'Question 40', 'traits' => 'Agreeableness', 'question' => 'Treat all people equally.', 'name' => 'question_40'],

            // Neuroticism (41–50)
            ['number' => 'Question 41', 'traits' => 'Neuroticism', 'question' => 'Often feel blue.', 'name' => 'question_41'],
            ['number' => 'Question 42', 'traits' => 'Neuroticism', 'question' => 'Dislike myself.', 'name' => 'question_42'],
            ['number' => 'Question 43', 'traits' => 'Neuroticism', 'question' => 'Am often down in the dumps.', 'name' => 'question_43'],
            ['number' => 'Question 44', 'traits' => 'Neuroticism', 'question' => 'Have frequent mood swings.', 'name' => 'question_44'],
            ['number' => 'Question 45', 'traits' => 'Neuroticism', 'question' => 'Panic easily.', 'name' => 'question_45'],
            ['number' => 'Question 46', 'traits' => 'Neuroticism', 'question' => 'Am filled with doubts about things.', 'name' => 'question_46'],
            ['number' => 'Question 47', 'traits' => 'Neuroticism', 'question' => 'Feel threatened easily.', 'name' => 'question_47'],
            ['number' => 'Question 48', 'traits' => 'Neuroticism', 'question' => 'Get stressed out easily.', 'name' => 'question_48'],
            ['number' => 'Question 49', 'traits' => 'Neuroticism', 'question' => 'Fear for the worst.', 'name' => 'question_49'],
            ['number' => 'Question 50', 'traits' => 'Neuroticism', 'question' => 'Worry about things.', 'name' => 'question_50'],
        ];

        foreach ($personalityQuestion as $item) {
            PersonalityTest::create($item);
        }
    }
}
