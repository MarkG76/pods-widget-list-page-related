<?php
/* Plugin Name: Pods Page-related List Widget 
Plugin URI: http://giannopoulos.net
Description: Display multiple Pod items, related to the current page. Based on (and requires) the PODS Framework http://podsframework.org/
Version: 0.1
Author: Markos Giannopoulos
Author URI: http://giannopoulos.net
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

class PodsWidgetListPageRelated extends WP_Widget {

    /**
     * Register the widget
     */
    public function PodsWidgetListPageRelated () {
        $this->WP_Widget(
            'pods-widget-list-page-related',
            'Pods - List Items / Page Related',
            array( 'classname' => 'pods-widget-list-page-related', 'description' => 'Display multiple Pod items, related to the current page' ),
            array( 'width' => 200 )
        );
    }

    /**
     * Output of widget
     */
    public function widget ( $args, $instance ) {
        extract( $args );

		// Find where we are
		global $wp_query;
		$object_id = $wp_query->get_queried_object_id();

		// Take where field and add the page relation part
		$where = trim( pods_var_raw( 'where', $instance, '' ) );
		$where = $where . " and " . pods_var_raw( 'page_field', $instance, '' ) .".ID = ". $object_id ." ";
		
        // Get widget fields
        $title = apply_filters( 'widget_title', $instance[ 'title' ] );

        $args = array(
            'name' => trim( pods_var_raw( 'pod_type', $instance, '' ) ),
            'template' => trim( pods_var_raw( 'template', $instance, '' ) ),
            'limit' => (int) pods_var_raw( 'limit', $instance, 15, null, true ),
            'orderby' => trim( pods_var_raw( 'orderby', $instance, '' ) ),
            'where' => $where
        );

        $content = trim( pods_var_raw( 'template_custom', $instance, '' ) );

        if ( 0 < strlen( $args[ 'name' ] ) && ( 0 < strlen( $args[ 'template' ] ) || 0 < strlen( $content ) ) ) {
            require 'ui_front_widgets.php';
        }

    }

    /**
     * Updates the new instance of widget arguments
     *
     * @returns array $instance Updated instance
     */
    public function update ( $new_instance, $old_instance ) {
        $instance = $old_instance;

        $instance[ 'title' ] = pods_var_raw( 'title', $new_instance, '' );
        $instance[ 'pod_type' ] = pods_var_raw( 'pod_type', $new_instance, '' );
        $instance[ 'template' ] = pods_var_raw( 'template', $new_instance, '' );
        $instance[ 'template_custom' ] = pods_var_raw( 'template_custom', $new_instance, '' );
        $instance[ 'limit' ] = (int) pods_var_raw( 'limit', $new_instance, 15, null, true );
        $instance[ 'orderby' ] = pods_var_raw( 'orderby', $new_instance, '' );
        $instance[ 'where' ] = pods_var_raw( 'where', $new_instance, '' );
        $instance[ 'page_field' ] = pods_var_raw( 'page_field', $new_instance, '' );

        return $instance;
    }

    /**
     * Widget Form
     */
    public function form ( $instance ) {
        $title = pods_var_raw( 'title', $instance, '' );
        $pod_type = pods_var_raw( 'pod_type', $instance, '' );
        $template = pods_var_raw( 'template', $instance, '' );
        $template_custom = pods_var_raw( 'template_custom', $instance, '' );
        $limit = (int) pods_var_raw( 'limit', $instance, 15, null, true );
        $orderby = pods_var_raw( 'orderby', $instance, '' );
        $where = pods_var_raw( 'where', $instance, '' );
        $page_field = pods_var_raw( 'page_field', $instance, '' );

        require 'ui_admin_list.php';
        
    }
}

add_action(
          'widgets_init',
          create_function('','return register_widget("PodsWidgetListPageRelated");')
);
?>