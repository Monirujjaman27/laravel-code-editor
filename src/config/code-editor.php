<?php

return [
    /*
    |--------------------------------------------------------------------------
    | File Manager Base Directory
    |--------------------------------------------------------------------------
    |
    | This option defines the base directory for the file manager.
    | You can set it to your project root or any specific directory.
    |
    */
    'base_directory' => base_path(),

    /*
    |--------------------------------------------------------------------------
    | Allowed File Extensions
    |--------------------------------------------------------------------------
    |
    | Define which file extensions are allowed to be edited.
    |
    */
    'allowed_extensions' => [
        'php',
        'js',
        'css',
        'html',
        'vue',
        'json',
        'xml',
        'yaml',
        'yml',
        'txt',
        'md',
        'env',
        'ini',
        'blade.php',
        'sql',
        'sh',
        'bash'
    ],

    /*
    |--------------------------------------------------------------------------
    | Excluded Directories
    |--------------------------------------------------------------------------
    |
    | Directories that will be hidden from the file tree.
    |
    */
    'excluded_directories' => [
        'vendor',
        'node_modules',
        '.git',
        'storage',
        'bootstrap/cache',
        'tests',
        '.idea',
        '.vscode'
    ],

    /*
    |--------------------------------------------------------------------------
    | Middleware
    |--------------------------------------------------------------------------
    |
    | Define the middleware for the file manager routes.
    |
    */
    'middleware' => ['web', 'auth'],

    /*
    |--------------------------------------------------------------------------
    | Route Prefix
    |--------------------------------------------------------------------------
    |
    | The prefix for all file manager routes.
    |
    */
    'route_prefix' => 'code-editor',

    /*
    |--------------------------------------------------------------------------
    | Terminal Enabled
    |--------------------------------------------------------------------------
    |
    | Enable or disable the terminal feature.
    |
    */
    'terminal_enabled' => true,

    /*
    |--------------------------------------------------------------------------
    | Allowed Terminal Commands
    |--------------------------------------------------------------------------
    |
    | Define which commands are allowed in the terminal.
    | Leave empty to allow all commands (not recommended for production).
    |
    */
    'allowed_commands' => [
        'ls',
        'pwd',
        'whoami',
        'php artisan',
        'composer',
        'git status'
    ],
];
