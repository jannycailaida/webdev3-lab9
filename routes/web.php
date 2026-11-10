<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/download-postman-collection', function () {
    $path = base_path('WEBDEV3_Lab9_Postman_Collection.json');

    return response()->download($path, 'WEBDEV3_Lab9_Postman_Collection.json', [
        'Content-Type' => 'application/json',
    ]);
});
