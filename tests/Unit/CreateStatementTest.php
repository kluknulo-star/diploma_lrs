<?php

namespace Tests\Unit;

use App\Statements\repository\impl\StatementRepositoryImpl;
use App\Statements\Services\StatementService;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use App\Models\Statement;


class CreateStatementTest extends TestCase
{
    public function testCreateStatement(): void
    {
        $dumpJsonContent = [
            'actor' => [
                'objectType' => 'Agent',
                'mbox' => 'mailto:' . fake()->email,
                'openid' => 'http://course-zone.org/expapi/users:' . fake()->uuid,
                'name' => 'http://course-zone.org/expapi/users:' . fake()->name,
            ],
            'verb' => [
                'id' => 'http://course-zone.org/expapi/verbs:create',
                'display' => [
                    "en-US" => 'create',
                ],
            ],
            'object' => [
                "id" => 'http://course-zone.org/expapi/courses/section:' . fake()->uuid,
                "type" => "http://course-zone.org/expapi/courses/section/type:" . fake()->word,
                'display' => [
                    "en-US" => fake()->word,
                ],
                'objectType' => 'Activity',
            ]
        ];

        $createdStatementId = (new StatementService(new StatementRepositoryImpl()))
            ->createStatement($dumpJsonContent);

        $newStatementContent = Statement::query()
            ->find($createdStatementId, ['content']);

        $this->assertTrue($newStatementContent->content == $dumpJsonContent);

        Statement::query()
            ->find($createdStatementId)
            ->delete();
    }
}
