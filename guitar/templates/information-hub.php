<?php
/**
 * Template Name: 资讯
 *
 * @package WordPress
 */


get_header(); ?>

<?php

// 资讯参数
$guitarNewsParm = [
    'post_type'      => 'guitar_news',
    'hide_empty'     => false,
    'parent'         => 0,
    'posts_per_page' => 16,
    'meta_key'       => 'guitar_news_views_count',
    'orderby'        => 'meta_value_num',
];

if ($_GET['search']) {
    $guitarNewsParm['s'] = $_GET['search'];
}

if (get_the_ID() == '88') {
    $guitarNewsParm['post_mime_type'] = 'video/mp4';
    $guitarNewsPageJs                 = '/wp-content/themes/CIA/dist/js/informationVideo.bundle.js';
} else {
    $guitarNewsParm['post_mime_type'] = 'text/html';
    $guitarNewsPageJs                 = '/wp-content/themes/CIA/dist/js/informationArticle.bundle.js';
}

$guitarNewsHtml = HTMLGeneratedByGuitarNewsArray($guitarNewsParm);

?>

    <section class="main">
        <section class="search-wrap" id="searchWrap">
            <div class="center">
                <form><input type="text" id="searchInput" class="search-input" name="search"
                             value="<?php echo $_GET['search']; ?>" placeholder="输入资讯名称，如你就不要想起我…"> <input
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
        <section class="infor-menu clearfix">
            <ul>
                <li <?php if (get_the_ID() == 88) {
                    echo 'class="active"';
                } ?>><a href="<?php echo get_permalink(88); ?>?search=<?php echo $_GET['search']; ?>">精彩视频</a></li>
                <li <?php if (get_the_ID() == 116) {
                    echo 'class="active"';
                } ?>><a href="<?php echo get_permalink(116); ?>?search=<?php echo $_GET['search']; ?>">热门文章</a></li>
            </ul>
        </section>
        <section class="information-list">
            <section class="section-item one">
                <section class="content-wrap">
                    <ul>
                        <?php echo $guitarNewsHtml; ?>
                    </ul>
                </section>
            </section>
        </section>
    </section>

    <script type="text/javascript" src="<?php echo $guitarNewsPageJs; ?>"></script>

<?php get_footer(); ?>