<li class="border-0 ps-2 py-0">
    @if ($node['type'] === 'dir')
        <div class="folder-toggle py-1 flex items-center" style="cursor:pointer; font-size: 0.85rem;">
            <i class="fa fa-folder mr-2" style="color: #89b4fa;"></i> {{ $node['name'] }}
        </div>
        <ul class="ml-2 hidden border-l pl-2 folder-content" style="border-color: #313244;">
            @foreach ($node['children'] as $child)
                @include('file-manager::partials.node', ['node' => $child])
            @endforeach
        </ul>
    @else
        <div class="file-item py-1 px-2 rounded cursor-pointer" style="cursor:pointer; font-size: 0.85rem; color: #cdd6f4;"
            data-path="{{ $node['path'] }}">
            <i class="fa fa-file-alt mr-2" style="color: #a6adc8;"></i> {{ $node['name'] }}
        </div>
    @endif
</li>