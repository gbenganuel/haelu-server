<?php

namespace App\Http\Resources\MNA;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User\UserResource;

class MNAResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'food_intake_decline' => $this->food_intake_decline,
            'weight_loss' => $this->weight_loss,
            'mobility' => $this->mobility,
            'psych_stress_or_acute_disease' => $this->psych_stress_or_acute_disease,
            'neurological_problems' => $this->neurological_problems,
            'bmi' => $this->bmi,
            'screening_score' => $this->screening_score,
            'screening_score_verdict' => $this->screening_score_verdict,
            'user' => new UserResource($this->user),
        ];
    }
}
