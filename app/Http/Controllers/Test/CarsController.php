<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Test\Cars as CarsModel;

class CarsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['cars'] = CarsModel::where('id', '>', 2)->get();

        return view('test.cars', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('test.car-create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $CarsModel = new CarsModel();

        /** One method of inserting to database using ORM */
        // I guess this is mysql field name
        $CarsModel->name = $request->input('name');
        // $CarsModel->founded = $request->input('founded');
        // $CarsModel->description = $request->input(('description'));

        $CarsModel->save();
        /** End of one method */

        /** Another method of saving to database */
        // CarsModel::create();

        return redirect('/learning/cars');
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
