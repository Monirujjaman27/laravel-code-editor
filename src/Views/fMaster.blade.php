<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>File Manager - @yield('pg_title', 'Editor')</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        :root {
            --bg-primary: #1e1e2e;
            --bg-secondary: #181825;
            --bg-tertiary: #11111b;
            --border-color: #313244;
            --text-primary: #cdd6f4;
            --text-secondary: #a6adc8;
            --accent-color: #89b4fa;
            --success-color: #a6e3a1;
            --error-color: #f38ba8;
            --warning-color: #f9e2af;
        }
        
        body {
            background-color: var(--bg-primary);
            color: var(--text-primary);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
        }
        
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: var(--bg-tertiary);
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--border-color);
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #45475a;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <main>
        @yield('content')
    </main>
    
    @stack('js')
</body>
</html>