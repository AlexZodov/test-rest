<?php


namespace App\Resources;


use Illuminate\Http\Resources\Json\Resource;

class AuthorResource extends Resource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'name_prefix' => $this->name_prefix,
            'name_concat' => $this->name_prefix.' '.$this->first_name.' '.$this->last_name
        ];
    }
}
