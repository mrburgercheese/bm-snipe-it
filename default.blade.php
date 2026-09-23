<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ Helper::determineLanguageDirection() }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        @section('title')
        @show
        :: {{ $snipeSettings->site_name }}
    </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1" name="viewport">

    <meta name="apple-mobile-web-app-capable" content="yes">


    <link rel="apple-touch-icon"
          href="{{ ($snipeSettings) && ($snipeSettings->favicon!='') ?  Storage::disk('public')->url(e($snipeSettings->logo)) :  config('app.url').'/img/snipe-logo-bug.png' }}">
    <link rel="apple-touch-startup-image"
          href="{{ ($snipeSettings) && ($snipeSettings->favicon!='') ?  Storage::disk('public')->url(e($snipeSettings->logo)) :  config('app.url').'/img/snipe-logo-bug.png' }}">
    <link rel="shortcut icon" type="image/ico"
          href="{{ ($snipeSettings) && ($snipeSettings->favicon!='') ?  Storage::disk('public')->url(e($snipeSettings->favicon)) : config('app.url').'/favicon.ico' }}">


    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="language" content="{{ Helper::mapBackToLegacyLocale(app()->getLocale()) }}">
    <meta name="language-direction" content="{{ Helper::determineLanguageDirection() }}">
    <meta name="baseUrl" content="{{ config('app.url') }}/">
    <meta name="theme-color" content="{{ $snipeSettings->header_color ?? '#5fa4cc' }}">

    <script nonce="{{ csrf_token() }}">
        window.Laravel = {csrfToken: '{{ csrf_token() }}'};
    </script>

    {{-- stylesheets --}}
    <link rel="stylesheet" href="{{ url(mix('css/dist/all.css')) }}">

    {{-- page level css --}}
    @stack('css')


    <style>


        :root {
            color-scheme: light dark;
            --btn-theme-hover-text-color: {{ $nav_link_color ?? 'light-dark(hsl(from var(--main-theme-color) h s calc(l - 10)),hsl(from var(--main-theme-color) h s calc(l - 10)))' }};
            --btn-theme-hover: {{ $nav_link_color ?? 'light-dark(hsl(from var(--main-theme-color) h s calc(l - 10)),hsl(from var(--main-theme-color) h s calc(l - 10)))' }};
            --btn-theme-text-color: {{ $nav_link_color ?? 'light-dark(hsl(from var(--main-theme-color) h s calc(l + 10)),hsl(from var(--main-theme-color) h s calc(l - 10)))' }};
            --color-fg: light-dark(#373636, #ffffff);
            --main-footer-bg-color: light-dark(#ffffff,#3d4144);
            --main-footer-text-color: light-dark(#605e5e, #d2d6de);
            --main-footer-top-border-color: light-dark(#d2d6de,#605e5e);
            --main-theme-color: {{ $snipeSettings->header_color ?? '#3c8dbc' }};
            --nav-hover-text-color: {{ $nav_link_color ?? 'hsl(from var(--main-theme-color) h s calc(l - 10))' }};
            --nav-primary-text-color: {{ $nav_link_color ?? '#ffffff' }};
            --search-highlight: #e9d15b;
            --sidenav-hover-color-bg: #4c4b4b;
            --sidenav-text-hover-color: #fff;
            --sidenav-text-nohover-color: #b8c7ce;
            --table-border-row-color: light-dark(#ecf0f5, #656464);
            --table-border-row-top: 1px solid #ecf0f5;
            --table-border-row: 1px solid var(--table-border-row-color);
            --table-stripe-bg-alt: light-dark(rgba(211, 211, 211, 0.25), #323131);
            --table-stripe-bg: light-dark(#ffffff, #494747);
            --text-danger: light-dark(#a94442, #fa5b48);
            --text-help: light-dark(#777676,#a6a4a4);
            --text-info: light-dark(#31708f,#2baae6);
            --text-success: light-dark(#039516,#4ced61);
            --text-warning: light-dark(#da9113,#f3a51f);
            --input-border-color: light-dark(#d2d6de,#656464);
        }

        [data-theme="light"] {
            color-scheme: light;
            --box-bg: #ffffff;
            --box-header-bottom-border-color: #f4f4f4;
            --box-header-bottom-border: 1px solid var(--box-header-bottom-border-color);
            --box-header-top-border-color: #d2d6de;
            --box-header-top-border: 3px solid var(--box-header-top-border-color);
            --btn-theme-base: hsl(from var(--main-theme-color) h s calc(l + 5));
            --btn-theme-border:  hsl(from var(--btn-theme-base) h s calc(l + 20));
            --btn-theme-hover-text-color:  var(--nav-primary-text-color);
            --btn-theme-hover: var(--main-theme-hover);
            --callout-bg-color: var(--box-header-bottom-border-color);
            --callout-left-border: var(--box-header-top-border-color);
            --color-bg: #ecf0f5;
            --header-color: #000000;
            --input-group-bg: hsl(from var(--box-bg) h s calc(l - 5));
            --input-group-fg: hsl(from var(--input-group-bg) h s calc(l - 50));
            --link-color: {{ $link_light_color ?? '#296282' }};
            --link-hover:  hsl(from var(--link-color) h s calc(l - 10));
            --main-theme-hover: hsl(from var(--main-theme-color) h s calc(l - 10));
            --tab-bottom-border: 1px solid var(--box-header-top-border-color);
            --text-legend-help: var(--text-help);

        }

        [data-theme="dark"] {
            color-scheme: dark;
            --box-bg: #3d4144;
            --box-header-bottom-border-color: #605e5e;
            --box-header-bottom-border: 1px solid var(--box-header-bottom-border-color);
            --box-header-top-border-color: #605e5e;
            --box-header-top-border: 3px solid var(--box-header-top-border-color);
            --btn-theme-base: hsl(from var(--main-theme-color) h s calc(l + 5));
            --btn-theme-border:  hsl(from var(--btn-theme-base) h s calc(l + 20));
            --btn-theme-hover-text-color:  var(--nav-primary-text-color);
            --btn-theme-hover: var(--main-theme-hover);
            --callout-bg-color: var(--box-header-top-border-color);
            --callout-left-border: #323131;
            --color-bg: #222222;
            --header-color: #ffffff;
            --input-group-bg: hsl(from var(--box-bg) h s calc(l + 10));
            --input-group-fg: hsl(from var(--input-group-bg) h s calc(l + 50));
            --link-color: {{ $link_dark_color ?? '#5fa4cc' }};
            --link-hover:  hsl(from var(--link-color) h s calc(l + 15));
            --main-theme-hover: hsl(from var(--main-theme-color) h s calc(l - 10));
            --tab-bottom-border: 1px solid var(--box-header-top-border-color);
            --text-legend-help: #d6d6d6;

        }

        .label2_fields,
        .l2fd-main,
        .l2fd-listitem,
        .fixed-table-loading,
        .list-group-item
        {
            background-color: var(--box-bg) !important;
            color: var(--color-fg) !important;
        }

        .list-group-item {
            border: var(--tab-bottom-border);
        }

        footer.main-footer {
            color: var(--main-footer-text-color) !important;
            background-color: var(--main-footer-bg-color) !important;
            border-top: 1px solid var(--main-footer-top-border-color) !important;
        }

        a,
        a:link,
        a:visited
        {
            color: var(--link-color);
        }

        a:hover,
        a:focus
        {
            color: var(--link-hover) !important;
        }

        label.form-control {
            color: var(--color-fg) !important;
        }

        .footer-links a {
            color: var(--link-color) !important;
        }

        h2 small {
            color: var(--color-fg) !important;
        }

        .btn-theme {
            background-color: var(--btn-theme-base);
            /*color: var(--btn-theme-hover-text-color) !important;*/
            color: var(--nav-primary-text-color) !important;
            border: 1px solid hsl(from var(--btn-theme-base) h s calc(l - 15)) !important;
        }

        .btn-theme:hover {
            background-color: var(--btn-theme-hover);
            /*color: var(--btn-theme-hover-text-color) !important;*/
            color: var(--nav-primary-text-color) !important;
            border: 1px solid hsl(from var(--btn-theme-base) h s calc(l - 15)) !important;
        }

        .btn-theme.active
        {
            background-color: var(--btn-theme-hover) !important;
        }

        .btn-theme:focus {
            color: var(--nav-primary-text-color) !important;
        }


        .dropdown-wrapper,
        .js-data-ajax,
        .option,
        .select2 .select2-container .select2-container--default,
        .select2,
        .select2-choice,
        .select2-container,
        .select2-results__option,
        .select2-search input,
        .select2-search--dropdown,
        .select2-search__field,
        .select2-selection .select2-selection--single,
        .select2-selection,
        .select2-selection--single,
        .select2-selection__rendered,
        input[type="date"],
        input[type="number"],
        input[type="text"],
        input[type="url"],
        input[type="email"],
        input[type="password"],
        input[type="tel"],
        option:active,
        option[active],
        option[selected],
        select option,
        select,
        textarea
        {
            background-color: var(--table-stripe-bg) !important;
            color: var(--color-fg) !important;
            border-color: var(--input-border-color) !important;

        }

        .select2-container--default.select2-container--focus .select2-selection--multiple,
        .select2-container--default .select2-search--dropdown .select2-search__field {
            border-color: hsl(from var(--main-theme-color) h s calc(l - 5)) !important;
        }

        /**
        Multiselect maybe?
         */
        .select2-results__option[aria-selected=true]
        {
            background-color: var(--main-theme-color) !important;
            color: var(--nav-primary-text-color) !important;
        }

        .select2-results__option[aria-selected=false]
        {
            background-color: var(--table-stripe-bg) !important;
            /*background-color: hsl(from var(--main-theme-color) h s calc(l - 15)) !important;*/
            /*color: var(--nav-primary-text-color) !important;*/
            color: var(--color-fg) !important;
        }

        /**
        Highlight the select2 on hover when NOT the selected option
         */
        .select2-results__option--highlighted[aria-selected=false]
        {
            background-color: hsl(from var(--main-theme-color) h s calc(l - 10)) !important;
            color: var(--nav-primary-text-color) !important;
        }

        /**
        Highlight the select2 on hover when the selected option
         */
        .select2-results__option--highlighted[aria-selected=true],
        .select2-results__option--highlighted[aria-selected=true]:hover,
        .select2-results__option--highlighted[aria-selected=true]:link,
        .select2-results__option--highlighted[aria-selected=true]:focus,
        .select2-results__option--highlighted[aria-selected=true]:visited
        {
            background-color: hsl(from var(--main-theme-color) h s calc(l - 15)) !important;
            /*color: var(--color-fg) !important;*/
            color: var(--nav-primary-text-color) !important;
        }

        .select2-selection__choice,
        .select2-container--default .select2-selection--multiple .select2-selection__choice
        {
            background-color: var(--main-theme-color) !important;
            border-color: hsl(from var(--main-theme-color) h s calc(l - 15)) !important;
            color: var(--nav-primary-text-color) !important;
        }

        .select2-selection__choice__remove {
            color: var(--nav-primary-text-color) !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice
        {
            background-color: hsl(from var(--main-theme-color) h s calc(l - 5)) !important;
            color: var(--nav-primary-text-color) !important;
            overflow-y: auto;
        }


        .input-group-addon {
            background-color: var(--input-group-bg) !important;
            color: var(--input-group-fg) !important;
            border-color: var(--input-border-color) !important;
        }



        input[type="*"]:disabled,
        input[type=checkbox]:disabled,
        input[type=radio]:disabled,
        input[readonly],
        .select2-container--default.select2-container--disabled .select2-selection--single,
        .select2-container--default.select2-container--disabled .select2-selection__rendered,
        textarea[readonly]
        {
            background-color: light-dark(rgb(234, 232, 232), rgb(117, 116, 117)) !important;
            cursor: not-allowed !important;
        }



        input[type="search"].search-highlight {
            background-color: var(--search-highlight);
            border: 1px solid hsl(from var(--search-highlight) h s calc(l - 20)) !important;
        }

        .content-wrapper {
            background-color: var(--color-bg);
        }

        .btn-anchor {
            outline: none !important;
            padding: 0;
            border: 0;
            padding-left: 20px;
            vertical-align: baseline;
            cursor: pointer;
        }

        h1,
        h2,
        h3,
        h4,
        p,
        .modal-title,
        .modal-header h2
        {
            color: var(--color-fg) !important;
        }

        .btn-danger,
        .btn-danger:hover,
        .btn-danger:focus,
        .btn-warning,
        .btn-warning:hover,
        .btn-warning:focus,
        .btn-primary,
        .btn-primary:hover,
        .btn-primary:focus,
        .modal-danger,
        .modal-danger h2,
        .modal-warning h2,
        .modal-danger h4,
        .modal-warning h4,
        .bg-maroon,
        .bg-maroon:hover,
        .bg-maroon:focus,
        .bg-purple,
        .bg-purple:hover,
        .bg-purple:focus
        {
            color: white !important;
        }


        .btn-selected,
        .btn-selected a,
        .btn-selected:hover,
        .btn-selected:focus {
            color: light-dark(hsl(from var(--main-theme-color) h s calc(l + 30)), hsl(from var(--main-theme-color) h s calc(l + 30))) !important;
            background-color: light-dark(hsl(from var(--main-theme-color) h s calc(l - 20)), hsl(from var(--main-theme-color) h s calc(l - 20))) !important;
            border-color: light-dark(hsl(from var(--main-theme-color) h s calc(l - 25)), hsl(from var(--main-theme-color) h s calc(l - 25))) !important;

        }

        .btn-default,
        .btn-default:hover
        {
            color: #3d4144 !important;
        }

        body
        {
            background-color: var(--color-bg);
            color: var(--color-fg);
        }



        label,
        .icon-med,
        .nav-tabs-custom > .nav-tabs > li > a,
        .nav-tabs-custom > .nav-tabs > li.active > a:link
        {
            color: var(--color-fg);
        }

        .popover.right .arrow:after
        {
            border-right-color: var(--box-bg) !important;
        }

        .popover.right .arrow {
            border-right-color: var(--box-bg) !important;
        }

        .table-bordered > tbody > tr > td,
        .table-bordered > tbody > tr > th,
        .table-bordered > tfoot > tr > td,
        .table-bordered > tfoot > tr > th,
        .table-bordered > thead > tr > td,
        .table-bordered > thead > tr > td,
        .table-bordered > thead > tr > th,
        .table-bordered > thead > tr > th,
        .table-bordered,
        .well
        {
            border: 1px solid var(--box-header-top-border-color) !important;
            border-left-color: var(--box-header-top-border-color) !important;
            border-right-color: var(--box-header-top-border-color) !important;
        }

        .box {
            border-top: 3px solid;
        }

        .box.box-default {
            border-top:  var(--box-header-top-border);
        }



        .box-header.with-border {
            border-bottom: var(--box-header-bottom-border);
        }

        .box-footer
        {
            border-top: var(--box-header-bottom-border);
        }


        .nav-tabs-custom > .nav-tabs {
            border-bottom: var(--tab-bottom-border);
            border-top-right-radius: 3px;
            border-top-left-radius: 3px;
            padding-bottom: 0;

        }

        .nav-tabs > li > a {
            margin-right: 0;
            border: 0;
        }

        .box,
        .box-footer,
        .tab-content,
        .nav-tabs-custom,
        .nav-tabs-custom > .nav-tabs > li,
        .nav-tabs-custom > .nav-tabs > li:first-of-type,
        .nav-tabs-custom > .nav-tabs > li.active > a:link,
        .nav-tabs-custom > .nav-tabs > li.active > a:visited,
        .nav-tabs-custom > .nav-tabs > li.active > a:hover,
        .bootstrap-table.fullscreen,
        .well
        {

            color: var(--color-fg);
            background-color: var(--box-bg) !important;
            border-left: 1px solid transparent;
            border-right: 1px solid  transparent;

        }

        .panel {
            border-color: var(--box-header-top-border-color);
        }
        .panel-body {
            background-color: var(--box-bg) !important;
        }

        .panel-heading,
        .panel-default > .panel-heading
        {
            color: var(--color-fg) !important;
            background-color: var(--table-stripe-bg-alt) !important;
            border-color: var(--box-header-top-border-color);
        }

        .panel-footer {
            background-color: var(--box-bg) !important;
            border-color: var(--box-header-top-border-color);
        }

        .nav-tabs-custom > .nav-tabs > li.active
        {
            border-top-color: var(--main-theme-color) !important;
            background-color: var(--box-header-top-border-color) !important;
            border-bottom: 2px solid  var(--box-bg) !important;
            border-right: 1px solid  var(--box-header-top-border-color) ;
            border-top-right-radius: 3px;
            border-top-left-radius: 3px;
        }

        .nav-tabs-custom > .nav-tabs > li:first-of-type {
            border-left: 0;
        }


        /**
        This fixes the weird spacing in the nav tabs if there is a badge count on the tab
         */
        .badge {
            font-size: 11px;
        }

        /**
        table rows
         */

        .table > thead > tr > th,
        .table > tbody > tr > th,
        .table > tfoot > tr > th,
        .table > thead > tr > td,
        .table > tbody > tr > td,
        .table > tfoot > tr > td
        {
            border-top: var(--table-border-row) !important;
        }


        .table-striped > tbody > tr:nth-of-type(even),
        .row-new-striped > .row:nth-of-type(even),
        .row-new-striped > .div:nth-of-type(odd),
        .cansort
        {
            background-color: var(--table-stripe-bg) !important;
            border-top: var(--table-border-row-top) !important;
            color: var(--color-fg) !important;
        }

        .table-striped > tbody > tr:nth-of-type(odd),
        .row-new-striped > .row:nth-of-type(even),
        .row-new-striped > .div:nth-of-type(odd),
        .cansort
        {
            background-color: var(--table-stripe-bg-alt) !important;
            border-top: var(--table-border-row-top) !important;
            color: var(--color-fg) !important;
        }




        /**
        main header nav
         */


        .dropdown-menu {
            background-color: var(--main-theme-color);
            border-color: var(--main-theme-color);
        }


        .dropdown-menu > li,
        .navbar,
        .navbar-nav,
        .label-default,
        .label-default:hover
        {
            background-color: var(--main-theme-color);
            color: var(--nav-primary-text-color) !important;
        }


        .dropdown-menu > li > a:link,
        .dropdown-menu > li > a:visited,
        .dropdown-menu > .active > a:link,
        .dropdown-menu > .active > a:visited,
        .navbar-nav .open > a:link,
        .navbar-nav .open > a:visited,
        .navbar-nav > li > a:link,
        .navbar-nav > li > a:visited
        {
            background-color: var(--main-theme-color);
            /*background-color: rgba(0,0,0,.15);*/
            color: var(--nav-primary-text-color) !important;
            /*color: var(--nav-primary-text-color) !important;*/

        }

        .btn-tableButton.active.focus,
        .btn-tableButton.active:focus,
        .btn-tableButton.active:hover,
        .dropdown-menu > .active > a:focus,
        .dropdown-menu > .active > a:hover,
        .dropdown-menu > .active > a:link,
        .dropdown-menu > .active > a:visited,
        .dropdown-menu > li > a:focus,
        .dropdown-menu > li > a:hover,
        .dropdown-menu > li:focus,
        .dropdown-menu > li:hover,
        .navbar-nav .open  li.active > a:focus,
        .navbar-nav .open  li.active > a:hover,
        .navbar-nav .open > a:focus,
        .navbar-nav .open > a:hover,
        .navbar-nav > li > a:focus,
        .navbar-nav > li > a:hover,
        .open > .dropdown-toggle.btn-tableButton:focus,
        .open > .dropdown-toggle.btn-tableButton:hover,
        .page-next a,
        .pagination > .active > a:hover,
        .page-item.active,
        .pagination > .active > a,
        .pagination > li > .active > a,
        .pagination > li > .active > a:hover,
        .pagination > li > a:hover
        {
            background-color: var(--main-theme-hover) !important;
            border-color: var(--btn-theme-hover) !important;
            color: var(--nav-primary-text-color) !important;
        }

        .pagination > li > a
        {
            background-color: var(--main-theme-color) !important;
            border-color: var(--btn-theme-hover) !important;
            color: var(--nav-primary-text-color) !important;
        }


        .bootstrap-table .fixed-table-toolbar li.dropdown-item-marker label
        {
            color: var(--nav-primary-text-color) !important;
        }

        .bootstrap-table .fixed-table-toolbar li.dropdown-item-marker label:hover
        {
            background-color: var(--main-theme-hover) !important;
            color: var(--nav-primary-text-color) !important;
        }


        .dropdown-menu,
        .dropdown-menu > li
        {
            background-color: hsl(from var(--main-theme-color) h s calc(l - 5));
            border-color: hsl(from var(--main-theme-color) h s calc(l - 10));
            color: var(--nav-primary-text-color) !important;
        }

        .main-header .navbar .nav>.active>a {
            background-color: hsl(from var(--main-theme-color) h s calc(l - 5)) !important;
            color: var(--nav-primary-text-color) !important;
        }

        .navbar-nav > .notifications-menu > .dropdown-menu > li.header,
        .navbar-nav > .messages-menu > .dropdown-menu > li.header,
        .navbar-nav > .tasks-menu > .dropdown-menu > li.header,
        .navbar-nav > .notifications-menu > .dropdown-menu > li .menu,
        .navbar-nav > .messages-menu > .dropdown-menu > li .menu, .navbar-nav > .tasks-menu > .dropdown-menu > li .menu,
        .navbar-nav > .messages-menu > .dropdown-menu > li .menu, .navbar-nav > .tasks-menu > .dropdown-menu > li .menu a:hover,
        .navbar-nav > .messages-menu > .dropdown-menu > li .menu, .navbar-nav > .tasks-menu > .dropdown-menu > li:hover,
        .navbar-nav > .tasks-menu > .dropdown-menu > li .menu > li:hover > a,
        .task_menu
        {
            background-color: hsl(from var(--main-theme-color) h s calc(l - 5)) !important;
            color: var(--nav-primary-text-color) !important;
            margin-bottom: 0;
        }

        .navbar-nav > .notifications-menu > .dropdown-menu > li .menu > li > a, .navbar-nav > .messages-menu > .dropdown-menu > li .menu > li > a, .navbar-nav > .tasks-menu > .dropdown-menu > li .menu > li > a {
            border-bottom: 1px solid hsl(from var(--main-theme-color) h s calc(l - 10));
        }


        /**
        Active and hover for top tier sidenav items
         */

        .main-sidebar {
            background-color: #1e282c;
        }

        .list-group-item.subitem {
            padding-left:20px !important;
        }

        .sidebar-menu>li.active > a,
        .sidebar-menu>li:hover>a,
        .treeview-menu>li> a
        {
            color: var(--sidenav-text-hover-color) !important;
            border-left-color: var(--main-theme-color);
        }

        .sidebar-menu > li:hover > a,
        .sidebar-menu > li.active > a
        {
            border-left-color: var(--main-theme-color);
            padding-left: 12px;
        }


        .sidebar-menu > li:hover {
            background-color: #2c3b41;
        }

        .sidebar-menu>li>.treeview-menu
        {
            background-color: #1e282c;
        }


        .list-group-item:first-child {
            border-top: 0 !important;
        }

        .sidebar-menu > li > a:link,
        .sidebar-menu > li > a:visited,
        .treeview-menu>li> a
        {
            color: var(--sidenav-text-nohover-color) !important;
        }

        .sidebar-menu > li.active > a,
        .sidebar-menu > li:hover > a
        {
            background-color: #1e282c;
            border-left-color: var(--main-theme-color);
            border-left-style: solid;
            border-left-width: 3px;
            color: var(--sidenav-text-hover-color) !important;
        }

        thead,
        tbody,
        .table > thead > tr > th,
        .table > tbody > tr > th,
        .table > tfoot > tr > th,
        .table > thead > tr > td,
        .table > tbody > tr > td,
        .table > tfoot > tr > td

        {
            border-top-color: var(--box-bg) !important;
            border-bottom-color: var(--box-header-bottom-border-color) !important;
            color: var(--color-fg);
        }


        .help-block {
            color: var(--text-help) !important;
        }

        .alert-msg,
        .has-error
        {
            color: var(--text-danger) !important;
        }

        .has-error .form-control {
            border-color: var(--text-danger);
        }

        .alert a {
            color: white !important;
        }


        .text-dark-gray a:link,
        .text-dark-gray a:hover,
        .text-dark-gray a:visited,
        .text-dark-gray a:focus
        {
            color: hsl(from var(--main-theme-color) h s calc(l - 5));
        }

        .text-warning {
            color: var(--text-warning) !important;
        }

        .text-info {
            color: var(--text-info) !important;
        }

        .text-primary {
            color: var(--main-theme-color) !important;
        }

        .text-danger {
            color: var(--text-danger) !important;
        }

        .text-success {
            color: var(--text-success) !important;
        }

        .dropdown-menu > .divider {
            background-color: hsl(from var(--main-theme-color) h s calc(l - 10));
            margin-top: 0;
            margin-bottom: 0;
            padding-top: 1px;

        }

        input[type="radio"]::before {
            box-shadow: inset 1em 1em hsl(from var(--main-theme-color) h s calc(l - 20)) !important;
        }


        input[type="checkbox"]::before {
            box-shadow: inset 1em 1em hsl(from var(--main-theme-color) h s calc(l - 20)) !important;
        }




        .callout.callout-legend {
            background-color: var(--callout-bg-color);
            border-left: 5px solid var(--callout-left-border);

        }

        .callout-legend h4 a,
        .callout-legend h4 a:hover
        {
            color: var(--color-fg) !important;
        }



        p.callout-subtext, p.callout-subtext a:hover, p.callout-subtext a:visited, p.callout-subtext a:link {
            color: var(--text-legend-help) !important;
            text-decoration: none;
        }


        legend {
            border-bottom: 1px solid var(--callout-left-border);
        }

        th,
        .fix-sticky table thead {
            background-color: var(--box-bg);
            color: var(--color-fg) !important;
        }

        .datepicker.dropdown-menu th, .datepicker.datepicker-inline th,
        .datepicker.dropdown-menu td,
        .datepicker.datepicker-inline td

        {
            color: var(--color-fg);
            border-color: var(--color-fg);
            background-color: var(--box-bg) !important;
        }

        .datepicker.dropdown-menu th:hover,
        .datepicker.datepicker-inline th:hover,
        .datepicker.dropdown-menu td:hover,
        .datepicker.datepicker-inline td:hover,
        .datepicker table tr td span:hover,
        .datepicker table tr td span.focused,
        .logo:hover
        {
            background-color: var(--main-theme-color) !important;
            color: var(--nav-primary-text-color) !important;
        }

        .datepicker.dropdown-menu,
        .modal-content,
        .popover.help-popover,
        .popover.help-popover .popover-content,
        .popover.help-popover .popover-body,
        .popover.help-popover .popover-title,
        .popover.help-popover .popover-header
        {
            background-color: var(--box-bg) !important;
            /*color: var(--color-fg) !important;*/
            color: contrast-color(var(--box-bg)) !important;
        }

        .treeview-menu > li {
            background-color: #2c3b41;
            color: var(--sidenav-text-nohover-color) !important;
        }

        .treeview-menu > li >a:hover,
        .treeview-menu > li:hover,
        .treeview-menu > li.active > a
        {
            color: white !important;
            background-color: var(--sidenav-hover-color-bg) !important;
            /*color: var(--sidenav-text-hover-color) !important;*/
        }

        .sidebar-toggle.btn,
        .sidebar-toggle.btn:hover
        {
            color: white !important;
        }

        .chart-responsive {
            color: var(--color-fg) !important;
        }

        .table > tbody + tbody {
            border-top: 0px !important;
        }

        h4#progress-text {
            color: white !important;
        }

        .small-box h3, .small-box p {
            color: white !important;
        }

        .box.box-theme {
            border-top:  var(--main-theme-color) !important;
        }

        input[type="date"]:focus,
        input[type="number"]:focus,
        input[type="text"]:focus,
        input[type="url"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="tel"]:focus,
        textarea:focus
        {
            border-color: hsl(from var(--main-theme-color) h s calc(l - 5)) !important;
        }

        input[type="date"]:required,
        input[type="number"]:required,
        input[type="text"]:required,
        input[type="url"]:required,
        input[type="email"]:required,
        input[type="password"]:required,
        input[type="tel"]:required,
        select:required,
        input:required,
        textarea:required
        {
            border-right: 5px solid orange !important;
        }

        .bootstrap-table .fixed-table-container .table tbody tr.selected td {
            background-color: light-dark(hsl(from var(--main-theme-color) h s calc(l + 40)),hsl(from var(--main-theme-color) h s calc(l - 40))) !important;
        }

        tr.success > td {
            background-color: #00a65a !important;
            color: white !important;
        }

        tr.danger > td {
            background-color: var(--text-danger) !important;
            color: white !important;
        }

        @media print {

            body,
            div.content-wrapper,
            section.content,
            .webui,
            .main-panel,
            .nav-tabs-custom,
            .box,
            .box-body,
            .list-group,
            .list-group-unbordered,
            .list-group-item,
            .row,
            .tab-content
            {
                background: white !important;
                color: black !important;
            }
            .fixed-table-toolbar,
            .fixed-table-pagination,
            #assetsToolBar,
            .fixed-table-pagination
            {
                display: none !important;
            }
            .tab-pane.hidden-print {
                display: none !important;
                visibility: hidden !important;
            }

            h2, h3, h4 {
                color: black !important;
            }

            .col-sm-9,
            .main-panel
            {
                float: left;
                width: 100% !important;
            }

        }

    </style>

    {{-- Custom CSS --}}
    @if (($snipeSettings) && ($snipeSettings->custom_css))
        <style>
            {!! $snipeSettings->show_custom_css() !!}
        </style>
    @endif


    <script nonce="{{ csrf_token() }}">
        window.snipeit = {
            settings: {
                "per_page": {{ $snipeSettings->per_page }}
            }
        };
    </script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <script src="{{ url(asset('js/html5shiv.js')) }}" nonce="{{ csrf_token() }}"></script>
    <script src="{{ url(asset('js/respond.js')) }}" nonce="{{ csrf_token() }}"></script>


</head>

    <body class="sidebar-mini{{ (session('menu_state')!='open') ? ' sidebar-mini sidebar-collapse' : ''  }}">

        <a class="skip-main" href="#main">{{ trans('general.skip_to_main_content') }}</a>
        <div class="wrapper">

            <header class="main-header">

                <!-- Logo -->

                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button above the compact sidenav -->
                    <a href="#" style="color: white" class="sidebar-toggle btn btn-white" data-toggle="push-menu"
                       role="button">
                        <span class="sr-only">{{ trans('general.toggle_navigation') }}</span>
                    </a>
                    <div class="nav navbar-nav navbar-left">
                        <div class="left-navblock">
                            @if ($snipeSettings->brand == '3')
                                <a class="logo navbar-brand no-hover" href="{{ config('app.url') }}">
                                    @if ($snipeSettings->logo!='')
                                        <img class="navbar-brand-img"
                                             src="{{ Storage::disk('public')->url($snipeSettings->logo) }}"
                                             alt="{{ $snipeSettings->site_name }} logo">
                                    @endif
                                    {{ $snipeSettings->site_name }}
                                </a>
                            @elseif ($snipeSettings->brand == '2')
                                <a class="logo navbar-brand no-hover" href="{{ config('app.url') }}">
                                    @if ($snipeSettings->logo!='')
                                        <img class="navbar-brand-img"
                                             src="{{ Storage::disk('public')->url($snipeSettings->logo) }}"
                                             alt="{{ $snipeSettings->site_name }} logo">
                                    @endif
                                    <span class="sr-only">{{ $snipeSettings->site_name }}</span>
                                </a>
                            @else
                                <a class="logo navbar-brand no-hover" href="{{ config('app.url') }}">
                                    {{ $snipeSettings->site_name }}
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Navbar Right Menu -->
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <li aria-hidden="true">

                                    <a href="#" class="sidebar-toggle-mobile visible-xs hidden-lg hidden-md" data-toggle="push-menu"
                                   role="button">
                                    <span class="sr-only">{{ trans('general.toggle_navigation') }}</span>
                                    <x-icon type="nav-toggle" />
                                </a>

                            </li>

                            @can('index', \App\Models\Asset::class)
                                <li aria-hidden="true"{!! (request()->is('hardware*') ? ' class="active"' : '') !!}>
                                    <a href="{{ url('hardware') }}" {{$snipeSettings->shortcuts_enabled == 1 ? "accesskey=1" : ''}} tabindex="-1" data-tooltip="true" data-placement="bottom" data-title="{{ trans('general.assets') }}">
                                        <x-icon type="assets" class="fa-fw" />
                                        <span class="sr-only">{{ trans('general.assets') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('view', \App\Models\License::class)
                                <li aria-hidden="true"{!! (request()->is('licenses*') ? ' class="active"' : '') !!}>
                                    <a href="{{ route('licenses.index') }}" {{$snipeSettings->shortcuts_enabled == 1 ? "accesskey=2" : ''}} tabindex="-1" data-tooltip="true" data-placement="bottom" data-title="{{ trans('general.licenses') }}">
                                        <x-icon type="licenses" class="fa-fw" />
                                        <span class="sr-only">{{ trans('general.licenses') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('index', \App\Models\Accessory::class)
                                <li aria-hidden="true"{!! (request()->is('accessories*') ? ' class="active"' : '') !!}>
                                    <a href="{{ route('accessories.index') }}" {{$snipeSettings->shortcuts_enabled == 1 ? "accesskey=3" : ''}} tabindex="-1" data-tooltip="true" data-placement="bottom" data-title="{{ trans('general.accessories') }}">
                                        <x-icon type="accessories" class="fa-fw" />
                                        <span class="sr-only">{{ trans('general.accessories') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('index', \App\Models\Consumable::class)
                                <li aria-hidden="true"{!! (request()->is('consumables*') ? ' class="active"' : '') !!}>
                                    <a href="{{ url('consumables') }}" {{$snipeSettings->shortcuts_enabled == 1 ? "accesskey=4" : ''}} tabindex="-1" data-tooltip="true" data-placement="bottom" data-title="{{ trans('general.consumables') }}">
                                        <x-icon type="consumables" class="fa-fw" />
                                        <span class="sr-only">{{ trans('general.consumables') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('view', \App\Models\Component::class)
                                <li aria-hidden="true"{!! (request()->is('components*') ? ' class="active"' : '') !!}>
                                    <a href="{{ route('components.index') }}" {{$snipeSettings->shortcuts_enabled == 1 ? "accesskey=5" : ''}} tabindex="-1" data-tooltip="true" data-placement="bottom" data-title="{{ trans('general.components') }}">
                                        <x-icon type="components" class="fa-fw" />
                                        <span class="sr-only">{{ trans('general.components') }}</span>
                                    </a>
                                </li>
                            @endcan

                            @can('index', \App\Models\User::class)
                                <li aria-hidden="true"{!! (request()->is('users*') ? ' class="active"' : '') !!}>
                                    <a href="{{ route('users.index') }}" {{$snipeSettings->shortcuts_enabled == 1 ? "accesskey=6" : ''}} tabindex="-1" data-tooltip="true" data-placement="bottom" data-title="{{ trans('general.users') }}">
                                        <x-icon type="users" class="fa-fw" />
                                        <span class="sr-only">{{ trans('general.users') }}</span>
                                    </a>
                                </li>
                            @endcan

                            @can('index', \App\Models\Asset::class)
                                <li>
                                    <form class="navbar-form navbar-left form-inline" role="search" action="{{ route('findbytag/hardware') }}" method="get">

                                                <div class="input-group col-xs-12" style="border: 0 !important;">
                                                    <label class="sr-only" for="tagSearch">
                                                        {{ trans('general.lookup_by_tag') }}
                                                    </label>
                                                    <input type="text" class="form-control" id="tagSearch" name="assetTag" placeholder="{{ trans('general.lookup_by_tag') }}">
                                                    <span class="input-group-btn">
                                                        <button type="submit" id="topSearchButton" class="btn btn-sm btn-theme" style="padding: 7px 10px 7px 10px; "><x-icon type="search" class="fa-fw" /><div class="sr-only">{{ trans('general.search') }}</div></button>
                                                    </span>
                                                </div>

                                        <input type="hidden" name="topsearch" value="true" id="search">

                                    </form>
                                </li>
                            @endcan

                            @can('admin')
                                <li class="dropdown user-menu" aria-hidden="true">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" tabindex="-1">
                                        {{ trans('general.create') }}
                                        <strong class="caret"></strong>
                                    </a>
                                    <ul class="dropdown-menu">
                                        @can('create', \App\Models\Asset::class)
                                            <li{!! (request()->is('hardware/create') ? ' class="active"' : '') !!}>
                                                <a href="{{ route('hardware.create') }}" tabindex="-1">
                                                    <x-icon type="assets" class="fa-fw" />
                                                    {{ trans('general.asset') }}
                                                </a>
                                            </li>
                                        @endcan
                                        @can('create', \App\Models\License::class)
                                            <li{!! (request()->is('licenses/create') ? ' class="active"' : '') !!}>
                                                <a href="{{ route('licenses.create') }}" tabindex="-1">
                                                    <x-icon type="licenses" class="fa-fw" />
                                                    {{ trans('general.license') }}
                                                </a>
                                            </li>
                                        @endcan
                                        @can('create', \App\Models\Accessory::class)
                                            <li {!! (request()->is('accessories/create') ? 'class="active"' : '') !!}>
                                                <a href="{{ route('accessories.create') }}" tabindex="-1">
                                                    <x-icon type="accessories" class="fa-fw" />
                                                    {{ trans('general.accessory') }}
                                                </a>
                                            </li>
                                        @endcan
                                        @can('create', \App\Models\Consumable::class)
                                            <li {!! (request()->is('consunmables/create') ? 'class="active"' : '') !!}>
                                                <a href="{{ route('consumables.create') }}" tabindex="-1">
                                                    <x-icon type="consumables" class="fa-fw" />
                                                    {{ trans('general.consumable') }}
                                                </a>
                                            </li>
                                        @endcan
                                        @can('create', \App\Models\Component::class)
                                            <li {!! (request()->is('components/create') ? 'class="active"' : '') !!}>
                                                <a href="{{ route('components.create') }}" tabindex="-1">
                                                    <x-icon type="components" class="fa-fw" />
                                                    {{ trans('general.component') }}
                                                </a>
                                            </li>
                                        @endcan
                                        @can('create', \App\Models\User::class)
                                            <li {!! (request()->is('users/create') ? 'class="active"' : '') !!}>
                                                <a href="{{ route('users.create') }}" tabindex="-1">
                                                    <x-icon type="users" class="fa-fw" />
                                                    {{ trans('general.user') }}
                                                </a>
                                            </li>
                                        @endcan


                                    </ul>
                                </li>
                            @endcan

                            @can('admin')
                                <x-alert-menu />
                            @endcan



                            <!-- User Account: style can be found in dropdown.less -->
                            @if (Auth::check())
                                <li class="dropdown user user-menu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        @if (Auth::user()->present()->gravatar())
                                            <img src="{{ Auth::user()->present()->gravatar() }}" class="user-image"
                                                 alt="">
                                        @else
                                            <x-icon type="user" />
                                        @endif

                                        <span class="hidden-xs">
                                            {{ Auth::user()->display_name }}
                                            <strong class="caret"></strong>
                                        </span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <!-- User image -->
                                        @can('self.profile')
                                        <li {!! (request()->is('account/view-assets') ? ' class="active"' : '') !!}>
                                            <a href="{{ route('view-assets') }}">
                                                <x-icon type="checkmark" class="fa-fw" />
                                                {{ trans('general.viewassets') }}
                                            </a>
                                        </li>


                                        @can('viewRequestable', \App\Models\Asset::class)
                                            <li {!! (request()->is('account/requested') ? ' class="active"' : '') !!}>
                                                <a href="{{ route('account.requested') }}">
                                                    <x-icon type="requested" class="fa-fw" />
                                                    {{ trans('general.requested_assets_menu') }}
                                                </a></li>
                                        @endcan

                                        <li {!! (request()->is('account/accept') ? ' class="active"' : '') !!}>
                                            <a href="{{ route('account.accept') }}">
                                                <x-icon type="checkmark" class="fa-fw" />
                                                {{ trans('general.accept_assets_menu') }}
                                            </a>
                                        </li>

                                        @endcan
                                        <li {!! (request()->is('account/password') ? ' class="active"' : '') !!}>
                                            <a href="{{ route('profile') }}">
                                                <x-icon type="user" class="fa-fw" />
                                                {{ trans('general.editprofile') }}
                                            </a>
                                        </li>

                                        @can('self.profile')
                                        @if (Auth::user()->ldap_import!='1')
                                        <li {!! (request()->is('account/profile') ? ' class="active"' : '') !!}>
                                            <a href="{{ route('account.password.index') }}">
                                                <x-icon type="password" class="fa-fw" />
                                                {{ trans('general.changepassword') }}
                                            </a>
                                        </li>
                                        @endif
                                        @endcan

                                        <li>
                                            <a type="button" data-theme-toggle aria-label="Dark mode" class="btn-link btn-anchor" href=""  onclick="event.preventDefault();">
                                                {{ trans('general.dark_mode') }}
                                            </a>
                                        </li>

                                        @can('self.api')
                                            <li {!! (request()->is('account/api') ? ' class="active"' : '') !!}>
                                                <a href="{{ route('user.api') }}">
                                                    <x-icon type="api-key" class="fa-fw" />
                                                     {{ trans('general.manage_api_keys') }}
                                                </a>
                                            </li>
                                        @endcan
                                        <li class="divider"></li>
                                        <li>
                                            <a href="{{ route('logout.get') }}"
                                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                <x-icon type="logout" class="fa-fw" />
                                                 {{ trans('general.logout') }}
                                            </a>

                                            <form id="logout-form" action="{{ route('logout.post') }}" method="POST" style="display: none;">
                                                <button type="submit" style="display: none;" title="logout"></button>
                                                {{ csrf_field() }}
                                            </form>

                                        </li>
                                    </ul>
                                </li>
                            @endif


                            @can('superadmin')
                                <li>
                                    <a href="{{ route('settings.index') }}">
                                        <x-icon type="admin-settings" />
                                        <span class="sr-only">{{ trans('general.admin') }}</span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </div>
                </nav>

                <!-- Sidebar toggle button-->
            </header>

            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu" data-widget="tree" {{ \App\Helpers\Helper::determineLanguageDirection() == 'rtl' ? 'style="margin-right:12px' : '' }}>
                        @can('admin')
                            <li {!! (optional(\request()->route())->getName()=='home' ? ' class="active"' : '') !!} class="firstnav">
                                <a href="{{ route('home') }}">
                                    <x-icon type="dashboard" class="fa-fw" />
                                    <span>{{ trans('general.dashboard') }}</span>
                                </a>
                            </li>
                        @endcan
                        @can('view', \App\Models\Asset::class)
                            <li>
                                <a href="#" id="btn-sidebar-relocate-checkout">
                                    <i class="fa fa-map-marker text-green fa-fw"></i>
                                    <span>Update Lokasi Cepat</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" id="btn-sidebar-quick-loan">
                                    <i class="fas fa-handshake text-aqua fa-fw"></i>
                                    <span>Pinjam & Kembali</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" id="btn-sidebar-checkin-repair">
                                    <i class="fa fa-wrench text-yellow fa-fw"></i>
                                    <span>Perbaikan Cepat</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" id="btn-sidebar-checkin-broken">
                                    <i class="fa fa-ban text-red fa-fw"></i>
                                    <span>Tarik Aset Rusak</span>
                                </a>
                            </li>
                            <li {{ (request()->is('hardware/track-cepat*') ? 'class="active"' : '') }}>
                                <a href="{{ route('custom.track_cepat') }}">
                                    <i class="fa fa-crosshairs text-aqua fa-fw"></i>
                                    <span>Track Cepat</span>
                                </a>
                            </li>
                        @endcan
                        @can('index', \App\Models\Asset::class)
                            <li class="treeview{{ ((request()->is('statuslabels/*') || request()->is(['hardware*', 'maintenances*'])) ? ' active' : '') }}">
                                <a href="#">
                                    <x-icon type="assets" class="fa-fw" />
                                    <span>{{ trans('general.assets') }}</span>
                                    <x-icon type="angle-left" class="pull-right fa-fw"/>
                                </a>
                                <ul class="treeview-menu">
                                    <li {!! (!request()->query('status') && (request()->is('hardware')) ? ' class="active"' : '') !!}>
                                        <a href="{{ url('hardware') }}">
                                            <x-icon type="circle" class="text-grey fa-fw"/>
                                            {{ trans('general.list_all') }}
                                            <span class="badge">
                                                {{ (isset($total_assets)) ? $total_assets : '' }}
                                            </span>
                                        </a>
                                    </li>

                                    <?php $status_navs = \App\Models\Statuslabel::where('show_in_nav', '=', 1)->withCount('assets as asset_count')->get(); ?>
                                    @if (count($status_navs) > 0)
                                        @foreach ($status_navs as $status_nav)
                                            <li{!! (request()->is('statuslabels/'.$status_nav->id) ? ' class="active"' : '') !!}>
                                                <a href="{{ route('statuslabels.show', ['statuslabel' => $status_nav->id]) }}">
                                                    <i class="fas fa-circle text-grey fa-fw"
                                                       aria-hidden="true"{!!  ($status_nav->color!='' ? ' style="color: '.e($status_nav->color).'"' : '') !!}></i>
                                                    {{ $status_nav->name }}
                                                    <span class="badge badge-secondary">{{ $status_nav->asset_count }}</span></a></li>
                                        @endforeach
                                    @endif


                                    <li id="deployed-sidenav-option" {!! (request()->query('status') == 'Deployed' ? ' class="active"' : '') !!}>
                                        <a href="{{ url('hardware?status=Deployed') }}">
                                            <x-icon type="circle" class="text-blue fa-fw" />
                                            {{ trans('general.deployed') }}
                                            <span class="badge">{{ (isset($total_deployed_sidebar)) ? $total_deployed_sidebar : '' }}</span>
                                        </a>
                                    </li>
                                    <li id="rtd-sidenav-option"{!! (request()->query('status') == 'RTD' ? ' class="active"' : '') !!}>
                                        <a href="{{ url('hardware?status=RTD') }}">
                                            <x-icon type="circle" class="text-green fa-fw" />
                                            {{ trans('general.ready_to_deploy') }}
                                            <span class="badge">{{ (isset($total_rtd_sidebar)) ? $total_rtd_sidebar : '' }}</span>
                                        </a>
                                    </li>
                                    <li id="pending-sidenav-option"{!! (request()->query('status') == 'Pending' ? ' class="active"' : '') !!}><a href="{{ url('hardware?status=Pending') }}">
                                            <x-icon type="circle" class="text-orange fa-fw" />
                                            {{ trans('general.pending') }}
                                            <span class="badge">{{ (isset($total_pending_sidebar)) ? $total_pending_sidebar : '' }}</span>
                                        </a>
                                    </li>
                                    <li id="undeployable-sidenav-option"{!! (request()->query('status') == 'Undeployable' ? ' class="active"' : '') !!} ><a
                                                href="{{ url('hardware?status=Undeployable') }}">
                                            <x-icon type="x" class="text-red fa-fw" />
                                            {{ trans('general.undeployable') }}
                                            <span class="badge">{{ (isset($total_undeployable_sidebar)) ? $total_undeployable_sidebar : '' }}</span>
                                        </a>
                                    </li>
                                    <li id="byod-sidenav-option"{!! (request()->query('status') == 'byod' ? ' class="active"' : '') !!}><a
                                                href="{{ url('hardware?status=byod') }}">
                                            <x-icon type="x" class="text-red fa-fw" />
                                            {{ trans('general.byod') }}
                                            <span class="badge">{{ (isset($total_byod_sidebar)) ? $total_byod_sidebar : '' }}</span>
                                        </a>
                                    </li>
                                    <li id="archived-sidenav-option"{!! (request()->query('status') == 'Archived' ? ' class="active"' : '') !!}><a
                                                href="{{ url('hardware?status=Archived') }}">
                                            <x-icon type="x" class="text-red fa-fw" />
                                            {{ trans('admin/hardware/general.archived') }}
                                            <span class="badge">{{ (isset($total_archived_sidebar)) ? $total_archived_sidebar : '' }}</span>
                                        </a>
                                    </li>
                                    <li id="requestable-sidenav-option"{!! (request()->query('status') == 'Requestable' ? ' class="active"' : '') !!}><a
                                                href="{{ url('hardware?status=Requestable') }}">
                                            <x-icon type="checkmark" class="text-blue fa-fw" />
                                            {{ trans('admin/hardware/general.requestable') }}
                                        </a>
                                    </li>

                                    @can('audit', \App\Models\Asset::class)
                                        <li id="audit-due-sidenav-option"{!! (request()->is('hardware/audit/due') ? ' class="active"' : '') !!}>
                                            <a href="{{ route('assets.audit.due') }}">
                                                <x-icon type="audit" class="text-yellow fa-fw"/>
                                                {{ trans('general.audit_due') }}
                                                <span class="badge">{{ (isset($total_due_and_overdue_for_audit)) ? $total_due_and_overdue_for_audit : '' }}</span>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('checkin', \App\Models\Asset::class)
                                    <li id="checkin-due-sidenav-option"{!! (request()->is('hardware/checkins/due') ? ' class="active"' : '') !!}>
                                        <a href="{{ route('assets.checkins.due') }}">
                                            <x-icon type="due" class="text-orange fa-fw"/>
                                            {{ trans('general.checkin_due') }}
                                            <span class="badge">{{ (isset($total_due_and_overdue_for_checkin)) ? $total_due_and_overdue_for_checkin : '' }}</span>
                                        </a>
                                    </li>
                                    @endcan

                                    <li class="divider">&nbsp;</li>
                                    @can('checkin', \App\Models\Asset::class)
                                        <li{!! (request()->is('hardware/quickscancheckin') ? ' class="active"' : '') !!}>
                                            <a href="{{ route('hardware/quickscancheckin') }}">
                                                {{ trans('general.quickscan_checkin') }}
                                            </a>
                                        </li>
                                    @endcan

                                    @can('checkout', \App\Models\Asset::class)
                                        <li{!! (request()->is('hardware/bulkcheckout') ? ' class="active"' : '') !!}>
                                            <a href="{{ route('hardware.bulkcheckout.show') }}">
                                                {{ trans('general.bulk_checkout') }}
                                            </a>
                                        </li>
                                        <li{!! (request()->is('hardware/requested') ? ' class="active"' : '') !!}>
                                            <a href="{{ route('assets.requested') }}">
                                                {{ trans('general.requested') }}</a>
                                        </li>
                                    @endcan

                                    @can('create', \App\Models\Asset::class)
                                        <li{!! (request()->query('status') == 'Deleted' ? ' class="active"' : '') !!}>
                                            <a href="{{ url('hardware?status=Deleted') }}">
                                                {{ trans('general.deleted') }}
                                            </a>
                                        </li>
                                        <li {!! (request()->is('maintenances') ? ' class="active"' : '') !!}>
                                            <a href="{{ route('maintenances.index') }}">
                                                {{ trans('general.maintenances') }}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('admin')
                                        <li id="import-history-sidenav-option" {!! (request()->is('hardware/history') ? ' class="active"' : '') !!}>
                                            <a href="{{ url('hardware/history') }}">
                                                {{ trans('general.import-history') }}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('audit', \App\Models\Asset::class)
                                        <li id="bulk-audit-sidenav-option" {!! (request()->is('hardware/bulkaudit') ? ' class="active"' : '') !!}>
                                            <a href="{{ route('assets.bulkaudit') }}">
                                                {{ trans('general.bulkaudit') }}
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endcan
                        @can('view', \App\Models\License::class)
                            <li class="treeview{{ (request()->is('licenses*') || request()->is('bulkcheckoutlicense') || request()->is('bulkcheckinlicense') ? ' active' : '') }}">
                                <a href="#">
                                    <x-icon type="licenses" class="fa-fw"/>
                                    <span>{{ trans('general.licenses') }}</span>
                                    <x-icon type="angle-left" class="pull-right fa-fw"/>
                                </a>
                                <ul class="treeview-menu">
                                    <li{!! (request()->is('licenses') || (request()->is('licenses/*') && !request()->is('licenses/create')) ? ' class="active"' : '') !!}>
                                        <a href="{{ route('licenses.index') }}">
                                            <x-icon type="circle" class="text-grey fa-fw"/>
                                            <span>{{ trans('general.list_all') }}</span>
                                        </a>
                                    </li>
                                    @can('create', \App\Models\License::class)
                                        <li{!! (request()->is('licenses/create') ? ' class="active"' : '') !!}>
                                            <a href="{{ route('licenses.create') }}">
                                                <x-icon type="circle" class="text-grey fa-fw"/>
                                                <span>{{ trans('general.create') }}</span>
                                            </a>
                                        </li>
                                    @endcan
                                    <li{!! (request()->is('bulkcheckoutlicense') ? ' class="active"' : '') !!}>
                                        <a href="{{ url('bulkcheckoutlicense') }}">
                                            <i class="fa fa-key fa-fw"></i>
                                            <span>Bulk Checkout CCTV</span>
                                        </a>
                                    </li>
                                    <li{!! (request()->is('bulkcheckinlicense') ? ' class="active"' : '') !!}>
                                        <a href="{{ url('bulkcheckinlicense') }}">
                                            <i class="fa fa-undo fa-fw"></i>
                                            <span>Bulk Checkin CCTV</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endcan
                        @can('index', \App\Models\Accessory::class)
                            <li id="accessories-sidenav-option"{!! (request()->is('accessories*') ? ' class="active"' : '') !!}>
                                <a href="{{ route('accessories.index') }}">
                                    <x-icon type="accessories" class="fa-fw" />
                                    <span>{{ trans('general.accessories') }}</span>
                                </a>
                            </li>
                        @endcan
                        @can('view', \App\Models\Consumable::class)
                            <li id="consumables-sidenav-option"{!! (request()->is('consumables*') ? ' class="active"' : '') !!}>
                                <a href="{{ url('consumables') }}">
                                    <x-icon type="consumables" class="fa-fw" />
                                    <span>{{ trans('general.consumables') }}</span>
                                </a>
                            </li>
                        @endcan
                        @can('view', \App\Models\Component::class)
                            <li id="components-sidenav-option"{!! (request()->is('components*') ? ' class="active"' : '') !!}>
                                <a href="{{ route('components.index') }}">
                                    <x-icon type="components" class="fa-fw" />
                                    <span>{{ trans('general.components') }}</span>
                                </a>
                            </li>
                        @endcan
                        @can('view', \App\Models\PredefinedKit::class)
                            <li id="kits-sidenav-option"{!! (request()->is('kits') ? ' class="active"' : '') !!}>
                                <a href="{{ route('kits.index') }}">
                                    <x-icon type="kits" class="fa-fw" />
                                    <span>{{ trans('general.kits') }}</span>
                                </a>
                            </li>
                        @endcan

                        @can('view', \App\Models\User::class)
                                <li class="treeview{{ (request()->is('users*') ? ' active' : '') }}" id="users-sidenav-option">
                                    <a href="#" {{$snipeSettings->shortcuts_enabled == 1 ? "accesskey=6" : ''}}>
                                        <x-icon type="users" class="fa-fw" />
                                        <span>{{ trans('general.people') }}</span>
                                        <x-icon type="angle-left" class="pull-right fa-fw"/>
                                    </a>

                                    <ul class="treeview-menu">
                                        <li {!! ((request()->is('users')  && (request()->input() == null)) ? ' class="active"' : '') !!} id="users-sidenav-list-all">
                                            <a href="{{ route('users.index') }}">
                                                <x-icon type="circle" class="text-grey fa-fw fa-fw"/>
                                                {{ trans('general.list_all') }}
                                            </a>
                                        </li>
                                        <li class="{{ (request()->is('users') && request()->input('superadmins') == "true") ? 'active' : '' }}" id="users-sidenav-superadmins">
                                            <a href="{{ route('users.index', ['superadmins' => 'true']) }}">
                                                <x-icon type="superadmin" class="text-danger fa-fw"/>
                                                {{ trans('general.show_superadmins') }}
                                            </a>
                                        </li>
                                        <li class="{{ (request()->is('users') && request()->input('admins') == "true") ? 'active' : '' }}" id="users-sidenav-list-admins">
                                            <a href="{{ route('users.index', ['admins' => 'true']) }}">
                                                <x-icon type="admin" class="text-warning fa-fw"/>
                                                {{ trans('general.show_admins') }}
                                            </a>
                                        </li>
                                        <li class="{{ (request()->is('users') && request()->input('status') == "deleted") ? 'active' : '' }}" id="users-sidenav-deleted">
                                            <a href="{{ route('users.index', ['status' => 'deleted']) }}">
                                                <x-icon type="x" class="text-danger fa-fw"/>
                                                {{ trans('general.deleted_users') }}
                                            </a>
                                        </li>
                                        <li class="{{ (request()->is('users') && request()->input('activated') == "1") ? 'active' : '' }}" id="users-sidenav-activated">
                                            <a href="{{ route('users.index', ['activated' => true]) }}">
                                                <i class="fa-solid fa-person-circle-check text-success fa-fw"></i>
                                                {{ trans('general.login_enabled') }}
                                            </a>
                                        </li>
                                        <li class="{{ (request()->is('users') && request()->input('activated') == "0") ? 'active' : '' }}" id="users-sidenav-not-activated">
                                            <a href="{{ route('users.index', ['activated' => false]) }}">
                                                <i class="fa-solid fa-person-circle-xmark text-danger fa-fw"></i>
                                                {{ trans('general.login_disabled') }}
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                        @endcan
                        @can('import')
                            <li id="import-sidenav-option"{!! (request()->is('import*') ? ' class="active"' : '') !!}>
                                <a href="{{ route('imports.index') }}">
                                    <x-icon type="import" class="fa-fw" />
                                    <span>{{ trans('general.import') }}</span>
                                </a>
                            </li>
                        @endcan

                        @can('backend.interact')
                            <li id="settings-sidenav-option" class="treeview {!! (request()->is(App\Helpers\Helper::SettingUrls()) ? ' active' : '') !!}">
                                <a href="#" id="settings">
                                    <x-icon type="settings" class="fa-fw" />
                                    <span>{{ trans('general.settings') }}</span>
                                    <x-icon type="angle-left" class="pull-right fa-fw"/>
                                </a>

                                <ul class="treeview-menu">
                                    @if(Gate::allows('view', App\Models\CustomField::class) || Gate::allows('view', App\Models\CustomFieldset::class))
                                        <li {!! (request()->is('fields*') ? ' class="active"' : '') !!}>
                                            <a href="{{ route('fields.index') }}">
                                                {{ trans('admin/custom_fields/general.custom_fields') }}
                                            </a>
                                        </li>
                                    @endif

                                    @can('view', \App\Models\Statuslabel::class)
                                        <li {!! (request()->is('statuslabels*') ? ' class="active"' : '') !!}>
                                            <a href="{{ route('statuslabels.index') }}">
                                                {{ trans('general.status_labels') }}
                                            </a>
                                        </li>
                                    @endcan

                                    @can('view', \App\Models\AssetModel::class)
                                        <li {{!! (request()->is('models*') ? ' class="active"' : '') !!}}>
                                            <a href="{{ route('models.index') }}">
                                                {{ trans('general.asset_models') }}
                                            </a>
                                        </li>
                                    @endcan

                                    @can('view', \App\Models\Category::class)
                                        <li {{!! (request()->is('categories*') ? ' class="active"' : '') !!}}>
                                            <a href="{{ route('categories.index') }}">
                                                {{ trans('general.categories') }}
                                            </a>
                                        </li>
                                    @endcan

                                    @can('view', \App\Models\Manufacturer::class)
                                        <li {{!! (request()->is('manufacturers*') ? ' class="active"' : '') !!}}>
                                            <a href="{{ route('manufacturers.index') }}">
                                                {{ trans('general.manufacturers') }}
                                            </a>
                                        </li>
                                    @endcan

                                    @can('view', \App\Models\Supplier::class)
                                        <li {{!! (request()->is('suppliers*') ? ' class="active"' : '') !!}}>
                                            <a href="{{ route('suppliers.index') }}">
                                                {{ trans('general.suppliers') }}
                                            </a>
                                        </li>
                                    @endcan

                                    @can('view', \App\Models\Department::class)
                                        <li {{!! (request()->is('departments*') ? ' class="active"' : '') !!}}>
                                            <a href="{{ route('departments.index') }}">
                                                {{ trans('general.departments') }}
                                            </a>
                                        </li>
                                    @endcan

                                    @can('view', \App\Models\Location::class)
                                        <li {{!! (request()->is('locations*') ? ' class="active"' : '') !!}}>
                                            <a href="{{ route('locations.index') }}">
                                                {{ trans('general.locations') }}
                                            </a>
                                        </li>
                                    @endcan

                                    @can('view', \App\Models\Company::class)
                                        <li {{!! (request()->is('companies*') ? ' class="active"' : '') !!}}>
                                            <a href="{{ route('companies.index') }}">
                                                {{ trans('general.companies') }}
                                            </a>
                                        </li>
                                    @endcan

                                    @can('view', \App\Models\Depreciation::class)
                                        <li  {{!! (request()->is('depreciations*') ? ' class="active"' : '') !!}}>
                                            <a href="{{ route('depreciations.index') }}">
                                                {{ trans('general.depreciation') }}
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endcan

                        @can('reports.view')
                            <li class="treeview{{ (request()->is('reports*') ? ' active' : '') }}">
                                <a href="#" class="dropdown-toggle">
                                    <x-icon type="reports" class="fa-fw" />
                                    <span>{{ trans('general.reports') }}</span>
                                    <x-icon type="angle-left" class="pull-right"/>
                                </a>

                                <ul class="treeview-menu">
                                    <li {{!! (request()->is('reports/activity') ? ' class="active"' : '') !!}}>
                                        <a href="{{ route('reports.activity') }}">
                                            {{ trans('general.activity_report') }}
                                        </a>
                                    </li>
                                    <li {{!! (request()->is('reports/custom') ? ' class="active"' : '') !!}}>
                                        <a href="{{ url('reports/custom') }}">
                                            {{ trans('general.custom_report') }}
                                        </a>
                                    </li>
                                    <li {{!! (request()->is('reports/audit') ? ' class="active"' : '') !!}}>
                                        <a href="{{ route('reports.audit') }}">
                                            {{ trans('general.audit_report') }}</a>
                                    </li>
                                    <li {{!! (request()->is('reports/depreciation') ? ' class="active"' : '') !!}}>
                                        <a href="{{ url('reports/depreciation') }}">
                                            {{ trans('general.depreciation_report') }}
                                        </a>
                                    </li>
                                    <li {{!! (request()->is('reports/licenses') ? ' class="active"' : '') !!}}>
                                        <a href="{{ url('reports/licenses') }}">
                                            {{ trans('general.license_report') }}
                                        </a>
                                    </li>
                                    <li {{!! (request()->is('ui.reports.maintenances') ? ' class="active"' : '') !!}}>
                                        <a href="{{ route('ui.reports.maintenances') }}">
                                            {{ trans('general.asset_maintenance_report') }}
                                        </a>
                                    </li>
                                    <li {{!! (request()->is('reports/unaccepted_assets') ? ' class="active"' : '') !!}}>
                                        <a href="{{ url('reports/unaccepted_assets') }}">
                                            {{ trans('general.unaccepted_asset_report') }}
                                        </a>
                                    </li>
                                    <li  {{!! (request()->is('reports/accessories') ? ' class="active"' : '') !!}}>
                                        <a href="{{ url('reports/accessories') }}">
                                            {{ trans('general.accessory_report') }}
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endcan

                        @can('viewRequestable', \App\Models\Asset::class)
                            <li{!! (request()->is('account/requestable-assets') ? ' class="active"' : '') !!}>
                                <a href="{{ route('requestable-assets') }}">
                                    <x-icon type="requestable" class="fa-fw" />
                                    <span>{{ trans('general.requestable_items') }}</span>
                                </a>
                            </li>
                        @endcan

                        <!-- Menu Analisa Hardware (Added by Lexa) -->
                        <li class="treeview{!! (request()->is('analisa/*') ? ' active' : '') !!}">
                            <a href="#">
                                <i class="fa fa-calculator fa-fw"></i>
                                <span>Analisa Hardware</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li{!! (request()->is('analisa/cpu-intel-noncore') ? ' class="active"' : '') !!}>
                                    <a href="{{ route('hardware.analisa.cpu_intel_noncore') }}">
                                        <i class="fa fa-microchip text-blue fa-fw"></i>
                                        <span>CPU Intel (Non-Core)</span>
                                    </a>
                                </li>
                                <li{!! (request()->is('analisa/progress-report') ? ' class="active"' : '') !!}>
                                    <a href="{{ route('hardware.analisa.progress_report') }}">
                                        <i class="fa fa-line-chart text-purple fa-fw"></i>
                                        <span>Laporan Progress Upgrade</span>
                                    </a>
                                </li>

                            </ul>
                        </li>



                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->

            <div class="content-wrapper" role="main" id="setting-list">

                @if ($debug_in_production)
                    <div class="row" style="margin-bottom: 0px; background-color: red; color: white; font-size: 15px;">
                        <div class="col-md-12"
                             style="margin-bottom: 0px; background-color: #b50408 ; color: white; padding: 10px 20px 10px 30px; font-size: 16px;">
                            <x-icon type="warning" class="fa-3x pull-left"/>
                            <strong>{{ strtoupper(trans('general.debug_warning')) }}:</strong>
                            {!! trans('general.debug_warning_text') !!}
                        </div>
                    </div>
                @endif

                <!-- Content Header (Page header) -->
                <section class="content-header">


                    <div class="row">
                        <div class="col-md-12" style="margin-bottom: 0px;">

                        <style>
                            .breadcrumb-item {
                                display: inline;
                                list-style: none;
                            }
                        </style>

                            <h1 class="pull-left pagetitle" style="font-size: 22px; margin-top: 5px;">

                                @if (Breadcrumbs::has() && (Breadcrumbs::current()->count() > 1))
                                    <ul style="padding-left: 0;">

                                    @foreach (Breadcrumbs::current() as $crumbs)
                                        @if ($crumbs->url() && !$loop->last)
                                            <li class="breadcrumb-item">
                                                <a href="{{ $crumbs->url() }}">
                                                    @if ($loop->first)
                                                        <x-icon type="home" />
                                                    @else
                                                        {{ $crumbs->title() }}
                                                    @endif
                                                </a>
                                                <x-icon type="angle-right" />
                                            </li>
                                        @elseif (is_null($crumbs->url()) && !$loop->last)
                                            <li class="breadcrumb-item active">
                                                {{ $crumbs->title() }}
                                                <x-icon type="angle-right" />
                                            </li>
                                       @else
                                            <li class="breadcrumb-item active">
                                                {{ $crumbs->title() }}
                                            </li>
                                        @endif
                                    @endforeach

                                    </ul>
                                @else
                                    @yield('title')
                                @endif

                            </h1>

                                @if (isset($helpText))
                                    @include ('partials.more-info',
                                                           [
                                                               'helpText' => $helpText,
                                                               'helpPosition' => (isset($helpPosition)) ? $helpPosition : 'left'
                                                           ])
                                @endif
                                <div class="pull-right">
                                    @yield('header_right')
                                </div>

                        </div>
                    </div>
                </section>


                <section class="content" id="main" tabindex="-1" style="padding-top: 0px;">

                    <!-- Notifications -->
                    <div class="row">
                        @if (config('app.lock_passwords'))
                            <div class="col-md-12">
                                <div class="callout callout-info">
                                    {{ trans('general.some_features_disabled') }}
                                </div>
                            </div>
                        @endif

                        @include('notifications')
                    </div>


                    <!-- Content -->
                    <div id="{!! (request()->is('*api*') ? 'app' : 'webui') !!}">
                        @yield('content')
                    </div>

                </section>

            </div><!-- /.content-wrapper -->
            <footer class="main-footer hidden-print" style="display:grid;flex-direction:column;">

                <div class="hidden-xs pull-left">
                    <div class="pull-left footer-links">
                         {!! trans('general.footer_credit') !!}

                        <a target="_blank" href="https://bsky.app/profile/snipeitapp.com" rel="noopener" data-tooltip="true" data-title="Join us on Bluesky">
                            <i class="fa-brands fa-square-bluesky fa-fw"></i>
                        </a>
                        <a target="_blank" href="https://github.com/grokability/snipe-it/" rel="noopener" data-tooltip="true" data-title="Join us on Github">
                            <i class="fa-brands fa-square-github fa-fw"></i>
                        </a>
                        <a target="_blank" href="https://hachyderm.io/@grokability" rel="noopener" data-tooltip="true" data-title="Join us on Mastodon">
                            <i class="fa-brands fa-mastodon fa-fw"></i>
                        </a>
                        <a target="_blank" href="https://discord.gg/yZFtShAcKk" rel="noopener" data-tooltip="true" data-title="Join us on Discord">
                            <i class="fa-brands fa-discord fa-fw"></i>
                        </a>

                    </div>
                    <div class="pull-right">
                    @if ($snipeSettings->version_footer!='off')
                        @if (($snipeSettings->version_footer=='on') || (($snipeSettings->version_footer=='admin') && (Auth::user()->isSuperUser()=='1')))
                            &nbsp; {{ trans('general.version') }} {{ config('version.app_version') }} -
                            {{ trans('general.build') }} {{ config('version.build_version') }} ({{ config('version.branch') }})
                        @endif
                    @endif

                    @if (isset($user) && ($user->isSuperUser()) && (app()->environment('local')))
                       <a href="{{ url('telescope') }}" class="label label-default" rel="noopener">Open Telescope</a>
                    @endif




                    @if ($snipeSettings->support_footer!='off')
                        @if (($snipeSettings->support_footer=='on') || (($snipeSettings->support_footer=='admin') && (Auth::user()->isSuperUser()=='1')))
                            <a target="_blank" class="label label-default"
                               href="https://snipe-it.readme.io/docs/overview"
                               rel="noopener">{{ trans('general.user_manual') }}</a>
                            <a target="_blank" class="label label-default" href="https://snipeitapp.com/support/"
                               rel="noopener">{{ trans('general.bug_report') }}</a>
                        @endif
                    @endif

                    @if ($snipeSettings->privacy_policy_link!='')
                        <a target="_blank" class="label label-default" rel="noopener"
                           href="{{  $snipeSettings->privacy_policy_link }}"
                           target="_new">{{ trans('admin/settings/general.privacy_policy') }}</a>
                    @endif
                    </div>
                    <br>
                    @if ($snipeSettings->footer_text!='')
                        <div class="pull-left">
                            {!!  Helper::parseEscapedMarkedown($snipeSettings->footer_text)  !!}
                        </div>
                    @endif
                </div>
            </footer>
        </div><!-- ./wrapper -->


        <!-- end main container -->

        <div class="modal modal-danger fade" id="dataConfirmModal" tabindex="-1" role="dialog" aria-labelledby="dataConfirmModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="dataConfirmModalLabel">
                            <span class="modal-header-icon"></span>&nbsp;
                        </h4>
                    </div>
                    <div class="modal-body"></div>
                    <div class="modal-footer">
                        <form method="post" id="deleteForm" role="form" action="">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}

                            <button type="button" class="btn btn-default pull-left"
                                    data-dismiss="modal">{{ trans('general.cancel') }}</button>
                            <button type="submit" class="btn btn-outline"
                                    id="dataConfirmOK">{{ trans('general.yes') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal modal-warning fade" id="restoreConfirmModal" tabindex="-1" role="dialog"
             aria-labelledby="confirmModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="confirmModalLabel">&nbsp;</h4>
                    </div>
                    <div class="modal-body"></div>
                    <div class="modal-footer">
                        <form method="post" id="restoreForm" role="form">
                            {{ csrf_field() }}
                            {{ method_field('POST') }}

                            <button type="button" class="btn btn-default pull-left"
                                    data-dismiss="modal">{{ trans('general.cancel') }}</button>
                            <button type="submit" class="btn btn-outline"
                                    id="dataConfirmOK">{{ trans('general.yes') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>



        {{-- Javascript files --}}
        <script src="{{ url(mix('js/dist/all.js')) }}" nonce="{{ csrf_token() }}"></script>
        <script src="{{ url('js/select2/i18n/'.Helper::mapBackToLegacyLocale(app()->getLocale()).'.js') }}"></script>

        {{-- Page level javascript --}}
        @stack('js')

        @section('moar_scripts')
        @show


        <script nonce="{{ csrf_token() }}">

            // Handle the first selected tabs regardless of permissions
            if ($('li.snipetab').is(':first-of-type')) {
                var hash = $('li.snipetab:first-of-type').children().attr('href');
                $('li.snipetab:first-of-type').addClass('active');
                $('div'+hash+'.snipetab-pane').addClass('in active');
            }


            //color picker with addon
            $(".color").colorpicker();


            /**
             * Utility function to calculate the current theme setting.
             * Look for a local storage value.
             * Fall back to system setting.
             * Fall back to light mode.
             */
            function calculateSettingAsThemeString({ localStorageTheme, systemSettingDark }) {
                if (localStorageTheme !== null) {
                    return localStorageTheme;
                }

                if (systemSettingDark.matches) {
                    return "dark";
                }

                return "light";
            }

            /**
             * Utility function to update the button text and aria-label.
             */
            function updateButton({ buttonEl, isDark }) {
                const newCta = isDark ? '<i class="fa-regular fa-sun fa-fw"></i>  {{ trans('general.light_mode') }}' : '<i class="fa-solid fa-moon fa-fw"></i>   {{ trans('general.dark_mode') }}';
                // use an aria-label if omitting text on the button
                // and using a sun/moon icon, for example
                buttonEl.setAttribute("aria-label", newCta);
                buttonEl.innerHTML = newCta;
            }

            /**
             * Utility function to update the theme setting on the html tag
             */
            function updateThemeOnHtmlEl({ theme }) {
                document.querySelector("html").setAttribute("data-theme", theme);
            }


            /**
             * On page load:
             */

            /**
             * 1. Grab what we need from the DOM and system settings on page load
             */

            const button = document.querySelector("[data-theme-toggle]");
            const localStorageTheme = localStorage.getItem("theme");
            const systemSettingDark = window.matchMedia("(prefers-color-scheme: dark)");
            const clearButton = document.querySelector("[data-theme-toggle-clear]");

            /**
             * 2. Work out the current site settings
             */
            let currentThemeSetting = calculateSettingAsThemeString({ localStorageTheme, systemSettingDark });

            /**
             * 3. Update the theme setting and button text according to current settings
             */
            updateButton({ buttonEl: button, isDark: currentThemeSetting === "dark" });
            updateThemeOnHtmlEl({ theme: currentThemeSetting });

            /**
             * 4. Add an event listener to toggle the theme
             */
            button.addEventListener("click", (event) => {
                const newTheme = currentThemeSetting === "dark" ? "light" : "dark";

                localStorage.setItem("theme", newTheme);
                updateButton({ buttonEl: button, isDark: newTheme === "dark" });
                updateThemeOnHtmlEl({ theme: newTheme });

                currentThemeSetting = newTheme;
            });




            $.fn.datepicker.dates['{{ app()->getLocale() }}'] = {
                days: [
                    "{{ trans('datepicker.days.sunday') }}",
                    "{{ trans('datepicker.days.monday') }}",
                    "{{ trans('datepicker.days.tuesday') }}",
                    "{{ trans('datepicker.days.wednesday') }}",
                    "{{ trans('datepicker.days.thursday') }}",
                    "{{ trans('datepicker.days.friday') }}",
                    "{{ trans('datepicker.days.saturday') }}"
                ],
                daysShort: [
                    "{{ trans('datepicker.short_days.sunday') }}",
                    "{{ trans('datepicker.short_days.monday') }}",
                    "{{ trans('datepicker.short_days.tuesday') }}",
                    "{{ trans('datepicker.short_days.wednesday') }}",
                    "{{ trans('datepicker.short_days.thursday') }}",
                    "{{ trans('datepicker.short_days.friday') }}",
                    "{{ trans('datepicker.short_days.saturday') }}"
                ],
                daysMin: [
                    "{{ trans('datepicker.min_days.sunday') }}",
                    "{{ trans('datepicker.min_days.monday') }}",
                    "{{ trans('datepicker.min_days.tuesday') }}",
                    "{{ trans('datepicker.min_days.wednesday') }}",
                    "{{ trans('datepicker.min_days.thursday') }}",
                    "{{ trans('datepicker.min_days.friday') }}",
                    "{{ trans('datepicker.min_days.saturday') }}"
                ],
                months: [
                    "{{ trans('datepicker.months.january') }}",
                    "{{ trans('datepicker.months.february') }}",
                    "{{ trans('datepicker.months.march') }}",
                    "{{ trans('datepicker.months.april') }}",
                    "{{ trans('datepicker.months.may') }}",
                    "{{ trans('datepicker.months.june') }}",
                    "{{ trans('datepicker.months.july') }}",
                    "{{ trans('datepicker.months.august') }}",
                    "{{ trans('datepicker.months.september') }}",
                    "{{ trans('datepicker.months.october') }}",
                    "{{ trans('datepicker.months.november') }}",
                    "{{ trans('datepicker.months.december') }}",
                ],
                monthsShort:  [
                    "{{ trans('datepicker.months_short.january') }}",
                    "{{ trans('datepicker.months_short.february') }}",
                    "{{ trans('datepicker.months_short.march') }}",
                    "{{ trans('datepicker.months_short.april') }}",
                    "{{ trans('datepicker.months_short.may') }}",
                    "{{ trans('datepicker.months_short.june') }}",
                    "{{ trans('datepicker.months_short.july') }}",
                    "{{ trans('datepicker.months_short.august') }}",
                    "{{ trans('datepicker.months_short.september') }}",
                    "{{ trans('datepicker.months_short.october') }}",
                    "{{ trans('datepicker.months_short.november') }}",
                    "{{ trans('datepicker.months_short.december') }}",
                ],
                today: "{{ trans('datepicker.today') }}",
                clear: "{{ trans('datepicker.clear') }}",
                format: "yyyy-mm-dd",
                weekStart: {{ $snipeSettings->week_start ?? 0 }},
            };


            var clipboard = new ClipboardJS('.js-copy-link');

            clipboard.on('success', function(e) {
                e.text = e.text.replace(/^\s/, '').trim();
                var clickedElement = $(e.trigger);
                clickedElement.tooltip('hide').attr('data-original-title', '{{ trans('general.copied') }}').tooltip('show');
            });


            // Reference: https://jqueryvalidation.org/validate/
            var validator = $('#create-form').validate({
                ignore: 'input[type=hidden]',
                errorClass: 'alert-msg',
                errorElement: 'div',
                errorPlacement: function(error, element) {

                    if ($(element).hasClass('select2') || $(element).hasClass('js-data-ajax')) {
                        // If the element is a select2 then append the error to the parent div
                        element.parent('div').append(error);

                     } else if ($(element).parent().hasClass('input-group')) {
                        var end_input_group = $(element).next('.input-group-addon').parent();
                        error.insertAfter(end_input_group);
                    } else {
                        error.insertAfter(element);
                    }

                },
                highlight: function(inputElement) {

                    // We have to go two levels up if it's an input group
                    if ($(inputElement).parent().hasClass('input-group')) {
                        $(inputElement).parent().parent().parent().addClass('has-error');
                    } else {
                        $(inputElement).parent().addClass('has-error');
                        $(inputElement).closest('.help-block').remove();
                    }

                },
                onfocusout: function(element) {
                    // We have to go two levels up if it's an input group
                    if ($(element).parent().hasClass('input-group')) {
                        $(element).parent().parent().parent().removeClass('has-error');
                        return $(element).valid();
                    } else {
                        $(element).parent().removeClass('has-error');
                        return $(element).valid();
                    }

                },

            });

            $.extend($.validator.messages, {
                required: "{{ trans('validation.generic.required') }}",
                email: "{{ trans('validation.generic.email') }}"
            });


            function showHideEncValue(e) {
                // Use element id to find the text element to hide / show
                var targetElement = e.id+"-to-show";
                var hiddenElement = e.id+"-to-hide";
                var audio = new Audio('{{ config('app.url') }}/sounds/lock.mp3');
                if($(e).hasClass('fa-lock')) {
                    @if ((isset($user)) && ($user->enable_sounds))
                        audio.play()
                    @endif
                    $(e).removeClass('fa-lock').addClass('fa-unlock');
                    // Show the encrypted custom value and hide the element with asterisks
                    document.getElementById(targetElement).style.fontSize = "100%";
                    document.getElementById(hiddenElement).style.display = "none";

                } else {
                    @if ((isset($user)) && ($user->enable_sounds))
                        audio.play()
                    @endif
                    $(e).removeClass('fa-unlock').addClass('fa-lock');
                    // ClipboardJS can't copy display:none elements so use a trick to hide the value
                    document.getElementById(targetElement).style.fontSize = "0px";
                    document.getElementById(hiddenElement).style.display = "";

                 }
             }




            function checkInfoSidePanel() {
                var side_panel_state = localStorage.getItem("side_panel_state");

                // Open side info panel
                if (side_panel_state == 'collapsed') {
                    collapseInfoSidePanel();

                // Collapse side info panel
                } else {
                    expandInfoSidePanel();
                }

            }

            function toggleInfoSidePanel() {
                var side_panel_state = localStorage.getItem("side_panel_state");

                if (side_panel_state == 'expanded') {
                    localStorage.setItem("side_panel_state", 'collapsed');
                } else {
                    localStorage.setItem("side_panel_state", 'expanded');
                }

                checkInfoSidePanel();
            }

            function collapseInfoSidePanel() {
                $('.side-box').removeClass('expanded').hide();
                $('.main-panel').removeClass('col-md-9').addClass('col-md-12');
                $("#expand-info-panel-button").addClass('fa-square-caret-left').removeClass('fa-square-caret-right');
            }

            function expandInfoSidePanel() {
                $('.side-box').fadeIn("fast").addClass('expanded');
                $('.main-panel').removeClass('col-md-12').addClass('col-md-9');
                $("#expand-info-panel-button").addClass('fa-square-caret-right').removeClass('fa-square-caret-left');
            }


            $(document).ready(function () {
                checkInfoSidePanel();

                // Handle the info-panel
                $("#expand-info-panel-button").click(function () {
                    toggleInfoSidePanel();
                });



                // This handles the show/hide for cloned items
                $('#use_cloned_image').click(function() {
                    if ($('#use_cloned_image').is(':checked')) {
                        $('#image_delete').prop('checked', false);
                        $('#image-upload').hide();
                        $('#existing-image').show();
                    } else {
                        $('#image-upload').show();
                        $('#existing-image').hide();
                    }
                    //$('#image-upload').hide();
                });

                // Invoke Bootstrap 3's tooltip
                $('[data-tooltip="true"]').tooltip({
                    container: 'body',
                    animation: true,
                });

                $('[data-toggle="popover"]').popover();
                $('.select2 span').addClass('needsclick');
                $('.select2 span').removeAttr('title');

                // This javascript handles saving the state of the menu (expanded or not)
                $('body').bind('expanded.pushMenu', function () {
                    $.ajax({
                        type: 'GET',
                        url: "{{ route('account.menuprefs', ['state'=>'open']) }}",
                        _token: "{{ csrf_token() }}"
                    });

                });

                $('body').bind('collapsed.pushMenu', function () {
                    $.ajax({
                        type: 'GET',
                        url: "{{ route('account.menuprefs', ['state'=>'close']) }}",
                        _token: "{{ csrf_token() }}"
                    });
                });

            });

            // Initiate the ekko lightbox
            $(document).on('click', '[data-toggle="lightbox"]', function (event) {
                event.preventDefault();
                $(this).ekkoLightbox();
            });
            //This prevents multi-click checkouts for accessories, components, consumables
            $(document).ready(function () {
                $('#checkout_form').submit(function (event) {
                    event.preventDefault();
                    $('#submit_button').prop('disabled', true);
                    this.submit();
                });
            });

            // Select encrypted custom fields to hide them in the asset list
            $(document).ready(function() {
                // Selector for elements with css-padlock class
                var selector = 'td.css-padlock';

                // Function to add original value to elements
                function addValue($element) {
                    // Get original value of the element
                    var originalValue = $element.text().trim();

                    // Show asterisks only for not empty values
                    if (originalValue !== '') {
                        // This is necessary to avoid loop because value is generated dynamically
                        if (originalValue !== '' && originalValue !== asterisks) $element.attr('value', originalValue);

                        // Hide the original value and show asterisks of the same length
                        var asterisks = '*'.repeat(originalValue.length);
                        $element.text(asterisks);

                        // Add click event to show original text
                        $element.click(function() {
                            var $this = $(this);
                            if ($this.text().trim() === asterisks) {
                                $this.text($this.attr('value'));
                            } else {
                                $this.text(asterisks);
                            }
                        });
                    }
                }
                // Add value to existing elements
                $(selector).each(function() {
                    addValue($(this));
                });

                // Function to handle mutations in the DOM because content is generated dynamically
                var observer = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mutation) {
                        // Check if new nodes have been inserted
                        if (mutation.type === 'childList') {
                            mutation.addedNodes.forEach(function(node) {
                                if ($(node).is(selector)) {
                                    addValue($(node));
                                } else {
                                    $(node).find(selector).each(function() {
                                        addValue($(this));
                                    });
                                }
                            });
                        }
                    });
                });

                // Configure the observer to observe changes in the DOM
                var config = { childList: true, subtree: true };
                observer.observe(document.body, config);
            });


        </script>

        @if ((session()->get('topsearch')=='true') || (request()->is('/')))
            <script nonce="{{ csrf_token() }}">
                $("#tagSearch").focus();
            </script>
        @endif

@can('view', \App\Models\Asset::class)
<!-- FAB & Modal Check-in Perbaikan Cepat (Global) -->
<style>

    /* Autocomplete dropdown styles */
    .fab-autocomplete-results {
        position: absolute;
        width: calc(100% - 30px);
        max-height: 200px;
        overflow-y: auto;
        border: 1px solid #ccc;
        border-radius: 4px;
        background-color: white;
        z-index: 1050;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        display: none;
        margin-top: 2px;
    }
    .fab-autocomplete-item {
        padding: 8px 12px;
        cursor: pointer;
        border-bottom: 1px solid #eee;
    }
    .fab-autocomplete-item:last-child {
        border-bottom: none;
    }
    .fab-autocomplete-item:hover {
        background-color: #f5f5f5;
        color: #dd4b39;
    }
    .fab-autocomplete-item strong {
        display: block;
        font-size: 13px;
    }
    .fab-autocomplete-item small {
        color: #777;
    }
    /* Dark mode support for autocomplete list */
    [class*="skin-"][class*="-dark"] .fab-autocomplete-results {
        background-color: #2b2b2b;
        border-color: #444;
        box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    }
    [class*="skin-"][class*="-dark"] .fab-autocomplete-item {
        border-bottom-color: #444;
        color: #ddd;
    }
    [class*="skin-"][class*="-dark"] .fab-autocomplete-item:hover {
        background-color: #3a3a3a;
        color: #8ab4f8;
    }
    [class*="skin-"][class*="-dark"] .fab-autocomplete-item small {
        color: #aaa;
    }
</style>


<!-- Modal Form Check-in Perbaikan Cepat -->
<div class="modal fade" id="modal-fab-checkin-repair" tabindex="-1" role="dialog" aria-labelledby="modal-fab-checkin-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 6px; box-shadow: 0 5px 15px rgba(0,0,0,0.3);">
            <form id="form-fab-checkin-repair">
                <div class="modal-header" style="background-color: #dd4b39; color: white; border-top-left-radius: 5px; border-top-right-radius: 5px;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white; opacity: 0.8;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="modal-fab-checkin-title">
                        <i class="fa fa-wrench"></i> Check-in Aset ke Perbaikan
                    </h4>
                </div>
                <div class="modal-body" style="padding: 20px;">
                    <div class="form-group">
                        <label for="fab-asset-tag">Tag Aset / Serial Number (Scan Barcode)</label>
                        <input type="text" class="form-control" id="fab-asset-tag" placeholder="Scan atau ketik Tag Aset (contoh: PBM-150101001)" required autocomplete="off" style="font-size: 16px; height: 40px;">
                        
                        <!-- Autocomplete Results Container -->
                        <div id="fab-autocomplete-box" class="fab-autocomplete-results"></div>
                        
                        <!-- Lookup Progress and Result -->
                        <div id="fab-lookup-loading" style="display: none; margin-top: 8px; color: #666; font-size: 13px;">
                            <i class="fa fa-spinner fa-spin"></i> Mencari data aset...
                        </div>
                        <div id="fab-lookup-error" class="text-danger" style="display: none; margin-top: 8px; font-weight: bold; font-size: 13px;">
                            <i class="fa fa-times-circle"></i> Aset tidak ditemukan / belum terdaftar!
                        </div>
                        
                        <!-- Preview Card With Asset Photo Thumbnail -->
                        <div id="fab-lookup-preview" style="display: none; margin-top: 12px; padding: 12px; border-radius: 6px; border: 1px solid #dcdcdc; background-color: #fcfcfc; box-shadow: inset 0 1px 3px rgba(0,0,0,0.05);">
                            <div style="display: flex; align-items: flex-start; gap: 12px;">
                                <div style="flex-shrink: 0;">
                                    <img id="preview-image" src="" alt="Foto Aset" style="width: 75px; height: 75px; object-fit: cover; border-radius: 6px; border: 1px solid #ccc; background-color: #fff; padding: 2px;">
                                </div>
                                <div style="flex: 1; min-width: 0;">
                                    <h5 style="margin-top: 0; color: #dd4b39; font-weight: bold; font-size: 14px; margin-bottom: 6px;">
                                        <i class="fa fa-info-circle"></i> Detail Aset Terdeteksi:
                                    </h5>
                                    <table style="width: 100%; font-size: 13px; line-height: 1.5;">
                                        <tr>
                                            <td style="width: 35%; font-weight: bold; color: #555;">Nama Aset</td>
                                            <td id="preview-name" style="color: #111; font-weight: bold;">-</td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: bold; color: #555;">Serial Number</td>
                                            <td id="preview-serial" style="color: #111;">-</td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: bold; color: #555;">Status Saat Ini</td>
                                            <td id="preview-status" style="color: #111;">-</td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: bold; color: #555;">Peminjam</td>
                                            <td id="preview-assignee" style="color: #111;">-</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group" style="margin-top: 15px;">
                        <label for="fab-status-id"><i class="fa fa-tag"></i> Status Pengembalian / Tarik Aset</label>
                        <select class="form-control" id="fab-status-id" style="font-size: 14px; height: 40px; font-weight: bold;">
                            <option value="7">🟡 Asset Dalam Perbaikan (Servis IT / Maintenance)</option>
                            <option value="3">🔴 Asset Rusak (Undeployable / Rusak Total / Afkir)</option>
                            <option value="8">⬛ Disimpan Untuk Kanibal</option>
                        </select>
                    </div>
                    <div class="form-group" style="margin-top: 15px;">
                        <label for="fab-repair-notes">Catatan Kerusakan / Keterangan Kondisi Unit</label>
                        <textarea class="form-control" id="fab-repair-notes" rows="3" placeholder="Tulis catatan kerusakan atau keluhan unit..." style="resize: vertical;"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" style="background-color: #dd4b39; border-color: #dd4b39;">
                        <i class="fa fa-wrench"></i> Tarik ke Perbaikan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Form Update Lokasi Cepat (Relokasi Checkout) -->
<div class="modal fade" id="modal-fab-relocate-location" role="dialog" aria-labelledby="modal-fab-relocate-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 6px; box-shadow: 0 5px 15px rgba(0,0,0,0.3);">
            <form id="form-fab-relocate-location">
                <div class="modal-header" style="background-color: #00a65a; color: white; border-top-left-radius: 5px; border-top-right-radius: 5px;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white; opacity: 0.8;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="modal-fab-relocate-title">
                        <i class="fa fa-map-marker"></i> Update Lokasi / Relokasi Checkout Cepat
                    </h4>
                </div>
                <div class="modal-body" style="padding: 20px;">
                    <!-- Interactive Guide Toggle Button & Container -->
                    <style>
                        @keyframes pulse-glow-amber {
                            0% {
                                box-shadow: 0 0 0 0 rgba(243, 156, 18, 0.8), 0 0 8px rgba(243, 156, 18, 0.6);
                                transform: scale(1);
                            }
                            50% {
                                box-shadow: 0 0 0 6px rgba(243, 156, 18, 0), 0 0 15px rgba(255, 179, 0, 0.95);
                                transform: scale(1.02);
                            }
                            100% {
                                box-shadow: 0 0 0 0 rgba(243, 156, 18, 0.8), 0 0 8px rgba(243, 156, 18, 0.6);
                                transform: scale(1);
                            }
                        }
                        .btn-guide-glowing {
                            background: linear-gradient(135deg, #ff9800 0%, #e65100 100%) !important;
                            border: 1px solid #bf360c !important;
                            color: #ffffff !important;
                            font-weight: bold !important;
                            font-size: 12px !important;
                            padding: 4px 12px !important;
                            border-radius: 20px !important;
                            animation: pulse-glow-amber 2.2s infinite ease-in-out;
                            letter-spacing: 0.3px;
                            cursor: pointer;
                            transition: all 0.2s ease;
                            display: inline-flex;
                            align-items: center;
                            gap: 5px;
                            text-shadow: 0 1px 2px rgba(0,0,0,0.3);
                        }
                        .btn-guide-glowing:hover {
                            background: linear-gradient(135deg, #ffa726 0%, #f57c00 100%) !important;
                            transform: scale(1.05) !important;
                            box-shadow: 0 0 18px rgba(255, 152, 0, 1) !important;
                            color: #fff !important;
                        }
                        .select2-container--open {
                            z-index: 99999999 !important;
                        }
                        .select2-dropdown {
                            z-index: 99999999 !important;
                        }
                        .select2-search--dropdown .select2-search__field {
                            z-index: 99999999 !important;
                        }
                    </style>

                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                        <label for="relocate-asset-tag" style="margin-bottom: 0; font-weight: bold; font-size: 14px;">
                            <i class="fa fa-barcode text-primary"></i> Tag Aset / Serial Number (Scan Barcode)
                        </label>
                        <button type="button" id="btn-toggle-relocate-guide" class="btn btn-guide-glowing">
                            <i class="fa fa-lightbulb-o" style="color: #fff880; font-size: 14px; text-shadow: 0 0 8px #ffeb3b;"></i> 💡 Panduan & Diagram Alur
                        </button>
                    </div>

                    <!-- Collapsible Guide & Diagram Box -->
                    <div id="relocate-guide-box" style="display: none; margin-bottom: 16px; border-radius: 6px; border: 1px solid #bce8f1; background-color: #f4fbfd; padding: 14px; box-shadow: 0 2px 5px rgba(0,0,0,0.06);">
                        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #d9edf7; padding-bottom: 6px; margin-bottom: 10px;">
                            <h5 style="margin: 0; color: #31708f; font-weight: bold; font-size: 13.5px;">
                                <i class="fa fa-sitemap text-info"></i> Diagram & Panduan Alur Kerja Relokasi Cepat
                            </h5>
                            <button type="button" id="btn-close-relocate-guide" class="btn btn-xs btn-default" style="font-size: 11px; padding: 1px 6px;">
                                <i class="fa fa-times"></i> Tutup
                            </button>
                        </div>

                        <!-- Visual Flow Diagram Cards -->
                        <div style="display: flex; flex-direction: column; gap: 8px; font-size: 12px; color: #333;">
                            
                            <!-- Step 1 -->
                            <div style="display: flex; align-items: flex-start; gap: 10px; background: #fff; padding: 8px 10px; border-radius: 5px; border-left: 4px solid #337ab7; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                                <div style="background: #337ab7; color: #fff; width: 22px; height: 22px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 11px; flex-shrink: 0; margin-top: 1px;">1</div>
                                <div>
                                    <strong style="color: #337ab7;">Scan / Ketik Tag Aset:</strong> Sistem secara otomatis mendeteksi info aset lengkap (Foto, Lokasi Lama, Status, dan PT/Company asal).
                                </div>
                            </div>

                            <!-- Step 2 -->
                            <div style="display: flex; align-items: flex-start; gap: 10px; background: #fff; padding: 8px 10px; border-radius: 5px; border-left: 4px solid #00a65a; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                                <div style="background: #00a65a; color: #fff; width: 22px; height: 22px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 11px; flex-shrink: 0; margin-top: 1px;">2</div>
                                <div>
                                    <strong style="color: #00a65a;">Pilih Target Penempatan:</strong>
                                    <div style="margin-top: 2px;">
                                        &bull; <strong>Lokasi / Ruangan Pabrik:</strong> Untuk CCTV, Mesin Absen, Switch, AP, dsb.<br>
                                        &bull; <strong>Karyawan / Personil (User):</strong> Untuk Laptop, Mouse, Keyboard, PC User, dsb.
                                    </div>
                                </div>
                            </div>

                            <!-- Step 3 -->
                            <div style="display: flex; align-items: flex-start; gap: 10px; background: #fff; padding: 8px 10px; border-radius: 5px; border-left: 4px solid #f39c12; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                                <div style="background: #f39c12; color: #fff; width: 22px; height: 22px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 11px; flex-shrink: 0; margin-top: 1px;">3</div>
                                <div>
                                    <strong style="color: #d58512;">Smart Auto-Sync (Otomatis):</strong> Sistem langsung mengidentifikasi <em>Cabang & PT</em> target. Lokasi Fisik, Default/Home Location (RTD), dan PT aset akan diselaraskan serentak.
                                </div>
                            </div>

                            <!-- Step 4 -->
                            <div style="display: flex; align-items: flex-start; gap: 10px; background: #fff; padding: 8px 10px; border-radius: 5px; border-left: 4px solid #9c27b0; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                                <div style="background: #9c27b0; color: #fff; width: 22px; height: 22px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 11px; flex-shrink: 0; margin-top: 1px;">4</div>
                                <div>
                                    <strong style="color: #9c27b0;">Eksekusi Checkout Otomatis:</strong>
                                    <div style="margin-top: 2px;">
                                        &bull; <em>Jika Aset sedang terpasang:</em> Dilakukan <strong>Auto-Checkin</strong> dulu ➔ lalu <strong>Checkout baru</strong>.<br>
                                        &bull; <em>Jika Aset dari Stock:</em> Langsung proses <strong>Checkout</strong> ke target baru.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Audit Footnote -->
                        <div style="margin-top: 10px; padding: 6px 10px; background: #eaf6fa; border-radius: 4px; font-size: 11.5px; color: #2e6da4;">
                            <i class="fa fa-info-circle"></i> <strong>Audit Trail Resmi:</strong> Riwayat tercatat penuh di log History aset Snipe-IT (tanggal, penanggung jawab, dan catatan relokasi).
                        </div>
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" id="relocate-asset-tag" placeholder="Scan atau ketik Tag Aset (contoh: PBM-SBY-GDB-L01-CAM-155.94)" required autocomplete="off" style="font-size: 15px; height: 40px;">
                        
                        <!-- Autocomplete Results Container -->
                        <div id="relocate-autocomplete-box" class="fab-autocomplete-results"></div>
                        
                        <!-- Lookup Progress and Result -->
                        <div id="relocate-lookup-loading" style="display: none; margin-top: 8px; color: #666; font-size: 13px;">
                            <i class="fa fa-spinner fa-spin"></i> Mencari data aset...
                        </div>
                        <div id="relocate-lookup-error" class="text-danger" style="display: none; margin-top: 8px; font-weight: bold; font-size: 13px;">
                            <i class="fa fa-times-circle"></i> Aset tidak ditemukan / belum terdaftar!
                        </div>
                        
                        <!-- Preview Card With Asset Photo Thumbnail -->
                        <div id="relocate-lookup-preview" style="display: none; margin-top: 12px; padding: 12px; border-radius: 6px; border: 1px solid #dcdcdc; background-color: #fcfcfc; box-shadow: inset 0 1px 3px rgba(0,0,0,0.05);">
                            <div style="display: flex; align-items: flex-start; gap: 12px;">
                                <div style="flex-shrink: 0;">
                                    <img id="relocate-preview-image" src="" alt="Foto Aset" style="width: 75px; height: 75px; object-fit: cover; border-radius: 6px; border: 1px solid #ccc; background-color: #fff; padding: 2px;">
                                </div>
                                <div style="flex: 1; min-width: 0;">
                                    <h5 style="margin-top: 0; color: #00a65a; font-weight: bold; font-size: 14px; margin-bottom: 6px;">
                                        <i class="fa fa-info-circle"></i> Detail Aset Terdeteksi:
                                    </h5>
                                    <table style="width: 100%; font-size: 13px; line-height: 1.5;">
                                        <tr>
                                            <td style="width: 35%; font-weight: bold; color: #555;">Nama Aset</td>
                                            <td id="relocate-preview-name" style="color: #111; font-weight: bold;">-</td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: bold; color: #555;">Serial Number</td>
                                            <td id="relocate-preview-serial" style="color: #111;">-</td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: bold; color: #555;">Status Saat Ini</td>
                                            <td id="relocate-preview-status" style="color: #111;">-</td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: bold; color: #555;">PT (Company)</td>
                                            <td id="relocate-preview-company" style="color: #337ab7; font-weight: bold;">-</td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: bold; color: #555;">Lokasi Saat Ini</td>
                                            <td id="relocate-preview-location" style="color: #00a65a; font-weight: bold;">-</td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: bold; color: #555;">Checkout Ke</td>
                                            <td id="relocate-preview-assignee" style="color: #111;">-</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Target Type Selector (Location vs User) -->
                    <div class="form-group" style="margin-top: 15px; background: #f9f9f9; padding: 10px 12px; border-radius: 5px; border: 1px solid #eee;">
                        <label style="font-weight: bold; margin-bottom: 8px; display: block;"><i class="fa fa-bullseye"></i> Checkout / Relokasi Ditujukan Ke:</label>
                        <div style="display: flex; gap: 20px;">
                            <label style="cursor: pointer; font-weight: 600; margin-bottom: 0;">
                                <input type="radio" name="relocate_target_type" value="location" checked style="margin-right: 5px;">
                                <i class="fa fa-map-marker text-green"></i> Lokasi / Ruangan Pabrik (Location)
                            </label>
                            <label style="cursor: pointer; font-weight: 600; margin-bottom: 0;">
                                <input type="radio" name="relocate_target_type" value="user" style="margin-right: 5px;">
                                <i class="fa fa-user text-primary"></i> Karyawan / Personil (User)
                            </label>
                        </div>
                    </div>

                    <!-- Location Dropdown Selection -->
                    <div class="form-group" id="grp-target-location" style="margin-top: 12px;">
                        <label for="relocate-location-id"><i class="fa fa-map-marker text-green"></i> Pilih Lokasi / Ruangan Baru</label>
                        <select class="form-control select2-relocate" id="relocate-location-id" style="width: 100%;">
                            <option value="">-- Cari atau Pilih Lokasi / Ruangan --</option>
                            @php
                                $allActiveLocations = \App\Models\Location::with('company')->orderBy('name', 'ASC')->get();
                            @endphp
                            @foreach ($allActiveLocations as $loc)
                                <option value="{{ $loc->id }}" data-company-id="{{ $loc->company_id }}" data-company-name="{{ $loc->company ? $loc->company->name : '' }}">{{ $loc->name }}</option>
                            @endforeach
                        </select>
                        <div id="relocate-loc-info-badge" style="display: none; margin-top: 8px; padding: 6px 10px; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 4px; font-size: 12px; color: #166534;">
                            <i class="fa fa-building-o"></i> <strong>Perusahaan (PT):</strong> <span id="relocate-badge-loc-company" style="font-weight: bold;">-</span>
                            <div style="margin-top: 2px; font-size: 11px; color: #15803d;">
                                <i class="fa fa-check-circle"></i> Lokasi fisik, default (RTD), dan PT aset akan otomatis diselaraskan ke lokasi ini.
                            </div>
                        </div>
                    </div>

                    <!-- User Dropdown Selection & Override Box -->
                    <div class="form-group" id="grp-target-user" style="margin-top: 12px; display: none;">
                        <label for="relocate-user-id"><i class="fa fa-user text-primary"></i> Pilih Karyawan / Personil Baru</label>
                        <select class="form-control select2-relocate" id="relocate-user-id" style="width: 100%;">
                            <option value="">-- Cari atau Pilih Nama Karyawan --</option>
                            @php
                                $allActiveUsers = \App\Models\User::with(['userloc', 'company'])->whereNull('deleted_at')->orderBy('first_name', 'ASC')->get();
                                $allCompanies = \App\Models\Company::orderBy('name', 'ASC')->get();
                            @endphp
                            @foreach ($allActiveUsers as $u)
                                <option value="{{ $u->id }}" 
                                    data-location-id="{{ $u->location_id }}" 
                                    data-location-name="{{ $u->userloc ? $u->userloc->name : '' }}"
                                    data-company-id="{{ $u->company_id }}"
                                    data-company-name="{{ $u->company ? $u->company->name : '' }}">
                                    {{ trim($u->first_name . ' ' . $u->last_name) }} ({{ $u->username }})
                                </option>
                            @endforeach
                        </select>

                        <!-- User Custom/Override Company & Location Assignment Box -->
                        <div id="relocate-user-override-box" style="display: none; margin-top: 10px; padding: 12px; background: #fafafa; border: 1px solid #e3e3e3; border-radius: 6px; box-shadow: inset 0 1px 2px rgba(0,0,0,0.03);">
                            <div id="relocate-user-empty-warning" style="display: none; margin-bottom: 10px; padding: 7px 10px; background: #fff8e1; border: 1px solid #ffe082; border-radius: 4px; font-size: 12px; color: #856404;">
                                <i class="fa fa-exclamation-triangle text-warning"></i> <strong>Profil Karyawan belum memiliki data PT / Lokasi lengkap.</strong> Silakan tentukan PT & Lokasi penempatan di bawah:
                            </div>
                            <div id="relocate-user-auto-detected" style="display: none; margin-bottom: 10px; padding: 7px 10px; background: #e8f4f8; border: 1px solid #bce8f1; border-radius: 4px; font-size: 12px; color: #31708f;">
                                <i class="fa fa-check-circle text-info"></i> <strong>Data Cabang Terdeteksi Otomatis.</strong> Anda dapat mengubahnya di bawah jika diperlukan:
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 col-xs-12" style="margin-bottom: 8px;">
                                    <label for="relocate-user-company-id" style="font-size: 12px; margin-bottom: 4px; font-weight: bold; color: #333;">
                                        <i class="fa fa-building text-primary"></i> Perusahaan (PT) Aset
                                    </label>
                                    <select class="form-control select2-relocate" id="relocate-user-company-id" style="width: 100%;">
                                        <option value="">-- Pilih PT / Perusahaan --</option>
                                        @foreach ($allCompanies as $comp)
                                            <option value="{{ $comp->id }}">{{ $comp->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 col-xs-12" style="margin-bottom: 8px;">
                                    <label for="relocate-user-location-id" style="font-size: 12px; margin-bottom: 4px; font-weight: bold; color: #333;">
                                        <i class="fa fa-map-marker text-green"></i> Lokasi Kerja / Penempatan
                                    </label>
                                    <select class="form-control select2-relocate" id="relocate-user-location-id" style="width: 100%;">
                                        <option value="">-- Pilih Lokasi Kerja --</option>
                                        @foreach ($allActiveLocations as $loc)
                                            <option value="{{ $loc->id }}" data-company-id="{{ $loc->company_id }}">{{ $loc->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div style="margin-top: 6px; padding-top: 6px; border-top: 1px dashed #ddd;">
                                <label style="cursor: pointer; font-size: 12px; font-weight: 600; margin-bottom: 0; color: #204d74; display: flex; align-items: center; gap: 7px;">
                                    <input type="checkbox" id="relocate-sync-user-profile" value="1" checked style="margin: 0; width: 15px; height: 15px;">
                                    <span><i class="fa fa-save text-primary"></i> Sekaligus perbarui & simpan PT dan Lokasi ini ke profil Karyawan</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Target Status -->
                    <div class="form-group" style="margin-top: 15px;">
                        <label for="relocate-status-id"><i class="fa fa-tag"></i> Status Akhir Aset</label>
                        <select class="form-control" id="relocate-status-id" style="font-size: 14px; height: 40px; font-weight: bold;">
                            <option value="4" selected>🟢 Asset Terpasang (Deployed / Operasional)</option>
                            <option value="2">🔵 Asset Stock (Siap Pakai)</option>
                            <option value="14">🟡 Asset Dipinjamkan</option>
                            <option value="15">🟣 Asset Tool IT</option>
                            <option value="16">🏭 Asset Produksi</option>
                        </select>
                    </div>

                    <div class="form-group" style="margin-top: 15px;">
                        <label for="relocate-notes">Catatan / Keterangan Relokasi</label>
                        <textarea class="form-control" id="relocate-notes" rows="2" placeholder="Tulis alasan relokasi / penempatan aset (contoh: Pemasangan di area Pocket Frame)..." style="resize: vertical;"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success" id="btn-submit-relocate" style="background-color: #00a65a; border-color: #008d4c;">
                        <i class="fa fa-check"></i> Simpan & Relokasi Aset
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Form Pinjam & Kembali (Quick Loan & Return Checkout) -->
<div class="modal fade" id="modal-fab-quick-loan" role="dialog" aria-labelledby="modal-fab-loan-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 6px; box-shadow: 0 5px 15px rgba(0,0,0,0.3);">
            <form id="form-fab-quick-loan">
                <div class="modal-header" style="background: linear-gradient(135deg, #008ba3 0%, #00acc1 100%); color: white; border-top-left-radius: 5px; border-top-right-radius: 5px;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white; opacity: 0.8;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="modal-fab-loan-title">
                        <i class="fas fa-exchange-alt"></i> Pinjam & Kembali / Peminjaman Aset IT
                    </h4>
                </div>
                <div class="modal-body" style="padding: 20px;">
                    
                    <!-- Mode Switcher: Pinjam vs Kembali -->
                    <div style="display: flex; gap: 8px; margin-bottom: 16px; background: #e2e8f0; padding: 4px; border-radius: 8px;">
                        <button type="button" id="btn-tab-mode-loan" class="btn btn-sm btn-mode-toggle" style="flex: 1; font-weight: bold; border-radius: 6px; padding: 8px 12px; background: #008ba3; color: white; border: none; box-shadow: 0 2px 4px rgba(0,0,0,0.1); cursor: pointer;">
                            <i class="fas fa-handshake"></i> 1. Pinjam Aset (Checkout)
                        </button>
                        <button type="button" id="btn-tab-mode-return" class="btn btn-sm btn-mode-toggle" style="flex: 1; font-weight: bold; border-radius: 6px; padding: 8px 12px; background: transparent; color: #475569; border: none; cursor: pointer;">
                            <i class="fas fa-undo"></i> 2. Pengembalian (Kembali ke IT / Stock)
                        </button>
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                        <label for="loan-asset-tag" style="margin-bottom: 0; font-weight: bold; font-size: 14px;">
                            <i class="fa fa-barcode text-primary"></i> Tag Aset / Serial Number (Scan Barcode)
                        </label>
                        <button type="button" id="btn-toggle-loan-guide" class="btn btn-guide-glowing">
                            <i class="fa fa-lightbulb-o" style="color: #fff880; font-size: 14px; text-shadow: 0 0 8px #ffeb3b;"></i> 💡 Panduan Alur
                        </button>
                    </div>

                    <!-- Collapsible Guide & Diagram Box for Loan & Return -->
                    <div id="loan-guide-box" style="display: none; margin-bottom: 16px; border-radius: 6px; border: 1px solid #bce8f1; background-color: #f4fbfd; padding: 14px; box-shadow: 0 2px 5px rgba(0,0,0,0.06);">
                        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #d9edf7; padding-bottom: 6px; margin-bottom: 10px;">
                            <h5 style="margin: 0; color: #31708f; font-weight: bold; font-size: 13.5px;">
                                <i class="fa fa-sitemap text-info"></i> Alur Kerja Peminjaman & Pengembalian Aset Cepat
                            </h5>
                            <button type="button" id="btn-close-loan-guide" class="btn btn-xs btn-default" style="font-size: 11px; padding: 1px 6px;">
                                <i class="fa fa-times"></i> Tutup
                            </button>
                        </div>

                        <div style="display: flex; flex-direction: column; gap: 8px; font-size: 12px; color: #333;">
                            <div style="display: flex; align-items: flex-start; gap: 10px; background: #fff; padding: 8px 10px; border-radius: 5px; border-left: 4px solid #008ba3; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                                <div style="background: #008ba3; color: #fff; width: 22px; height: 22px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 11px; flex-shrink: 0; margin-top: 1px;">1</div>
                                <div>
                                    <strong style="color: #008ba3;">Mode 1: Peminjaman Aset (Pinjam):</strong>
                                    <div style="margin-top: 2px;">
                                        &bull; Masukkan Tag Aset ➔ Pilih Karyawan/Lokasi ➔ Tentukan tanggal rencana pengembalian.<br>
                                        &bull; Status otomatis menjadi <strong>🟡 Asset Dipinjamkan (ID: 14)</strong>.
                                    </div>
                                </div>
                            </div>
                            <div style="display: flex; align-items: flex-start; gap: 10px; background: #fff; padding: 8px 10px; border-radius: 5px; border-left: 4px solid #00a65a; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                                <div style="background: #00a65a; color: #fff; width: 22px; height: 22px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 11px; flex-shrink: 0; margin-top: 1px;">2</div>
                                <div>
                                    <strong style="color: #00a65a;">Mode 2: Pengembalian Aset (Kembali):</strong>
                                    <div style="margin-top: 2px;">
                                        &bull; Masukkan Tag Aset ➔ Lokasi otomatis default ke <strong>Ruang Office IT (ID: 36)</strong>.<br>
                                        &bull; Status otomatis kembali menjadi <strong>🔵 Asset Stock (ID: 2)</strong> siap pakai.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div style="margin-top: 10px; padding: 6px 10px; background: #eaf6fa; border-radius: 4px; font-size: 11.5px; color: #2e6da4;">
                            <i class="fa fa-info-circle"></i> <strong>Pencatatan Standar:</strong> Seluruh transaksi pinjam dan kembali tercatat resmi di log History aset Snipe-IT lengkap dengan ID admin dan catatan audit.
                        </div>
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" id="loan-asset-tag" placeholder="Scan atau ketik Tag Aset (contoh: PBM-SBY-GDB-L01-CAM-155.94)" required autocomplete="off" style="font-size: 15px; height: 40px;">
                        
                        <!-- Autocomplete Results Container for Loan -->
                        <div id="loan-autocomplete-box" class="fab-autocomplete-results"></div>
                        
                        <!-- Lookup Progress and Result -->
                        <div id="loan-lookup-loading" style="display: none; margin-top: 8px; color: #666; font-size: 13px;">
                            <i class="fa fa-spinner fa-spin"></i> Mencari data aset...
                        </div>
                        <div id="loan-lookup-error" class="text-danger" style="display: none; margin-top: 8px; font-weight: bold; font-size: 13px;">
                            <i class="fa fa-times-circle"></i> Aset tidak ditemukan / belum terdaftar!
                        </div>
                        
                        <!-- Preview Card With Asset Photo Thumbnail -->
                        <div id="loan-lookup-preview" style="display: none; margin-top: 12px; padding: 12px; border-radius: 6px; border: 1px solid #dcdcdc; background-color: #fcfcfc; box-shadow: inset 0 1px 3px rgba(0,0,0,0.05);">
                            <div style="display: flex; align-items: flex-start; gap: 12px;">
                                <div style="flex-shrink: 0;">
                                    <img id="loan-preview-image" src="" alt="Foto Aset" style="width: 75px; height: 75px; object-fit: cover; border-radius: 6px; border: 1px solid #ccc; background-color: #fff; padding: 2px;">
                                </div>
                                <div style="flex: 1; min-width: 0;">
                                    <h5 style="margin-top: 0; color: #008ba3; font-weight: bold; font-size: 14px; margin-bottom: 6px;">
                                        <i class="fa fa-info-circle"></i> Detail Aset Terdeteksi:
                                    </h5>
                                    <table style="width: 100%; font-size: 13px; line-height: 1.5;">
                                        <tr>
                                            <td style="width: 35%; font-weight: bold; color: #555;">Nama Aset</td>
                                            <td id="loan-preview-name" style="color: #111; font-weight: bold;">-</td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: bold; color: #555;">Serial Number</td>
                                            <td id="loan-preview-serial" style="color: #111;">-</td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: bold; color: #555;">Status Saat Ini</td>
                                            <td id="loan-preview-status" style="color: #111;">-</td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: bold; color: #555;">PT (Company)</td>
                                            <td id="loan-preview-company" style="color: #337ab7; font-weight: bold;">-</td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: bold; color: #555;">Lokasi Saat Ini</td>
                                            <td id="loan-preview-location" style="color: #00a65a; font-weight: bold;">-</td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: bold; color: #555;">Pemegang Aset</td>
                                            <td id="loan-preview-assignee" style="color: #111;">-</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ======================================================== -->
                    <!-- SECTION 1: MODE PINJAM ASET (CHECKOUT)                   -->
                    <!-- ======================================================== -->
                    <div id="section-mode-loan">
                        <!-- Target Type Selector (User vs Location) -->
                        <div class="form-group" style="margin-top: 15px; background: #f9f9f9; padding: 10px 12px; border-radius: 5px; border: 1px solid #eee;">
                            <label style="font-weight: bold; margin-bottom: 8px; display: block;"><i class="fa fa-user-circle"></i> Target Peminjam Aset:</label>
                            <div style="display: flex; gap: 20px;">
                                <label style="cursor: pointer; font-weight: 600; margin-bottom: 0;">
                                    <input type="radio" name="loan_target_type" value="user" checked style="margin-right: 5px;">
                                    <i class="fa fa-user text-primary"></i> Karyawan / Personil (User)
                                </label>
                                <label style="cursor: pointer; font-weight: 600; margin-bottom: 0;">
                                    <input type="radio" name="loan_target_type" value="location" style="margin-right: 5px;">
                                    <i class="fa fa-map-marker text-green"></i> Lokasi / Ruangan / Event (Location)
                                </label>
                            </div>
                        </div>

                        <!-- User Dropdown Selection & Override Box for Loan -->
                        <div class="form-group" id="grp-loan-target-user" style="margin-top: 12px;">
                            <label for="loan-user-id"><i class="fa fa-user text-primary"></i> Pilih Karyawan Peminjam</label>
                            <select class="form-control select2-loan" id="loan-user-id" style="width: 100%;">
                                <option value="">-- Cari atau Pilih Nama Karyawan Peminjam --</option>
                                @foreach ($allActiveUsers as $u)
                                    <option value="{{ $u->id }}" 
                                        data-location-id="{{ $u->location_id }}" 
                                        data-location-name="{{ $u->userloc ? $u->userloc->name : '' }}"
                                        data-company-id="{{ $u->company_id }}"
                                        data-company-name="{{ $u->company ? $u->company->name : '' }}">
                                        {{ trim($u->first_name . ' ' . $u->last_name) }} ({{ $u->username }})
                                    </option>
                                @endforeach
                            </select>

                            <!-- User Custom/Override Company & Location Assignment Box -->
                            <div id="loan-user-override-box" style="display: none; margin-top: 10px; padding: 12px; background: #fafafa; border: 1px solid #e3e3e3; border-radius: 6px; box-shadow: inset 0 1px 2px rgba(0,0,0,0.03);">
                                <div id="loan-user-empty-warning" style="display: none; margin-bottom: 10px; padding: 7px 10px; background: #fff8e1; border: 1px solid #ffe082; border-radius: 4px; font-size: 12px; color: #856404;">
                                    <i class="fa fa-exclamation-triangle text-warning"></i> <strong>Profil Karyawan belum memiliki data PT / Lokasi lengkap.</strong> Silakan tentukan PT & Lokasi penempatan di bawah:
                                </div>
                                <div id="loan-user-auto-detected" style="display: none; margin-bottom: 10px; padding: 7px 10px; background: #e8f4f8; border: 1px solid #bce8f1; border-radius: 4px; font-size: 12px; color: #31708f;">
                                    <i class="fa fa-check-circle text-info"></i> <strong>Data Cabang Peminjam Terdeteksi Otomatis.</strong> Anda dapat menyesuaikannya di bawah jika diperlukan:
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 col-xs-12" style="margin-bottom: 8px;">
                                        <label for="loan-user-company-id" style="font-size: 12px; margin-bottom: 4px; font-weight: bold; color: #333;">
                                            <i class="fa fa-building text-primary"></i> Perusahaan (PT) Peminjam
                                        </label>
                                        <select class="form-control select2-loan" id="loan-user-company-id" style="width: 100%;">
                                            <option value="">-- Pilih PT / Perusahaan --</option>
                                            @foreach ($allCompanies as $comp)
                                                <option value="{{ $comp->id }}">{{ $comp->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 col-xs-12" style="margin-bottom: 8px;">
                                        <label for="loan-user-location-id" style="font-size: 12px; margin-bottom: 4px; font-weight: bold; color: #333;">
                                            <i class="fa fa-map-marker text-green"></i> Lokasi Kerja / Cabang Peminjam
                                        </label>
                                        <select class="form-control select2-loan" id="loan-user-location-id" style="width: 100%;">
                                            <option value="">-- Pilih Lokasi Kerja --</option>
                                            @foreach ($allActiveLocations as $loc)
                                                <option value="{{ $loc->id }}" data-company-id="{{ $loc->company_id }}">{{ $loc->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div style="margin-top: 6px; padding-top: 6px; border-top: 1px dashed #ddd;">
                                    <label style="cursor: pointer; font-size: 12px; font-weight: 600; margin-bottom: 0; color: #204d74; display: flex; align-items: center; gap: 7px;">
                                        <input type="checkbox" id="loan-sync-user-profile" value="1" checked style="margin: 0; width: 15px; height: 15px;">
                                        <span><i class="fa fa-save text-primary"></i> Sekaligus perbarui & simpan PT dan Lokasi ini ke profil Karyawan</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Location Dropdown Selection for Loan -->
                        <div class="form-group" id="grp-loan-target-location" style="margin-top: 12px; display: none;">
                            <label for="loan-location-id"><i class="fa fa-map-marker text-green"></i> Pilih Lokasi / Ruangan Peminjaman</label>
                            <select class="form-control select2-loan" id="loan-location-id" style="width: 100%;">
                                <option value="">-- Cari atau Pilih Lokasi / Ruangan / Event --</option>
                                @foreach ($allActiveLocations as $loc)
                                    <option value="{{ $loc->id }}" data-company-id="{{ $loc->company_id }}" data-company-name="{{ $loc->company ? $loc->company->name : '' }}">{{ $loc->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tanggal Rencana Pengembalian (Expected Return Date) -->
                        <div class="form-group" style="margin-top: 15px;">
                            <label for="loan-expected-checkin" style="font-weight: bold; color: #333;">
                                <i class="fa fa-calendar text-primary"></i> Rencana Tanggal Pengembalian (Estimasi Selesai Pinjam)
                            </label>
                            <input type="date" class="form-control" id="loan-expected-checkin" style="font-size: 14px; height: 40px;">
                            <small class="text-muted"><i class="fa fa-info-circle"></i> Opsional. Membantu tim IT memantau masa peminjaman aset.</small>
                        </div>

                        <!-- Target Status Pinjam (Badge Otomatis) -->
                        <div class="form-group" style="margin-top: 15px;">
                            <label style="font-weight: bold; color: #333;"><i class="fa fa-tag text-purple"></i> Status Akhir Aset:</label>
                            <div style="padding: 10px 14px; background: #fdf4ff; border: 1px solid #f0abfc; border-radius: 5px; font-weight: bold; color: #86198f; font-size: 13.5px; display: flex; align-items: center; justify-content: space-between;">
                                <span><i class="fa fa-check-circle text-purple"></i> 🟡 Asset Dipinjamkan (Status ID: 14)</span>
                                <span class="label label-warning" style="background-color: #d97706 !important;">Deployable</span>
                            </div>
                        </div>

                        <!-- Catatan Keperluan Peminjaman -->
                        <div class="form-group" style="margin-top: 15px;">
                            <label for="loan-notes" style="font-weight: bold; color: #333;">
                                <i class="fa fa-pencil text-info"></i> Keperluan Peminjaman / No. Surat / Keterangan
                            </label>
                            <textarea class="form-control" id="loan-notes" rows="2" placeholder="Tulis alasan peminjaman (contoh: Peminjaman laptop untuk keperluan dinas luar kota / meeting event)..." style="resize: vertical;"></textarea>
                        </div>
                    </div>

                    <!-- ======================================================== -->
                    <!-- SECTION 2: MODE PENGEMBALIAN (KEMBALI KE RUANG IT/STOCK)-->
                    <!-- ======================================================== -->
                    <div id="section-mode-return" style="display: none;">
                        <!-- Lokasi Pengembalian (Default: Ruang Office IT ID 36) -->
                        <div class="form-group" style="margin-top: 12px;">
                            <label for="return-location-id" style="font-weight: bold; color: #333;">
                                <i class="fa fa-map-marker text-green"></i> Lokasi Pengembalian / Penyimpanan Unit
                            </label>
                            <select class="form-control select2-loan" id="return-location-id" style="width: 100%;">
                                @foreach ($allActiveLocations as $loc)
                                    <option value="{{ $loc->id }}" {{ $loc->id == 36 ? 'selected' : '' }}>{{ $loc->name }}</option>
                                @endforeach
                            </select>
                            <div style="margin-top: 6px; padding: 6px 10px; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 4px; font-size: 12px; color: #166534;">
                                <i class="fa fa-check-circle"></i> Default diset ke <strong>Ruang Office IT</strong>. Lokasi fisik dan home location (RTD) aset akan otomatis diselaraskan.
                            </div>
                        </div>

                        <!-- Status Akhir Pengembalian (Default: Asset Stock ID 2) -->
                        <div class="form-group" style="margin-top: 15px;">
                            <label for="return-status-id" style="font-weight: bold; color: #333;">
                                <i class="fa fa-tag text-primary"></i> Status Akhir Setelah Dikembalikan
                            </label>
                            <select class="form-control" id="return-status-id" style="font-size: 14px; height: 40px; font-weight: bold;">
                                <option value="2" selected>🔵 Asset Stock (Siap Pakai / Ready to Deploy)</option>
                                <option value="4">🟢 Asset Terpasang (Deployed / Operasional)</option>
                                <option value="15">🟣 Asset Tool IT</option>
                                <option value="7">🟡 Asset Dalam Perbaikan (Unit Bermasalah / Butuh Servis)</option>
                                <option value="3">🔴 Asset Rusak (Undeployable / Rusak Total)</option>
                            </select>
                        </div>

                        <!-- Catatan Pengembalian -->
                        <div class="form-group" style="margin-top: 15px;">
                            <label for="return-notes" style="font-weight: bold; color: #333;">
                                <i class="fa fa-pencil text-info"></i> Catatan Kondisi Unit Saat Dikembalikan
                            </label>
                            <textarea class="form-control" id="return-notes" rows="2" placeholder="Tulis catatan (contoh: Unit telah diterima kembali oleh IT dalam kondisi lengkap dan normal)..." style="resize: vertical;"></textarea>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <!-- Submit Button for Loan Mode -->
                    <button type="submit" class="btn btn-primary" id="btn-submit-loan" style="background-color: #008ba3; border-color: #007c91; font-weight: bold;">
                        <i class="fas fa-handshake"></i> Simpan & Eksekusi Peminjaman
                    </button>
                    <!-- Submit Button for Return Mode -->
                    <button type="button" class="btn btn-success" id="btn-submit-return" style="display: none; background-color: #00a65a; border-color: #008d4c; font-weight: bold;">
                        <i class="fas fa-undo"></i> Simpan & Proses Pengembalian Unit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script nonce="{{ csrf_token() }}">
    // Fix Select2 search focus trap inside Bootstrap Modal
    $.fn.modal.Constructor.prototype.enforceFocus = function() {};

    $(document).ready(function() {
        // Initialize Select2 with dropdownParent to fix Bootstrap Modal focus issue
        function initRelocateSelect2() {
            if ($('#relocate-location-id').data('select2')) {
                $('#relocate-location-id').select2('destroy');
            }
            if ($('#relocate-user-id').data('select2')) {
                $('#relocate-user-id').select2('destroy');
            }
            if ($('#relocate-user-company-id').data('select2')) {
                $('#relocate-user-company-id').select2('destroy');
            }
            if ($('#relocate-user-location-id').data('select2')) {
                $('#relocate-user-location-id').select2('destroy');
            }
            
            $('#relocate-location-id').select2({
                dropdownParent: $('#modal-fab-relocate-location'),
                width: '100%',
                placeholder: '-- Cari atau Pilih Lokasi / Ruangan --'
            });
            $('#relocate-user-id').select2({
                dropdownParent: $('#modal-fab-relocate-location'),
                width: '100%',
                placeholder: '-- Cari atau Pilih Nama Karyawan --'
            });
            $('#relocate-user-company-id').select2({
                dropdownParent: $('#modal-fab-relocate-location'),
                width: '100%',
                placeholder: '-- Pilih PT / Perusahaan --'
            });
            $('#relocate-user-location-id').select2({
                dropdownParent: $('#modal-fab-relocate-location'),
                width: '100%',
                placeholder: '-- Pilih Lokasi Kerja --'
            });
        }

        // Initialize Select2 for Pinjam Cepat Modal
        function initLoanSelect2() {
            if ($('#loan-location-id').data('select2')) {
                $('#loan-location-id').select2('destroy');
            }
            if ($('#loan-user-id').data('select2')) {
                $('#loan-user-id').select2('destroy');
            }
            if ($('#loan-user-company-id').data('select2')) {
                $('#loan-user-company-id').select2('destroy');
            }
            if ($('#loan-user-location-id').data('select2')) {
                $('#loan-user-location-id').select2('destroy');
            }
            if ($('#return-location-id').data('select2')) {
                $('#return-location-id').select2('destroy');
            }
            
            $('#loan-location-id').select2({
                dropdownParent: $('#modal-fab-quick-loan'),
                width: '100%',
                placeholder: '-- Cari atau Pilih Lokasi / Ruangan / Event --'
            });
            $('#loan-user-id').select2({
                dropdownParent: $('#modal-fab-quick-loan'),
                width: '100%',
                placeholder: '-- Cari atau Pilih Nama Karyawan Peminjam --'
            });
            $('#loan-user-company-id').select2({
                dropdownParent: $('#modal-fab-quick-loan'),
                width: '100%',
                placeholder: '-- Pilih PT / Perusahaan --'
            });
            $('#loan-user-location-id').select2({
                dropdownParent: $('#modal-fab-quick-loan'),
                width: '100%',
                placeholder: '-- Pilih Lokasi Kerja --'
            });
            $('#return-location-id').select2({
                dropdownParent: $('#modal-fab-quick-loan'),
                width: '100%',
                placeholder: '-- Pilih Lokasi Pengembalian (Default: Ruang Office IT) --'
            });
        }

        // Sidebar Menu Trigger - Update Lokasi Cepat
        $("#btn-sidebar-relocate-checkout").on("click", function(e) {
            e.preventDefault();
            $("#modal-fab-relocate-location").modal("show");
        });

        // Sidebar Menu Trigger - Pinjam Cepat
        $("#btn-sidebar-quick-loan").on("click", function(e) {
            e.preventDefault();
            $("#modal-fab-quick-loan").modal("show");
        });

        // Toggle target type radio for Relocate (Location vs User)
        $('input[name="relocate_target_type"]').on('change', function() {
            if ($(this).val() === 'location') {
                $('#grp-target-location').show();
                $('#grp-target-user').hide();
            } else {
                $('#grp-target-location').hide();
                $('#grp-target-user').show();
            }
            initRelocateSelect2();
        });

        // Toggle target type radio for Loan (User vs Location)
        $('input[name="loan_target_type"]').on('change', function() {
            if ($(this).val() === 'location') {
                $('#grp-loan-target-location').show();
                $('#grp-loan-target-user').hide();
            } else {
                $('#grp-loan-target-location').hide();
                $('#grp-loan-target-user').show();
            }
            initLoanSelect2();
        });

        // Sidebar Menu Trigger - Perbaikan Cepat
        $("#btn-sidebar-checkin-repair").on("click", function(e) {
            e.preventDefault();
            $("#fab-status-id").val("7");
            $("#modal-fab-checkin-title").html('<i class="fa fa-wrench"></i> Check-in / Tarik Aset ke Perbaikan');
            $("#modal-fab-checkin-repair .modal-header").css("background-color", "#f39c12");
            $("#modal-fab-checkin-repair").modal("show");
        });

        // Sidebar Menu Trigger - Tarik Aset Rusak
        $("#btn-sidebar-checkin-broken").on("click", function(e) {
            e.preventDefault();
            $("#fab-status-id").val("3");
            $("#modal-fab-checkin-title").html('<i class="fa fa-ban"></i> Check-in / Tarik Aset Rusak (Undeployable)');
            $("#modal-fab-checkin-repair .modal-header").css("background-color", "#dd4b39");
            $("#modal-fab-checkin-repair").modal("show");
        });

        // Autofocus Asset Tag input when modals open
        $("#modal-fab-checkin-repair").on("shown.bs.modal", function() {
            $("#fab-asset-tag").focus();
        });

        $("#modal-fab-relocate-location").on("shown.bs.modal", function() {
            $(document).off('focusin.modal');
            $(document).off('focusin.bs.modal');
            $("#relocate-asset-tag").focus();
            initRelocateSelect2();
        });

        // Auto-lookup & Autocomplete logic for Asset Tag (Perbaikan Cepat)
        var lookupTimeout = null;
        var autocompleteTimeout = null;

        function performAssetLookup(specificTag) {
            var tag = specificTag || $("#fab-asset-tag").val().trim();
            if (tag.length < 3) {
                $("#fab-lookup-preview").hide();
                $("#fab-lookup-error").hide();
                $("#fab-lookup-loading").hide();
                return;
            }

            $("#fab-lookup-loading").show();
            $("#fab-lookup-preview").hide();
            $("#fab-lookup-error").hide();
            $("#fab-autocomplete-box").hide();

            $.ajax({
                url: "{{ route('custom.lookup_asset') }}",
                type: "GET",
                data: { tag: tag },
                success: function(response) {
                    $("#fab-lookup-loading").hide();
                    $("#preview-name").text(response.name);
                    $("#preview-serial").text(response.serial);
                    $("#preview-status").text(response.status);
                    $("#preview-assignee").text(response.assignee);
                    if (response.image_url) {
                        $("#preview-image").attr("src", response.image_url);
                    }
                    
                    $("#fab-lookup-preview").fadeIn(300);
                },
                error: function() {
                    $("#fab-lookup-loading").hide();
                    $("#fab-lookup-error").show();
                }
            });
        }

        // Trigger autocomplete live search while typing (Perbaikan Cepat)
        $("#fab-asset-tag").on("input", function() {
            var queryVal = $(this).val().trim();
            clearTimeout(autocompleteTimeout);
            clearTimeout(lookupTimeout);
            
            if (queryVal.length < 2) {
                $("#fab-autocomplete-box").hide();
                $("#fab-lookup-preview").hide();
                $("#fab-lookup-error").hide();
                $("#fab-lookup-loading").hide();
                return;
            }

            autocompleteTimeout = setTimeout(function() {
                $.ajax({
                    url: "{{ route('custom.lookup_asset') }}",
                    type: "GET",
                    data: { query: queryVal },
                    success: function(data) {
                        var box = $("#fab-autocomplete-box");
                        box.empty();
                        
                        if (data.length > 0) {
                            $.each(data, function(index, item) {
                                var imgHtml = item.image_url ? '<img src="' + item.image_url + '" style="width: 38px; height: 38px; object-fit: cover; border-radius: 4px; margin-right: 10px; float: left; border: 1px solid #ddd; background: #fff;">' : '';
                                var div = $('<div class="fab-autocomplete-item" style="overflow: hidden; display: flex; align-items: center; padding: 6px 10px;"></div>')
                                    .attr('data-tag', item.asset_tag)
                                    .html(imgHtml + '<div style="flex: 1; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><strong style="display: block; overflow: hidden; text-overflow: ellipsis;">' + item.name + '</strong><small style="color: #666;">' + item.asset_tag + ' &bull; SN: ' + item.serial + '</small></div>');
                                box.append(div);
                            });
                            box.show();
                        } else {
                            box.hide();
                            performAssetLookup();
                        }
                    },
                    error: function() {
                        $("#fab-autocomplete-box").hide();
                    }
                });
            }, 300);
        });

        // Click autocomplete item (Perbaikan Cepat)
        $(document).on("click", "#fab-autocomplete-box .fab-autocomplete-item", function() {
            var tag = $(this).data("tag");
            $("#fab-asset-tag").val(tag);
            $("#fab-autocomplete-box").hide();
            performAssetLookup(tag);
        });

        // Hide autocomplete when clicking outside
        $(document).on("click", function(e) {
            if (!$(e.target).closest("#fab-asset-tag, #fab-autocomplete-box").length) {
                $("#fab-autocomplete-box").hide();
            }
            if (!$(e.target).closest("#relocate-asset-tag, #relocate-autocomplete-box").length) {
                $("#relocate-autocomplete-box").hide();
            }
        });

        // Trigger immediately on Enter key (Perbaikan Cepat)
        $("#fab-asset-tag").on("keypress", function(e) {
            if (e.which === 13) {
                e.preventDefault();
                clearTimeout(autocompleteTimeout);
                clearTimeout(lookupTimeout);
                var activeItem = $("#fab-autocomplete-box .fab-autocomplete-item:first");
                if ($("#fab-autocomplete-box").is(":visible") && activeItem.length) {
                    var tag = activeItem.attr("data-tag");
                    $("#fab-asset-tag").val(tag);
                    $("#fab-autocomplete-box").hide();
                    performAssetLookup(tag);
                } else {
                    performAssetLookup();
                }
            }
        });

        // Clear preview when modal is closed (Perbaikan Cepat)
        $("#modal-fab-checkin-repair").on("hidden.bs.modal", function() {
            $("#form-fab-checkin-repair")[0].reset();
            $("#fab-lookup-preview").hide();
            $("#fab-lookup-error").hide();
            $("#fab-lookup-loading").hide();
            $("#fab-autocomplete-box").hide();
        });

        // FAB Check-in Form Submit (Perbaikan Cepat)
        $("#form-fab-checkin-repair").on("submit", function(e) {
            e.preventDefault();
            var form = $(this);
            var assetTag = $("#fab-asset-tag").val().trim();
            var notes = $("#fab-repair-notes").val().trim();
            var submitBtn = form.find("button[type='submit']");

            if (!assetTag) {
                alert("Harap masukkan atau scan Tag Aset!");
                return;
            }

            submitBtn.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i> Processing...');

            $.ajax({
                url: "{{ route('custom.checkin_to_repair.process') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    asset_tag: assetTag,
                    notes: notes,
                    status_id: $("#fab-status-id").val()
                },
                success: function(response) {
                    submitBtn.prop("disabled", false).html('<i class="fa fa-wrench"></i> Tarik ke Perbaikan');
                    $("#modal-fab-checkin-repair").modal("hide");
                    form[0].reset();
                    
                    // Update dashboard counters if present
                    var repairCounter = $("#counter-asset-repair");
                    if (repairCounter.length) {
                        var repairCount = parseInt(repairCounter.text().replace(/,/g, ''), 10);
                        if (!isNaN(repairCount)) {
                            repairCounter.text(repairCount + 1);
                        }
                    }
                    if (response.was_checked_out) {
                        var borrowedCounter = $("#counter-asset-borrowed");
                        if (borrowedCounter.length) {
                            var borrowedCount = parseInt(borrowedCounter.text().replace(/,/g, ''), 10);
                            if (!isNaN(borrowedCount) && borrowedCount > 0) {
                                borrowedCounter.text(borrowedCount - 1);
                            }
                        }
                    }
                    
                    alert("Sukses! " + response.asset_name + " (" + response.asset_tag + ") " + response.success);
                    
                    var loc = window.location.pathname;
                    if (loc === '/' || loc.indexOf('/dashboard') > -1 || loc.indexOf('/hardware') > -1) {
                        setTimeout(function() {
                            location.reload();
                        }, 500);
                    }
                },
                error: function(xhr) {
                    submitBtn.prop("disabled", false).html('<i class="fa fa-wrench"></i> Tarik ke Perbaikan');
                    var errMsg = "Terjadi kesalahan saat memproses check-in.";
                    if (xhr.responseJSON && xhr.responseJSON.error) {
                        errMsg = xhr.responseJSON.error;
                    }
                    alert(errMsg);
                }
            });
        });

        // -------------------------------------------------------------
        // UPDATE LOKASI / RELOKASI CHECKOUT CEPAT JS LOGIC
        // -------------------------------------------------------------
        var relocateLookupTimeout = null;
        var relocateAutocompleteTimeout = null;

        // Toggle Guide & Diagram Box
        $(document).on("click", "#btn-toggle-relocate-guide", function(e) {
            e.preventDefault();
            $("#relocate-guide-box").slideToggle(200);
        });
        $(document).on("click", "#btn-close-relocate-guide", function(e) {
            e.preventDefault();
            $("#relocate-guide-box").slideUp(200);
        });

        // Listener dropdown user & location untuk menampilkan badge info cabang & auto-fill override
        $('#relocate-user-id').on('change', function() {
            var selectedOption = $(this).find('option:selected');
            var compId = selectedOption.data('company-id') || '';
            var locId = selectedOption.data('location-id') || '';

            if ($(this).val()) {
                $('#relocate-user-override-box').slideDown(150, function() {
                    initRelocateSelect2();
                });

                if (compId) {
                    $('#relocate-user-company-id').val(compId).trigger('change');
                } else {
                    $('#relocate-user-company-id').val('').trigger('change');
                }

                if (locId) {
                    $('#relocate-user-location-id').val(locId).trigger('change');
                } else {
                    $('#relocate-user-location-id').val('').trigger('change');
                }

                if (!compId || !locId) {
                    $('#relocate-user-empty-warning').show();
                    $('#relocate-user-auto-detected').hide();
                } else {
                    $('#relocate-user-empty-warning').hide();
                    $('#relocate-user-auto-detected').show();
                }
            } else {
                $('#relocate-user-override-box').slideUp(150);
            }
        });

        $('#relocate-location-id').on('change', function() {
            var selectedOption = $(this).find('option:selected');
            var compName = selectedOption.data('company-name') || '';
            if ($(this).val() && compName && compName !== '-') {
                $('#relocate-badge-loc-company').text(compName);
                $('#relocate-loc-info-badge').slideDown(150);
            } else {
                $('#relocate-loc-info-badge').slideUp(150);
            }
        });

        function performRelocateLookup(specificTag) {
            var tag = specificTag || $("#relocate-asset-tag").val().trim();
            if (tag.length < 3) {
                $("#relocate-lookup-preview").hide();
                $("#relocate-lookup-error").hide();
                $("#relocate-lookup-loading").hide();
                return;
            }

            $("#relocate-lookup-loading").show();
            $("#relocate-lookup-preview").hide();
            $("#relocate-lookup-error").hide();
            $("#relocate-autocomplete-box").hide();

            $.ajax({
                url: "{{ route('custom.lookup_asset') }}",
                type: "GET",
                data: { tag: tag },
                success: function(response) {
                    $("#relocate-lookup-loading").hide();
                    $("#relocate-preview-name").text(response.name);
                    $("#relocate-preview-serial").text(response.serial);
                    $("#relocate-preview-status").text(response.status);
                    $("#relocate-preview-company").text(response.company || '-');
                    $("#relocate-preview-location").text(response.location);
                    $("#relocate-preview-assignee").text(response.assignee);
                    if (response.image_url) {
                        $("#relocate-preview-image").attr("src", response.image_url);
                    }
                    
                    // Auto-select current location or user if exists
                    if (response.location_id) {
                        $("#relocate-location-id").val(response.location_id).trigger('change');
                    }
                    if (response.assigned_type === 'App\\Models\\User' && response.assigned_to_id) {
                        $('input[name="relocate_target_type"][value="user"]').prop('checked', true).trigger('change');
                        $("#relocate-user-id").val(response.assigned_to_id).trigger('change');
                    } else if (response.assigned_type === 'App\\Models\\Location' && response.assigned_to_id) {
                        $('input[name="relocate_target_type"][value="location"]').prop('checked', true).trigger('change');
                        $("#relocate-location-id").val(response.assigned_to_id).trigger('change');
                    }

                    $("#relocate-lookup-preview").fadeIn(300);
                },
                error: function() {
                    $("#relocate-lookup-loading").hide();
                    $("#relocate-lookup-error").show();
                }
            });
        }

        // Live search autocomplete for Relokasi
        $("#relocate-asset-tag").on("input", function() {
            var queryVal = $(this).val().trim();
            clearTimeout(relocateAutocompleteTimeout);
            clearTimeout(relocateLookupTimeout);
            
            if (queryVal.length < 2) {
                $("#relocate-autocomplete-box").hide();
                $("#relocate-lookup-preview").hide();
                $("#relocate-lookup-error").hide();
                $("#relocate-lookup-loading").hide();
                return;
            }

            relocateAutocompleteTimeout = setTimeout(function() {
                $.ajax({
                    url: "{{ route('custom.lookup_asset') }}",
                    type: "GET",
                    data: { query: queryVal },
                    success: function(data) {
                        var box = $("#relocate-autocomplete-box");
                        box.empty();
                        
                        if (data.length > 0) {
                            $.each(data, function(index, item) {
                                var imgHtml = item.image_url ? '<img src="' + item.image_url + '" style="width: 38px; height: 38px; object-fit: cover; border-radius: 4px; margin-right: 10px; float: left; border: 1px solid #ddd; background: #fff;">' : '';
                                var compText = item.company ? ' &bull; ' + item.company : '';
                                var div = $('<div class="fab-autocomplete-item" style="overflow: hidden; display: flex; align-items: center; padding: 6px 10px;"></div>')
                                    .attr('data-tag', item.asset_tag)
                                    .html(imgHtml + '<div style="flex: 1; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><strong style="display: block; overflow: hidden; text-overflow: ellipsis;">' + item.name + '</strong><small style="color: #666;">' + item.asset_tag + ' &bull; Lokasi: ' + (item.location || '-') + compText + '</small></div>');
                                box.append(div);
                            });
                            box.show();
                        } else {
                            box.hide();
                            performRelocateLookup();
                        }
                    },
                    error: function() {
                        $("#relocate-autocomplete-box").hide();
                    }
                });
            }, 300);
        });

        // Click autocomplete item for Relokasi
        $(document).on("click", "#relocate-autocomplete-box .fab-autocomplete-item", function() {
            var tag = $(this).data("tag");
            $("#relocate-asset-tag").val(tag);
            $("#relocate-autocomplete-box").hide();
            performRelocateLookup(tag);
        });

        // Trigger on Enter key for Relokasi
        $("#relocate-asset-tag").on("keypress", function(e) {
            if (e.which === 13) {
                e.preventDefault();
                clearTimeout(relocateAutocompleteTimeout);
                clearTimeout(relocateLookupTimeout);
                var activeItem = $("#relocate-autocomplete-box .fab-autocomplete-item:first");
                if ($("#relocate-autocomplete-box").is(":visible") && activeItem.length) {
                    var tag = activeItem.attr("data-tag");
                    $("#relocate-asset-tag").val(tag);
                    $("#relocate-autocomplete-box").hide();
                    performRelocateLookup(tag);
                } else {
                    performRelocateLookup();
                }
            }
        });

        // Clear preview when modal is closed
        $("#modal-fab-relocate-location").on("hidden.bs.modal", function() {
            $("#form-fab-relocate-location")[0].reset();
            $("#relocate-lookup-preview").hide();
            $("#relocate-lookup-error").hide();
            $("#relocate-lookup-loading").hide();
            $("#relocate-autocomplete-box").hide();
            $("#relocate-user-override-box").hide();
            $("#relocate-user-empty-warning").hide();
            $("#relocate-user-auto-detected").hide();
            $("#relocate-loc-info-badge").hide();
            $("#relocate-guide-box").hide();
            $('input[name="relocate_target_type"][value="location"]').prop('checked', true).trigger('change');
            if ($('#relocate-location-id').hasClass('select2-hidden-accessible')) {
                $('#relocate-location-id').val('').trigger('change');
            }
            if ($('#relocate-user-id').hasClass('select2-hidden-accessible')) {
                $('#relocate-user-id').val('').trigger('change');
            }
            if ($('#relocate-user-company-id').hasClass('select2-hidden-accessible')) {
                $('#relocate-user-company-id').val('').trigger('change');
            }
            if ($('#relocate-user-location-id').hasClass('select2-hidden-accessible')) {
                $('#relocate-user-location-id').val('').trigger('change');
            }
        });

        // Submit Relokasi Form
        $("#form-fab-relocate-location").on("submit", function(e) {
            e.preventDefault();
            var form = $(this);
            var assetTag = $("#relocate-asset-tag").val().trim();
            var targetType = $('input[name="relocate_target_type"]:checked').val();
            var targetId = (targetType === 'location') ? $("#relocate-location-id").val() : $("#relocate-user-id").val();
            var customCompanyId = (targetType === 'user') ? $("#relocate-user-company-id").val() : '';
            var customLocationId = (targetType === 'user') ? $("#relocate-user-location-id").val() : '';
            var syncUserProfile = $("#relocate-sync-user-profile").is(":checked") ? 1 : 0;
            var statusId = $("#relocate-status-id").val();
            var notes = $("#relocate-notes").val().trim();
            var submitBtn = $("#btn-submit-relocate");

            if (!assetTag) {
                alert("Harap masukkan atau scan Tag Aset!");
                return;
            }
            if (!targetId) {
                alert("Harap pilih target Lokasi atau Karyawan baru!");
                return;
            }

            submitBtn.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i> Memproses Relokasi & Sinkronisasi...');

            $.ajax({
                url: "{{ route('custom.relocate_checkout.process') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    asset_tag: assetTag,
                    target_type: targetType,
                    target_id: targetId,
                    custom_company_id: customCompanyId,
                    custom_location_id: customLocationId,
                    sync_user_profile: syncUserProfile,
                    status_id: statusId,
                    notes: notes
                },
                success: function(response) {
                    submitBtn.prop("disabled", false).html('<i class="fa fa-check"></i> Simpan & Relokasi Aset');
                    $("#modal-fab-relocate-location").modal("hide");
                    form[0].reset();
                    
                    var detailMsg = "✅ Sukses!\n" + response.asset_name + " (" + response.asset_tag + ")\n" + response.success;
                    if (response.location_name || response.company_name) {
                        detailMsg += "\n\n📍 Lokasi Terpasang: " + (response.location_name || '-') + "\n🏢 Perusahaan (PT): " + (response.company_name || '-');
                    }
                    if (response.user_profile_updated) {
                        detailMsg += "\n👤 Profil Karyawan berhasil diperbarui & disimpan.";
                    }
                    alert(detailMsg);
                    
                    var loc = window.location.pathname;
                    if (loc === '/' || loc.indexOf('/dashboard') > -1 || loc.indexOf('/hardware') > -1) {
                        setTimeout(function() {
                            location.reload();
                        }, 500);
                    }
                },
                error: function(xhr) {
                    submitBtn.prop("disabled", false).html('<i class="fa fa-check"></i> Simpan & Relokasi Aset');
                    var errMsg = "Terjadi kesalahan saat memproses relokasi.";
                    if (xhr.responseJSON && xhr.responseJSON.error) {
                        errMsg = xhr.responseJSON.error;
                    }
                    alert(errMsg);
                }
            });
        });

        // -------------------------------------------------------------
        // PINJAM CEPAT (QUICK ASSET LOAN) JS LOGIC
        // -------------------------------------------------------------
        var loanLookupTimeout = null;
        var loanAutocompleteTimeout = null;

        // Toggle Guide & Diagram Box for Loan
        $(document).on("click", "#btn-toggle-loan-guide", function(e) {
            e.preventDefault();
            $("#loan-guide-box").slideToggle(200);
        });
        $(document).on("click", "#btn-close-loan-guide", function(e) {
            e.preventDefault();
            $("#loan-guide-box").slideUp(200);
        });

        // Tab Switcher between Mode Pinjam & Mode Kembali
        $('#btn-tab-mode-loan').on('click', function() {
            $(this).css({'background': '#008ba3', 'color': 'white', 'box-shadow': '0 2px 4px rgba(0,0,0,0.1)'});
            $('#btn-tab-mode-return').css({'background': 'transparent', 'color': '#475569', 'box-shadow': 'none'});
            $('#section-mode-loan').slideDown(150);
            $('#section-mode-return').slideUp(150);
            $('#btn-submit-loan').show();
            $('#btn-submit-return').hide();
            initLoanSelect2();
        });

        $('#btn-tab-mode-return').on('click', function() {
            $(this).css({'background': '#00a65a', 'color': 'white', 'box-shadow': '0 2px 4px rgba(0,0,0,0.1)'});
            $('#btn-tab-mode-loan').css({'background': 'transparent', 'color': '#475569', 'box-shadow': 'none'});
            $('#section-mode-loan').slideUp(150);
            $('#section-mode-return').slideDown(150);
            $('#btn-submit-loan').hide();
            $('#btn-submit-return').show();
            initLoanSelect2();
        });

        // Focus & Init Select2 when Loan Modal Opens
        $("#modal-fab-quick-loan").on("shown.bs.modal", function() {
            $(document).off('focusin.modal');
            $(document).off('focusin.bs.modal');
            $("#loan-asset-tag").focus();
            initLoanSelect2();
        });

        // Reset Loan Modal when closed
        $("#modal-fab-quick-loan").on("hidden.bs.modal", function() {
            $("#form-fab-quick-loan")[0].reset();
            $("#loan-lookup-preview").hide();
            $("#loan-lookup-error").hide();
            $("#loan-lookup-loading").hide();
            $("#loan-autocomplete-box").hide();
            $("#loan-user-override-box").hide();
            $("#loan-user-empty-warning").hide();
            $("#loan-user-auto-detected").hide();
            $("#loan-guide-box").hide();
            $('#btn-tab-mode-loan').trigger('click');
            $('input[name="loan_target_type"][value="user"]').prop('checked', true).trigger('change');
            if ($('#loan-location-id').hasClass('select2-hidden-accessible')) {
                $('#loan-location-id').val('').trigger('change');
            }
            if ($('#loan-user-id').hasClass('select2-hidden-accessible')) {
                $('#loan-user-id').val('').trigger('change');
            }
            if ($('#loan-user-company-id').hasClass('select2-hidden-accessible')) {
                $('#loan-user-company-id').val('').trigger('change');
            }
            if ($('#loan-user-location-id').hasClass('select2-hidden-accessible')) {
                $('#loan-user-location-id').val('').trigger('change');
            }
            if ($('#return-location-id').hasClass('select2-hidden-accessible')) {
                $('#return-location-id').val('36').trigger('change');
            }
            $('#return-status-id').val('2');
        });

        // Listener dropdown user for loan to auto-detect company & location
        $('#loan-user-id').on('change', function() {
            var selectedOption = $(this).find('option:selected');
            var compId = selectedOption.data('company-id') || '';
            var locId = selectedOption.data('location-id') || '';

            if ($(this).val()) {
                $('#loan-user-override-box').slideDown(150, function() {
                    initLoanSelect2();
                });

                if (compId) {
                    $('#loan-user-company-id').val(compId).trigger('change');
                } else {
                    $('#loan-user-company-id').val('').trigger('change');
                }

                if (locId) {
                    $('#loan-user-location-id').val(locId).trigger('change');
                } else {
                    $('#loan-user-location-id').val('').trigger('change');
                }

                if (!compId || !locId) {
                    $('#loan-user-empty-warning').show();
                    $('#loan-user-auto-detected').hide();
                } else {
                    $('#loan-user-empty-warning').hide();
                    $('#loan-user-auto-detected').show();
                }
            } else {
                $('#loan-user-override-box').slideUp(150);
            }
        });

        function performLoanLookup(specificTag) {
            var tag = specificTag || $("#loan-asset-tag").val().trim();
            if (tag.length < 3) {
                $("#loan-lookup-preview").hide();
                $("#loan-lookup-error").hide();
                $("#loan-lookup-loading").hide();
                return;
            }

            $("#loan-lookup-loading").show();
            $("#loan-lookup-preview").hide();
            $("#loan-lookup-error").hide();
            $("#loan-autocomplete-box").hide();

            $.ajax({
                url: "{{ route('custom.lookup_asset') }}",
                type: "GET",
                data: { tag: tag },
                success: function(response) {
                    $("#loan-lookup-loading").hide();
                    $("#loan-preview-name").text(response.name);
                    $("#loan-preview-serial").text(response.serial);
                    $("#loan-preview-status").text(response.status);
                    $("#loan-preview-company").text(response.company || '-');
                    $("#loan-preview-location").text(response.location);
                    $("#loan-preview-assignee").text(response.assignee);
                    if (response.image_url) {
                        $("#loan-preview-image").attr("src", response.image_url);
                    }
                    $("#loan-lookup-preview").fadeIn(300);
                },
                error: function() {
                    $("#loan-lookup-loading").hide();
                    $("#loan-lookup-error").show();
                }
            });
        }

        // Live search autocomplete for Loan
        $("#loan-asset-tag").on("input", function() {
            var queryVal = $(this).val().trim();
            clearTimeout(loanAutocompleteTimeout);
            clearTimeout(loanLookupTimeout);
            
            if (queryVal.length < 2) {
                $("#loan-autocomplete-box").hide();
                $("#loan-lookup-preview").hide();
                $("#loan-lookup-error").hide();
                $("#loan-lookup-loading").hide();
                return;
            }

            loanAutocompleteTimeout = setTimeout(function() {
                $.ajax({
                    url: "{{ route('custom.lookup_asset') }}",
                    type: "GET",
                    data: { query: queryVal },
                    success: function(data) {
                        var box = $("#loan-autocomplete-box");
                        box.empty();
                        
                        if (data.length > 0) {
                            $.each(data, function(index, item) {
                                var imgHtml = item.image_url ? '<img src="' + item.image_url + '" style="width: 38px; height: 38px; object-fit: cover; border-radius: 4px; margin-right: 10px; float: left; border: 1px solid #ddd; background: #fff;">' : '';
                                var compText = item.company ? ' &bull; ' + item.company : '';
                                var div = $('<div class="fab-autocomplete-item" style="overflow: hidden; display: flex; align-items: center; padding: 6px 10px;"></div>')
                                    .attr('data-tag', item.asset_tag)
                                    .html(imgHtml + '<div style="flex: 1; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><strong style="display: block; overflow: hidden; text-overflow: ellipsis;">' + item.name + '</strong><small style="color: #666;">' + item.asset_tag + ' &bull; Lokasi: ' + (item.location || '-') + compText + '</small></div>');
                                box.append(div);
                            });
                            box.show();
                        } else {
                            box.hide();
                            performLoanLookup();
                        }
                    },
                    error: function() {
                        $("#loan-autocomplete-box").hide();
                    }
                });
            }, 300);
        });

        // Click autocomplete item for Loan
        $(document).on("click", "#loan-autocomplete-box .fab-autocomplete-item", function() {
            var tag = $(this).data("tag");
            $("#loan-asset-tag").val(tag);
            $("#loan-autocomplete-box").hide();
            performLoanLookup(tag);
        });

        // Trigger on Enter key for Loan
        $("#loan-asset-tag").on("keypress", function(e) {
            if (e.which === 13) {
                e.preventDefault();
                clearTimeout(loanAutocompleteTimeout);
                clearTimeout(loanLookupTimeout);
                var activeItem = $("#loan-autocomplete-box .fab-autocomplete-item:first");
                if ($("#loan-autocomplete-box").is(":visible") && activeItem.length) {
                    var tag = activeItem.attr("data-tag");
                    $("#loan-asset-tag").val(tag);
                    $("#loan-autocomplete-box").hide();
                    performLoanLookup(tag);
                } else {
                    performLoanLookup();
                }
            }
        });

        // Submit Pinjam Cepat Form (Mode Pinjam)
        $("#form-fab-quick-loan").on("submit", function(e) {
            e.preventDefault();
            var form = $(this);
            var assetTag = $("#loan-asset-tag").val().trim();
            var targetType = $('input[name="loan_target_type"]:checked').val();
            var targetId = (targetType === 'location') ? $("#loan-location-id").val() : $("#loan-user-id").val();
            var customCompanyId = (targetType === 'user') ? $("#loan-user-company-id").val() : '';
            var customLocationId = (targetType === 'user') ? $("#loan-user-location-id").val() : '';
            var syncUserProfile = $("#loan-sync-user-profile").is(":checked") ? 1 : 0;
            var expectedCheckin = $("#loan-expected-checkin").val();
            var notes = $("#loan-notes").val().trim();
            var submitBtn = $("#btn-submit-loan");

            if (!assetTag) {
                alert("Harap masukkan atau scan Tag Aset!");
                return;
            }
            if (!targetId) {
                alert("Harap pilih target Karyawan atau Lokasi peminjam!");
                return;
            }

            submitBtn.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i> Memproses Peminjaman...');

            $.ajax({
                url: "{{ route('custom.loan_checkout.process') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    asset_tag: assetTag,
                    target_type: targetType,
                    target_id: targetId,
                    custom_company_id: customCompanyId,
                    custom_location_id: customLocationId,
                    sync_user_profile: syncUserProfile,
                    expected_checkin: expectedCheckin,
                    notes: notes
                },
                success: function(response) {
                    submitBtn.prop("disabled", false).html('<i class="fas fa-handshake"></i> Simpan & Eksekusi Peminjaman');
                    $("#modal-fab-quick-loan").modal("hide");
                    form[0].reset();
                    
                    var detailMsg = "✅ Peminjaman Sukses!\n" + response.asset_name + " (" + response.asset_tag + ")\n" + response.success;
                    if (response.expected_checkin) {
                        detailMsg += "\n📅 Rencana Pengembalian: " + response.expected_checkin;
                    }
                    if (response.location_name || response.company_name) {
                        detailMsg += "\n📍 Cabang/Lokasi: " + (response.location_name || '-') + "\n🏢 Perusahaan: " + (response.company_name || '-');
                    }
                    if (response.user_profile_updated) {
                        detailMsg += "\n👤 Profil Karyawan peminjam berhasil diperbarui.";
                    }
                    alert(detailMsg);
                    
                    var loc = window.location.pathname;
                    if (loc === '/' || loc.indexOf('/dashboard') > -1 || loc.indexOf('/hardware') > -1) {
                        setTimeout(function() {
                            location.reload();
                        }, 500);
                    }
                },
                error: function(xhr) {
                    submitBtn.prop("disabled", false).html('<i class="fas fa-handshake"></i> Simpan & Eksekusi Peminjaman');
                    var errMsg = "Terjadi kesalahan saat memproses peminjaman.";
                    if (xhr.responseJSON && xhr.responseJSON.error) {
                        errMsg = xhr.responseJSON.error;
                    }
                    alert(errMsg);
                }
            });
        });

        // Submit Pengembalian Unit (Mode Kembali)
        $("#btn-submit-return").on("click", function(e) {
            e.preventDefault();
            var assetTag = $("#loan-asset-tag").val().trim();
            var locationId = $("#return-location-id").val();
            var statusId = $("#return-status-id").val();
            var notes = $("#return-notes").val().trim();
            var submitBtn = $(this);

            if (!assetTag) {
                alert("Harap masukkan atau scan Tag Aset yang akan dikembalikan!");
                return;
            }

            submitBtn.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i> Memproses Pengembalian...');

            $.ajax({
                url: "{{ route('custom.loan_checkin.process') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    asset_tag: assetTag,
                    location_id: locationId,
                    status_id: statusId,
                    notes: notes
                },
                success: function(response) {
                    submitBtn.prop("disabled", false).html('<i class="fas fa-undo"></i> Simpan & Proses Pengembalian Unit');
                    $("#modal-fab-quick-loan").modal("hide");
                    $("#form-fab-quick-loan")[0].reset();
                    
                    var detailMsg = "✅ Pengembalian Sukses!\n" + response.asset_name + " (" + response.asset_tag + ")\n" + response.success;
                    detailMsg += "\n📍 Lokasi: " + response.location_name + "\n🏷️ Status: " + response.status_name;
                    alert(detailMsg);
                    
                    var loc = window.location.pathname;
                    if (loc === '/' || loc.indexOf('/dashboard') > -1 || loc.indexOf('/hardware') > -1) {
                        setTimeout(function() {
                            location.reload();
                        }, 500);
                    }
                },
                error: function(xhr) {
                    submitBtn.prop("disabled", false).html('<i class="fas fa-undo"></i> Simpan & Proses Pengembalian Unit');
                    var errMsg = "Terjadi kesalahan saat memproses pengembalian.";
                    if (xhr.responseJSON && xhr.responseJSON.error) {
                        errMsg = xhr.responseJSON.error;
                    }
                    alert(errMsg);
                }
            });
        });
    });
</script>
@endcan

        </body>
</html>
