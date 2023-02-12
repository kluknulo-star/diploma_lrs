<?php

namespace App\Export\Services;

use App\Models\ExcelExport;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ExportService
{
    public static function getExports(): Builder
    {
        return ExcelExport::query()
            ->where('user_id', Auth::id())
            ->orderBy('export_id', 'desc');
    }

    public static function findExcelFile(int $excelFileId): Collection|array
    {
        return ExcelExport::query()->where('export_id', $excelFileId)
            ->where('user_id', Auth::id())
            ->where('percent_of_work', 100)
            ->get();
    }

    public static function createNewExportRecord(string $fileName, array $filters = []): Model|Builder
    {
        return ExcelExport::query()->create([
            'file_path' => $fileName,
            'user_id' => Auth::id(),
            'export_filter' => json_encode($filters)
        ]);
    }

    public static function updatePercentsOfWork($exportId, $percents = 100): void
    {
        ExcelExport::query()
            ->find($exportId)
            ->update([
                'percent_of_work' => $percents
            ]);
    }

    public static function checkExportWithCurrentFiltersExists($exportFilter): bool
    {
        return ExcelExport::query()
            ->where('user_id', Auth::id())
            ->whereBetween(
                'created_at',
                [now()->subDays(1), now()]
            )
            ->whereJsonContains(
                'export_filter',
                $exportFilter
            )
            ->exists();
    }
}
