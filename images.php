<?php

$count = 1000;

shell_exec( 'mkdir img' );

for ( $i = 1; $i <= $count; $i++ ) {
	$w = rand( 640, 1920 );
	$h = rand( 640, 1920 );
	shell_exec( "curl http://lorempixel.com/{$w}/{$h}/ -o img/{$i}.jpg" );
}
