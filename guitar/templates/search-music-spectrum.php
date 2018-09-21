<?php
/**
 * Template Name: 曲谱搜索页
 *
 * @package WordPress
 */


get_header(); ?>
<?php

// 公共参数
global $paged;
$paged  = $paged ?: 1;
$params = [
    'hide_empty'     => false,
    'parent'         => 0,
    'posts_per_page' => 10,
    'paged'          => $paged,
];

if ($_GET['search']) {
    $params['s'] = $_GET['search'];
}

$guitarMusicSpectrumHtml = getGuitarMusicSpectrum($params);

?>
<style>
    .pagination {
        overflow: hidden;
        text-align: center;
        margin-top: 20px
    }

    .pagination .btn-next, .pagination .btn-prev, .pagination .pager {
        display: inline-block
    }

    .pagination .pager {
        overflow: hidden;
        vertical-align: top;
        font-size: 0
    }

    .pagination .pager li {
        float: left;
        height: 40px;
        line-height: 40px;
        text-align: center;
        border: 1px solid #bbb;
        padding: 0 16px;
        margin: 0 10px;
        cursor: pointer
    }

    .pagination .pager li.active {
        border-color: #cdaf6e
    }

    .pagination .pager li.active a {
        color: #cdaf6e
    }

    .pagination .pager li.more {
        border: none;
        font-size: 26px;
        color: #999;
        line-height: 26px;
        padding: 0;
        cursor: default
    }

    .pagination .pager li a {
        font-size: 16px;
        color: #bbb
    }

    .pagination .btn-next, .pagination .btn-prev {
        width: 40px;
        height: 40px;
        line-height: 40px;
        text-align: center;
        background: #cdaf6e;
        position: relative;
        top: 1px;
        cursor: pointer;
        outline: none
    }

    .pagination .btn-next img, .pagination .btn-prev img {
        vertical-align: sub
    }

    .pagination .btn-next[disabled=disabled], .pagination .btn-prev[disabled=disabled] {
        background: #eee;
        cursor: no-drop
    }

    .pagination .btn-prev {
        margin-right: 20px
    }

    .pagination .btn-next {
        margin-left: 20px
    }
</style>
    <script type="text/javascript" src="/wp-content/themes/CIA/dist/js/searchMusicSpectrum.bundle.js"></script>
    <section class="main">
        <section class="search-wrap" id="searchWrap">
            <div class="center">
                <form action="<?php echo get_permalink(); ?>"><input type="text" id="searchInput" class="search-input" name="search"
                             value="<?php echo $_GET['search']; ?>" placeholder="输入曲谱名称，如: 你就不要想起我…"> <input
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
        <div class="search-res">
            <ul>
                <?php echo $guitarMusicSpectrumHtml; ?>
            </ul>
        </div>
        <!-- <div class="search-no">            <p class="tips">暂无收录此数据～</p>            <button type="button" class="feedback-btn">缺谱反馈</button>        </div> -->
    </section>
<?php get_footer(); ?>