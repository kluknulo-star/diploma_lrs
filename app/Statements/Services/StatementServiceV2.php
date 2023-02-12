<?php

namespace App\Statements\Services;

use App\Models\Statement;
use App\Statements\repository\StatementRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class StatementServiceV2
{

    public static function getFilteredStatements(array $params): Collection|array
    {
        $statementBuilder = Statement::query();
        if(isset($params['verb'])) {
            $statementBuilder = $statementBuilder->where('verb', $params['verb']);
        }
        if(isset($params['activity'])){
            $statementBuilder = $statementBuilder->where('activity', $params['activity']);
        }

        return $statementBuilder->get();

    }
}
