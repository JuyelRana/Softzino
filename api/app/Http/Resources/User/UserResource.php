<?php

namespace App\Http\Resources\User;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'create_dates' => [
                'created_at_human' => $this->created_at->diffForHumans(),
                'created_at' => $this->created_at
            ],
            'email' => $this->email,
            'birthdates' => [
                'age' => $this->birthdate ? Carbon::parse($this->birthdate)->diff(Carbon::now())
                    ->format('%y years, %m months and %d days') : null,
                'birthdate' => $this->birthdate ? Carbon::parse($this->birthdate)->isoFormat('MMM D, YYYY') : null
            ]
        ];
    }
}
