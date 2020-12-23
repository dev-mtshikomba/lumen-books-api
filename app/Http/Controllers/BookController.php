<?php

namespace App\Http\Controllers;

use App\book;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     *
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        return $this->successReponse(Book::all());
    }

    /**
     *
     * @return Illuminate\Http\Response
     */
    public function show($book)
    {
        return $this->successReponse(Book::findOrFail($book));
    }

    /**
     *
     * @return Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'gender' => 'required|max:255|in:male,female',
            'country' => 'required|max:255'
        ];

        $this->validate($request, $rules);

        $new_book = Book::create($request->all());

        return $this->successReponse($new_book, Response::HTTP_CREATED);
    }
    /**
     *
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, $book)
    {
        $rules = [
            'title' => 'string|max:255',
            'description' => 'string|max:255',
            'price' => 'required|float',
            'author_id' => 'required|integer'
        ];

        $this->validate($request, $rules);

        $updated_book = book::findOrFail($book);
        $updated_book->fill($request->all());

        if ($updated_book->isClean()) {
            return $this->errorResponse('One value should change atleast', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $updated_book->save();

        return $this->successReponse($updated_book);
    }

    public function destroy($book)
    {
        $book = Book::findOrFail($book);

        $book->delete();

        return $this->successReponse($book);
    }
}
