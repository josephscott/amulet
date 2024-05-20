<?php
declare( strict_types = 1 );

require __DIR__ . '/../vendor/autoload.php';

$http = new JosephScott\Amulet();
$response = $http->get( url: 'http://example.com/' );

print_r( $response );
