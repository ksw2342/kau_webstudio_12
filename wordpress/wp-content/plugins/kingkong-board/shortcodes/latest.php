<?php

add_shortcode("kingkong_board_latest","kingkong_board_latest");
function kingkong_board_latest($attr){

  do_action('kingkongboard_latest_display_before', $attr);

  $title           = $attr['title'];
  $skin            = $attr['skin'];
  $number          = $attr['number'];
  $length          = $attr['length'];
  $board_id        = $attr['board_id'];

  $kingkongboard  = new kkbLatest($board_id);
  $latests        = $kingkongboard->kkb_get_latest_list($number);

  $summary        = apply_filters('kkb_latest_summary', sprintf(__('%s 게시판의 제목과 날짜를 제공하는 최신글 표', 'kingkongboard'), get_the_title($board_id)), $board_id);

  $latest_priority = apply_filters('kingkongboard_latest_priority', array('title', 'date'), $attr);

  ob_start();
    include_once( kkb_template_path( "view.latest.php" ) );
    $latest_content = ob_get_contents();
  ob_get_clean();

  return apply_filters('kingkongboard_latest_after', $latest_content, $latests, $attr);

}

?>