<?php
/**
 * Get svg content
 *
 * @param string $svg SVG Path
 * @return string SVG content
 * @author Ralf Hortt
 **/
function get_svg($svg)
{
    if (is_numeric( $svg )) :
        $svg = get_attached_file( $svg );
    endif;

    if (false === $file = get_transient( "svg-$svg" )) :
        if ('.svg' != substr( $svg, -4, 4 )) :
            throw new Exception( 'svg() only accepts .svg files' );
        endif;

        $file = ( '/' == $svg[0] ) ? $svg : get_stylesheet_directory() . '/dist/img/' . $svg;

        if (!file_exists( $file )) :
            throw new Exception( "File $file does not exist" );
        endif;

        $file = file_get_contents( $file );

        set_transient( "svg-$svg", $file, 1 );
    endif;

    return $file;
}
