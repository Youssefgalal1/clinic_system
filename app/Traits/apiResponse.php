<?php

namespace App\Traits;

trait apiResponse
{
    public function apiResponse($data,$message='',$status=200)
    {
        return response()->json([
        'message'=>$message,
        'data'=>$data
       ], $status);
    }
}
