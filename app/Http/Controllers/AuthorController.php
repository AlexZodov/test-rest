<?php

namespace App\Http\Controllers;

use App\Author;
use App\Http\Requests\Author\Create;
use App\Http\Requests\Author\Update;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request
     * @param \App\Author
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, Author $author)
    {
        $queryParameters = $this->composeQueryParameters($request);
        $result = $author::processQueryParameters($queryParameters)->get();

        return response()->json([
            'success' => true,
            'data' => json_encode($result),
            'items_filtered' => count($result),
            'items_total' => $author::count(),
            'parameters' => json_encode($queryParameters),
            'message' => 'result authors',
            'code' => Response::HTTP_OK,
        ], Response::HTTP_OK);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Author\Create  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Create $request)
    {
        $author = Author::store($request->all());

        if ($author === false || blank($author)) {
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
     * @param  \App\Author  $author
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Author $author)
    {
        return response()->json([
            'data' => $author->toArray(),
            'success' => true,
            'message' => 'found',
            'code' => Response::HTTP_OK,
        ], Response::HTTP_OK);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Author\Update  $request
     * @param  \App\Author  $author
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Update $request, Author $author)
    {
        $result = $author->update($request->all());

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
     * @param  \App\Author  $author
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Author $author)
    {
        $result = $author->delete();

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
