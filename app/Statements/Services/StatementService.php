<?php

namespace App\Statements\Services;

use App\Models\Statement;
use App\Statements\repository\StatementRepository;
use Illuminate\Database\Eloquent\Builder;

class StatementService
{
    public function __construct(protected StatementRepository $statementRepository)
    {
    }

    public function getAllStatements(): Builder
    {
        return $this->statementRepository->getStatementBuilder();
    }

    public function getFilteredStatements(array $filterAttr): array
    {
        $statements = $this->statementRepository->getStatementBuilder();
        list($filterParam, $statements) = $this->webFilter($filterAttr, $statements);

        $sortDirection = key_exists('dep-sort', $filterAttr) && $filterAttr['dep-sort'] === 'ASC' ? 'ASC' : 'DESC';
        $this->statementRepository->selectSortDirection($statements, $sortDirection);

        $filterResponse['statements'] = $statements;
        $filterResponse['filter-param'] = $filterParam;
        $filterResponse['dep-sort'] = $filterAttr['dep-sort'] ?? [];
        return $filterResponse;
    }

    public function getFilteredStatementsForApi(array $filterAttr): array
    {
        $statements = $this->statementRepository->getStatementBuilder();
        list($filterParam, $statements) = $this->apiFilter($filterAttr, $statements);

        $sortDirection = key_exists('dep-sort', $filterAttr) && $filterAttr['dep-sort'] === 'ASC' ? 'ASC' : 'DESC';
        $this->statementRepository->selectSortDirection($statements, $sortDirection);

        $filterResponse['statements'] = $statements;
        $filterResponse['filter-param'] = $filterParam;
        $filterResponse['dep-sort'] = $filterAttr['dep-sort'] ?? [];
        return $filterResponse;
    }

    public function createStatement(array $content)
    {
        $statement = new Statement;
        $statement->content = $content;
        return $this->statementRepository->createStatement($statement);
    }

    /**
     * @param array $filterAttr
     * @param Builder $statements
     * @return array
     */
    private function webFilter(array $filterAttr, Builder $statements): array
    {
        $filterParam = [];
        if (key_exists('actor-filter', $filterAttr) && !is_null($filterAttr['actor-filter'])) {
            $filterParam['actor-filter'] = $filterAttr['actor-filter'];
            $statements = $this->statementRepository
                ->filterStatementByActor($statements, $filterAttr['actor-filter']);
        }
        if (key_exists('verb-filter', $filterAttr) && !is_null($filterAttr['verb-filter'])) {
            $filterParam['verb-filter'] = $filterAttr['verb-filter'];
            $statements = $this->statementRepository
                ->filterStatementByVerb($statements, $filterAttr['verb-filter']);
        }
        if (key_exists('object-filter', $filterAttr) && !is_null($filterAttr['object-filter'])) {
            $filterParam['object-filter'] = $filterAttr['object-filter'];
            $statements = $this->statementRepository
                ->filterStatementByObject($statements, $filterAttr['object-filter']);
        }
        if (key_exists('context-filter', $filterAttr) && !is_null($filterAttr['context-filter'])) {
            $filterParam['context-filter'] = $filterAttr['context-filter'];
            $statements = $this->statementRepository
                ->filterStatementByContext($statements, $filterAttr['context-filter']);
        }
        return array($filterParam, $statements);
    }


    /**
     * @param array $filterAttr
     * @param Builder $statements
     * @return array
     */
    private function apiFilter(array $filterAttr, Builder $statements): array
    {
        $filterParam = [];
        if (key_exists('actor-filter', $filterAttr) && !is_null($filterAttr['actor-filter'])) {
            $filterParam['actor-filter'] = $filterAttr['actor-filter'];
            $statements = $this->statementRepository
                ->filterStatementByActors($statements, $filterAttr['actor-filter']);
        }
        if (key_exists('verb-filter', $filterAttr) && !is_null($filterAttr['verb-filter'])) {
            $filterParam['verb-filter'] = $filterAttr['verb-filter'];
            $statements = $this->statementRepository
                ->filterStatementByVerbs($statements, $filterAttr['verb-filter']);
        }
        if (key_exists('object-filter', $filterAttr) && !is_null($filterAttr['object-filter'])) {
            $filterParam['object-filter'] = $filterAttr['object-filter'];
            $statements = $this->statementRepository
                ->filterStatementByObjects($statements, $filterAttr['object-filter']);
        }
        if (key_exists('context-filter', $filterAttr) && !is_null($filterAttr['context-filter'])) {
            $filterParam['context-filter'] = $filterAttr['context-filter'];
            $statements = $this->statementRepository
                ->filterStatementByContexts($statements, $filterAttr['context-filter']);
        }
        return array($filterParam, $statements);
    }
}
