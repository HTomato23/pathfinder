<?php

namespace Database\Seeders;

use App\Models\SoftSkillTest;
use Illuminate\Database\Seeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SoftSkillTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $softSkillQuestion = [
            // Communication (1-10)
            ['number' => 'Question 1', 'question' => 'Usually like to spend my free time with people.', 'name' => 'question_1'],
            ['number' => 'Question 2', 'question' => 'Am good at sensing what others are feeling.', 'name' => 'question_2'],
            ['number' => 'Question 3', 'question' => 'Love to chat.', 'name' => 'question_3'],
            ['number' => 'Question 4', 'question' => 'Get along well with people I have just met.', 'name' => 'question_4'],
            ['number' => 'Question 5', 'question' => 'Am open about my feelings.', 'name' => 'question_5'],
            ['number' => 'Question 6', 'question' => 'Know what to say to make people feel good.', 'name' => 'question_6'],
            ['number' => 'Question 7', 'question' => 'Am able to fit into any situation.', 'name' => 'question_7'],
            ['number' => 'Question 8', 'question' => 'Have the ability to make others feel interesting.', 'name' => 'question_8'],
            ['number' => 'Question 9', 'question' => 'Know what makes others tick.', 'name' => 'question_9'],
            ['number' => 'Question 10', 'question' => 'Radiate joy.', 'name' => 'question_10'],

            // Teamwork (11–15)
            ['number' => 'Question 11', 'question' => "Don't miss group meetings or team practices.", 'name' => 'question_11'],
            ['number' => 'Question 12', 'question' => 'Enjoy being part of a group.', 'name' => 'question_12'],
            ['number' => 'Question 13', 'question' => 'Support my teammates or fellow group members.', 'name' => 'question_13'],
            ['number' => 'Question 14', 'question' => 'Feel I must respect the decisions made by my group.', 'name' => 'question_14'],
            ['number' => 'Question 15', 'question' => "Don't talk badly to outsiders about my own group.", 'name' => 'question_15'],

            // Critical Thinking (16–20)
            ['number' => 'Question 16', 'question' => 'Love to read challenging material.', 'name' => 'question_16'],
            ['number' => 'Question 17', 'question' => 'Find political discussions interesting.', 'name' => 'question_17'],
            ['number' => 'Question 18', 'question' => 'Want to increase my knowledge.', 'name' => 'question_18'],
            ['number' => 'Question 19', 'question' => 'Enjoy examining myself and my life.', 'name' => 'question_19'],
            ['number' => 'Question 20', 'question' => 'Try to examine myself objectively.', 'name' => 'question_20'],

            // Adaptability (21–25)
            ['number' => 'Question 21', 'question' => 'Am good at taking advice.', 'name' => 'question_21'],
            ['number' => 'Question 22', 'question' => 'Adapt easily to new situations.', 'name' => 'question_22'],
            ['number' => 'Question 23', 'question' => 'Can stand criticism.', 'name' => 'question_23'],
            ['number' => 'Question 24', 'question' => 'Adjust easily.', 'name' => 'question_24'],
            ['number' => 'Question 25', 'question' => 'Go straight for the goal.', 'name' => 'question_25'],

            // Leadership (26–35)
            ['number' => 'Question 26', 'question' => 'Take charge.', 'name' => 'question_26'],
            ['number' => 'Question 27', 'question' => 'Try to make sure everyone in a group feels included.', 'name' => 'question_27'],
            ['number' => 'Question 28', 'question' => 'Express myself easily.', 'name' => 'question_28'],
            ['number' => 'Question 29', 'question' => 'Am the first to act.', 'name' => 'question_29'],
            ['number' => 'Question 30', 'question' => 'Never at a loss for words', 'name' => 'question_30'],
            ['number' => 'Question 31', 'question' => 'Like having authority over others.', 'name' => 'question_31'],
            ['number' => 'Question 32', 'question' => 'See myself as a good leader.', 'name' => 'question_32'],
            ['number' => 'Question 33', 'question' => 'Try to lead others.', 'name' => 'question_33'],
            ['number' => 'Question 34', 'question' => 'Want to be in charge.', 'name' => 'question_34'],
            ['number' => 'Question 35', 'question' => 'Have a strong need for power.', 'name' => 'question_35'],
        ];

        foreach ($softSkillQuestion as $item) {
            SoftSkillTest::create($item);
        }
    }
}
