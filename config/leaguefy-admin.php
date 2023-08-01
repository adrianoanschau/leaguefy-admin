<?php

return [
    'title' => 'Leaguefy',
    'logo' => 'Leaguefy Admin',

    'route' => [
        'prefix' => 'leaguefy',
        'middleware' => ['web'],
    ],

    'menu' => [
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
            'path' => '/vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt' => 'AdminLTE Preloader Image',
            'effect' => 'animation__wobble',
            'width' => 60,
            'height' => 60,
        ],
    ],

    'dashboard_route' => 'leaguefy.admin.index',
    'logout_route' => 'auth.logout',

    'right_sidebar' => true,
    'right_sidebar_push' => false,
    'right_sidebar_theme' => 'light',

    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,
];
