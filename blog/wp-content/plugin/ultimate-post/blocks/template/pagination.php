<?php
defined('ABSPATH') || exit;
$page_post_id = (isset($attr['currentPostId']) &&  $attr['currentPostId'])  ? $attr['currentPostId'] : ultimate_post()->get_page_post_id(ultimate_post()->get_ID(), $attr['blockId']);
$self_post_id = 'data-selfpostid="' .( (isset($attr['currentPostId']) &&  $attr['currentPostId']) ? "yes" : "no"). '"';
$wraper_after .= '<div class="ultp-pagination-wrap'.($attr["paginationAjax"] ? " ultp-pagination-ajax-action" : "").'" data-paged="1" data-blockid="'.$attr['blockId'].'" data-postid="'.$page_post_id.'" data-pages="'.$pageNum.'" data-blockname="ultimate-post_'.$block_name.'" '.ultimate_post()->get_builder_attr($attr['queryType']).$self_post_id.'>';
    $wraper_after .= ultimate_post()->pagination($pageNum, $attr['paginationNav'], $attr['paginationText'], $attr["paginationAjax"]);
$wraper_after .= '</div>';