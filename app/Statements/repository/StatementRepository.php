<?php

namespace App\Statements\repository;

use App\Models\Statement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Pagination\LengthAwarePaginator;

interface StatementRepository
{
    public function getStatementBuilder(): Builder;

    public function getPaginatedStatements(int $statementsPerPage = 20): LengthAwarePaginator;

    public function getCursorPaginatedStatements(int $statementsPerPage = 10): CursorPaginator;

    public function createStatement(Statement $statement);

    public function filterStatementByVerb(Builder $builderForSorting, string $filterValue): Builder;

    public function filterStatementByVerbs(Builder $builderForSorting, array $filterValues): Builder;

    public function filterStatementByActor(Builder $builderForSorting, string $filterValue): Builder;

    public function filterStatementByActors(Builder $builderForSorting, array $filterValues): Builder;

    public function filterStatementByObject(Builder $builderForSorting, string $filterValue): Builder;

    public function filterStatementByObjects(Builder $builderForSorting, array $filterValues): Builder;

    public function filterStatementByContext(Builder $builderForSorting, string $filterValue): Builder;

    public function filterStatementByContexts(Builder $builderForSorting, array $filterValues): Builder;

    public function selectSortDirection(Builder $builderForSorting, string $direction = 'DESC'): Builder;
}
