<?php
/**
 * Customizer
 *
 * @param obj $wp_customize WordPress Customizer
 * @since v1.0.12
 * @author Ralf Hortt
 */
if (!class_exists( 'WP_Widget_Contact' )) :
    class WP_Widget_Contact extends WP_Widget
    {



        /**
     * Constructor
     *
     * @since v1.0
     * @author Ralf Hortt
     */
        function __construct()
        {

            $widget_ops = array(
            'classname' => 'widget-contact',
            'description' => __( 'Kontakt', 'TEXTDOMAIN' ),
            );
            $control_ops = array( 'id_base' => 'widget-contact' );
            parent::__construct( 'widget-contact', __( 'Kontakt', 'TEXTDOMAIN' ), $widget_ops, $control_ops );
        }



        /**
     * Output
     *
     * @param array $args Arguments
     * @param array $instance Widget instance
     * @since v1.0.12
     * @author Ralf Hortt
     */
        function widget($args, $instance)
        {

            $company = get_theme_mod( 'company' );
            $zip = get_theme_mod( 'zip' );
            $city = get_theme_mod( 'city' );
            $street = get_theme_mod( 'street' );
            $streetnumber = get_theme_mod( 'streetnumber' );
            $phone = get_theme_mod( 'phone' );
            $fax = get_theme_mod( 'fax' );
            $email = get_theme_mod( 'email' );

            echo $args['before_widget'];

            if ($company) {
                printf( '<strong class="company">%s</strong>', $company );
            }
            if ($zip) {
                printf( '%s %s, %s %s<br><br>', $street, $streetnumber, $zip, $city );
            }
            if ($phone) {
                printf( 'Tel.: %s<br>', $phone );
            }
            if ($fax) {
                printf( 'Fax: %s<br>', $fax );
            }
            if ($email) {
                printf( 'E-Mail: <a href="mailto:%s">%s</a>', $email, $email );
            }

            echo $args['after_widget'];
        }



        /**
     * Save widget settings
     *
     * @param array $new_instance New widget instance
     * @param array $old_instance Old widget instance
     * @since v1.0.12
     * @author Ralf Hortt
     */
        function update($new_instance, $old_instance)
        {
        }



        /**
     * Widget settings
     *
     * @param array $instance Widget instance
     * @since v1.0.12
     * @author Ralf Hortt
     */
        function form($instance)
        {
        }
    } // end WP_Widget_Contact
endif;
