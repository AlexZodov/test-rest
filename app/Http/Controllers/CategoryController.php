<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\Category\Create;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request
     * @param \App\Category
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, Category $category)
    {
        $queryParameters = $this->composeQueryParameters($request);
        $result = $category::processQueryParameters($queryParameters)->get();

        return response()->json([
            'success' => true,
            'data' => json_encode($result),
            'items_filtered' => count($result),
            'items_total' => $category::count(),
            'parameters' => json_encode($queryParameters),
            'message' => 'result categories',
            'code' => Response::HTTP_OK,
        ], Response::HTTP_OK);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Category\Create  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Create $request)
    {
        $category = Category::store($request->all());

        if ($category === false || blank($category)) {
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
     * @param  \App\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Category $category)
    {
        return response()->json([
            'data' => $category->toArray(),
            'success' => true,
            'message' => 'found',
            'code' => Response::HTTP_OK,
        ], Response::HTTP_OK);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Category\Update  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Category $category)
    {
        $result = $category->update($request->all());

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
     * @param \App\Category $category
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Category $category)
    {
        $result = $category->delete();

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
