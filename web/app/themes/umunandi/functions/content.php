<?php
// Get template type - list copied from src/wp-includes/template-loader.php
function umunandi_get_template_type() {
  $template_type = 'index';
  if     (is_embed()            ) : $template_type = 'embed';
  elseif (is_404()              ) : $template_type = '404';
  elseif (is_search()           ) : $template_type = 'search';
  elseif (is_front_page()       ) : $template_type = 'front-page';
  elseif (is_home()             ) : $template_type = 'home';
  elseif (is_post_type_archive()) : $template_type = 'archive';
  elseif (is_tax()              ) : $template_type = 'taxonomy';
  elseif (is_attachment()       ) : $template_type = 'attachment';
  elseif (is_page()             ) : $template_type = 'page';
  elseif (is_singular()         ) : $template_type = 'singular';
  elseif (is_category()         ) : $template_type = 'category';
  elseif (is_tag()              ) : $template_type = 'tag';
  elseif (is_author()           ) : $template_type = 'author';
  elseif (is_date()             ) : $template_type = 'date';
  elseif (is_archive()          ) : $template_type = 'archive';
  endif;
  return $template_type;
}

// Image tag without dimensions
function wp_get_image_tag($attach_id, $size, $icon, $alt = '') {
  if ($src = wp_get_attachment_image_src($attach_id, $size, $icon)) {
    return sprintf('<img src="%s" alt="%s" />', $src[0], $alt);
  }
}

// Use featured image as css background-image
// Returns 'style="background-image: url(path/to/image);"' if post featured image is set
function umunandi_featured_image_bg_style($isRandom = false) {
  $bg_style = 'style="background-image: url(%s);"';
  if ($isRandom) {
    return sprintf($bg_style, 'http://lorempixel.com/900/500/people');
  }
  if ($bg_img = (wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'))) {
    return sprintf($bg_style, wp_make_link_relative($bg_img[0]));
  }
}

// Force 404 on hidden pages
function umunandi_force_404() {
  global $post;
  if ($post->post_parent && get_post_meta($post->post_parent, 'hide_child_pages')) {
    global $wp_query;
    $wp_query->set_404();
    status_header(404);
  }
}
add_action('wp', 'umunandi_force_404');

function umunandi_split_sentence($sentence, $line_count = 2) {
  $words = explode(" ", $sentence);
  $av_word_length = strlen($sentence) / count($words);
  $max_line_length = (strlen($sentence) / $line_count) + $av_word_length / 2;
  return explode("\n", wordwrap($sentence, $max_line_length));
}
