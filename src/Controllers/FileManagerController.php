<?php

namespace Monirujjaman27\LaravelCodeEditor\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Process\Process;

class FileManagerController extends Controller
{
    protected $basePath;
    protected $excludedDirs;

    public function __construct()
    {
        $this->basePath = config('code-editor.base_directory', base_path());
        $this->excludedDirs = config('code-editor.excluded_directories', ['vendor', 'node_modules', '.git']);
    }

    /**
     * Display the file manager interface
     */
    public function index()
    {
        $tree = $this->buildFileTree($this->basePath);
        return view('code-editor::index', compact('tree'));
    }

    /**
     * Build the file tree structure
     */
    private function buildFileTree($directory, $relativePath = '')
    {
        $tree = [];
        
        if (!File::exists($directory)) {
            return $tree;
        }
        
        $items = File::directories($directory);
        $files = File::files($directory);

        // Add directories first
        foreach ($items as $dir) {
            $dirName = basename($dir);
            
            // Skip excluded directories
            if (in_array($dirName, $this->excludedDirs)) {
                continue;
            }

            $newRelativePath = $relativePath ? $relativePath . '/' . $dirName : $dirName;
            
            $tree[] = [
                'name' => $dirName,
                'type' => 'dir',
                'path' => $newRelativePath,
                'children' => $this->buildFileTree($dir, $newRelativePath)
            ];
        }

        // Add files
        $allowedExtensions = config('code-editor.allowed_extensions', ['php', 'js', 'css', 'html']);
        
        foreach ($files as $file) {
            $fileName = $file->getFilename();
            $extension = $file->getExtension();
            
            // Check if file extension is allowed
            $isAllowed = false;
            foreach ($allowedExtensions as $allowedExt) {
                if ($extension === $allowedExt || $fileName === $allowedExt) {
                    $isAllowed = true;
                    break;
                }
            }
            
            if ($isAllowed) {
                $newRelativePath = $relativePath ? $relativePath . '/' . $fileName : $fileName;
                
                $tree[] = [
                    'name' => $fileName,
                    'type' => 'file',
                    'path' => $newRelativePath,
                    'size' => $file->getSize(),
                    'modified' => $file->getMTime()
                ];
            }
        }

        // Sort directories first, then files
        usort($tree, function($a, $b) {
            if ($a['type'] === $b['type']) {
                return strcmp($a['name'], $b['name']);
            }
            return $a['type'] === 'dir' ? -1 : 1;
        });

        return $tree;
    }

    /**
     * Read file content
     */
    public function read(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'path' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid path'], 400);
        }

        $fullPath = $this->getFullPath($request->path);

        if (!File::exists($fullPath) || !File::isFile($fullPath)) {
            return response()->json(['error' => 'File not found'], 404);
        }

        try {
            $content = File::get($fullPath);
            return response()->json(['content' => $content]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to read file: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Save file content
     */
    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'path' => 'required|string',
            'content' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Invalid data'], 400);
        }

        $fullPath = $this->getFullPath($request->path);

        if (!File::exists($fullPath)) {
            return response()->json(['success' => false, 'message' => 'File not found'], 404);
        }

        try {
            File::put($fullPath, $request->content);
            return response()->json(['success' => true, 'message' => 'File saved successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Unable to save file: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Execute terminal command
     */
    public function terminal(Request $request)
    {
        if (!config('code-editor.terminal_enabled', true)) {
            return response()->json(['output' => 'Terminal is disabled'], 403);
        }

        $validator = Validator::make($request->all(), [
            'command' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['output' => 'Invalid command'], 400);
        }

        $command = $request->command;
        $allowedCommands = config('code-editor.allowed_commands', []);

        // Check if command is allowed
        if (!empty($allowedCommands)) {
            $allowed = false;
            foreach ($allowedCommands as $allowedCmd) {
                if (str_starts_with($command, $allowedCmd)) {
                    $allowed = true;
                    break;
                }
            }
            
            if (!$allowed) {
                return response()->json(['output' => 'Command not allowed'], 403);
            }
        }

        try {
            $process = Process::fromShellCommandline($command);
            $process->setTimeout(60);
            $process->run();

            $output = $process->getOutput();
            $errorOutput = $process->getErrorOutput();

            $result = $output ?: ($errorOutput ?: 'Command executed successfully');
            
            return response()->json(['output' => $result]);
        } catch (\Exception $e) {
            return response()->json(['output' => 'Error executing command: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Get full system path
     */
    private function getFullPath($relativePath)
    {
        // Prevent directory traversal attacks
        $relativePath = str_replace(['..', './', '.\\'], '', $relativePath);
        $relativePath = ltrim($relativePath, '/\\');
        
        return $this->basePath . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $relativePath);
    }
}