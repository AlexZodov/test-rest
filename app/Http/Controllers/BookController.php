<?php

namespace App\Http\Controllers;

use App\Book;
use App\Http\Requests\Book\Create;
use App\Http\Requests\Book\Update;
use App\Interfaces\IModelQueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param \Illuminate\Http\Request
     * @param \App\Book
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, Book $book)
    {
        $queryParameters = $this->composeQueryParameters($request);
        $result = $book::processQueryParameters($queryParameters)->get();

        return response()->json([
            'success' => true,
            'data' => json_encode($result),
            'items_filtered' => count($result),
            'items_total' => $book::count(),
            'parameters' => json_encode($queryParameters),
            'message' => 'result books',
            'code' => Response::HTTP_OK,
        ], Response::HTTP_OK);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Book\Create  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Create $request)
    {
        //
        $book = Book::store($request->all());

        if ($book === false || blank($book)) {
            return response()->json([
                'success' => false,
                'message' => 'not created'
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'success' => true,
            'message' => 'created',
            'code' => Response::HTTP_CREATED,
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Book $book)
    {
        return response()->json([
            'data' => $book->toArray(),
            'success' => true,
            'message' => 'found',
            'code' => Response::HTTP_OK,
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Book\Update  $request
     * @param  \App\Book  $book
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Update $request, Book $book)
    {
        $result = $book->update($request->only(['category_id'])); //if system should update only category of book, not clear from task, otherwise - just do $request->all()

        if ($result === false || blank($result)) {
            return response()->json([
                'success' => false,
                'message' => 'not updated'
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'success' => true,
            'message' => 'updated',
            'code' => Response::HTTP_OK,
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Book $book)
    {
        $result = $book->delete();

        if ($result === false || blank($result)) {
            return response()->json([
                'success' => false,
                'message' => 'not deleted'
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'success' => true,
            'message' => 'deleted',
            'code' => Response::HTTP_ACCEPTED,
        ], Response::HTTP_ACCEPTED);
    }


}
