<?php

namespace App\Http\Resources;

use App\Http\Resources\Group as GroupResource;
use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'group_id' => $this->group_id,
            'name' => $this->name,
            'firstname' => $this->firstname,
            'username' => $this->username,
            'email' => $this->email,
            'phonenumber' => $this->phonenumber,
            'role' => $this->role,
            'status' => $this->status,
            'api_token' => $this->api_token,
            'group' => new GroupResource($this->group),
            'avatar' => $this->avatar
        ];
    }
}
