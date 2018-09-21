<?php
get_header(); ?>

<?php

$isBrand = get_field('is_series', 'guitar_brand_' . get_queried_object()->term_id );

function getAllGuitarByBrandId ($brandId) {
	$posts_array = get_posts(
		array(
			'posts_per_page' => -1,
			'post_type' => 'guitar',
			'tax_query' => array(
				array(
					'taxonomy' => 'guitar_brand',
					'field' => 'term_id',
					'terms' => $brandId,
				)
			)
		)
	);


	$guitarListHtml = '';

	foreach ($posts_array as &$post) {
		$currentPostName = $post->post_title;
		$currentPostImg = get_field( 'guitar_main_img', $post->ID );
		$currentPostLink = get_permalink($post->ID);
		$guitarListHtml .= "<li><a href=\"{$currentPostLink}\"> <img width=\"208\" height=\"208\" src=\"{$currentPostImg}\" alt=\"\"> <p class=\"name text-ellipsis\">{$currentPostName}</p></a></li>";
	}

	return $guitarListHtml;
}

// If this is brand archive page
if(!$isBrand) {

    $brandName = get_queried_object()->name;
	$brandStory = get_field('brand_story', 'guitar_brand_' . get_queried_object()->term_id );

	$allSerieshtml = '';

	$terms = get_terms([
		'taxonomy' => 'guitar_brand',
		'hide_empty' => false,
		'parent'   => get_queried_object()->term_id
	]);

	foreach ($terms as &$term) {
		$currentItemName = $term->name;
		$currentItemImg = get_field( 'band_image', 'guitar_brand_' . $term->term_id );
		$currentItemLink = '?guitar_brand=' . $term->slug;
		$allSerieshtml .= "<li><a href=\"{$currentItemLink}\"> <img width=\"208\" height=\"208\" src=\"{$currentItemImg}\" alt=\"\"> <p class=\"name text-ellipsis\">{$currentItemName}</p></a></li>";
	}

	?>

    <section class="main"><h1 class="title"><?php echo $brandName;?></h1>
        <section class="story-wrap">
            <div class="wrap-top"><h3>品牌故事</h3></div>
            <div class="describe">
                <?php echo $brandStory;?>
            </div>
        </section>
        <section class="video-list">
            <div class="wrap-top"><h3>品牌视频</h3></div>
            <ul>
                <li><img class="thumbnail" width="356" height="200"
                         src="https://img.alicdn.com/imgextra/i1/3898023023/TB2iWLND7yWBuNjy0FpXXassXXa_!!3898023023-0-item_pic.jpg_430x430q90.jpg"
                         alt=""> <a href="javascript:void(0);" class="play"> <img
                                src="/wp-content/themes/CIA/dist/images/f897faa56263ad18818806e1a76c854b.png" alt="">
                    </a></li>
                <li><img class="thumbnail" width="356" height="200"
                         src="https://img.alicdn.com/imgextra/i1/3898023023/TB2iWLND7yWBuNjy0FpXXassXXa_!!3898023023-0-item_pic.jpg_430x430q90.jpg"
                         alt=""> <a href="javascript:void(0);" class="play"> <img
                                src="/wp-content/themes/CIA/dist/images/f897faa56263ad18818806e1a76c854b.png" alt="">
                    </a></li>
                <li><img class="thumbnail" width="356" height="200"
                         src="https://img.alicdn.com/imgextra/i1/3898023023/TB2iWLND7yWBuNjy0FpXXassXXa_!!3898023023-0-item_pic.jpg_430x430q90.jpg"
                         alt=""> <a href="javascript:void(0);" class="play"> <img
                                src="/wp-content/themes/CIA/dist/images/f897faa56263ad18818806e1a76c854b.png" alt="">
                    </a></li>
            </ul>
        </section>
        <section class="guitar-list">
            <div class="wrap-top"><h3>热销系列</h3></div>
            <ul>
                <?php echo $allSerieshtml;?>
<!--                <li><a href="#"> <img width="208" height="208"-->
<!--                                      src="https://static.jishida.vip/upload/shop_list_pic_url/148803953492.jpg" alt="">-->
<!--                        <p class="name text-ellipsis">Randon RG-540</p></a></li>-->
<!--                <li><a href="#"> <img width="208" height="208"-->
<!--                                      src="https://g-search3.alicdn.com/img/bao/uploaded/i4/i3/2815538636/TB1SECdFqmWBuNjy1XaXXXCbXXa_!!0-item_pic.jpg"-->
<!--                                      alt="">-->
<!--                        <p class="name text-ellipsis">Randon RG-540</p></a></li>-->
<!--                <li><a href="#"> <img width="208" height="208"-->
<!--                                      src="https://g-search1.alicdn.com/img/bao/uploaded/i4/i4/2094323899/TB2DkPUAHuWBuNjSszgXXb8jVXa_!!2094323899-0-item_pic.jpg   "-->
<!--                                      alt="">-->
<!--                        <p class="name text-ellipsis">Randon RG-540</p></a></li>-->
<!--                <li><a href="#"> <img width="208" height="208"-->
<!--                                      src="https://img.alicdn.com/imgextra/i4/127915153/TB25on9XRsmBKNjSZFsXXaXSVXa_!!0-saturn_solar.jpg"-->
<!--                                      alt="">-->
<!--                        <p class="name text-ellipsis">Randon RG-540</p></a></li>-->
<!--                <li><a href="#"> <img width="208" height="208"-->
<!--                                      src="https://img.alicdn.com/imgextra/i1/123099861/TB2VBsWl0fJ8KJjy0FeXXXKEXXa_!!0-saturn_solar.jpg"-->
<!--                                      alt="">-->
<!--                        <p class="name text-ellipsis">Randon RG-540</p></a></li>-->
<!--                <li><a href="#"> <img width="208" height="208"-->
<!--                                      src="https://g-search1.alicdn.com/img/bao/uploaded/i4/i3/2373517045/TB1z3jFegnH8KJjSspcXXb3QFXa_!!0-item_pic.jpg"-->
<!--                                      alt="">-->
<!--                        <p class="name text-ellipsis">Randon RG-540</p></a></li>-->
<!--                <li><a href="#"> <img width="208" height="208"-->
<!--                                      src="https://img.alicdn.com/imgextra/i4/16048147/TB2OubSkf6TBKNjSZJiXXbKVFXa_!!2-saturn_solar.png"-->
<!--                                      alt="">-->
<!--                        <p class="name text-ellipsis">Randon RG-540</p></a></li>-->
<!--                <li><a href="#"> <img width="208" height="208"-->
<!--                                      src="https://img.alicdn.com/imgextra/i3/59425047/TB2zSnXieGSBuNjSspbXXciipXa_!!0-saturn_solar.jpg"-->
<!--                                      alt="">-->
<!--                        <p class="name text-ellipsis">Randon RG-540</p></a></li>-->
<!--                <li><a href="#"> <img width="208" height="208"-->
<!--                                      src="https://img.alicdn.com/imgextra/i2/176610103214156139/TB2FJNGdXXXXXXxXpXXXXXXXXXX_!!10867661-0-saturn_solar.jpg"-->
<!--                                      alt="">-->
<!--                        <p class="name text-ellipsis">Randon RG-540</p></a></li>-->
<!--                <li><a href="#"> <img width="208" height="208"-->
<!--                                      src="https://img.alicdn.com/imgextra/i3/120025254/TB2sRe2w_tYBeNjy1XdXXXXyVXa_!!0-saturn_solar.jpg"-->
<!--                                      alt="">-->
<!--                        <p class="name text-ellipsis">Randon RG-540</p></a></li>-->
<!--                <li><a href="#"> <img width="208" height="208"-->
<!--                                      src="https://img.alicdn.com/imgextra/i2/43565643/TB25IJEfcnI8KJjSsziXXb8QpXa_!!0-saturn_solar.jpg"-->
<!--                                      alt="">-->
<!--                        <p class="name text-ellipsis">Randon RG-540</p></a></li>-->
<!--                <li><a href="#"> <img width="208" height="208"-->
<!--                                      src="https://img.alicdn.com/imgextra/i1/123099861/TB2VBsWl0fJ8KJjy0FeXXXKEXXa_!!0-saturn_solar.jpg"-->
<!--                                      alt="">-->
<!--                        <p class="name text-ellipsis">Randon RG-540</p></a></li>-->
<!--                <li><a href="#"> <img width="208" height="208"-->
<!--                                      src="https://g-search1.alicdn.com/img/bao/uploaded/i4/i3/2373517045/TB1z3jFegnH8KJjSspcXXb3QFXa_!!0-item_pic.jpg"-->
<!--                                      alt="">-->
<!--                        <p class="name text-ellipsis">Randon RG-540</p></a></li>-->
<!--                <li><a href="#"> <img width="208" height="208"-->
<!--                                      src="https://img.alicdn.com/imgextra/i4/16048147/TB2OubSkf6TBKNjSZJiXXbKVFXa_!!2-saturn_solar.png"-->
<!--                                      alt="">-->
<!--                        <p class="name text-ellipsis">Randon RG-540</p></a></li>-->
<!--                <li><a href="#"> <img width="208" height="208"-->
<!--                                      src="https://img.alicdn.com/imgextra/i3/59425047/TB2zSnXieGSBuNjSspbXXciipXa_!!0-saturn_solar.jpg"-->
<!--                                      alt="">-->
<!--                        <p class="name text-ellipsis">Randon RG-540</p></a></li>-->
            </ul>
        </section>
        <section class="guitar-list">
            <div class="wrap-top"><h3>热销型号</h3></div>
            <ul>

                <?php

                echo getAllGuitarByBrandId(get_queried_object()->term_id);

                ?>



<!--                <li><a href="#"> <img width="208" height="208"-->
<!--                                      src="https://static.jishida.vip/upload/shop_list_pic_url/148803953492.jpg" alt="">-->
<!--                        <p class="name text-ellipsis">Randon RG-540</p></a></li>-->
<!--                <li><a href="#"> <img width="208" height="208"-->
<!--                                      src="https://g-search3.alicdn.com/img/bao/uploaded/i4/i3/2815538636/TB1SECdFqmWBuNjy1XaXXXCbXXa_!!0-item_pic.jpg"-->
<!--                                      alt="">-->
<!--                        <p class="name text-ellipsis">Randon RG-540</p></a></li>-->
<!--                <li><a href="#"> <img width="208" height="208"-->
<!--                                      src="https://g-search1.alicdn.com/img/bao/uploaded/i4/i4/2094323899/TB2DkPUAHuWBuNjSszgXXb8jVXa_!!2094323899-0-item_pic.jpg   "-->
<!--                                      alt="">-->
<!--                        <p class="name text-ellipsis">Randon RG-540</p></a></li>-->
<!--                <li><a href="#"> <img width="208" height="208"-->
<!--                                      src="https://img.alicdn.com/imgextra/i4/127915153/TB25on9XRsmBKNjSZFsXXaXSVXa_!!0-saturn_solar.jpg"-->
<!--                                      alt="">-->
<!--                        <p class="name text-ellipsis">Randon RG-540</p></a></li>-->
<!--                <li><a href="#"> <img width="208" height="208"-->
<!--                                      src="https://img.alicdn.com/imgextra/i1/123099861/TB2VBsWl0fJ8KJjy0FeXXXKEXXa_!!0-saturn_solar.jpg"-->
<!--                                      alt="">-->
<!--                        <p class="name text-ellipsis">Randon RG-540</p></a></li>-->
<!--                <li><a href="#"> <img width="208" height="208"-->
<!--                                      src="https://g-search1.alicdn.com/img/bao/uploaded/i4/i3/2373517045/TB1z3jFegnH8KJjSspcXXb3QFXa_!!0-item_pic.jpg"-->
<!--                                      alt="">-->
<!--                        <p class="name text-ellipsis">Randon RG-540</p></a></li>-->
<!--                <li><a href="#"> <img width="208" height="208"-->
<!--                                      src="https://img.alicdn.com/imgextra/i4/16048147/TB2OubSkf6TBKNjSZJiXXbKVFXa_!!2-saturn_solar.png"-->
<!--                                      alt="">-->
<!--                        <p class="name text-ellipsis">Randon RG-540</p></a></li>-->
<!--                <li><a href="#"> <img width="208" height="208"-->
<!--                                      src="https://img.alicdn.com/imgextra/i3/59425047/TB2zSnXieGSBuNjSspbXXciipXa_!!0-saturn_solar.jpg"-->
<!--                                      alt="">-->
<!--                        <p class="name text-ellipsis">Randon RG-540</p></a></li>-->
<!--                <li><a href="#"> <img width="208" height="208"-->
<!--                                      src="https://img.alicdn.com/imgextra/i2/176610103214156139/TB2FJNGdXXXXXXxXpXXXXXXXXXX_!!10867661-0-saturn_solar.jpg"-->
<!--                                      alt="">-->
<!--                        <p class="name text-ellipsis">Randon RG-540</p></a></li>-->
<!--                <li><a href="#"> <img width="208" height="208"-->
<!--                                      src="https://img.alicdn.com/imgextra/i3/120025254/TB2sRe2w_tYBeNjy1XdXXXXyVXa_!!0-saturn_solar.jpg"-->
<!--                                      alt="">-->
<!--                        <p class="name text-ellipsis">Randon RG-540</p></a></li>-->
<!--                <li><a href="#"> <img width="208" height="208"-->
<!--                                      src="https://img.alicdn.com/imgextra/i2/43565643/TB25IJEfcnI8KJjSsziXXb8QpXa_!!0-saturn_solar.jpg"-->
<!--                                      alt="">-->
<!--                        <p class="name text-ellipsis">Randon RG-540</p></a></li>-->
<!--                <li><a href="#"> <img width="208" height="208"-->
<!--                                      src="https://img.alicdn.com/imgextra/i1/123099861/TB2VBsWl0fJ8KJjy0FeXXXKEXXa_!!0-saturn_solar.jpg"-->
<!--                                      alt="">-->
<!--                        <p class="name text-ellipsis">Randon RG-540</p></a></li>-->
<!--                <li><a href="#"> <img width="208" height="208"-->
<!--                                      src="https://g-search1.alicdn.com/img/bao/uploaded/i4/i3/2373517045/TB1z3jFegnH8KJjSspcXXb3QFXa_!!0-item_pic.jpg"-->
<!--                                      alt="">-->
<!--                        <p class="name text-ellipsis">Randon RG-540</p></a></li>-->
<!--                <li><a href="#"> <img width="208" height="208"-->
<!--                                      src="https://img.alicdn.com/imgextra/i4/16048147/TB2OubSkf6TBKNjSZJiXXbKVFXa_!!2-saturn_solar.png"-->
<!--                                      alt="">-->
<!--                        <p class="name text-ellipsis">Randon RG-540</p></a></li>-->
<!--                <li><a href="#"> <img width="208" height="208"-->
<!--                                      src="https://img.alicdn.com/imgextra/i3/59425047/TB2zSnXieGSBuNjSspbXXciipXa_!!0-saturn_solar.jpg"-->
<!--                                      alt="">-->
<!--                        <p class="name text-ellipsis">Randon RG-540</p></a></li>-->

            </ul>
        </section>
        <section class="nearby-dealer-list">
            <div class="wrap-top"><h3>附近经销商</h3></div>
            <ul>
                <li>
                    <div class="img fl"><img width="140" height="162"
                                             src="http://p0.meituan.net/deal/__40618744__3553076.jpg@213w_120h_1e_1c"
                                             alt=""></div>
                    <div class="info-div fl"><p class="name">新顺路店</p>
                        <p class="address">地址：广州市白云区白云大道北11689号岭南新世界1层101</p>
                        <p class="telephone">电话：133 5658 9999</p></div>
                    <div class="location"><span> 586米</span> <img width="24" height="24"
                                                                  src="/wp-content/themes/CIA/dist/images/bb1b95222e0e8a614574e9674d61f719.png"
                                                                  alt=""></div>
                </li>
                <li>
                    <div class="img fl"><img width="140" height="162"
                                             src="http://p0.meituan.net/deal/__40618744__3553076.jpg@213w_120h_1e_1c"
                                             alt=""></div>
                    <div class="info-div fl"><p class="name">新顺路店</p>
                        <p class="address">地址：广州市白云区白云大道北11689号岭南新世界1层101</p>
                        <p class="telephone">电话：133 5658 9999</p></div>
                    <div class="location"><span> 586米</span> <img width="24" height="24"
                                                                  src="/wp-content/themes/CIA/dist/images/bb1b95222e0e8a614574e9674d61f719.png"
                                                                  alt=""></div>
                </li>
            </ul>
        </section>
    </section>


	<?php get_footer(); ?>


    <script type="text/javascript" src="/wp-content/themes/CIA/dist/js/brandDetails.bundle.js"></script>

</body>

</html>

	<?php
} else {

	$seriesName = get_queried_object()->name;
	$seriesDetail = get_field('series_detail', 'guitar_brand_' . get_queried_object()->term_id );

    ?>

    <section class="main"><h1 class="title"><?php echo $seriesName;?></h1>
        <section class="describe-wrap">
            <div class="content">
                <?php echo $seriesDetail; ?>
            </div>
        </section>
        <section class="guitar-list">
            <div class="wrap-top"><h3>吉他型号</h3></div>
            <ul>
	            <?php

	            echo getAllGuitarByBrandId(get_queried_object()->term_id);

	            ?>
<!--                <li><a href="#"> <img width="208" height="208"-->
<!--                                      src="https://static.jishida.vip/upload/shop_list_pic_url/148803953492.jpg" alt="">-->
<!--                        <p class="name text-ellipsis">Randon RG-540</p></a></li>-->
<!--                <li><a href="#"> <img width="208" height="208"-->
<!--                                      src="https://g-search3.alicdn.com/img/bao/uploaded/i4/i3/2815538636/TB1SECdFqmWBuNjy1XaXXXCbXXa_!!0-item_pic.jpg"-->
<!--                                      alt="">-->
<!--                        <p class="name text-ellipsis">Randon RG-540</p></a></li>-->
<!--                <li><a href="#"> <img width="208" height="208"-->
<!--                                      src="https://g-search1.alicdn.com/img/bao/uploaded/i4/i4/2094323899/TB2DkPUAHuWBuNjSszgXXb8jVXa_!!2094323899-0-item_pic.jpg   "-->
<!--                                      alt="">-->
<!--                        <p class="name text-ellipsis">Randon RG-540</p></a></li>-->
<!--                <li><a href="#"> <img width="208" height="208"-->
<!--                                      src="https://img.alicdn.com/imgextra/i4/127915153/TB25on9XRsmBKNjSZFsXXaXSVXa_!!0-saturn_solar.jpg"-->
<!--                                      alt="">-->
<!--                        <p class="name text-ellipsis">Randon RG-540</p></a></li>-->
<!--                <li><a href="#"> <img width="208" height="208"-->
<!--                                      src="https://img.alicdn.com/imgextra/i1/123099861/TB2VBsWl0fJ8KJjy0FeXXXKEXXa_!!0-saturn_solar.jpg"-->
<!--                                      alt="">-->
<!--                        <p class="name text-ellipsis">Randon RG-540</p></a></li>-->
<!--                <li><a href="#"> <img width="208" height="208"-->
<!--                                      src="https://g-search1.alicdn.com/img/bao/uploaded/i4/i3/2373517045/TB1z3jFegnH8KJjSspcXXb3QFXa_!!0-item_pic.jpg"-->
<!--                                      alt="">-->
<!--                        <p class="name text-ellipsis">Randon RG-540</p></a></li>-->
<!--                <li><a href="#"> <img width="208" height="208"-->
<!--                                      src="https://img.alicdn.com/imgextra/i4/16048147/TB2OubSkf6TBKNjSZJiXXbKVFXa_!!2-saturn_solar.png"-->
<!--                                      alt="">-->
<!--                        <p class="name text-ellipsis">Randon RG-540</p></a></li>-->
<!--                <li><a href="#"> <img width="208" height="208"-->
<!--                                      src="https://img.alicdn.com/imgextra/i3/59425047/TB2zSnXieGSBuNjSspbXXciipXa_!!0-saturn_solar.jpg"-->
<!--                                      alt="">-->
<!--                        <p class="name text-ellipsis">Randon RG-540</p></a></li>-->
<!--                <li><a href="#"> <img width="208" height="208"-->
<!--                                      src="https://img.alicdn.com/imgextra/i2/176610103214156139/TB2FJNGdXXXXXXxXpXXXXXXXXXX_!!10867661-0-saturn_solar.jpg"-->
<!--                                      alt="">-->
<!--                        <p class="name text-ellipsis">Randon RG-540</p></a></li>-->
<!--                <li><a href="#"> <img width="208" height="208"-->
<!--                                      src="https://img.alicdn.com/imgextra/i3/120025254/TB2sRe2w_tYBeNjy1XdXXXXyVXa_!!0-saturn_solar.jpg"-->
<!--                                      alt="">-->
<!--                        <p class="name text-ellipsis">Randon RG-540</p></a></li>-->
<!--                <li><a href="#"> <img width="208" height="208"-->
<!--                                      src="https://img.alicdn.com/imgextra/i2/43565643/TB25IJEfcnI8KJjSsziXXb8QpXa_!!0-saturn_solar.jpg"-->
<!--                                      alt="">-->
<!--                        <p class="name text-ellipsis">Randon RG-540</p></a></li>-->
<!--                <li><a href="#"> <img width="208" height="208"-->
<!--                                      src="https://img.alicdn.com/imgextra/i1/123099861/TB2VBsWl0fJ8KJjy0FeXXXKEXXa_!!0-saturn_solar.jpg"-->
<!--                                      alt="">-->
<!--                        <p class="name text-ellipsis">Randon RG-540</p></a></li>-->
<!--                <li><a href="#"> <img width="208" height="208"-->
<!--                                      src="https://g-search1.alicdn.com/img/bao/uploaded/i4/i3/2373517045/TB1z3jFegnH8KJjSspcXXb3QFXa_!!0-item_pic.jpg"-->
<!--                                      alt="">-->
<!--                        <p class="name text-ellipsis">Randon RG-540</p></a></li>-->
<!--                <li><a href="#"> <img width="208" height="208"-->
<!--                                      src="https://img.alicdn.com/imgextra/i4/16048147/TB2OubSkf6TBKNjSZJiXXbKVFXa_!!2-saturn_solar.png"-->
<!--                                      alt="">-->
<!--                        <p class="name text-ellipsis">Randon RG-540</p></a></li>-->
<!--                <li><a href="#"> <img width="208" height="208"-->
<!--                                      src="https://img.alicdn.com/imgextra/i3/59425047/TB2zSnXieGSBuNjSspbXXciipXa_!!0-saturn_solar.jpg"-->
<!--                                      alt="">-->
<!--                        <p class="name text-ellipsis">Randon RG-540</p></a></li>-->
            </ul>
        </section>
    </section>

    <?php get_footer();?>

    <script type="text/javascript" src="/wp-content/themes/CIA/dist/js/brandSeriesDetails.bundle.js"></script>

    </body>
    </html>

<?php
};

?>