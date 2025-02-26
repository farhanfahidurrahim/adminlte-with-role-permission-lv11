<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
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

        // Get the data to export
        $query = $model::query(); // You can customize this based on the model

        if ($dateFrom) {
            $query->whereDate('date', '>=', Carbon::createFromFormat('Y-m-d', $dateFrom)->startOfDay());
        }

        if ($dateTo) {
            $query->whereDate('date', '<=', Carbon::createFromFormat('Y-m-d', $dateTo)->endOfDay());
        }

        $data = $query->get();

        // Create a new Spreadsheet object
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Dynamically create headers based on the model's attributes
        $headers = $this->getHeaders($modelType);
        $column = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($column . '1', $header);
            $column++; // Move to the next column
        }

        // Populate the sheet with data
        $row = 2; // Start from the second row
        foreach ($data as $item) {
            $column = 'A'; // Reset to column A
            foreach ($headers as $header) {
                $sheet->setCellValue($column . $row, $item->{$header});
                $column++; // Move to the next column
            }
            $row++; // Move to the next row
        }

        // Write the file to a response
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
        switch ($modelType) {
            case 'posts':
                return ['id', 'name', 'date', 'category_id', 'status', 'created_by', 'updated_by'];
            case 'categories':
                return ['id', 'name', 'description'];
            default:
                return [];
        }
    }
}
