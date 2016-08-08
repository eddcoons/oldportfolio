<?php

add_shortcode('text', 'zorbix_text' );
function zorbix_text($atts, $content = null)
{

    $v = array(
        'padding' => '',
        'padding_top' => '',
        'padding_right' => '',
        'padding_bottom' => '',
        'padding_left' => '',
    );

    $v = shortcode_atts($v, $atts);

    $output = sprintf('<div %s>',
        zorbix_sc::get_format_style_esc_multi(array(
            'padding' => $v['padding'],
            'padding-top' => $v['padding_top'],
            'padding-right' => $v['padding_right'],
            'padding-bottom' => $v['padding_bottom'],
            'padding-left' => $v['padding_left'],
        ))
    );

    $output .= do_shortcode($content);

    $output .= '</div>';

    return $output;

}