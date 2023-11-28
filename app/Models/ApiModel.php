<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Http\JsonResponse;
class ApiModel extends Model
{
    use HasFactory;
    public function sendError($errorMessages = [], $code = 404)
    {
        $response=response()->json($errorMessages, $code);
        return $response;
    }
}
