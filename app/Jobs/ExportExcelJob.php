<?php

namespace App\Jobs;

use App\Export\Services\ExportService;
use App\Statements\repository\impl\StatementRepositoryImpl;
use App\Statements\Services\StatementService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExportExcelJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    const MAX_RECORDS_ON_PAGE = 1048575;

    protected int $timeout = 9000;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        private string $filePath,
        private array $filter,
        private $exportId,
        private string $filterHash
    ) {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $filteredStatements = (new StatementService(
            new StatementRepositoryImpl()
        ))->getFilteredStatements($this->filter ?? []);


        $allStatementsLength = $filteredStatements['statements']->count();
        $allRecordsCounter = $excelRowIndex = $percent = 0;

        $filteredStatements['statements']->chunk(
            10000,
            function ($chunkedStatements)
            use (
                &$spreadsheet,
                &$excelRowIndex,
                &$sheet,
                &$allStatementsLength,
                &$allRecordsCounter,
                &$percent
            ) {
                foreach ($chunkedStatements as $statement) {
                    $excelRowIndex++;

                    if (
                        (int)round($allRecordsCounter / $allStatementsLength * 100) === $percent && $percent !== 100
                    ) {
                        ExportService::updatePercentsOfWork($this->exportId, $percent);
                        $percent += 10;
                    }

                    if (self::MAX_RECORDS_ON_PAGE === $excelRowIndex) {
                        $sheet = $spreadsheet->createSheet();
                        $excelRowIndex = 1;
                    }

                    $sheet->setCellValue(
                        'A' . ($excelRowIndex),
                        $statement->statement_id
                    );
                    $sheet->setCellValue(
                        'B' . ($excelRowIndex),
                        json_encode(
                            $statement->content,
                            JSON_UNESCAPED_UNICODE |
                            JSON_UNESCAPED_SLASHES
                        )
                    );

                    $allRecordsCounter++;
                }
            }
        );

        $writer = new Xlsx($spreadsheet);
        $savedFileName = $this->filePath;
        $writer->save($savedFileName);

        Cache::forget($this->filterHash);

        ExportService::updatePercentsOfWork($this->exportId);
    }
}
