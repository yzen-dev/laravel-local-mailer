<?php

namespace LocalMailer\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

/**
 *
 */
class LocalMailerResourceController
{
    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $path = (string)$request->route('file');
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $path = __DIR__ . '/../../views/' . $request->route('file');
        if (!file_exists($path)) {
            return Response::make('', 404);
        }
        $src = file_get_contents($path);
        $response = Response::make((string) $src);
        if ($ext === 'css') {
            $response->header('Content-Type', 'text/css');
        }
        return $response;
    }
}
