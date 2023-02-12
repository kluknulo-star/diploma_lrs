<?php

namespace App\Statements\Http\Controllers\api;

use App\Models\Statement;
use App\Statements\repository\impl\StatementRepositoryImpl;
use App\Statements\Services\StatementService;
use Tests\TestCase;

class ApiStatementsControllerTest extends TestCase
{
    private int $statementId;

    public function testTest()
    {
        $statementService = new StatementService(new StatementRepositoryImpl());
        $this->statementId = $statementId = $statementService
            ->createStatement(['verb' => 'passed', 'actor' => 'Anatoly']);
        $actual = Statement::query()
            ->find($statementId)
            ->exists();
        $statement = Statement::query()
            ->select('content')
            ->find($statementId);
        $this->assertTrue(
            $statement->content == ['verb' => 'passed', 'actor' => 'Anatoly'] &&
            $actual
        );
    }

    public function tearDown(): void
    {
        Statement::query()->find($this->statementId)->delete();
    }
}
