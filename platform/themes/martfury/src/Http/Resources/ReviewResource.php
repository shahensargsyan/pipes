<?php

namespace Theme\Martfury\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'user_name'   => $this->name,
            'user_avatar' => $this->image,
            'created_at'  => $this->created_at->format('d M, Y'),
            'comment'     => $this->comment,
            'star'        => $this->star,
        ];
    }
}
