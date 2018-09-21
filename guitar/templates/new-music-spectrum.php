<?php
/**
 * Template Name: 最新曲谱
 *
 * @package WordPress
 */


get_header(); ?>

<?php

// 最新曲谱
$newPosts    = get_posts([
    'post_type'      => 'music_spectrum',
    'hide_empty'     => false,
    'parent'         => 0,
    'orderby'        => 'date',
    'posts_per_page' => 40
]);
$ArrayByDate = [];
foreach ($newPosts as $postObject) {
    $currentNewPostTime = strtotime($postObject->post_date);

    // 根据年月组装数组
    $currentNewPostKey                 = date('Y-m月', $currentNewPostTime);
    $ArrayByDate[$currentNewPostKey][] = getMusicSpectrumHTMLByMusicSpectrumObject($postObject);
}

$postsHtml = '';
foreach ($ArrayByDate as $date => $value) {
    $liHtml    = implode('', $value);
    $postsHtml .= "<section class=\"section-item section-item-rowX5 mg-top30\"><section class=\"top\"><h3>{$date}</h3></section><section class=\"content-wrap\"><ul>{$liHtml}</ul></section></section>";
}


?>


    <section class="main">
        <h1 class="h1-title">
            最新曲谱
        </h1>
        <?php echo $postsHtml; ?>
    </section>
    <div class="footer-msg">
        别拖啦～到底啦！
    </div>
    <script type="text/javascript" src="/wp-content/themes/CIA/dist/js/newMusicSpectrum.bundle.js"></script>

<?php get_footer(); ?>