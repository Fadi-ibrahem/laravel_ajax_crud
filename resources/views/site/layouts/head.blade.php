<!DOCTYPE html>
<html lang="en">

<head>
    @include('site.layouts.head.meta')
    
    <title>Ajax CRUD - @yield('title')</title>
    
    @include('site.layouts.head.vendors')
    @include('site.layouts.head.links')
    @include('site.layouts.head.js')

    @stack('head-js')
</head>