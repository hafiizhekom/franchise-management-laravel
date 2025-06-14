<!DOCTYPE html>
@php
    $menuFixed = ($configData['layout'] === 'vertical') ? ($menuFixed ?? '') : (($configData['layout'] === 'front') ? '' : $configData['headerType']);
    $navbarType = ($configData['layout'] === 'vertical') ? $configData['navbarType']: (($configData['layout'] === 'front') ? 'layout-navbar-fixed': '');
    $isFront = ($isFront ?? '') == true ? 'Front' : '';
    $contentLayout = (isset($container) ? (($container === 'container-xxl') ? "layout-compact" : "layout-wide") : "");
@endphp

    <html lang="❴❴ session()->get('locale') ?? app()->getLocale() ❵❵" class="light-style {{($contentLayout ?? '')}}" dir="ltr" data-theme="theme-default" data-framework="laravel">

    <head>
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

      <title>@yield('title')</title>
      <meta name="description" content="" />
      <meta name="keywords" content="">
      <!-- laravel CRUD token -->
      <meta name="csrf-token" content="❴❴ csrf_token() ❵❵">
      <!-- Favicon -->
      <link rel="icon" type="image/x-icon" href="❴❴ asset('assets/img/favicon/favicon.ico') ❵❵" />

      <!-- Include Styles -->
      <!-- $isFront is used to append the front layout styles only on the front layout otherwise the variable will be blank -->
      @include('layouts/sections/styles' . $isFront)

      <!-- Include Scripts for customizer, helper, analytics, config -->
      <!-- $isFront is used to append the front layout scriptsIncludes only on the front layout otherwise the variable will be blank -->
      @include('layouts/sections/scriptsIncludes' . $isFront)
    </head>

    <body>

      <!-- Layout Content -->
      @yield('layoutContent')
      <!--/ Layout Content -->

      <!-- Include Scripts -->
      <!-- $isFront is used to append the front layout scripts only on the front layout otherwise the variable will be blank -->
      @include('layouts/sections/scripts' . $isFront)

    </body>

  </html>
