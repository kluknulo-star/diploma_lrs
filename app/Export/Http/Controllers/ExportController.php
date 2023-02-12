<?php

namespace App\Export\Http\Controllers;

use Illuminate\Contracts\Pagination\CursorPaginator;
use App\Export\Services\ExportService;
use App\Http\Controllers\Controller;
use App\Jobs\ExportExcelJob;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController extends Controller
{
    public function index(): Factory|View|Application
    {
        $exports = ExportService::getExports()->cursorPaginate(7);

        return view('exports.index', ['exports' => $exports]);
    }

    public function export(Request $request): RedirectResponse
    {
        $filtersAndSorting = $request->all(
            [
                'verb-filter',
                'actor-filter',
                'object-filter',
                'context-filter',
                'dep-sort',
            ]
        );

        $cleanFiltersForExportTable = array_filter(
            $filtersAndSorting,
            function ($filterField) {
                return isset($filterField);
            }
        );

        ksort($cleanFiltersForExportTable);

        $filterHash = md5(serialize($cleanFiltersForExportTable));

        if (Cache::get($filterHash)) {
            return redirect()->back()->withErrors(
                [
                    'status' => 'Файл с такими фильтрами создается или уже существует, проверьте вкладку "My exports"'
                ]
            );
        }
        Cache::put($filterHash, 'true', 20);

        $filePath = './storage/app/';
        $fileName = 'statements-' . now('Europe/Moscow') . '.xlsx';

        $createdExcelRecordInDB = ExportService::createNewExportRecord(
            $fileName,
            $cleanFiltersForExportTable
        );

        ExportExcelJob::dispatch(
            $filePath . $fileName,
            $filtersAndSorting,
            $createdExcelRecordInDB->export_id,
            $filterHash
        );

        return redirect()->back()->with('message', 'Загрузка началась, ожидайте.');
    }

    public function download(Request $request): StreamedResponse
    {
        $exportFile = ExportService::findExcelFile($request->id)->toArray();

        if ($exportFile) {
            $file = array_shift($exportFile);

            if (file_exists('../storage/app/' . $file['file_path'])) {
                return Storage::download($file['file_path']);
            }
        }

        return abort('403');
    }
}
