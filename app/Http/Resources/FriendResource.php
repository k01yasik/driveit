// app/Http/Resources/FriendResource.php
<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FriendResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'user' => new UserResource($this->user),
            'confirmed' => $this->confirmed,
            'created_at' => $this->created_at,
        ];
    }
}
