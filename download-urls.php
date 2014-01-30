<?php

$file = dirname( __FILE__ ) . '/top-1m.csv';
$fp = fopen( $file, 'r' );

while ( ( $data = fgetcsv( $fp, 1000, "," ) ) !== false ) {

	$number = str_pad( $data[0], 7, 0, STR_PAD_LEFT );
	$site_file = dirname( __FILE__ ) . '/data/' . $number . '.html';

	if ( ! file_exists( $site_file ) ) {
		echo "[{$number}] Downloading: {$data[1]}" . PHP_EOL;
		shell_exec( "wget -O {$site_file} {$data[1]} > /dev/null 2>/dev/null &" );
	} else {
		echo "[{$number}] File already exists: {$data[1]}" . PHP_EOL;
	}
}
fclose( $fp );
