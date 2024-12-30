<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
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
            'source' => $this->source,
            'author' => $this->author,
            'title' => $this->title,
            'category' => $this->category,
            'description' => $this->description,
            'url' => $this->url,
            'image_url' => $this->url_to_image,
            'published_at' => Carbon::parse($this->published_at)->format('Y-m-d') ?? null,
            'content' => $this->content,
            'created_at' => $this->created_at->format('Y-m-d'),
        ];
    }
}
