<?php

/**
 * Custom Slider Template
 *
 * @package CustomMapACf
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;
$slides = get_field('slides') ?: 'slides..'; ?>

<section class="banner">
  <div class="container">
    <div class="banner__slider">
      <?php
      foreach ($slides as $key => $slide) {
        $image = $slide['banner_img'] ? wp_get_attachment_image($slide['banner_img'], 'full') : '<img src=' .  get_template_directory_uri() . '/assets/image/teatr-muzyczny-zdjecie.webp' . ' alt="alternative_name">';
        $title_banner = $slide['titile_banner'] ?: 'Your titile here...';
        $title =  $key ? '<h2 class="slide__content_title">' . $title_banner . '</h2>' : '<h1 class="slide__content_title">' . $title_banner . '</h1>';
        $banner_descr = $slide['descr_banner'] ? $slide['descr_banner'] : 'Description banner..';
        $trim_word_descr = 50;
        $descr_count = wp_trim_words($banner_descr, $trim_word_descr);
        echo '<div class="banner__slider_slide slide">
        <div class="slide__img">' .
          $image .
          '</div>
        <div class="slide__content">
          <p class="slide__content_pre-title">' . $slide['pre_title'] . '</p>' .
          $title . '<p class="slide__content_descr">' . $descr_count . '</p>
        </div>
      </div>';
      }
      ?>
    </div>
  </div>
</section>