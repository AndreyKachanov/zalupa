<?php

use App\Models\Admin\Item\Category;
use App\Models\Admin\Item\Item;
use App\Models\Admin\Cart\Order\Contact;
use App\Models\User\User;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator as Crumbs;

// Main page
Breadcrumbs::register('home', function (Crumbs $crumbs) {
    $crumbs->push('Главная', route('home'));
});

 //Authentication
Breadcrumbs::register('login', function (Crumbs $crumbs) {
    $crumbs->parent('home');
    $crumbs->push('Login', route('login'));
});

Breadcrumbs::register('login.phone', function (Crumbs $crumbs) {
    $crumbs->parent('home');
    $crumbs->push('Login', route('login.phone'));
});


Breadcrumbs::register('register', function (Crumbs $crumbs) {
    $crumbs->parent('home');
    $crumbs->push('Registration', route('register'));
});

Breadcrumbs::register('password.request', function (Crumbs $crumbs) {
    $crumbs->parent('login');
    $crumbs->push('Reset request', route('password.request'));
});

Breadcrumbs::register('password.reset', function (Crumbs $crumbs) {
    $crumbs->parent('password.request');
    $crumbs->push('Change');
});

// Admin
Breadcrumbs::register('admin.home', function (Crumbs $crumbs) {
    //$crumbs->parent('home');
    $crumbs->push('Админка', route('admin.home'));
});

//
//
// Users
Breadcrumbs::register('admin.users.index', function (Crumbs $crumbs) {
    $crumbs->parent('admin.home');
    $crumbs->push('Users', route('admin.users.index'));
});

Breadcrumbs::register('admin.users.create', function (Crumbs $crumbs) {
    $crumbs->parent('admin.users.index');
    $crumbs->push('Create', route('admin.users.create'));
});

Breadcrumbs::register('admin.users.show', function (Crumbs $crumbs, User $user) {
    $crumbs->parent('admin.users.index');
    $crumbs->push($user->name, route('admin.users.show', $user));
});

Breadcrumbs::register('admin.users.edit', function (Crumbs $crumbs, User $user) {
    $crumbs->parent('admin.users.show', $user);
    $crumbs->push('Edit', route('admin.users.edit', $user));
});

//Admin Categories
Breadcrumbs::register('admin.categories.index', function (Crumbs $crumbs) {
    $crumbs->parent('admin.home');
    $crumbs->push('Категории', route('admin.categories.index'));
});

Breadcrumbs::register('admin.categories.create', function (Crumbs $crumbs) {
    $crumbs->parent('admin.categories.index');
    $crumbs->push('Create', route('admin.categories.create'));
});

Breadcrumbs::register('admin.categories.show', function (Crumbs $crumbs, Category $category) {
    $crumbs->parent('admin.categories.index');
    $crumbs->push($category->title, route('admin.categories.show', $category));
});

Breadcrumbs::register('admin.categories.edit', function (Crumbs $crumbs, Category $category) {
    $crumbs->parent('admin.categories.show', $category);
    $crumbs->push('Изменить', route('admin.categories.edit', $category));
});

//Admin SubCategories
Breadcrumbs::register('admin.subcategories.index', function (Crumbs $crumbs) {
    $crumbs->parent('admin.home');
    $crumbs->push('Подкатегории', route('admin.subcategories.index'));
});

Breadcrumbs::register('admin.subcategories.create', function (Crumbs $crumbs, Category $category) {
    $crumbs->parent('admin.categories.show', $category);
    $crumbs->push('Создать подкатегорию', route('admin.subcategories.create', $category));
});

Breadcrumbs::register('admin.subcategories.show', function (Crumbs $crumbs, Category $category) {
    $crumbs->parent('admin.categories.show', $category->parent);
    $crumbs->push($category->title, route('admin.subcategories.show', $category));
});

Breadcrumbs::register('admin.subcategories.edit', function (Crumbs $crumbs, Category $category) {
    $crumbs->parent('admin.subcategories.show', $category);
    $crumbs->push('Изменить', route('admin.subcategories.edit', $category));
});
//Admin Items
Breadcrumbs::register('admin.items.index', function (Crumbs $crumbs) {
    $crumbs->parent('admin.home');
    $crumbs->push('Товары', route('admin.items.index'));
});

Breadcrumbs::register('admin.items.create', function (Crumbs $crumbs) {
    $crumbs->parent('admin.items.index');
    $crumbs->push('Создать', route('admin.items.create'));
});

Breadcrumbs::register('admin.items.show', function (Crumbs $crumbs, Item $item) {
    $crumbs->parent('admin.items.index');
    $crumbs->push($item->title, route('admin.items.show', $item));
});

Breadcrumbs::register('admin.items.edit', function (Crumbs $crumbs, Item $item) {
    $crumbs->parent('admin.items.show', $item);
    $crumbs->push('Изменить', route('admin.items.edit', $item));
});

//Orders-Contacts
Breadcrumbs::register('admin.orders.index', function (Crumbs $crumbs) {
    $crumbs->parent('admin.home');
    $crumbs->push('Заказы', route('admin.orders.index'));
});

Breadcrumbs::register('admin.orders.show', function (Crumbs $crumbs, Contact $order) {
    $crumbs->parent('admin.orders.index');
    $crumbs->push($order->token->invoice->bill_number, route('admin.orders.show', $order));
});

//Settings
Breadcrumbs::register('admin.settings.index', function (Crumbs $crumbs) {
    $crumbs->parent('admin.home');
    $crumbs->push('Настройки', route('admin.settings.index'));
});

Breadcrumbs::register('admin.settings.edit-price', function (Crumbs $crumbs) {
    $crumbs->parent('admin.settings.index');
    $crumbs->push('Редактирование цены', route('admin.settings.edit-price'));
});

////Admin Parser
//Breadcrumbs::register('admin.parser.index', function (Crumbs $crumbs) {
//    $crumbs->parent('admin.home');
//    $crumbs->push('Parser', route('admin.parser.index'));
//});
