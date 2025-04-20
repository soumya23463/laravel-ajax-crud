<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cities = City::with('state:id,state_name')
        ->select('id', 'city_name', 'status', 'state_id')
        ->get();

        if($cities){
            return response()->json([
                'message' => 'Data  Found',
                'code' => 200,
                'data' => $cities,

            ]);
        }
        else{
            return "City not added";
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $city=new City();
        $city->city_name=$request->city_name;
        $city->state_id=$request->state_id;
        $result=$city->save();
        if($result){
            return response()->json([
                'message' => 'City added successfully',
                'code' => 200,

            ]);
        }
        else{
            return "City not added";
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
