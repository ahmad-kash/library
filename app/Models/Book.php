<?php

namespace App\Models;

use App\Traits\AttributeToSnakeCase;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class Book extends Model
{
    use HasFactory, AttributeToSnakeCase;

    // eager loading these model on every request
    protected $with = ['category', 'publisher', 'author'];

    protected $hidden = [
        'number_of_available_books',
    ];

    protected static $allowedFilters = ['title', 'category', 'author', 'publisher', 'language', 'minprice', 'maxprice'];
    public function scopeFilter($query, $filters)
    {
        //this function will call the scoped defined on this model 
        // if we have more than one model we can move this function into trait and it will work just fine

        foreach ($filters as $key => $data) {
            if (in_array($key, static::$allowedFilters, true)) {
                //call scoped filter functions 
                // ex: scopeCategoryFilter
                $funcName = $key . 'Filter';
                try {
                    $query->$funcName($data);
                } catch (Exception $ex) {
                    throw new Exception("method scope$funcName is not defined in model " . get_called_class());
                }
            }
        }
    }

    public function scopeCategoryFilter($query, string $categoryName = "")
    {
        return $query->join('categories', 'books.category_id', '=', 'categories.id')
            ->where('categories.name', 'like', "%$categoryName%");
    }
    public function scopeAuthorFilter($query, string $authorName = "")
    {
        return $query->join('authors', 'books.author_id', '=', 'authors.id')
            ->where('authors.name', 'like', "%$authorName%");
    }
    public function scopePublisherFilter($query, string $publisherName = "")
    {
        return $query->join('publishers', 'books.publisher_id', '=', 'publishers.id')
            ->where('publishers.name', 'like', "%$publisherName%");
    }
    public function scopeLanguageFilter($query, string $languageName = "")
    {
        return $query->where('language', $languageName);
    }
    public function scopeTitleFilter($query, string $title = "")
    {
        return $query->where('title', 'like',  "%$title%");
    }
    public function scopeMinPriceFilter($query, $minPrice = 0)
    {
        return $query->where('selling_price', '>=', $minPrice);
    }
    public function scopeMaxPriceFilter($query, $maxPrice = 0)
    {
        return $query->where('selling_price', '<=', $maxPrice);
    }

    public function isAvailable()
    {
        return $this->number_of_available_books > 0;
    }
    public function decreaseNumberOfAvailableBooks($number = 1)
    {
        $this->update(['number_of_available_books' => ($this->number_of_available_books - $number)]);
    }
    public function increaseNumberOfAvailableBooks($number = 1)
    {
        $this->update(['number_of_available_books' => ($this->number_of_available_books + $number)]);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }
    public function author()
    {
        return $this->belongsTo(Author::class);
    }
    public function purchaseCustomers()
    {
        return $this->belongsToMany(User::class, 'purchase_details', 'book_id', 'user_id')->withTimestamps();
    }
    public function rentCustomers()
    {
        return $this->belongsToMany(User::class, 'rent_details', 'book_id', 'user_id')->withTimestamps();
    }
}
