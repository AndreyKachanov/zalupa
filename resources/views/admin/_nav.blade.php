<ul class="nav nav-tabs mb-3">
{{--    @can ('admin-panel')--}}
        <li class="nav-item"><a class="nav-link{{ $page === 'items' ? ' active' : '' }}" href="{{ route('admin.items.index') }}">Товары</a></li>
        <li class="nav-item"><a class="nav-link{{ $page === 'categories' ? ' active' : '' }}" href="{{ route('admin.categories.index') }}">Категории</a></li>
        <li class="nav-item"><a class="nav-link{{ $page === 'subcategories' ? ' active' : '' }}" href="{{ route('admin.subcategories.index') }}">Подкатегории</a></li>
        <li class="nav-item"><a class="nav-link{{ $page === 'orders' ? ' active' : '' }}" href="{{ route('admin.orders.index') }}">Заказы</a></li>
{{--        <li class="nav-item"><a class="nav-link{{ $page === 'settings' ? ' active' : '' }}" href="{{ route('admin.settings.index') }}">Настройки</a></li>--}}
        <li class="nav-item"><a class="nav-link{{ $page === 'users' ? ' active' : '' }}" href="{{ route('admin.users.index') }}">Users</a></li>
{{--    @endcan--}}
</ul>
