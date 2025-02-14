<?php
declare( strict_types = 1 );

test( 'post-curl: data', function () {
	$http = new JosephScott\Amulet();
	$response = $http->put(
		url: 'http://127.0.0.1:7878/?method=put',
		data: [
			'this' => 'here',
			'hello' => 'world',
		]
	);

	$data = json_decode( $response->body, associative: true );

	expect( $response->error )->toBe( false );
	expect( $response->code )->toBe( 200 );
	expect( $response->headers['content-type'] )->toBe( 'application/json' );
} );

test( 'post-php: data', function () {
	$http = new JosephScott\Amulet();
	$http->default_options['using'] = 'php';
	$response = $http->put(
		url: 'http://127.0.0.1:7878/?method=put',
		data: [
			'this' => 'here',
			'hello' => 'world',
		]
	);

	$data = json_decode( $response->body, associative: true );

	expect( $response->error )->toBe( false );
	expect( $response->code )->toBe( 200 );
	expect( $response->headers['content-type'] )->toBe( 'application/json' );
} );
