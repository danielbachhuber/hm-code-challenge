<?php

define( 'DP_DIR', dirname( __FILE__ ) . '/' );

require_once( DP_DIR . '/inc/class-data-analyser.php' );

$fp = fopen( DP_DIR . "is_wordpress.csv", "w" );

for ( $i = 0; $i < 10; $i++ ) {

	$filename = DP_DIR  . sprintf( '%07d', $i ) . '.html' ;

	if ( file_exists( $filename ) ) {

		$analyser = new DP_Data_Analyser( file_get_contents( $filename ) );

		$is_wordpress = $analyser->is_wordpress();

		fputcsv($fp, array( $i, $is_wordpress ) );
	}

}

fclose( $fp );
