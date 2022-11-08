<ul class="nav nav-tabs mb-3">
{{--    @can ('admin-panel')--}}
        <li class="nav-item"><a class="nav-link{{ $page === 'items' ? ' active' : '' }}" href="{{ route('admin.items.index') }}">Items</a></li>
        <li class="nav-item"><a class="nav-link{{ $page === 'categories' ? ' active' : '' }}" href="{{ route('admin.categories.index') }}">Categories</a></li>
{{--        <li class="nav-item"><a class="nav-link{{ $page === 'parser' ? ' active' : '' }}" href="{{ route('admin.parser.index') }}">Vk parser</a></li>--}}
        <li class="nav-item"><a class="nav-link{{ $page === 'users' ? ' active' : '' }}" href="{{ route('admin.users.index') }}">Users</a></li>
{{--    @endcan--}}
</ul>
