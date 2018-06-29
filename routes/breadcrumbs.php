<?php

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Home', url('/'));
});

Breadcrumbs::for('author', function ($trail) {
    $trail->parent('home');
    $trail->push('Author(s)', url('/author/all'));
});

Breadcrumbs::for('authors', function ($trail, $title) {
    $trail->parent('author');
    $trail->push($title, url('/author/{name}'));
});

Breadcrumbs::for('genre', function ($trail) {
    $trail->parent('home');
    $trail->push('Categories', url('/genre/all'));
});

Breadcrumbs::for('genres', function ($trail, $title) {
    $trail->parent('genre');
    $trail->push($title, url('/genre/{name}'));
});

Breadcrumbs::for('detail', function ($trail) {
    $trail->parent('home');
    $trail->push('Book Detail');
});

Breadcrumbs::for('search', function ($trail) {
    $trail->parent('home');
    $trail->push('Search Result');
});

Breadcrumbs::for('book-list', function ($trail) {
    $trail->parent('home');
    $trail->push('Book List',url('admin/book/all'));
});

Breadcrumbs::for('book-create', function ($trail) {
    $trail->parent('book-list');
    $trail->push('Book Create');
});

Breadcrumbs::for('publisher-list', function ($trail) {

    $trail->parent('home');
    $trail->push('Publisher List');
});

Breadcrumbs::for('genre-list', function ($trail) {
    $trail->parent('home');
    $trail->push('Genre List');
});

Breadcrumbs::for('author-list', function ($trail) {
    $trail->parent('home');
    $trail->push('Author List');
});

Breadcrumbs::for('book-edit', function ($trail,$title) {
    $trail->parent('book-list');
    $trail->push($title,url('book/detail').'/'.str_replace(' ','_',strtolower($title)));
    $trail->push('Edit');
});
/*
// Home > About
Breadcrumbs::for('about', function ($trail) {
    $trail->parent('home');
    $trail->push('About', route('about'));
});

// Home > Blog
Breadcrumbs::for('blog', function ($trail) {
    $trail->parent('home');
    $trail->push('Blog', route('blog'));
});

// Home > Blog > [Category]
Breadcrumbs::for('category', function ($trail, $category) {
    $trail->parent('blog');
    $trail->push($category->title, route('category', $category->id));
});

// Home > Blog > [Category] > [Post]
Breadcrumbs::for('post', function ($trail, $post) {
    $trail->parent('category', $post->category);
    $trail->push($post->title, route('post', $post->id));
});*/