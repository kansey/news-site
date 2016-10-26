<?php
return [
    'login' => [
        'type' => 2,
    ],
    'logout' => [
        'type' => 2,
    ],
    'error' => [
        'type' => 2,
    ],
    'signup' => [
        'type' => 2,
    ],
    'site_index' => [
        'type' => 2,
    ],
    'news_view' => [
        'type' => 2,
    ],
    'news_update' => [
        'type' => 2,
    ],
    'news_delete' => [
        'type' => 2,
    ],
    'news_create' => [
        'type' => 2,
    ],
    'news_index' => [
        'type' => 2,
    ],
    'user_update' => [
        'type' => 2,
    ],
    'user_delete' => [
        'type' => 2,
    ],
    'user_create' => [
        'type' => 2,
    ],
    'user_index' => [
        'type' => 2,
    ],
    'guest' => [
        'type' => 1,
        'ruleName' => 'userGroup',
        'children' => [
            'login',
            'error',
            'signup',
            'site_index',
        ],
    ],
    'user' => [
        'type' => 1,
        'ruleName' => 'userGroup',
        'children' => [
            'logout',
            'news_view',
            'guest',
        ],
    ],
    'moder' => [
        'type' => 1,
        'ruleName' => 'userGroup',
        'children' => [
            'news_index',
            'news_update',
            'news_delete',
            'news_create',
            'user',
        ],
    ],
    'admin' => [
        'type' => 1,
        'ruleName' => 'userGroup',
        'children' => [
            'user_index',
            'news_view',
            'user_create',
            'user_update',
            'user_delete',
            'moder',
        ],
    ],
];
