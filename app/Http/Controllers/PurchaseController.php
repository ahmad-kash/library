<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    function registerBookPurchaseRequest(Book $book)
    {
        if (!$book->isAvailable())
            return Response()->withFailure(message: 'This book is not available');

        auth('sanctum')->user()->purchaseBooks()->attach($book->id);
        $book->decreaseNumberOfAvailableBooks();

        return Response()->withSuccess(message: 'Purchase request done successfully');
    }
}
