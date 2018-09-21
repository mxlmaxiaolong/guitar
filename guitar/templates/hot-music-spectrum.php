<?php
/**
 * Template Name: 最热曲谱
 *
 * @package WordPress
 */


get_header(); ?>

<?php
// 最热曲谱
$musicSpectrumParm = [
    'post_type'  => 'music_spectrum',
    'hide_empty' => false,
    'parent'     => 0,
    'meta_key'   => 'music_spectrum_views_count',
    'orderby'    => 'meta_value_num'
];
$hotPostsHtml      = HTMLGeneratedByMusicSpectrumArray($musicSpectrumParm);


?>


    <section class="main">
        <h1 class="h1-title">
            最热曲谱
        </h1>
        <section class="section-item section-item-rowX5 mg-top30">
            <section class="content-wrap">
                <ul>
                    <?php echo $hotPostsHtml; ?>
                </ul>
            </section>
        </section>
    </section>
    <script type="text/javascript" src="/wp-content/themes/CIA/dist/js/hotMusicSpectrum.bundle.js"></script>

<?php get_footer(); ?>