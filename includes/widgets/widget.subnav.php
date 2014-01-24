<?php
/**
 * Customizer
 *
 * @param obj $wp_customize WordPress Customizer
 * @since v1.0
 * @author Ralf Hortt
 */
if ( !class_exists( 'WP_Widget_Subnav' ) ) :
class WP_Widget_Subnav extends WP_Widget {



	/**
	 * Constructor
	 *
	 * @since v1.0
	 * @author Ralf Hortt
	 */
	function __construct() {
		$widget_ops = array(
			'classname' => 'widget-subnav',
			'description' => __( 'Unternavigation', 'diro' ),
		);
		$control_ops = array( 'id_base' => 'widget-subnav' );
		$this->WP_Widget( 'widget-subnav', __( 'Unternavigation', 'diro' ), $widget_ops, $control_ops );
	}



	/**
	 * Output
	 *
	 * @param array $args Arguments
	 * @param array $instance Widget instance
	 * @since v1.0
	 * @author Ralf Hortt
	 */
	function widget( $args, $instance ) {

		$id = ( is_singular( 'post' ) ) ? get_option( 'page_for_posts' ) : get_the_ID();

		$ancestors = get_post_ancestors( apply_filters( 'widget-subnav-get-ancestors', $id ) );

		$ancestor = end( $ancestors );
		$ancestor = ( 0 == $ancestor ) ? get_the_ID() : $ancestor;

		$args = array(
			'child_of' => apply_filters( 'widget-subnav-ancestor', $ancestor ),
			'title_li' => '',
			'echo' => 0
		);

		$nav = wp_list_pages( apply_filters( 'widget-subnav-list-pages-args', $args ) );

		if ( !$nav )
			return;

		?>
		<aside class="widget widget-subnav widget-subnav-<?php echo $ancestor ?>">
			<h3 class="widget-title"><?php echo get_the_title( $ancestor ) ?></h3>
			<ul>
				<?php echo $nav ?>
			</ul>
		</aside>
		<?php

	}



	/**
	 * Save widget settings
	 *
	 * @param array $new_instance New widget instance
	 * @param array $old_instance Old widget instance
	 * @since v1.0
	 * @author Ralf Hortt
	 */
	function update( $new_instance, $old_instance ) {}



	/**
	 * Widget settings
	 *
	 * @param array $instance Widget instance
	 * @since v1.0
	 * @author Ralf Hortt
	 */
	function form( $instance ) {}



} // end WP_Widget_Subnav
endif;