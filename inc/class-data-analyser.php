<?php

class DP_Data_Analyser {

	var $html;

	function __construct( $html ) {

		$this->html = $html;
	}

	function is_wordpress() {

		$regex = sprintf( '(%s)|(%s)',  preg_quote( '<meta name="generator"' ), preg_quote( '/wp-content/' ) );

		return preg_match( '%' . $regex . '%', $this->html );
	}

}