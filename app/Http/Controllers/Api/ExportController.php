<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Vehicle;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $fileName = 'vehicles_stock_'.date('d-m-Y_-_H:i:s').'.csv';
        $vehicles = Vehicle::selectRaw("vehicles.*, CONCAT(makes.title, ' ', ranges.title, ' ', vehicles.title ) as vehicle_title")
                            ->join('models','vehicles.model_id', '=', 'models.id')
                            ->join('ranges', 'models.range_id', '=', 'ranges.id')
                            ->join('makes', 'makes.id', '=', 'ranges.make_id')
                            ->where('makes.title', '=', 'Ford')
                            ->get();

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('Reg', 'Title', 'Price', 'VAT', 'Image');

        $callback = function() use($vehicles, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            if(isset($vehicles) && count($vehicles)) {


                foreach ($vehicles as $vehicle) {

                    $vat = $vat = ($vehicle->price_inc_vat / 100) * 20;

                    $row['reg'] = $vehicle->reg;
                    $row['title'] = $vehicle->vehicle_title;
                    $row['price'] =  number_format($vehicle->price_inc_vat - $vat,2,'.',',');
                    $row['vat'] = number_format($vat,2,'.',',');
                    $row['image'] = $vehicle->images[0]->target;

                    fputcsv($file, array($row['reg'], $row['title'], $row['price'], $row['vat'], $row['image']));
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
