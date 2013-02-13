<?php

    $result = pods_shortcode( $args, ( isset( $content ) ? $content : null ) );

	if(!$result) {

		//	$result="Nothing to show";

	} else {

		echo $before_widget;
	
		if ( !empty( $title ) )
			echo $before_title . $title . $after_title;

		echo $result;

		echo $after_widget;

    }
