@extends('code-editor::fMaster')

@section('pg_title', 'Editor')

@section('content')
    <style>
        .file-item:hover {
            background-color: #313244;
        }

        .file-item.active-file {
            background-color: #89b4fa !important;
            color: #1e1e2e !important;
        }

        .file-item.active-file i {
            color: #1e1e2e !important;
        }

        .resizable-editor {
            height: 620px;
            min-height: 300px;
            max-height: 90vh;
            border: 1px solid #313244;
            border-radius: 0.5rem;
            resize: vertical;
            overflow: hidden;
            background-color: #181825;
        }

        .file-tab {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            background: #181825;
            border: 1px solid #313244;
            border-bottom: none;
            border-radius: 8px 8px 0 0;
            cursor: pointer;
            font-size: 13px;
            transition: all 0.2s;
            white-space: nowrap;
            color: #a6adc8;
        }

        .file-tab:hover {
            background: #313244;
            color: #cdd6f4;
        }

        .file-tab.active {
            background: #1e1e2e;
            border-bottom: 2px solid #89b4fa;
            color: #89b4fa;
        }

        .file-tab .tab-close {
            color: #a6adc8;
            font-size: 12px;
            padding: 2px;
            border-radius: 4px;
            transition: all 0.2s;
        }

        .file-tab .tab-close:hover {
            color: #f38ba8;
            background: rgba(243, 139, 168, 0.1);
        }

        .tabs-container {
            display: flex;
            gap: 4px;
            overflow-x: auto;
            padding-bottom: 4px;
            scrollbar-width: thin;
        }

        .tabs-container::-webkit-scrollbar {
            height: 4px;
        }
        
        .folder-toggle {
            cursor: pointer;
            color: #89b4fa;
        }
        
        .folder-toggle:hover {
            color: #89b4fa;
        }
    </style>

    <div class="w-full px-0">
        <div class="flex flex-wrap">
            <!-- LEFT: FILE TREE -->
            <div class="w-full md:w-1/3 lg:w-1/4 border-r" style="border-color: #313244; max-height:95vh; overflow-y:auto; background-color: #181825;">
                <div class="sticky top-0 pb-2 px-3" style="background-color: #181825;">
                    <h5 class="m-0 text-lg font-semibold" style="color: #cdd6f4;">Project Explorer</h5>
                    <div class="flex mb-2">
                        <span class="inline-flex items-center px-3 rounded-l-md" style="background-color: #1e1e2e; border: 1px solid #313244; border-right: none;">
                            <i class="fa fa-search" style="color: #a6adc8;"></i>
                        </span>
                        <input type="text" id="treeSearch" 
                            class="flex-1 rounded-r-md px-3 py-2 text-sm focus:outline-none"
                            style="background-color: #1e1e2e; border: 1px solid #313244; border-left: none; color: #cdd6f4;"
                            placeholder="Search files...">
                    </div>
                </div>

                <ul class="divide-y" id="fileTree" style="border-color: #313244;">
                    @foreach ($tree as $item)
                        @include('file-manager::partials.node', ['node' => $item])
                    @endforeach
                </ul>
            </div>

            <!-- RIGHT: EDITOR -->
            <div class="w-full md:w-2/3 lg:w-3/4 p-4" style="background-color: #1e1e2e;">
                <div class="tabs-container mb-2" id="tabsContainer"></div>
                <div id="editor" class="resizable-editor mt-2"></div>

                <div class="flex gap-3 my-3">
                    <button id="saveBtn" class="hidden font-medium py-1 px-3 text-sm rounded transition duration-200" style="background-color: #a6e3a1; color: #1e1e2e;">
                        💾 Save
                    </button>
                    <span id="saveStatus" class="self-center text-sm" style="color: #a6adc8;"></span>
                </div>

                <div class="p-3 rounded-lg font-mono text-sm" style="height:160px; overflow:auto; background-color: #181825; border: 1px solid #313244;">
                    <div class="mb-1" style="color: #a6e3a1;">File Manager Terminal</div>
                    <div id="terminal" style="color: #cdd6f4;"></div>
                </div>

                <div class="p-3 rounded-lg mt-3 font-mono text-sm" style="height:250px; display:flex; flex-direction:column; background-color: #181825; border: 1px solid #313244;">
                    <textarea id="terminalInput" 
                        class="w-full rounded-md p-2 mb-2 text-sm focus:outline-none focus:ring-2"
                        style="background-color: #1e1e2e; color: #cdd6f4; border: 1px solid #313244;"
                        placeholder="Enter Linux / Composer / Artisan command"></textarea>
                    <div id="terminalOutput" style="flex:1; overflow-y:auto; padding:4px; border-top: 1px solid #313244; color: #cdd6f4;"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/monaco-editor@0.45.0/min/vs/loader.js"></script>
    <script>
        // Your existing JavaScript code here (from previous response)
        // Make sure to update route names to use the package routes
    </script>
@endpush