<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\BookResource;
use App\Models\Author;
use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{

    public function index(Request $request)
    {
        if (!empty($request->query()))
            return BookResource::collection(Book::select('books.*')->filter($request->query())->get());
        return BookResource::collection(Book::all());
    }

    public function store(StoreBookRequest $request)
    {
        //for this simple example we could put all the storing logic in this function 
        //if we have complex project we could put them in repository classes
        $photoPath = $request->file('coverPhoto')->store('images/CoverPhotos');
        $category = Category::firstOrCreate(['name' => $request->input('category')]);
        $publisher = Publisher::firstOrCreate(['name' => $request->input('publisher')]);
        $author = Author::firstOrCreate(['name' => $request->input('author')]);

        $book = Book::create(
            $request->safe()->only(['title', 'language', 'numberOfPages', 'sellingPrice', 'rentingPrice', 'numberOfAvailableBooks'])
                + [
                    'category_id' => $category->id, 'publisher_id' => $publisher->id, 'author_id' => $author->id,
                    'cover_photo_url' => $photoPath,
                ]
        );

        return Response()->withSuccess(
            message: 'the book has been added',
            data: BookResource::make($book)->resolve()
        );
    }
    public function show(Book $book)
    {
        // dd($book);
        // dd($book);
        return BookResource::make($book);
        // return $book;
    }

    public function destroy(Book $book)
    {
        if (Storage::delete($book->coverPhotoUrl) && $book->delete())
            return Response()->withSuccess(
                message: 'The book has been deleted',
            );
        return Response()->withFailure(
            message: "Can't delete the book contact the developers",
        );
    }

    function isAvailable(Book $book)
    {
        if ($book->isAvailable())
            return Response()->withSuccess(message: 'Book is available');
        return Response()->withFailure(message: 'Book is not available');
    }
}
