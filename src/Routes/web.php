<?php

use Monirujjaman27\LaravelCodeEditor\Controllers\FileManagerController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => config('code-editor.route_prefix', 'code-editor'),
    'middleware' => config('code-editor.middleware', ['web', 'auth']),
], function () {
    Route::get('/', [FileManagerController::class, 'index'])->name('code.editor.index');
    Route::post('/read', [FileManagerController::class, 'read'])->name('code.editor.read');
    Route::post('/save', [FileManagerController::class, 'save'])->name('code.editor.save');
    Route::post('/terminal', [FileManagerController::class, 'terminal'])->name('code.editor.terminal');
});