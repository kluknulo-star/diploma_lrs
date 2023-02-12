<?php

namespace App\Statements\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Statement;
use App\Statements\Helpers\StatementHelper;
use App\Statements\Services\StatementService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class StatementsController extends Controller
{
    public function __construct(protected StatementService $statementService)
    {
    }

    public function index(Request $request): View
    {
        $filterParameters = $request->all([
            'verb-filter',
            'actor-filter',
            'object-filter',
            'context-filter',
            'dep-sort',
        ]);

        $filterResponse = $this->statementService->getFilteredStatements($filterParameters);

        $statementPaginator = $filterResponse['statements']->cursorPaginate(5);
        $statementsArray = $statementPaginator->toArray();

        $statements = StatementHelper::prepareDataForDisplay($statementsArray['data']);

        $formExportParams = [
            ...$filterResponse['filter-param'],
            'dep-sort' => $filterResponse['dep-sort']
        ];

        return view('statements.index', [
            'statements' => $statements,
            'filterParam' => $filterResponse['filter-param'],
            'sorting' => $filterResponse['dep-sort'],
            'formExportParams' => $formExportParams,
            'paginator' => $statementPaginator
        ]);
    }

    public function redirectToFilteredAndSortedPage(Request $request): RedirectResponse
    {
        $getParams = array_filter($request->all(), function ($filterField, $key) {
            return isset($filterField) && $key !== '_token';
        }, ARRAY_FILTER_USE_BOTH);

        return redirect()->route('statements', $getParams)->withInput();
    }

    public function show(Statement $statement): View
    {
        return view('statements.show', [
            'statement' => $statement,
        ]);
    }
}
