<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Statement>
 */
class StatementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name = ['Gosha', 'Vera', 'Eugenie', 'Poll', 'Anatoly', 'Victor'];
        $verbName = [
            'follow', 'find', 'favorite', 'experience', 'dislike', 'disagree', 'deny',
            'deliver', 'delete', 'create', 'checkin', 'consume', 'confirm', 'complete',
            'close', 'cancel', 'build', 'borrow', 'authorize', 'author', 'attend',
            'attach', 'at', 'assign', 'archive', 'approve', 'append', 'agree',
            'add', 'accept', 'access', 'acknowledge'
        ];
        $namesOfType = ['article', 'video', 'test'];

        $userEmail = fake()->email();
        $userId = rand(0, 999999);
        $userName = $name[rand(0, count($name) - 1)];
        $verbNameTmp = $verbName[rand(0, (count($verbName) - 1))];
        $courseId = rand(0, 20);
        $sectionId = rand(0, 15);
        $typeName = $namesOfType[rand(0, count($namesOfType) - 1)];
        $courseTitle = fake()->title();

        $data =  ['content' =>
            [
                'actor' => [
                    'objectType' => 'Agent',
                    'mbox' => 'mailto:' . $userEmail, //index
                    'openid' => 'http://course-zone.org/expapi/users/' . $userId, // index low
                    'name' => 'http://course-zone.org/expapi/users/' . $userName,
                ],
                'verb' => [
                    'id' => 'http://adlnet.gov/expapi/verbs/' . $verbNameTmp, // index
                    'display' => [
                        "en-US" => $verbNameTmp,
                    ],
                ],
                'object' => [
                    "id" => 'http://course-zone.org/expapi/courses/section/' . $sectionId,
                    "type" => "http://course-zone.org/expapi/courses/section/type/" . $typeName,
                    'display' => [
                        "en-US" => $typeName,
//                            "ru-Ru" => "<--имя_типа-->",
                    ],
                    'objectType' => 'Activity',
                ],
                'context' => [
                    'id' => 'http://course-zone.org/expapi/courses/' . $courseId,
                    "display" => [
                        "en-US" => $courseTitle,
//                        "ru-Ru" => "<--курса_заголовок-->",
                    ],
                ]
            ]
        ];
        return $data;
    }
}
