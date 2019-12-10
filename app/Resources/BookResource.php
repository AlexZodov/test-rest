<?php


namespace App\Resources;


use Illuminate\Http\Resources\Json\Resource;

class BookResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'author_id' => $this->author_id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'name_prefix' => $this->name_prefix,
            'category_id' => $this->category_id,
            'category_name' => $this->name

        ];
    }
}
