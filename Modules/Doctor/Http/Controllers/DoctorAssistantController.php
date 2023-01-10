<?php

namespace Modules\Doctor\Http\Controllers;

use App\Models\Assistant;
use App\Models\Doctor;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Modules\Doctor\Transformers\DoctorAssistantResource;

class DoctorAssistantController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {

        $Doctor=Doctor::where("user_id",Auth::id())->first();
        if(!$Doctor){
            return response()->json(["message"=>"Doctor Not Found"],404);
        }
        $doctorAssistant=Assistant::where("doctor_id",$Doctor->id)->get();
        if(sizeof($doctorAssistant)==0){
            return response()->json(["message"=>"No assistant has been added yet"],402);
        }
         return DoctorAssistantResource::collection($doctorAssistant);
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
            'address' => 'required|min:5|max:250',
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
                $AUser = User::create([
                    "name" => $request->name,
                    "phone" => $request->phone,
                    "password" =>Hash::make($request->password),
                ])->assignRole("Assistant");
                $doctor_id=Doctor::where("user_id",Auth::id())->first()->id;
                Assistant::create([
                    "user_id"=>$AUser["id"],
                    "doctor_id"=>$doctor_id,
                    "address"=>$request->address,
                    "gender"=>$request->gender,
                ]);
                DB::commit();
                return response()->json(["message" =>  $request->name ." has been added as Assistant successfully"], 201);
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
          $doctorAssistant=Assistant::find($id);
        if(!$doctorAssistant){
            return response()->json(["message"=>"Assistant Not Found"],404);
        }
         return new DoctorAssistantResource($doctorAssistant);
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
