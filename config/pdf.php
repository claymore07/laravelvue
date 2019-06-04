<?php

return [
    'mode'                  => 'utf-8',
    'format'                => 'A4',
    'author'                => 'researchi',
    'subject'               => '',
    'keywords'              => '',
    'creator'               => 'researchi',
    'display_mode'          => 'fullpage',
    //'tempDir'               => base_path('../temp/'),
    'font_path' => base_path('resources/fonts/'),
    'font_data' => [
        'iransans1' => [
            'R'  => 'ttf/IRANSansWeb.ttf',
            'B'  => 'ttf/IRANSansWeb_Bold.ttf',
            'useOTL' => 0xFF,
            'useKashida' => 75,
        ],
        'en' => [
            'R'  => 'Gothic/Century Gothic.ttf',
            'B'  => 'Gothic/GOTHICB.ttf',
        ]
    ]
];
