<?php

namespace Modules\Doctor\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class DoctorAssistantResource extends JsonResource
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

            "id" =>$this->id,
            "address" =>$this->address,
            "gender" =>$this->gender,
            'image' => (is_null($this->image))?null:asset('storage/'. $this->image),
            "doctor" => new DoctorResource(  $this->doctor),

        ];
    }
}
