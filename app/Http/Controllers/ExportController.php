<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Carbon\Carbon;

class ExportController extends Controller
{
    public function export(Request $request, $modelType)
    {
        // Dynamically select the model based on the $modelType parameter
        $model = $this->getModel($modelType);

        if (!$model) {
            return redirect()->back()->with('error', 'Invalid model type');
        }

        // Get the date range from the request
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');
        $search = $request->input('search');

        // Get the data to export
        $query = $model::query();

        // Apply the date range filter if both 'date_from' and 'date_to' are provided
        if ($dateFrom && $dateTo) {
            $query->whereDate('date', '>=', Carbon::createFromFormat('Y-m-d', $dateFrom)->startOfDay())
                ->whereDate('date', '<=', Carbon::createFromFormat('Y-m-d', $dateTo)->endOfDay());

            // If both date range filters are provided, apply the search only within that range
            if ($search) {
                $searchableFields = $model::searchableColumns(); // Model searchable columns
                $query->where(function ($q) use ($searchableFields, $search) {
                    foreach ($searchableFields as $field => $operator) {
                        $q->orWhere($field, $operator, "%{$search}%");
                    }
                });
            }
//            dd("query", $query->toSql(), $query->get());
        } else {
            // If only date filters are provided (either 'date_from' or 'date_to'), apply them
            if ($dateFrom) {
                $query->whereDate('date', '>=', Carbon::createFromFormat('Y-m-d', $dateFrom)->startOfDay());
            } elseif ($dateTo) {
                $query->whereDate('date', '<=', Carbon::createFromFormat('Y-m-d', $dateTo)->endOfDay());
            }

            // If no date range is provided, the search is independent
            if ($search) {
                $searchableFields = $model::searchableColumns(); // Model searchable columns
                foreach ($searchableFields as $field => $operator) {
                    $query->orWhere($field, $operator, "%{$search}%");
                }
            }
        }

        $data = $query->orderBy('name', 'asc')->get();

        if ($request->has('export_type') && $request->export_type == 'pdf') {
            return $this->exportPdf($data, $modelType);
        }

        return $this->exportExcel($data, $modelType);
    }

    private function exportExcel($data, $modelType)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Dynamically create headers based on the model's attributes
        $headers = $this->getHeaders($modelType);
        $column = 'A'; // Start from column A
        foreach ($headers as $header) {
            $sheet->setCellValue($column . '1', $header);
            $column++; // Move to the next column
        }

        // Populate the sheet with data
        $row = 2; // Start from the second row
        foreach ($data as $item) {
            $column = 'A'; // Reset to column A
            foreach ($headers as $header) {
                $value = $header === 'category_name' ? ($item->category->name ?? 'N/A') :
                    ($header === 'created_by' ? ($item->createdBy->name ?? 'N/A') :
                    ($header === 'updated_by' ? ($item->updatedBy->name ?? 'N/A') :
                    $item->{$header}));
                $sheet->setCellValue($column . $row, $value);
                $column++; // Move to the next column
            }
            $row++; // Move to the next row
        }

        $writer = new Xlsx($spreadsheet);
        $filename = $modelType . '_export_' . now()->format('Y_m_d_H_i_s') . '.xlsx';

        // Return the response as a download
        return response()->stream(
            function () use ($writer) {
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment;filename="' . $filename . '"',
                'Cache-Control' => 'max-age=0',
            ]
        );
    }

    // Get the model based on the model type
    private function getModel($modelType)
    {
        switch ($modelType) {
            case 'posts':
                return Post::class;
            case 'categories':
                return Category::class;
            default:
                return null;
        }
    }

    // Define the headers for each model
    private function getHeaders($modelType)
    {
//        dd("asda");
        switch ($modelType) {
            case 'posts':
                return ['id', 'name', 'date', 'category_name', 'status', 'created_by', 'updated_by'];
            case 'categories':
                return ['id', 'name', 'description'];
            default:
                return [];
        }
    }

    // Export PDF
    private function exportPdf($data, $modelType)
    {
        $pdf = Pdf::loadView('exports.pdf.posts', ['data' => $data]);

        // Return the PDF download response
        return $pdf->download($modelType . '_export_' . now()->format('Y_m_d_H_i_s') . '.pdf');
    }
}
