<?php

if (!function_exists('file_manager_asset')) {
    function file_manager_asset($path)
    {
        return asset('vendor/file-manager/' . $path);
    }
}