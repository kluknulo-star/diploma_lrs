<?php

namespace Database\Seeders;

use App\Models\Statement;
use Carbon\Traits\Date;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Type\Time;

class StatementSeeder extends Seeder
{
    //      php artisan db:seed --class=StatementSeeder
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timeStamp = now();
        $iter = 2 * 10;
        for ($ix = 0; $ix < $iter; $ix++) {
            echo "\nвыполнен $ix из $iter\n";
            $name = ['Gosha', 'Vera', 'Eugenie', 'Poll', 'Anatoly', 'Victor'];
            $verbName = ['launched', 'passed', 'failed', 'completed',];
            $namesOfType = ['article', 'video', 'test'];
            echo "Формируется контент.....\r\n";
            $seedQuantity = 10000;

            for ($i = 1; $i <= $seedQuantity; $i++) {
                echo "\r    " . round($i / $seedQuantity * 100) . "\t%";
                $userEmail = fake()->email();
                $userId = rand(0, 999999);
                $userName = $name[rand(0, count($name) - 1)];
                $verbNameTmp = $verbName[rand(0, (count($verbName) - 1))];
                $courseId = rand(0, 20);
                $sectionId = rand(0, 15);
                $typeName = $namesOfType[rand(0, count($namesOfType) - 1)];
                $courseTitle = fake()->title();

                $data[] = ['content' => json_encode(
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
                            ],
                            'objectType' => 'Activity',
                        ],
                        'context' => [
                            'id' => 'http://course-zone.org/expapi/courses/' . $courseId,
                            "display" => [
                                "en-US" => $courseTitle,
                            ],
                        ]
                    ], JSON_UNESCAPED_SLASHES)
                ];
            }

            $len = 5000;
            $division = $seedQuantity / $len;
            echo "\nДобавляется в бд......\n";
            foreach (array_chunk($data, $len) as $key => $chunk) {
                echo "\r    " . $key / $division * 100 . "\t%";
                DB::table('statements')->insert($chunk);
            }
            echo "\r\n";
            echo "\t time from starting seeding ---------- " . (now()->diffInMilliseconds($timeStamp,)) . " ms.\v\n";
            unset($data);
        }
    }
}
