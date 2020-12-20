<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Make;
use App\Modelo;
use App\Range;
use App\Vehicle;
use App\VehicleImage;
use App\VehicleType;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $failed = []; //how many failed inserts
        $success = []; //how many successfully inserts
        //import & read CSV
        $targetFile = storage_path('app/public/csv/example_stock.csv');
        $lines = file($targetFile);
        $titles = explode(',', str_replace(['"',",\r\n","\r\n"],['','',''],$lines[0]));
        unset($lines[0]);
        if (isset($lines) && count($lines) > 0) {

            $data = [];
            $newData = [];
            // lines on csv
            foreach($lines as $keyLine => $line) {

                $data[$keyLine] = explode(',', str_replace('\"','', $line),12);

                $data[$keyLine][5] = str_replace('"','', $data[$keyLine][5].','.$data[$keyLine][6]);
                unset($data[$keyLine][6]);
                $data[$keyLine][11] = explode(',',str_replace(['"',",\r\n"],['',''],$data[$keyLine][11]));
                $index = 0;
                foreach($data[$keyLine] as $d) {
                    $newData[$index] = $d;
                    $index++;
                }

                $print = [];
                $vehicle = [];


                foreach ($titles as $key => $title) {


                    // VALIDATES:
                    // Reg; 3 images; price > 0

                    // Reg
                    if ($title == 'REG' && strlen($newData[$key]) == 0) {
                        continue;
                    }

                    // 3 images
                    if ($title == 'IMAGES' && isset($newData[$key]) && count($newData[$key]) <= 2) {
                        continue;
                    }

                    // Price > 0

                    if ($title == 'PRICE_INC_VAT') {

                        $price = (float) str_replace(',','', $newData[$key]);
                        if ($price <= 0) {
                            continue;
                        }
                    }

                    $print[$title] = $newData[$key];

                    switch ($title) {
                        case 'MAKE':

                            try {
                                $make = Make::findOrCreate(['title' => $newData[$key]]);
                                $vehicle['make_id'] = $make->id;
                            } catch (\Exception $e) {
                                dd($e->getMessage());
                            }

                            break;

                        case 'RANGE':

                            try {
                                $range = Range::findOrCreate([
                                    'make_id' => $vehicle['make_id'],
                                    'title' => $newData[$key]
                                ]);
                                $vehicle['range_id'] = $range->id;
                            } catch (\Exception $e) {
                                dd($e->getMessage());
                            }

                            break;

                        case 'MODEL':

                            try {
                                $model = Modelo::findOrCreate([
                                    'range_id' => $vehicle['range_id'],
                                    'title' => $newData[$key]
                                ]);
                                $vehicle['model_id'] = $model->id;
                            } catch (\Exception $e) {
                                dd($e->getMessage());
                            }

                            break;

                        case 'VEHICLE_TYPE':

                            try {
                                $vehicleType = VehicleType::findOrCreate(['title' => $newData[$key]]);
                                $vehicle['vehicle_type_id'] = $vehicleType->id;
                            } catch (\Exception $e) {
                                dd($e->getMessage());
                            }

                            break;
                    }
                }
                //check and insert

                if(!isset($print['IMAGES'])) {
                    $print['error']['message'] = 'Images < 3';
                    $print['error']['line_csv'] = $keyLine+1;
                    $falied[] = $print;

                    continue;
                }

                if(!isset($print['REG'])) {
                    $print['error']['message'] = 'No REG';
                    $print['error']['line_csv'] = $keyLine+1;
                    $failed[] = $print;
                    continue;
                }

                if(!isset($print['PRICE_INC_VAT']) || ($print['PRICE_INC_VAT']) <= 0) {
                    $print['error']['message'] = 'Price <= 0';
                    $print['error']['line_csv'] = $keyLine+1;
                    $failed[] = $print;
                    continue;
                }

                if(!isset($vehicle['vehicle_type_id']) || !is_numeric($vehicle['vehicle_type_id']) || is_null($vehicle['vehicle_type_id'])) {
                    $print['error']['message'] = 'No set vehicle type';
                    $print['error']['line_csv'] = $keyLine+1;
                    $failed[] = $print;
                    continue;
                }

                if(!isset($vehicle['model_id']) || !is_numeric($vehicle['model_id']) || is_null($vehicle['model_id'])) {
                    $print['error']['message'] = 'No set model vehicle';
                    $print['error']['line_csv'] = $keyLine+1;
                    $failed[] = $print;
                    continue;
                }

                $vehicle += [
                    'reg' => $print['REG'],
                    'title' => $print['DERIVATIVE'],
                    'price_inc_vat' => $print['PRICE_INC_VAT'],
                    'colour' => $print['COLOUR'],
                    'mileage' => $print['MILEAGE'],
                    'date_on_forecourt' => $print['DATE_ON_FORECOURT'],
                    'images' => $print['IMAGES']
                ];


                try {

                    if($vehicle = Vehicle::create($vehicle)) {
                        if(isset($print['IMAGES'])) {
                            foreach ($print['IMAGES'] as $image) {
                                VehicleImage::create([
                                    'vehicle_id' => $vehicle->id,
                                    'target' => $image
                                ]);
                            }
                        }
                    }

                    $success[] = $vehicle;
                    unset($vehicle,$print);
                } catch (\Exception $e) {
                    $print['error']['message'] = $e->getMessage();
                    $print['error']['line_csv'] = $keyLine+1;
                    $failed[] = $print;

                } // try & catch
            } // foreach lines
        } // if lines


        $details = [
            'success' => $success,
            'failed' => $failed
        ];

        $dataView = ['success', 'failed'];

//        \Mail::to('dennysaug@gmail.com')->send(new \App\Mail\Email($details));

        return view('mail', compact($dataView));

    }
}
