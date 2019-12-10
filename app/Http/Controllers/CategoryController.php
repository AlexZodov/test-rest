<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\Category\Create;
use App\Resources\CategoriesResource;
use App\Resources\CategoryResource;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{

    private $service;

    public function __construct(CategoryService $service)
    {
        $this->service = $service;
    }

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
        $result = $this->service->parametrizedResult(
            $queryParameters['search'],
            $queryParameters['order'],
            $queryParameters['start'],
            $queryParameters['length']);

        return response()->json([
            'success' => true,
            'data' => json_encode(CategoriesResource::make($result)),
            'items_filtered' => count($result),
            'items_total' => $this->service->getCount(),
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
        $category = $this->service->create($request->all());

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
        $this->service->setInstance($category); //setting already fetched instance into repository, so Laravel didn`t do it without purpose

        return response()->json([
            'data' => CategoryResource::make($this->service->find()),
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
        $this->service->setInstance($category); //setting already fetched instance into repository, so Laravel didn`t do it without purpose

        $result = $this->service->update($request->all());

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
        $this->service->setInstance($category); //setting already fetched instance into repository, so Laravel didn`t do it without purpose

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
