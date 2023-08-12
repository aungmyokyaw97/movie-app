<?php

namespace App\Http\Traits;


trait APIResponser{

    protected function successResponse($data = null, $message = 'Success', $code = 200)
    {
        return response()->json([
            'status'=> true, 
            'message' => $message, 
            'code' => $code,
            'error' => [],
            'data' => $data
        ], $code);
    }


    protected function paginateResponse($data, $message = 'Success', $code = 200)
    {
        $result = $this->checkResponseData($data);

        return response()->json([
            'status'=> true,
            'message' => $message,
            'code' => $code,
            'error' => [],
            'data' => $result,
            'paginate' => [
                'current_page' => $data->currentPage(),
                'next_page_url' => $data->nextPageUrl(),
                'path' => $data->path(),
                'prev_page_url' => $data->previousPageUrl(),
                'per_page' => $data->perPage(),
                'from' => $data->firstItem(),
                'to' => $data->lastItem()
            ]
        ], $code);
    }


    protected function errorResponse($message = 'Success', $code = 200)
    {
        return response()->json([
            'status'=> false, 
            'message' => $message, 
            'code' => $code,
            'error' => [],
            'data' => ""
        ], $code);
    }

    private function checkResponseData($data)
    {
        if ($data instanceof \Illuminate\Http\Resources\Json\ResourceCollection) {
            $result = $data->collection;
        } else {
            $result = $data->toArray()['data'];
        }
        
        return $result;
    }


}