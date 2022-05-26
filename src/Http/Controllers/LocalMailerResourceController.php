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
        $ext = pathinfo($request->route('file'), PATHINFO_EXTENSION);
        $src = file_get_contents(__DIR__ . '/../../views/' . $request->route('file'));
        if (!$src) {
            return Response::make('', 404);
        }
        
        $response = Response::make($src, 200);
        if ($ext === 'css') {
            $response->header('Content-Type', 'text/css');
        }
        if ($ext === 'js') {
            $response->header('Content-Type', 'application/javascript');
        }
        return $response;
    }

}
