<?php


namespace App\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AuthorsResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function toArray($request)
    {
        return AuthorResource::collection($this->collection);
    }
}
