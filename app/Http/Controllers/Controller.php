<?php

namespace App\Http\Controllers;

use App\Services\BaseService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Method to compose Query Parameters from request query
     *
     * @param Request $request The Request Object
     *
     * @return array
     */
    protected function composeQueryParameters(Request $request): array
    {
        // Define the order
        $order = $request->get('order', null);
        if (is_string($order)) {
            try {
                $order = json_decode($order, true);
            } catch (Exception $e) {
                $order = null;
            }
        }

        // Define start & length
        $start = (int)$request->get('page', 1);
        $length = (int)$request->get('size', 10);
        $start = ($start - 1) * $length;


        // Define the search
        $search = $request->get('search', null);
        if (is_string($search)) {
            try {
                $search = json_decode($search, true);
            } catch (Exception $e) {
                $search = null;
            }
        }

        // Return the parameters
        return [
            'start'                 => $start,
            'length'                => $length,
            'search'                => $search ?? [],
            'order'                 => $order ?? []
        ];
    }
}
