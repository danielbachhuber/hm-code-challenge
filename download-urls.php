<?php

$max_processes = 150;

$file = dirname( __FILE__ ) . '/top-1m.csv';
$fp = fopen( $file, 'r' );

$spawned = false;
while ( ( $data = fgetcsv( $fp, 1000, "," ) ) !== false ) {

	// Wait if there are too many processes
	while( $spawned && trim( shell_exec( 'ps aux | grep wget | wc -l' ) ) > $max_processes ) {
		sleep( 1 );
	}

	$number = str_pad( $data[0], 7, 0, STR_PAD_LEFT );
	$dir = str_pad( ceil( $number / 10000 ), 3, 0, STR_PAD_LEFT );

	$dir_path = dirname( __FILE__ ) . "/data/{$dir}";
	if ( ! is_dir( $dir_path ) ) {
		mkdir( $dir_path );
	}

	$site_file = dirname( __FILE__ ) . "/data/{$dir}/{$number}.html";

	if ( ! file_exists( $site_file ) ) {
		$spawned = true;
		echo "[{$number}] Downloading: {$data[1]}" . PHP_EOL;
		shell_exec( "wget -O {$site_file} -T 5 {$data[1]} > /dev/null 2>/dev/null &" );
	} else {
		$spawned = false;
		echo "[{$number}] File already exists: {$data[1]}" . PHP_EOL;
	}
}
fclose( $fp );
