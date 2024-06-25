<?php

/** @var Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use Illuminate\Support\Facades\Storage;
use Laravel\Lumen\Routing\Router;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use GuzzleHttp\Client;

$router->group(['prefix' => 'logo'], function () use ($router) {
    $router->get('/airline/{logo}', function ($logo) {
        $client = new Client();
        $apiKey = env('IVAO_API_KEY');
        $apiUrl = "https://api.ivao.aero/v2/airlines/{$logo}/logo?apiKey={$apiKey}";

        try {
            $response = $client->get($apiUrl);
            $logoContent = $response->getBody()->getContents();
            $type = $response->getHeaderLine('Content-Type') ?: 'image/gif';

            return response($logoContent, 200, ['Content-Type' => $type]);
        } catch (\Exception $e) {
            return response('Logo not found', 404);
        }
    });
});
