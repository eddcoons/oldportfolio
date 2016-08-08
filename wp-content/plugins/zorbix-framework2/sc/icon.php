<?php

add_shortcode('icon', 'zorbix_icon');
function zorbix_icon($atts)
{

    $default_atts = array(
        'link' => '',
        'size' => '',
        'style' => '',
        'spacing' => 'm-5'
    );

    $default_atts = array_merge($default_atts, zorbix_sc::get_icon_atts());
    $default_atts = zorbix_sc::get_attr_set($default_atts, array('margin', 'padding'));

    $atts = shortcode_atts($default_atts, $atts);

    $atts = zorbix_sc::icon($atts);

    $class = zorbix::join(
        $atts['size'],
        $atts['style'],
        $atts['spacing']
    );

    $html = zorbix_sc::get_opening_anchor($atts['link'], 'zx-icon-wrap');
    $html .= zorbix_sc::get_print_icon($atts, '', $class);
    $html .= zorbix_sc::get_closing_anchor($atts['link']);

    return $html;
}
