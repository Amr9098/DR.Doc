<?php

namespace Modules\Doctor\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
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
            "doctor_id" =>$this->id,
            "name" =>$this->user->name,
            "phone" =>$this->user->phone,
            'image' => (is_null($this->image))?null:asset('storage/'. $this->image),
            "bio" =>$this->bio,
            "gender" =>$this->gender,
            "renewal" =>$this->renewal,
            "Specialization_name" =>$this->Specialization->name,
            "Specialization_description" =>$this->Specialization->description,
        ];
    }
}
