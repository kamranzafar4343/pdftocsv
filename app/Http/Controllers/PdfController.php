<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PdfController extends Controller
{
public function convert(Request $request)
{
    $request->validate([
        'pdf' => 'required|mimes:pdf'
    ]);

    // Get real uploaded file path (no storage issues)
    $pdfFull = $request->file('pdf')->getRealPath();

    if (!file_exists($pdfFull)) {
        return response()->json([
            'error' => 'Uploaded PDF not found',
            'path' => $pdfFull
        ]);
    }

    $tabulaJar = realpath(storage_path("app/tabula.jar"));
    $outputCsv = storage_path("app/output.csv");

    $javaPath = "C:\\Program Files\\Eclipse Adoptium\\jdk-25.0.1.8-hotspot\\bin\\java.exe";

    $command = "\"$javaPath\" -jar \"$tabulaJar\" -p all -f CSV \"$pdfFull\"";

    $output = [];
    $returnCode = 0;

    exec($command . " 2>&1", $output, $returnCode);

    if ($returnCode !== 0) {
        return response()->json([
            'error' => 'Tabula failed',
            'command' => $command,
            'output' => $output,
            'code' => $returnCode
        ]);
    }

    file_put_contents($outputCsv, implode("\n", $output));

    return response()->download($outputCsv);
}



}
