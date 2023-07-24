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
            'url'         => 'leaguefy/games',
            'icon'        => 'fas fa-fw fa-gamepad',
        ],
        [
            'text'        => 'teams',
            'url'         => 'leaguefy/teams',
            'icon'        => 'fas fa-fw fa-users',
        ],
        [
            'text'        => 'tournaments',
            'url'         => 'leaguefy/tournaments',
            'icon'        => 'fas fa-fw fa-trophy',
        ],
    ],

    'classes_brand' => 'bg-orange',
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
];
