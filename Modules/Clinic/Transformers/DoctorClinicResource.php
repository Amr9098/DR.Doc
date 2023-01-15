<?php

namespace Modules\Clinic\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Doctor\Transformers\DoctorResource;

class DoctorClinicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
      return[
        "clinic_id"=>$this->id,
        "clinic_name"=>$this->name,
        "clinic_phone"=>$this->phone,
        "clinic_address"=>$this->address,
        'clinic_image' => (is_null($this->image)) ? null : asset('storage/'. $this->image),
        "clinic_number_of_doctor"=>$this->count,
        "clinic_manger"=>new DoctorResource($this->manger),
        "clinic_assistant"=>new ClinicAssistantResource($this->assistant),
      ];
    }
}
