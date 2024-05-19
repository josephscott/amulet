<?php
declare( strict_types = 1 );

test( 'delete-curl', function () {
	$http = new JosephScott\Amulet\Request();
	$response = $http->delete( url: 'http://127.0.0.1:7878/?method=delete' );

	$data = json_decode( $response->body, associative: true );

	expect( $response->error )->toBe( false );
	expect( $response->code )->toBe( 200 );
	expect( $response->headers['content-type'] )->toBe( 'application/json' );
} );

test( 'delete-php', function () {
	$http = new JosephScott\Amulet\Request();
	$http->default_options['using'] = 'php';
	$response = $http->delete( url: 'http://127.0.0.1:7878/?method=delete' );

	$data = json_decode( $response->body, associative: true );

	expect( $response->error )->toBe( false );
	expect( $response->code )->toBe( 200 );
	expect( $response->headers['content-type'] )->toBe( 'application/json' );
} );
