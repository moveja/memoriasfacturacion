<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\User;
use App\Models\Product;
use App\Exports\SalesExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{ 
     public function reportPDF($userId, $reportType,$dateFrom = null,$dateTo = null)
    {
        $data = [];

        if ($reportType == 0) {
            $from = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 23:59:59';

        } else {
            $from = Carbon::parse($dateFrom)->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse($dateTo)->format('Y-m-d') . ' 23:59:59';
        }

        if ($userId == 0) {
            $data = Sale::join('users as u','u.id','sales.user_id')
            ->select('sales.*','u.name as user')
            ->whereBetween('sales.created_at',[$from, $to])
            ->get();
        } else {
            $data = Sale::join('users as u','u.id','sales.user_id')
            ->select('sales.*','u.name as user')
            ->whereBetween('sales.created_at',[$from, $to])
            ->where('sales.user_id',$userId)
            ->get();
        }

        //dd($data);
        $user = $userId == 0 ? 'Todos' : User::find($userId)->name; // indicamos si el usuario selecciono todos los usuarios o especificamente uno en particular
        $pdf = PDF::loadview('PDF.reporte', compact('data','reportType','user','dateFrom','dateTo')); // cargamos nuestra vista y le pasamos todos los valores
        return $pdf ->stream('salesReport.pdf'); //visualizamos en el explorador
        //return $pdf ->download('salesReport.pdf'); //descargamos el reporte
   
    }

    public function cierrePDF($userId, $dateFrom,$dateTo)
    {
        $data = [];
        $from = Carbon::parse($dateFrom)->format('Y-m-d') . ' 00:00:00';
        $to = Carbon::parse($dateTo)->format('Y-m-d') . ' 23:59:59';
    
        $data = Sale::join('sale_details as d', 'd.sale_id', 'sales.id')
        ->join('products as p', 'p.id', 'd.product_id')
        ->select('d.sale_id', 'p.name as product', 'd.quantity', 'd.price')
        ->whereBetween('sales.created_at', [$from, $to])
        ->where('sales.status', 'Paid')
        ->where('sales.user_id', $userId)
        ->get();
        //dd($data);
        $user = $userId == 0 ? 'Todos' : User::find($userId)->name;
        $pdf = PDF::loadview('PDF.cierre', compact('data','user','dateFrom','dateTo')); // cargamos nuestra vista y le pasamos todos los valores
        return $pdf ->stream('cierre.pdf'); //visualizamos en el explorador
        //return $pdf ->download('salesReport.pdf'); //descargamos el reporte
   
    }

    public function invPDF()
    {
        $data = [];

        $data = Product::join('categories as c', 'c.id', 'products.category_id')
                            ->select('products.*', 'c.name as category')
                            ->orderBy('products.name', 'asc')
                            ->get();

        //dd($data);
        //$user = $userId == 0 ? 'Todos' : User::find($userId)->name; // indicamos si el usuario selecciono todos los usuarios o especificamente uno en particular
        $pdf = PDF::loadview('PDF.inventario', compact('data')); // cargamos nuestra vista y le pasamos todos los valores
        return $pdf ->stream('salesReport.pdf'); //visualizamos en el explorador
        //return $pdf ->download('salesReport.pdf'); //descargamos el reporte
   
    }

    public function proformaPDF($saleId)
    {
        $detalle = [];

        $detalle = Sale::join('sale_details as d', 'd.sale_id', 'sales.id')
        ->join('products as p', 'p.id', 'd.product_id')
        ->select('d.sale_id', 'p.name as product', 'd.quantity', 'd.price')
        ->where('sales.status', 'Paid')
        ->where('sales.id', $saleId)
        ->get();
        //dd($saleId);
        //$user = $userId == 0 ? 'Todos' : User::find($userId)->name; // indicamos si el usuario selecciono todos los usuarios o especificamente uno en particular
        $pdf = PDF::loadview('PDF.proforma', compact('detalle','saleId')); // cargamos nuestra vista y le pasamos todos los valores
        return $pdf ->stream('proforma.pdf'); //visualizamos en el explorador
   
    }

    
}
