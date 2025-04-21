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
        ->select('id', 'city_name', 'status', 'state_id', 'image')
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
        if ($request->hasFile('city_image')) {
            $image = $request->file('city_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/cities'), $imageName);
            $city->image = $imageName; // assuming `image` column exists
        }
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
    public function edit(Request $request)
    {
        $city = City::find($request->id);

        if ($city) {
            return response()->json([
                'status' => true,
                'message' => 'City data found',
                'data' => $city
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'City not found'
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $city = City::find($request->id);
        $city->update([
            'state_id'      => $request->edit_state_id,
            'city_name'     => $request->edit_city_name,
            'status'        => $request->edit_status
        ]);

        if ($request->hasFile('city_image')) {
            // Delete the old image if it exists
            if ($city->image && file_exists(public_path('uploads/cities/' . $city->image))) {
                unlink(public_path('uploads/cities/' . $city->image));
            }

            // Save the new image
            $image = $request->file('city_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/cities'), $imageName);

            // Update the image field in the database
            $city->image = $imageName;
            $city->save();
        }

        if ($city) {
            return response()->json([
                'message' => "Data Updated Successfully!",
                "code"    => 200,
            ]);
        } else {
            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 500
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $result = City::where('id', $request->id)->delete();

        if($result) {
            return response()->json([
                'message' => "Data Deleted Successfully!",
                "code"    => 200,
            ]);
        } else  {
            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 500
            ]);
        }
    }
}
