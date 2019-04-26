<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use App\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use PDF;

class ReportsController extends Controller
{

    public function create()
    {
        return view('admin.reportes.create');
    }

    public function generarReporte(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_final' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        $fecha_inicio = Carbon::parse($request->fecha_inicio)->format('Y-m-d');
        $fecha_final = Carbon::parse($request->fecha_final)->format('Y-m-d');

        if ($request->tipo === 'all') {
            $results = Venta::whereBetween('fecha_emision', [$fecha_inicio, $fecha_final])
                ->where('user_id', Auth::id())->get();
            return response()->json([
                'results' => $results,
            ], 200);
        }

        $results = Venta::whereBetween('fecha_emision', [$fecha_inicio, $fecha_final])
            ->where('tipo', $request->tipo)
            ->where('user_id', Auth::id())->get();
        return response()->json([
            'results' => $results,
        ], 200);

    }

    public function exportarPDF($fecha_inicio, $fecha_final, $tipo)
    {

        $documents = Venta::whereBetween('fecha_emision', [$fecha_inicio, $fecha_final])
            ->where('tipo', $tipo)
            ->where('user_id', Auth::id())->get();

        $empresa = User::findOrFail(Auth::id());

        if ($tipo === 'all') {
            $documents = Venta::whereBetween('fecha_emision', [$fecha_inicio, $fecha_final])
                ->where('user_id', Auth::id())->get();
        }

        $number = 1;
        $pdf = PDF::loadView('plantillas.reporte', [
            'documents' => $documents,
            'empresa' => $empresa,
            'number' => $number,
        ]);

        $pdf->setPaper('a4', 'landscape');

        $name_pdf = "reporte-$fecha_final.pdf";
        return $pdf->stream();
        // return $pdf->download($name_pdf);
    }

    public function exportarExcel(Request $request)
    {

    }
}
