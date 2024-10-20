<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExportController extends Controller
{
  /**
   * Handle the incoming request.
   */
  public function __invoke(Request $request)
  {
    $fileName = $request->fileName;
    $arrayData = $request->arrayData;
    $columns = array_keys($arrayData[0]);
    $file = fopen(public_path('temp/' . $fileName), 'w');
    fputcsv($file, $columns);

    foreach ($arrayData as $data) {
      fputcsv($file, $data);
    }
    fclose($file);
  }
}
