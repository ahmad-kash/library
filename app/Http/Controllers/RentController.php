<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;

class RentController extends Controller
{

    function registerBookRentRequest(Book $book)
    {
        if (!$book->isAvailable())
            return Response()->withFailure(message: 'This book is not available');

        // if the user has rented this book before then don't add new rent log
        if (auth('sanctum')->user()->rentBooks()->where('books.id', $book->id)->exists())
            return Response()->withFailure(message: 'You already has rented this book');

        // add new rent details
        auth('sanctum')->user()->rentBooks()->attach($book->id);
        $book->decreaseNumberOfAvailableBooks();
        return Response()->withSuccess(message: 'Rent request saved successfully');
    }
    function removeBookRent(Book $book, User $user)
    {
        //remove rent details
        if ($user->rentBooks()->detach($book->id)) {
            $book->increaseNumberOfAvailableBooks();
            return Response()->withSuccess(message: 'Rent request has been removed');
        }
        return Response()->withFailure(message: "This user doesn't have this book");
    }
}
