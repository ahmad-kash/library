<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'numberOfPages' => $this->number_of_pages,
            // if user exists and it's an admin return number of available books
            'numberOfAvailableBooks' => $this->when((auth()->user() && auth()->user()->isAdmin()), $this->number_of_available_books),
            'isAvailable' => $this->isAvailable(),
            'sellingPrice' => $this->selling_price,
            'rentingPrice' => $this->renting_price,
            'coverPhotoUrl' => $this->cover_photo_url,
            'categoryName' => $this->when($this->relationLoaded('category'), $this->category->name),
            'authorName' => $this->when($this->relationLoaded('author'), $this->author->name),
            'publisherName' => $this->when($this->relationLoaded('publisher'), $this->publisher->name),
        ];
    }
}
