<?php
/**
 * Template Name: 吉他数据库
 *
 * @package WordPress
 */


get_header(); ?>

<?php


$getParm        = $_GET;
$getParmTheName = [];
unset($getParm['page_id']);
$filteHtml  = '';
$filterParm = [
    'guitar_brand'  => '品牌',
    'guitar_shape'  => '桶型',
    'guitar_color'  => '颜色',
    'guitar_origin' => '产地',
    'guitar_type'   => '类型',
    'guitar_price'  => '价格'
];
foreach ($filterParm as $parm => $title) {
    if ($parm == 'guitar_price') {
        $terms = [
            (object)[
                'slug' => '0-499',
                'name' => '0-499',
            ],
            (object)[
                'slug' => '500-999',
                'name' => '500-999',
            ],
            (object)[
                'slug' => '1000-1999',
                'name' => '1000-1999',
            ],
            (object)[
                'slug' => '2000-3999',
                'name' => '2000-3999',
            ],
            (object)[
                'slug' => '4000',
                'name' => '4000以上',
            ]
        ];
    } else {
        $terms = get_terms([
            'taxonomy'   => $parm,
            'hide_empty' => false,
            'parent'     => 0
        ]);
    }
    if ($terms) {
        // 生成url
        $cascadeUrl = get_permalink();
        if ($getParm) {
            $cascadeUrlParm = $getParm;
            // 不包含当前参数
            unset($cascadeUrlParm[$parm]);
            $cascadeUrlParm = http_build_query($cascadeUrlParm);
            $cascadeUrl     .= $cascadeUrlParm ? "?{$cascadeUrlParm}" : '';
        }

        $filteHtml .= "<dl><dt>{$title}</dt>";
        foreach ($terms as $term) {
            $currentTermslug = $term->slug;
            $currentTermName = $term->name;
            // 把已选条件的名称存到数组里
            if (urldecode($currentTermslug) == $getParm[$parm]) {
                $getParmTheName[$parm] = $currentTermName;
            }
            $currentTermUrl = $cascadeUrlParm ? "{$cascadeUrl}&{$parm}={$currentTermslug}" : "{$cascadeUrl}?{$parm}={$currentTermslug}";
            $filteHtml      .= "<dd><a href=\"{$currentTermUrl}\">{$currentTermName}</a></dd>";
        }
        if ($parm == 'guitar_price') {
            $filteHtml .= '<dd class="price-form-dd"><form action=""><input class="input-text" name="price" type="text" placeholder="￥"> <span>-</span><input class="input-text" name="price" type="text" placeholder="￥"><input type="submit" style="display:none;"></form></dd></dl>';
        } else {
            $filteHtml .= "<dd class=\"more\" data-off=\"0\">更多<img width=\"14\" height=\"14\" src=\"/wp-content/themes/CIA/dist/images/29d0be3ebfe64e16d92c92ffb016ff4d.png\" alt=\"\"></dd></dl>";
        }
    }
}
$search = '';
// 存在联动查询的参数时读取吉他，不存在时读取热门品牌
if ($getParm) {
    // 吉他参数
    $guitarParm = [
        'post_type'      => 'guitar',
        'hide_empty'     => false,
        'parent'         => 0,
        'orderby'        => 'date',
        'posts_per_page' => 40
    ];
    // 标题关键字
    if ($getParm['search']) {
        $search = $guitarParm['s'] = $getParm['search'];
        unset($getParm['search']);
    }
    // 已选条件
    $selectedConditionsHtml = '';
    foreach ($getParm as $parm => $value) {
        if ($parm != 'search') {
            if ($parm == 'guitar_price') {
                $priceParm                  = explode('-', $value);
                $guitarParm['meta_query'][] = [
                    'key'     => 'reference_price',
                    'compare' => 'BETWEEN',
                    'value'   => $priceParm
                ];
            } else {
                $guitarParm['tax_query'][] = [
                    'taxonomy' => $parm,
                    'field'    => 'slug',
                    'terms'    => $value
                ];
            }
            $currentCascadeUrl     = get_permalink();
            $currentCascadeUrlParm = $getParm;
            // 不包含当前参数
            unset($currentCascadeUrlParm[$parm]);
            $currentCascadeUrlParm = http_build_query($currentCascadeUrlParm);
            $currentCascadeUrl     .= $currentCascadeUrlParm ? "?{$currentCascadeUrlParm}" : '';

            $currentTermName        = $getParmTheName[$parm];
            $selectedConditionsHtml .= "<dd>{$currentTermName} <a href=\"{$currentCascadeUrl}\" class=\"close\"> <img width=\"8\" height=\"8\" src=\"/wp-content/themes/CIA/dist/images/d2b980bff2636e0daf95e8a3a67b8955.png\" alt=\"\"> </a></dd>";
        }
    }
    $guitarQuery = new WP_Query($guitarParm);
    $guitarArray = $guitarQuery->posts;
    // $guitarArray = get_posts($guitarParm);
    $guitarHtml  = '';
    foreach ($guitarArray as $guitarObject) {
        $currentGuitarName = $guitarObject->post_title;
        $currentGuitarImg  = get_field('guitar_main_img', $guitarObject->ID);
        $currentGuitarLink = esc_url(get_permalink($guitarObject->ID));
        // 吉他参考价格
        $currentGuitarPrice = get_field('reference_price', $guitarObject->ID);
        $currentGuitarPrice = $currentGuitarPrice ? "¥ {$currentGuitarPrice}" : '';
        $guitarHtml         .= "<li><a href=\"{$currentGuitarLink}\"><img width=\"208\" height=\"208\" src=\"{$currentGuitarImg}\" alt=\"\"><p class=\"name text-ellipsis\">{$currentGuitarName}</p><span class=\"price\">{$currentGuitarPrice}</span></a></li>";
    }
    $paginationHtml = get_the_search_result_pagination($guitarQuery);
    wp_reset_postdata();
} else {
    $terms = get_terms([
        'taxonomy'   => 'guitar_brand',
        'hide_empty' => false,
        'parent'     => 0
    ]);

    $brandHtml = "";
    foreach ($terms as $term) {
        $currentItemName = $term->name;
        $currentItemImg  = get_field('band_image', 'guitar_brand_' . $term->term_id);
        $currentItemLink = '/?guitar_brand=' . $term->slug;
        $brandHtml       .= "<li><a href=\"{$currentItemLink}\"> <div class=\"img\"><img src=\"{$currentItemImg}\" alt=\"\"></div> <p class=\"name\">{$currentItemName}</p></a></li> <li>";
    }
}


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

    <section class="main">
        <section class="search-wrap" id="searchWrap">
            <div class="center">
                <form><input type="text" id="searchInput" class="search-input" name="search"
                             value="<?php echo $search; ?>" placeholder="吉他产品数据、精彩视频、曲谱、资讯…"> <input
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
        <section class="filter-wrap">
            <div class="filter-list" id="filterList">
                <?php echo $filteHtml; ?>
                <!-- <dl>
                    <dt>品牌</dt>
                    <dd><a href="#">Randon蓝盾</a></dd>
                    <dd><a href="#">YAMAHA雅马哈</a></dd>
                    <dd><a href="#">Mayson曼森</a></dd>
                    <dd><a href="#">Magic麦杰克</a></dd>
                    <dd><a href="#">TYMA泰玛</a></dd>
                    <dd><a href="#">LEGPAP莱柏</a></dd>
                    <dd><a href="#">LAVA拿火</a></dd>
                    <dd><a href="#">Randon蓝盾</a></dd>
                    <dd><a href="#">YAMAHA雅马哈</a></dd>
                    <dd><a href="#">Mayson曼森</a></dd>
                    <dd><a href="#">Magic麦杰克</a></dd>
                    <dd><a href="#">TYMA泰玛</a></dd>
                    <dd><a href="#">LEGPAP莱柏</a></dd>
                    <dd><a href="#">LAVA拿火</a></dd>
                    <dd class="more" data-off="0">更多<img width="14" height="14"
                                                         src="/wp-content/themes/CIA/dist/images/29d0be3ebfe64e16d92c92ffb016ff4d.png"
                                                         alt=""></dd>
                </dl>
                <dl>
                    <dt>桶型</dt>
                    <dd><a href="#">A桶</a></dd>
                    <dd><a href="#">O桶</a></dd>
                    <dd><a href="#">D桶</a></dd>
                    <dd><a href="#">OM桶</a></dd>
                    <dd><a href="#">GA桶</a></dd>
                    <dd><a href="#">R桶</a></dd>
                    <dd><a href="#">GC桶</a></dd>
                    <dd><a href="#">AJ桶</a></dd>
                    <dd><a href="#">Jumbo桶</a></dd>
                    <dd><a href="#">MINI</a></dd>
                </dl>
                <dl>
                    <dt>颜色</dt>
                    <dd><a href="#">原木色</a></dd>
                    <dd><a href="#">复古色</a></dd>
                    <dd><a href="#">日落色</a></dd>
                    <dd><a href="#">黑色</a></dd>
                    <dd><a href="#">樱桃红</a></dd>
                    <dd><a href="#">其他颜色</a></dd>
                </dl>
                <dl>
                    <dt>产地</dt>
                    <dd><a href="#">中国</a></dd>
                    <dd><a href="#">德国</a></dd>
                    <dd><a href="#">意大利</a></dd>
                    <dd><a href="#">法国</a></dd>
                </dl>
                <dl>
                    <dt>类型</dt>
                    <dd><a href="#">合板</a></dd>
                    <dd><a href="#">面背单</a></dd>
                    <dd><a href="#">全单</a></dd>
                    <dd><a href="#">复合材料</a></dd>
                </dl>
                <dl>
                    <dt>价格</dt>
                    <dd><a href="#">0-499</a></dd>
                    <dd><a href="#">500-999</a></dd>
                    <dd><a href="#">1000-1999</a></dd>
                    <dd><a href="#">2000-3999</a></dd>
                    <dd><a href="#">4000以上</a></dd>
                    <dd class="price-form-dd">
                        <form action=""><input class="input-text" name="price" type="text" placeholder="￥"> <span>-</span>
                            <input class="input-text" name="price" type="text" placeholder="￥"> <input type="submit"
                                                                                                       style="display:none;">
                        </form>
                    </dd>
                </dl> -->
            </div>
            <div class="selected-list">
                <dl>
                    <!-- <dt>已选条件</dt>
                    <dd>Randon蓝盾 <i class="close"> <img width="8" height="8"
                                                        src="/wp-content/themes/CIA/dist/images/d2b980bff2636e0daf95e8a3a67b8955.png"
                                                        alt=""> </i></dd>
                    <dd>原木色<i class="close"> <img width="8" height="8"
                                                  src="/wp-content/themes/CIA/dist/images/d2b980bff2636e0daf95e8a3a67b8955.png"
                                                  alt=""> </i></dd>
                    <dd>巴西玫瑰木<i class="close"> <img width="8" height="8"
                                                    src="/wp-content/themes/CIA/dist/images/d2b980bff2636e0daf95e8a3a67b8955.png"
                                                    alt=""> </i></dd> -->
                    <?php echo $selectedConditionsHtml; ?>
                </dl>
            </div>
            <a href="javascript:void(0);" id="switch" class="switch" data-off="0"><span class="text">收起</span><img
                        width="14" height="14"
                        src="/wp-content/themes/CIA/dist/images/9981158fa983bdce807a4013d12e650d.png"
                        alt=""></a></section>
        <?php if ($getParm || $search) { ?>
            <section class="guitar-list" style="display: block;">
                <ul>
                    <?php echo $guitarHtml; ?>
                    <!-- <li><a href="#"> <img width="208" height="208"
                                          src="https://static.jishida.vip/upload/shop_list_pic_url/148803953492.jpg" alt="">
                            <p class="name text-ellipsis">Randon RG-540</p>                        <span class="price">¥ 6190</span>
                        </a></li>
                    <li><a href="#"> <img width="208" height="208"
                                          src="https://g-search3.alicdn.com/img/bao/uploaded/i4/i3/2815538636/TB1SECdFqmWBuNjy1XaXXXCbXXa_!!0-item_pic.jpg"
                                          alt="">
                            <p class="name text-ellipsis">Randon RG-540</p>                        <span class="price">¥ 6190</span>
                        </a></li>
                    <li><a href="#"> <img width="208" height="208"
                                          src="https://g-search1.alicdn.com/img/bao/uploaded/i4/i4/2094323899/TB2DkPUAHuWBuNjSszgXXb8jVXa_!!2094323899-0-item_pic.jpg   "
                                          alt="">
                            <p class="name text-ellipsis">Randon RG-540</p>                        <span class="price">¥ 6190</span>
                        </a></li>
                    <li><a href="#"> <img width="208" height="208"
                                          src="https://img.alicdn.com/imgextra/i4/127915153/TB25on9XRsmBKNjSZFsXXaXSVXa_!!0-saturn_solar.jpg"
                                          alt="">
                            <p class="name text-ellipsis">Randon RG-540</p>                        <span class="price">¥ 6190</span>
                        </a></li>
                    <li><a href="#"> <img width="208" height="208"
                                          src="https://img.alicdn.com/imgextra/i1/123099861/TB2VBsWl0fJ8KJjy0FeXXXKEXXa_!!0-saturn_solar.jpg"
                                          alt="">
                            <p class="name text-ellipsis">Randon RG-540</p>                        <span class="price">¥ 6190</span>
                        </a></li>
                    <li><a href="#"> <img width="208" height="208"
                                          src="https://g-search1.alicdn.com/img/bao/uploaded/i4/i3/2373517045/TB1z3jFegnH8KJjSspcXXb3QFXa_!!0-item_pic.jpg"
                                          alt="">
                            <p class="name text-ellipsis">Randon RG-540</p>                        <span class="price">¥ 6190</span>
                        </a></li>
                    <li><a href="#"> <img width="208" height="208"
                                          src="https://img.alicdn.com/imgextra/i4/16048147/TB2OubSkf6TBKNjSZJiXXbKVFXa_!!2-saturn_solar.png"
                                          alt="">
                            <p class="name text-ellipsis">Randon RG-540</p>                        <span class="price">¥ 6190</span>
                        </a></li>
                    <li><a href="#"> <img width="208" height="208"
                                          src="https://img.alicdn.com/imgextra/i3/59425047/TB2zSnXieGSBuNjSspbXXciipXa_!!0-saturn_solar.jpg"
                                          alt="">
                            <p class="name text-ellipsis">Randon RG-540</p>                        <span class="price">¥ 6190</span>
                        </a></li>
                    <li><a href="#"> <img width="208" height="208"
                                          src="https://img.alicdn.com/imgextra/i2/176610103214156139/TB2FJNGdXXXXXXxXpXXXXXXXXXX_!!10867661-0-saturn_solar.jpg"
                                          alt="">
                            <p class="name text-ellipsis">Randon RG-540</p>                        <span class="price">¥ 6190</span>
                        </a></li>
                    <li><a href="#"> <img width="208" height="208"
                                          src="https://img.alicdn.com/imgextra/i3/120025254/TB2sRe2w_tYBeNjy1XdXXXXyVXa_!!0-saturn_solar.jpg"
                                          alt="">
                            <p class="name text-ellipsis">Randon RG-540</p>                        <span class="price">¥ 6190</span>
                        </a></li>
                    <li><a href="#"> <img width="208" height="208"
                                          src="https://img.alicdn.com/imgextra/i2/43565643/TB25IJEfcnI8KJjSsziXXb8QpXa_!!0-saturn_solar.jpg"
                                          alt="">
                            <p class="name text-ellipsis">Randon RG-540</p>                        <span class="price">¥ 6190</span>
                        </a></li>
                    <li><a href="#"> <img width="208" height="208"
                                          src="https://img.alicdn.com/imgextra/i1/123099861/TB2VBsWl0fJ8KJjy0FeXXXKEXXa_!!0-saturn_solar.jpg"
                                          alt="">
                            <p class="name text-ellipsis">Randon RG-540</p>                        <span class="price">¥ 6190</span>
                        </a></li>
                    <li><a href="#"> <img width="208" height="208"
                                          src="https://g-search1.alicdn.com/img/bao/uploaded/i4/i3/2373517045/TB1z3jFegnH8KJjSspcXXb3QFXa_!!0-item_pic.jpg"
                                          alt="">
                            <p class="name text-ellipsis">Randon RG-540</p>                        <span class="price">¥ 6190</span>
                        </a></li>
                    <li><a href="#"> <img width="208" height="208"
                                          src="https://img.alicdn.com/imgextra/i4/16048147/TB2OubSkf6TBKNjSZJiXXbKVFXa_!!2-saturn_solar.png"
                                          alt="">
                            <p class="name text-ellipsis">Randon RG-540</p>                        <span class="price">¥ 6190</span>
                        </a></li>
                    <li><a href="#"> <img width="208" height="208"
                                          src="https://img.alicdn.com/imgextra/i3/59425047/TB2zSnXieGSBuNjSspbXXciipXa_!!0-saturn_solar.jpg"
                                          alt="">
                            <p class="name text-ellipsis">Randon RG-540</p>                        <span class="price">¥ 6190</span>
                        </a></li> -->
                </ul>
                <?php $paginationHtml; ?>
            </section>
        <?php } else { ?>
            <section class="hot-brand-wrap" style="display:block;">
                <div class="wrap-top"><h3>热门品牌</h3></div>
                <ul>
                    <?php echo $brandHtml; ?>
                    <!--                <li><a href="#">-->
                    <!--                        <div class="img"><img src="http://shop.guitarworld.com.cn/sitestyle/shop/images//brand/brand1.gif"-->
                    <!--                                              alt=""></div>-->
                    <!--                        <p class="name">Dove鸽子</p></a></li>-->
                    <!--                <li><a href="#">-->
                    <!--                        <div class="img"><img src="http://shop.guitarworld.com.cn/sitestyle/shop/images//brand/brand2.gif"-->
                    <!--                                              alt=""></div>-->
                    <!--                        <p class="name">Farida法丽达</p></a></li>-->
                    <!--                <li><a href="#">-->
                    <!--                        <div class="img"><img src="http://shop.guitarworld.com.cn/sitestyle/shop/images//brand/brand3.gif"-->
                    <!--                                              alt=""></div>-->
                    <!--                        <p class="name">S.Yairi艾斯雅依利</p></a></li>-->
                    <!--                <li><a href="#">-->
                    <!--                        <div class="img"><img src="http://shop.guitarworld.com.cn/sitestyle/shop/images//brand/brand11.gif"-->
                    <!--                                              alt=""></div>-->
                    <!--                        <p class="name">St.paul圣保罗</p></a></li>-->
                    <!--                <li><a href="#">-->
                    <!--                        <div class="img"><img src="http://shop.guitarworld.com.cn/sitestyle/shop/images//brand/brand15.gif"-->
                    <!--                                              alt=""></div>-->
                    <!--                        <p class="name">Tylanhua天音</p></a></li>-->
                    <!--                <li><a href="#">-->
                    <!--                        <div class="img"><img src="http://shop.guitarworld.com.cn/sitestyle/shop/images//brand/brand18.gif"-->
                    <!--                                              alt=""></div>-->
                    <!--                        <p class="name">Dunlop邓禄普</p></a></li>-->
                    <!--                <li><a href="#">-->
                    <!--                        <div class="img"><img src="http://shop.guitarworld.com.cn/sitestyle/shop/images//brand/brand24.gif"-->
                    <!--                                              alt=""></div>-->
                    <!--                        <p class="name">SAMCIK三益</p></a></li>-->
                    <!--                <li><a href="#">-->
                    <!--                        <div class="img"><img src="http://shop.guitarworld.com.cn/sitestyle/shop/images//brand/brand17.gif"-->
                    <!--                                              alt=""></div>-->
                    <!--                        <p class="name">Adeline爱德琳</p></a></li>-->
                </ul>
            </section>
        <?php } ?>
    </section>

<?php get_footer(); ?>