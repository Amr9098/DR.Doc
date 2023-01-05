<?php

namespace Modules\Specialization\Http\Controllers;

use App\Models\Specialization;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\Specialization\Transformers\SpecializationResource;

class SpecializationController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $Specializations=Specialization::get();

        if(sizeof($Specializations) == 0){
            return response()->json(["message" => "No Specializations Found"],402);

        }else{
            return SpecializationResource::collection($Specializations);
        }
    }



    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:200',
            'description' => 'required|min:10|max:1000',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else {
            $newSpecialization=Specialization::create([
                'name' => $request->name,
                'description' => $request->description,
            ]);
            return response()->json(["message" => "Specialization Created Successfully" ,
            "New Specialization"=>  new SpecializationResource($newSpecialization) ], 201);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {

        $ShowSpecialization=Specialization::find($id);
        if ($ShowSpecialization){
            return new SpecializationResource($ShowSpecialization);
        }else{
           return response()->json(["message" => "Not Found"], 404);
        }
    }


    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' =>'required|min:3|max:200',
            'description' =>'required|min:10|max:1000',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }else{
            $UpdateSpecialization=Specialization::find($id);
            if ($UpdateSpecialization){
                $UpdateSpecialization->update([
                    'name' => $request->name,
                    'description' => $request->description,
                ]);
                return response()->json(["message" => "Specialization Updated Successfully"],200);
        }
        return response()->json(["message" => "Not Found"], 404);
    }}

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $DeleteSpecialization=Specialization::find($id);
        if ($DeleteSpecialization){
            $DeleteSpecialization->delete();
            return response()->json(["message" => "Specialization Deleted Successfully"],200);
        }else{
            return response()->json(["message" => "Not Found"], 404);
        }
    }
}
