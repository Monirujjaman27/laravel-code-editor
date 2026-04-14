<?php

use monirujjaman27\LaravelCodeEditor\Controllers\FileManagerController;

Route::get('/file-manager', [FileManagerController::class, 'index']);