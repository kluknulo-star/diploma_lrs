<?php

namespace App\Statements\repository\impl;

use App\Models\Statement;
use App\Statements\repository\StatementRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Pagination\LengthAwarePaginator;

class StatementEloquentRepositoryImpl implements StatementRepository
{
    public function getPaginatedStatements(int $statementsPerPage = 20): LengthAwarePaginator
    {
        return Statement::query()->paginate($statementsPerPage);
    }

    public function getCursorPaginatedStatements(int $statementsPerPage = 10): CursorPaginator
    {
        return Statement::query()->cursorPaginate($statementsPerPage);
    }

    public function createStatement(Statement $statement): int
    {
        $statement->save();
        return $statement->statement_id;
    }

    public function getStatementBuilder(): Builder
    {
        return Statement::query();
    }

    public function filterStatementByVerb(Builder $builderForSorting, string $filterValue): Builder
    {
        return $builderForSorting
            ->whereJsonContains('content', $filterValue, 'or', false)
            // КАК ИСКАТЬ??????
            ->whereJsonContains('content', $filterValue, 'and', false);
    }

    public function filterStatementByActor(Builder $builderForSorting, string $filterValue): Builder
    {
        return $builderForSorting;
    }

    public function filterStatementByObject(Builder $builderForSorting, string $filterValue): Builder
    {
        return $builderForSorting;
    }

    public function filterStatementByContext(Builder $builderForSorting, string $filterValue): Builder
    {
        return $builderForSorting;
    }

    public function selectSortDirection(Builder $builderForSorting, string $direction = 'DESC'): Builder
    {
        return $builderForSorting->orderBy('statement_id', $direction);
    }


}
