<?php

return [
    'title' => 'Leaguefy',
    'logo' => '<b>Leaguefy</b>Admin',

    'route' => [
        'prefix' => 'leaguefy',
        'middleware' => ['web'],
    ],

    'menu' => [
        [
            'type' => 'sidebar-menu-search',
            'text' => 'search',
        ],
        [
            'text'        => 'games',
            'route'       => 'leaguefy.admin.games.index',
            'icon'        => 'fas fa-fw fa-gamepad',
        ],
        [
            'text'        => 'teams',
            'route'       => 'leaguefy.admin.teams.index',
            'icon'        => 'fas fa-fw fa-users',
        ],
        [
            'text'        => 'tournaments',
            'route'       => 'leaguefy.admin.tournaments.index',
            'icon'        => 'fas fa-fw fa-trophy',
        ],
    ],

    'database' => [
        'connection' => '',

        'tables' => [
            'settings' => 'leaguefy_admin_settings',
        ],
    ],

    'classes_brand' => 'bg-orange',
    'classes_brand_text' => '',
    'classes_topnav_nav' => 'navbar-expand bg-orange',

    'preloader' => [
        'enabled' => true,
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt' => 'AdminLTE Preloader Image',
            'effect' => 'animation__wobble',
            'width' => 60,
            'height' => 60,
        ],
    ],

    'dashboard_url' => 'leaguefy',

    'right_sidebar' => true,
    'right_sidebar_push' => false,
    'right_sidebar_theme' => 'light',
];
