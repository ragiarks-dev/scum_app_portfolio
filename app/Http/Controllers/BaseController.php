<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    protected array $response;

    public function __construct()
    {
        $this->response = [
            'messages' => [],
            'errors' => [],
            'result' => [],
        ];
    }
}
