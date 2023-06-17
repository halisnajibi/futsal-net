<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function paymenHandler(Request $request)
    {
        $json = \json_decode($request->getContent());
        return $request->getContent();
    }
}
