<?php

namespace App\Statements\repository\impl;

use App\Models\Statement;
use App\Statements\repository\StatementRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class StatementRepositoryImpl implements StatementRepository
{
    const JSON_CONTENT_HAVE = 'json_contains(content,\'"';
    const IN_JSON_WITH_MASK_VERB_ID = '"\',\'$.verb.id\')';
    const IN_JSON_WITH_MASK_ACTOR_NAME = '"\',\'$.actor.name\')';
    const IN_JSON_WITH_MASK_ACTOR_MBOX = '"\',\'$.actor.mbox\')';
    const IN_JSON_WITH_MASK_ACTOR_OPEN_ID = '"\',\'$.actor.openid\')';
    const IN_JSON_WITH_MASK_OBJECT_ID = '"\',\'$.object.id\')';
    const IN_JSON_WITH_MASK_OBJECT_TYPE = '"\',\'$.object.type\')';
    const IN_JSON_WITH_MASK_CONTEXT_ID = '"\',\'$.context.id\')';

    public function getPaginatedStatements(int $statementsPerPage = 20): LengthAwarePaginator
    {
        return Statement::query()->paginate($statementsPerPage);
    }

    public function getCursorPaginatedStatements(int $statementsPerPage = 10): CursorPaginator
    {
        return Statement::query()->cursorPaginate($statementsPerPage);
    }

    public function createStatement(Statement $statement)
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

        return $builderForSorting->where(function (Builder $query) use ($filterValue) {
            $query
                ->where('verb_id', '=', $filterValue);
        });
    }

    public function filterStatementByVerbs(Builder $builderForSorting, array $filterValues): Builder
    {
        return $builderForSorting->where(function (Builder $query) use ($filterValues) {
            foreach ($filterValues as $filterValue) {
                $query->orWhere(function (Builder $query) use ($filterValue) {
                    $query
                        ->orWhere('verb_id', '=', $filterValue);
                });
            }
        });
    }

    public function filterStatementByActor(Builder $builderForSorting, string $filterValue): Builder
    {
        return $builderForSorting->where(function (Builder $query) use ($filterValue) {
            $query
                ->where('actor_name', '=', $filterValue)
                ->orWhere('actor_mbox', '=', $filterValue)
                ->orWhere('actor_openid', '=', $filterValue);
        });
    }

    public function filterStatementByActors(Builder $builderForSorting, array $filterValues): Builder
    {
        return $builderForSorting->where(function (Builder $query) use ($filterValues) {
            foreach ($filterValues as $filterValue) {
                $query->orWhere(function (Builder $query) use ($filterValue) {
                    $query
                        ->orWhere('actor_name', '=', $filterValue)
                        ->orWhere('actor_mbox', '=', $filterValue)
                        ->orWhere('actor_openid', '=', $filterValue);
                });
            }
        });
    }

    public function filterStatementByObject(Builder $builderForSorting, string $filterValue): Builder
    {
        return $builderForSorting->where(function (Builder $query) use ($filterValue) {
            $query
                ->where('object_id', '=', $filterValue)
                ->orWhere('object_type', '=', $filterValue);
        });
    }

    public function filterStatementByObjects(Builder $builderForSorting, array $filterValues): Builder
    {
        return $builderForSorting->where(function (Builder $query) use ($filterValues) {
            foreach ($filterValues as $filterValue) {
                $query->orWhere(function (Builder $query) use ($filterValue) {
                    $query
                        ->orWhere('object_id', '=', $filterValue)
                        ->orWhere('object_type', '=', $filterValue);
                });
            }
        });
    }

    public function filterStatementByContext(Builder $builderForSorting, string $filterValue): Builder
    {
        return $builderForSorting->where(function (Builder $query) use ($filterValue) {
            $query
                ->where('context_id', '=', $filterValue);
        });
    }

    public function filterStatementByContexts(Builder $builderForSorting, array $filterValues): Builder
    {
        return $builderForSorting->where(function (Builder $query) use ($filterValues) {
            foreach ($filterValues as $filterValue) {
                $query->orWhere(function (Builder $query) use ($filterValue) {
                    $query
                        ->orWhere('context_id', '=', $filterValue);
                });
            }
        });
    }

    public function selectSortDirection(Builder $builderForSorting, string $direction = 'DESC'): Builder
    {
        return $builderForSorting->orderBy('statement_id', $direction);
    }


}
