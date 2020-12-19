<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
        $titles = explode(',', $lines[0]);
        $data = explode(',', str_replace('\"','', $lines[1],),12);

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

        foreach ($titles as $key => $title) {

            $print[$title] = $newData[$key];
        }

//        return str_replace('\"','', $lines[1]);
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
