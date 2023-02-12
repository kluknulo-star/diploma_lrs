<?php

namespace App\Statements\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StatementResource;
use App\Jobs\InsertStatementJob;
use App\Models\Statement;
use App\Statements\repository\impl\StatementRepositoryImpl;
use App\Statements\Requests\StatementApiRequest;
use App\Statements\Requests\StatementApiRequestV2;
use App\Statements\Services\StatementService;
use App\Statements\Services\StatementServiceV2;
use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiStatementsController extends Controller
{
    public function __construct(protected StatementService $statementService)
    {
    }

    public function index(Request $request): JsonResponse
    {
        $filterParameters = $request->all([
            'verb-filter',
            'actor-filter',
            'object-filter',
            'context-filter',
            'dep-sort'
        ]);
        $filterResponse = $this->statementService->getFilteredStatements($filterParameters);
        $statementsCollection = $filterResponse['statements']->orderBy('statement_id')->cursorPaginate(100);
        $statementsCollection->withQueryString();
        return response()->json([
            'body' => StatementResource::collection($statementsCollection),
            'previous_page_url' => $statementsCollection->previousPageUrl(),
            'next_page_url' => $statementsCollection->nextPageUrl(),
            'filter_param' => $filterResponse['filter-param'],
        ]);
    }

    // todo
    //  Метод в следующем обновлении будет перенесён в индекс
    public function getFilteredStatements(Request $request): JsonResponse
    {
        $filterParameters = $request->only('filter-parameters');
        $filterResponse = $this->statementService->getFilteredStatementsForApi($filterParameters['filter-parameters']);
        $statementsCollection = $filterResponse['statements']->orderBy('statement_id')->cursorPaginate(100);
        $statementsCollection->withQueryString();
        return response()->json([
            'body' => StatementResource::collection($statementsCollection),
            'previous_page_url' => $statementsCollection->previousPageUrl(),
            'next_page_url' => $statementsCollection->nextPageUrl(),
            'filter_param' => $filterResponse['filter-param'],
        ]);
    }

    public function show(Statement $statement): JsonResponse
    {
        return response()->json(['body' => new StatementResource($statement)]);
    }

    public function store(StatementApiRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $statementId = $this->statementService->createStatement($validated);
        return response()->json(['statement_id' => $statementId]);
    }

    public function storeV2(StatementApiRequestV2 $request)
    {

        $validatedStatements = $request->validated();

        $createdStatementUuids = [];
        foreach ($validatedStatements as $statement) {
            $newStatement = $this->statementService->createStatement($statement);
            $createdStatementUuids[] = $newStatement;
        }

        return response($createdStatementUuids, 200);
    }

    public function indexV2(Request $request)
    {
        $filteredStatements = StatementServiceV2::getFilteredStatements($request->all());

//        foreach ($filterParameters as $key => $value) {
//            $statementBuilder = $statementBuilder->where($key, $value);
//        }

        return response($filteredStatements, 200);
    }
}
