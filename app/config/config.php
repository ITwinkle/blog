<?php

return array(
    'mode'        => 'dev',
    'routes'      => include('routes.php'),
    'main_layout' => __DIR__.'/../../src/Blog/views/layout.html.php',
    'error_500'   => __DIR__.'/../../src/Blog/views/500.html.php',
    'pdo'         => array(
        'dns'      => 'mysql:dbname=education;host=127.0.0.1',
        'user'     => 'root',
        'password' => 'independent12'
    ),
    'security'    => array(
        'user_class'  => 'Blog\\Model\\User',
        'login_route' => 'login'
    ),
    'location'    => array(
        'path' => __DIR__.'/../Locale/',
        'language' => 'ru_RU'
    )
);