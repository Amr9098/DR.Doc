<?php

namespace Modules\Doctor\Http\Controllers;

use App\Models\Doctor;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;
use Modules\Doctor\Transformers\DoctorResource;

class DoctorController extends Controller
{


    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $allDoctors = Doctor::get();
        if (sizeof($allDoctors) == 0) {
            return response()->json(["message" => "No Doctor Found "], 402);
        } else {
            return DoctorResource::collection($allDoctors);
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
            'name' => 'required|min:3|max:50',
            'phone' => 'required|unique:users|min:7|max:15',
            'image' => 'nullable|max:2048|image|mimes:jpg,jpeg,png',
            'specialization_id' => 'required|exists:specializations,id',
            'bio' => 'required|min:7|max:250',
            'gender' => 'required|in:Male,Female',
            'password' => [
                'required',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ]
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else {
            DB::beginTransaction();
            try {
                $dUser = User::create([
                    "name" => $request->name,
                    "phone" => $request->phone,
                    "password" =>Hash::make($request->password),
                ])->assignRole("Doctor");
                $renewal = Carbon::now()->addWeek(2)->format("Y-m-d H:i:s");
                $addNewDoctor = Doctor::create([
                    "user_id" => $dUser['id'],
                    "specialization_id" => $request->specialization_id,
                    "bio" => $request->bio,
                    "gender" => $request->gender,
                    "renewal" => $renewal,
                ]);
                if (!is_null($request->image)) {
                    $filename = "";
                    if ($request->hasFile('image')) {
                        $filename = $request->file('image')->store('doctor_images', 'public');
                    } else {
                        $filename = Null;
                    }
                    Doctor::where('id', $addNewDoctor->id)->update(array('image' => $filename));
                }
                DB::commit();
                return response()->json(["message" => "New Doctor Add successfully"], 201);
            } catch (Exception $e) {
                DB::rollBack();
                return response()->json(['message' => 'An error occurred while adding a new user', $e], 422);
            }
        }
    }


    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $showDoctor = Doctor::find($id);

        if (!$showDoctor) {
            return response()->json(["message" => "Not Found"], 404);
        } else {
            return new DoctorResource($showDoctor);
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
            'specialization_id' => 'required|exists:specializations,id',
            'bio' => 'required|min:7|max:250',
            'gender' => 'required|in:Male,Female',

        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else {

            $updateDoctor=Doctor::find($id);
            if(!$updateDoctor){
                return response()->json(["message" => "Not Found"], 404);
            }
            $updateDoctor->update([
                "specialization_id"=>$request->specialization_id,
                "bio"=>$request->bio,
                "gender"=>$request->gender,
            ]);
            return response()->json(["message" => "Doctor Data Updated successfully"], 200);
        }

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
    public function UpdateAuthDoctorImage(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'image' => 'required|max:2048|image|mimes:jpg,jpeg,png',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else {

            $doctor=Doctor::where("user_id",Auth::id())->first();
            if(!$doctor){
                return response()->json(["message" => "Not Found"], 404);
            }

            $destination =storage_path('app\public\\'.$doctor->image);
            if(File::exists($destination)){
                File::delete($destination);
            }
            $filename="";
            if($request->hasFile('image')){

                $filename=$request->file('image')->store('doctor_images','public');

            }else{
                $filename=Null;
            }
            $images=Doctor::where('id',$doctor->id)->update(array('image' => $filename));
            if($images){
                return response()->json(["message"=>"Image saved successfully."],200);
                }else{
                    return response()->json(["message"=>"error in image updated"],422);
                 }
        }
    }
}
