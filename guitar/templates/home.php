<?php
/**
 * Template Name: 首页
 *
 * @package WordPress
 */


get_header(); ?>

<?php

// 曲谱参数
$musicSpectrumParm = [
    'post_type'      => 'music_spectrum',
    'hide_empty'     => false,
    'parent'         => 0,
    'posts_per_page' => 10,
];
// 最新曲谱
$musicSpectrumParm['orderby'] = 'date';
$newPostsHtml                 = HTMLGeneratedByMusicSpectrumArray($musicSpectrumParm);

// 最热曲谱
$musicSpectrumParm['meta_key'] = 'music_spectrum_views_count';
$musicSpectrumParm['orderby']  = 'meta_value_num';
$hotPostsHtml                  = HTMLGeneratedByMusicSpectrumArray($musicSpectrumParm);

// 资讯参数
$guitarNewsParm = [
    'post_type'      => 'guitar_news',
    'hide_empty'     => false,
    'parent'         => 0,
    'posts_per_page' => 8,
    'meta_key'       => 'guitar_news_views_count',
    'orderby'        => 'meta_value_num',
    'post_mime_type' => 'text/html',
];
$guitarNewsHtml = HTMLGeneratedByGuitarNewsArray($guitarNewsParm);

// 获取有官方授权权限的用户
$userParm          = [
    'role'   => 'Administrator',
    'fields' => 'ID'
];
$authorizedUsersId = get_users($userParm);
// 官方出品视频的参数
$guitarVideoParm = [
    'post_type'      => 'guitar_news',
    'hide_empty'     => false,
    'parent'         => 0,
    'posts_per_page' => 8,
    'meta_key'       => 'guitar_news_views_count',
    'orderby'        => 'meta_value_num',
    'post_mime_type' => 'video/mp4',
    'meta_query'     => [
        'key'     => 'upload_by',
        'compare' => '=',
        'value'   => '',
    ]
];
$guitarVideoHtml = '';
if ($authorizedUsersId) {
    $guitarVideoParm['author__in'] = $authorizedUsersId;
    $guitarVideoQuery              = new WP_Query($guitarVideoParm);
    if ($guitarVideoQuery->have_posts()) {
        while ($guitarVideoQuery->have_posts()) {
            $guitarVideoQuery->the_post();
            $currentVideoObject = $guitarVideoQuery->post;
            $guitarVideoHtml    .= getGuitarNewsHTMLByGuitarNewsObject($currentVideoObject);
        }
        wp_reset_postdata();
    }
}

?>

    <section class="main">
        <section class="banner-wrap"><h1 class="title">少研究器材，多和音乐做朋友</h1>
            <section class="search-wrap" id="searchWrap">
                <div class="center">
                    <form action="<?php echo esc_url(get_permalink(272)); ?>"><input type="text" id="searchInput"
                                                                                     name="search" class="search-input"
                                                                                     placeholder="吉他产品数据、精彩视频、曲谱、资讯…">
                        <input
                                type="submit" value="搜索" class="submit-search-btn">
                        <div class="search-box">
                            <div class="history">最近搜索</div>
                            <ul>
                                <li><a href="#"> <span>你就不要想</span> <b>起我</b> </a></li>
                                <li><a href="#"> <span>你就不要想</span> <b>起我</b> </a></li>
                                <li><a href="#"> <span>你就不要想</span> <b>起我</b> </a></li>
                                <li><a href="#"> <b>起我</b> </a></li>
                                <li><a href="#"> <b>起我</b> </a></li>
                            </ul>
                        </div>
                    </form>
                </div>
            </section>
        </section>
        <section class="section-item one">
            <section class="top"><h3>官方出品</h3></section>
            <section class="content-wrap">
                <ul>
                    <?php echo $guitarVideoHtml; ?>
                </ul>
            </section>
        </section>
        <section class="section-item section-item-rowX5">
            <section class="top"><h3>最新曲谱</h3></section>
            <section class="content-wrap">
                <ul>
                    <?php echo $newPostsHtml; ?>
                </ul>
            </section>
        </section>
        <section class="section-item section-item-rowX5">
            <section class="top"><h3>最热曲谱</h3></section>
            <section class="content-wrap">
                <ul>
                    <?php echo $hotPostsHtml; ?>
                </ul>
            </section>
        </section>
        <section class="section-item">
            <section class="top"><h3>行业新闻</h3></section>
            <section class="content-wrap">
                <ul>
                    <?php echo $guitarNewsHtml; ?>
                </ul>
            </section>
        </section>
    </section>

<?php get_footer(); ?>