<?php

namespace App\Traits;

use Illuminate\Support\Facades\Response;

trait ExportTrait
{
    public function csv($data, $filenamePrefix = 'export')
    {
        $filename = $filenamePrefix.'_'.date('Y-m-d').'.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ];

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');

            // Write the CSV headers

            $headers = array_map(function ($key) {
                $key = str_replace('_', ' ', $key);

                return ucwords($key);
            }, array_keys($data[0]));

            fputcsv($file, $headers);

            // Write the CSV data
            foreach ($data as $row) {
                fputcsv($file, $row);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}
