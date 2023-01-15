<?php

namespace Modules\Clinic\Transformers;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class ClinicAssistantResource extends JsonResource
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
            "name" =>User::find($this->user_id)->name,
            "address" =>$this->address,
            "gender" =>$this->gender,
            'image' => (is_null($this->image))?null:asset('storage/'. $this->image),
        ];
        }
}
