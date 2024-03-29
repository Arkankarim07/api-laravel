<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        
        return [
            'id' => $this->id,
            'title' => $this->title,
            'image' => $this->image,
            'content' => $this->content,
            'author' => $this->whenLoaded('authorPost'),
            'postComment' => $this->whenLoaded('postComment', function() {
                // samakan collect dengan whenLoaded
                return collect($this->postComment)->each(function ($comment) {
                    $comment->userComment;
                    return $comment;
                });
            }),
            'total_comment' => $this->whenLoaded('postComment', function () {
                return count($this->postComment);
            }),
            'created_at' => date_format($this->created_at, 'd/m/y h:i:s')
        ];
    }
}
