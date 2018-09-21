<?php
/**
 * Template Name: 曲谱
 *
 * @package WordPress
 */


get_header(); ?>

<?php

// 曲谱参数
$musicSpectrumParm = [
    'post_type'  => 'music_spectrum',
    'hide_empty' => false,
    'parent'     => 0,
];
// 最新曲谱
$musicSpectrumParm['orderby']        = 'date';
$musicSpectrumParm['posts_per_page'] = 5;
$newPostsHtml                        = HTMLGeneratedByMusicSpectrumArray($musicSpectrumParm);

// 最热曲谱
$musicSpectrumParm['meta_key']       = 'music_spectrum_views_count';
$musicSpectrumParm['orderby']        = 'meta_value_num';
$musicSpectrumParm['posts_per_page'] = 10;
$hotPostsHtml                        = HTMLGeneratedByMusicSpectrumArray($musicSpectrumParm);

// 读取轮播图
$slideArray = get_field('music_spectrum_slide');
$slideHtml  = '';
foreach ($slideArray as $slide) {
    $slideHtml .= "<div class=\"swiper-slide\"><img width=\"900\" src=\"{$slide["Image"]}\"/></div>";
}

// 获取最新曲谱和最热曲谱的页面链接
$pageParm                = [
    'post_type'    => 'page',
    'hierarchical' => 0,
    'meta_key'     => '_wp_page_template',
    'meta_value'   => 'templates/new-music-spectrum.php'
];
$newMusicSpectrumPageUrl = getTheFirstPageUrlByTemplatesParm($pageParm);

$pageParm['meta_value']  = 'templates/hot-music-spectrum.php';
$hotMusicSpectrumPageUrl = getTheFirstPageUrlByTemplatesParm($pageParm);
?>


    <section class="main">
        <section class="search-wrap" id="searchWrap">
            <div class="center">
                <form action="<?php echo esc_url(get_permalink(277)); ?>"><input type="text" id="searchInput"
                                                                                 class="search-input" name="search"
                                                                                 placeholder="输入曲谱名称，如你就不要想起我…"> <input
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
        <div id="certify">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <?php echo $slideHtml; ?>
                </div>
            </div>
            <div class="swiper-pagination">
            </div>
            <div class="swiper-button-prev">
            </div>
            <div class="swiper-button-next">
            </div>
        </div>
        <section class="section-item section-item-rowX5 mg-top78">
            <section class="top">
                <h3 class="fl">
                    <a href="<?php echo $newMusicSpectrumPageUrl; ?>">
                        最新曲谱
                        <img style="vertical-align: sub;" width="24" height="24"
                             src="/wp-content/themes/CIA/dist/images/b8646e86a142564caa4576f6cef6cb14.png"
                             alt="">
                    </a>
                </h3>
                <p class="fr tips">
                    开通VIP，尊享所有曲谱高清去广告下载，首开仅需8元！
                </p>
            </section>
            <section class="content-wrap">
                <ul>
                    <?php echo $newPostsHtml; ?>
                </ul>
            </section>
        </section>
        <section class="section-item section-item-rowX5 mg-top40">
            <section class="top">
                <h3 class="fl">
                    <a href="<?php echo $hotMusicSpectrumPageUrl; ?>">
                        最热曲谱
                        <img style="vertical-align: sub;" width="24" height="24"
                             src="/wp-content/themes/CIA/dist/images/b8646e86a142564caa4576f6cef6cb14.png"
                             alt="">
                    </a>
                </h3>
            </section>
            <section class="content-wrap">
                <ul>
                    <?php echo $hotPostsHtml; ?>
                </ul>
            </section>
        </section>
        <section class="user-wrap">
            <section class="top">
                <h3>
                    制谱达人
                </h3>
            </section>
            <ul>
                <li>
                    <img class="head"
                         src="http://p3.music.126.net/91rRthaugmYxlqyyMdO1vA==/109951163433331023.jpg?param=110y110"
                         alt="">
                    <p class="name">
                        一束花菜
                    </p>
                    <p class="upload-num">
                        已上传20首
                    </p>
                </li>
                <li>
                    <img class="head"
                         src="http://p3.music.126.net/gK0nqK8iiG1o6axkHmmqrQ==/109951163416312552.jpg?param=110y110"
                         alt="">
                    <p class="name">
                        一束花菜
                    </p>
                    <p class="upload-num">
                        已上传20首
                    </p>
                </li>
                <li>
                    <img class="head"
                         src="http://p3.music.126.net/38yIb-71lSD8m5_FTQNmNA==/109951163432626976.jpg?param=110y110"
                         alt="">
                    <p class="name">
                        一束花菜
                    </p>
                    <p class="upload-num">
                        已上传20首
                    </p>
                </li>
                <li>
                    <img class="head"
                         src="http://p4.music.126.net/oBYV6JMh2wjlBjBrWmqHQQ==/109951163428139283.jpg?param=110y110"
                         alt="">
                    <p class="name">
                        一束花菜
                    </p>
                    <p class="upload-num">
                        已上传20首
                    </p>
                </li>
                <li>
                    <img class="head"
                         src="http://p4.music.126.net/EsiOYTWHV1AjORq2K-BgYg==/109951163428183887.jpg?param=110y110"
                         alt="">
                    <p class="name">
                        一束花菜
                    </p>
                    <p class="upload-num">
                        已上传20首
                    </p>
                </li>
                <li>
                    <img class="head"
                         src="http://p3.music.126.net/p-ylHyVvXXh1ndCB2vMGbA==/109951163422875632.jpg?param=110y110"
                         alt="">
                    <p class="name">
                        一束花菜
                    </p>
                    <p class="upload-num">
                        已上传20首
                    </p>
                </li>
            </ul>
        </section>
    </section>
    <script src="https://aliblog-1254407033.cos.ap-guangzhou.myqcloud.com/swiper.min.js"></script>
    <script type="text/javascript" src="/wp-content/themes/CIA/dist/js/musicSpectrum.bundle.js"></script>

<?php get_footer(); ?>