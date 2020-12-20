<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\VehicleResource;
use App\Make;
use App\Modelo;
use App\Range;
use App\Vehicle;
use App\VehicleImage;
use App\VehicleType;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return Excel::CSV(VehicleResource::collection(Vehicle::all()),'file.csv');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new VehicleResource(Vehicle::findOrFail($id));
    }
}
