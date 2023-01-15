<?php

namespace Modules\Clinic\Http\Controllers;

use App\Models\Clinic;
use App\Models\ClinicDoctor;
use App\Models\Doctor;
use Exception;
use GuzzleHttp\Promise\Create;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Modules\Clinic\Transformers\DoctorClinicResource;

class ClinicController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {


       $authDoctorClinics=Clinic::where("manger_id",Auth::user()->doctor->id)->get();
        if(sizeof( $authDoctorClinics) == 0){
            return response()->json(["message" => "No clinic has been added"], 402);
        }
            return DoctorClinicResource::collection($authDoctorClinics);
    }


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:50',
            'phone' => 'required|unique:clinics|min:10|max:15',
            'image' => 'nullable|max:2048|image|mimes:jpg,jpeg,png',
            'address' => 'required|min:7|max:250',
            'assistant_id' => 'required|exists:assistants,id',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else {
            $clinic_count=Doctor::where("user_id",Auth::id())->first()->clinic_count;
            $CountAuthDoctorClinics =Clinic::where("manger_id",Auth::user()->doctor->id)->count();
            if( $CountAuthDoctorClinics >= $clinic_count){
                return response()->json(["message"=>"You now own ".$$CountAuthDoctorClinics." clinics. If you want to add more, please renew your Plan"],402);
            }else{
                DB::beginTransaction();
                try {
               $newClinic= Clinic::create([
                    "manger_id" => Auth::user()->doctor->id,
                    "assistant_id"=>$request->assistant_id,
                    "name"=>$request->name,
                    "phone"=>$request->phone,
                    "address"=>$request->address,
                ]);

                if (!is_null($request->image)) {
                        $filename = "";
                    if ($request->hasFile('image')) {
                        $filename = $request->file('image')->store('clinic_images', 'public');
                    } else {
                        $filename = Null;
                    }
                    Clinic::where('id', $newClinic->id)->update(array('image' => $filename));
                }
                ClinicDoctor::Create([
                    "clinic_id"=>$newClinic->id,
                    "doctor_id"=> Doctor::where("user_id",Auth::id())->first()->id,
                ]);

                DB::commit();
                return response()->json(["message" => "New Clinic Add successfully"], 201);
            } catch (Exception $e) {
                DB::rollBack();}
            }
            return response()->json(['message' => 'An error occurred while adding a new Clinic', $e], 422);



        }

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('clinic::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('clinic::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
