<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;

class AuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */


     private $withSession;

    public function __construct(User $user, $withSession = false){
        parent::__construct($user);

        $this->withSession = $withSession;
    }



    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
         ];
  
      if ($this->withSession === false) {
          $data['token'] = $this->createToken('user-token')->plainTextToken;
      }
      return $data;
    }
}
