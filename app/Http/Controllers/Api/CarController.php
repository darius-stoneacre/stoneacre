<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Make;
use App\Modelo;
use App\Range;
use App\VehicleType;
use Illuminate\Http\Request;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //import CSV
        //create tables kindd Po, make, range, model, car, images car

        $targetFile = storage_path('app/public/csv/example_stock.csv');
        $lines = file($targetFile);
        $titles = explode(',', str_replace(['"',",\r\n"],['',''],$lines[0]));
        $data = explode(',', str_replace('\"','', $lines[1]),12);

        $data[5] = str_replace('"','', $data[5].','.$data[6]);
        unset($data[6]);
        $data[11] = explode(',',str_replace(['"',",\r\n"],['',''],$data[11]));
        $index = 0;
        $newData = [];
        foreach($data as $d) {
            $newData[$index] = $d;
            $index++;
        }

        $print = [];
        $insert = [];

        dump($titles);

        foreach ($titles as $key => $title) {

            $print[$title] = $newData[$key];

            switch ($title) {
                case 'MAKE':

                    try {
                        $make = Make::findOrCreate(['title' => $newData[$key]]);
                        $insert['make_id'] = $make->id;
                    } catch (\Exception $e) {
                        dd($e->getMessage());
                    }

                    break;

                case 'RANGE':

                    try {
                        $range = Range::findOrCreate([
                            'make_id' => $insert['make_id'],
                            'title' => $newData[$key]
                        ]);
                        $insert['range_id'] = $range->id;
                    } catch (\Exception $e) {
                        dd($e);
                    }

                    break;

                case 'MODEL':

                    try {
                        $model = Modelo::findOrCreate([
                            'range_id' => $insert['range_id'],
                            'title' => $newData[$key]
                        ]);
                        $insert['model_id'] = $model->id;
                    } catch (\Exception $e) {
                        dd($e->getMessage());
                    }

                    break;

                case 'VEHICLE_TYPE':

                    try {
                        $vehicleType = VehicleType::findOrCreate(['title' => $newData[$key]]);
                        $insert['vehicle_type'] = $vehicleType->id;
                    } catch (\Exception $e) {
                        dd($e->getMessage());
                    }

                    break;
            }
        }
        //check and insert

        dd($print);

        $insert += [
            'reg' => $print['REG'],
            'title' => $print['DERIVATIVE'],
            'price_inc_vat' => $print['PRICE_INC_VAT'],
            'colour' => $print['COLOUR'],
            'mileage' => $print['MILEAGE'],
            'date_on_forecourt' => $print['DATE_ON_FORECOURT'],
            'images' => $print['images']
        ];


        dd($insert);

        return [$print,$newData];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //import CSV
        //create tables kindd Po, make, range, model, car, images car

        $targetFile = storage_path('app/public/csv/example_stock.csv');

        return file($targetFile);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
