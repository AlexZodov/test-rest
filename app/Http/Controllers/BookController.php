<?php

namespace App\Http\Controllers;

use App\Book;
use App\Http\Requests\Book\Create;
use App\Http\Requests\Book\Update;
use App\Resources\BookResource;
use App\Resources\BooksResource;
use App\Services\BookService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookController extends Controller
{

    private $service;

    public function __construct(BookService $service)
    {
        $this->service = $service;
    }


    /**
     * Display a listing of the resource.
     * @param \Illuminate\Http\Request
     * @param \App\Book
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, Book $book)
    {
        $queryParameters = $this->composeQueryParameters($request);

        $result = $this->service->parametrizedResult(
            $queryParameters['search'],
            $queryParameters['order'],
            $queryParameters['start'],
            $queryParameters['length']);

        return response()->json([
            'success' => true,
            'data' => json_encode(BooksResource::make($result)),
            'items_filtered' => count($result),
            'items_total' => $this->service->getCount(),
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
        $book = $this->service->create($request->all());

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

        $this->service->setInstance($book); //setting already fetched instance into repository, so Laravel didn`t do it without purpose

        return response()->json([
            'data' => BookResource::make($this->service->find()),
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
        $this->service->setInstance($book); //setting already fetched instance into repository, so Laravel didn`t do it without purpose

        $result = $this->service->update($request->only(['category_id'])); //if system should update only category of book, not clear from task, otherwise - just do $request->all()

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
        $this->service->setInstance($book); //setting already fetched instance into repository, so Laravel didn`t do it without purpose

        $result = $this->service->destroy();

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
