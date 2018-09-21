<?php
/**
 * Template Name: 关于我们
 *
 * @package WordPress
 */


get_header(); ?>

<?php
$terms = get_terms([
	'taxonomy' => 'guitar_brand',
	'hide_empty' => false,
	'parent'   => 0
]);

$brandHtml = "";
foreach ($terms as &$term) {
    $currentItemName = $term->name;
    $currentItemImg = get_field( 'band_image', 'guitar_brand_' . $term->term_id );
    $currentItemLink = '/?guitar_brand=' . $term->slug;
	$brandHtml .= "<li><a href=\"{$currentItemLink}\"> <div class=\"img\"><img src=\"{$currentItemImg}\" alt=\"\"></div> <p class=\"name\">{$currentItemName}</p></a></li> <li>";
}


?>


    <section class="main"><h2 class="title">关于GUITARCIA</h2>
        <p class="text">
            “吉他情报局”是一群爱音乐的极客组成的团队，对于这个想法，其实早在15年就已经成型。我们通过不断的探索与交流后，最终在2017年3月22日公发布第一篇微信公众号文章，告诉大家我们的想法。此后各界反馈热烈，文章24小时浏览量就达到了1万＋，同时也不乏国内多家一线厂家联系到我们，谈起了合作。在大势所趋之下，我们着手了此事，把这异想天开的想法变成现实。在同年4月，GuitarCIA网站测试版正式上线。我们风雨兼程着实不易，但是，我们知道，这才刚刚开始。</p>
        <h2 class="title">GUITARCIA存在的意义</h2>
        <p class="text">
            大家都在说市场不成熟，太多弊病，其实每个行业或多或少都会存在一些问题，然而重点并不在于说说，而是该怎么去解决。CIA存在的意义在于为喜欢吉他的琴友提高效率，节约时间，让他们更快的找到想要的品牌吉他，然后普及吉他类别的各类基础知识，也为各级大大小小的厂家/经销商提供一个标准的数据库方便大家传播品牌产品和正确的价值观。。</p>
        <h2 class="title">GuitarCIA的创新（三大类）</h2>
        <h3 class="title2">参数配置表</h3>
        <p class="text">结合官方给出的信息和商家/消费者想了解的信息，我们罗列出24项（如下表）和官方进行校对然后记录在GuitarCIA。</p>
        <h3 class="title2">图片</h3>
        <p class="text">
            图片展示部分我们称为“135体系”，意为13张外观照片加5张内部图片组，方便大家透过统一的拍摄环境来对比外观细节和对比内部细节做工。内部照片这个环节放眼全球应该是首创（欢迎批斗），这样的目的是希望让厂家在消费者看不到的地方也格外用心，金玉其外败絮其中的例子我们也有看到。（会得罪很多人，但是，或许，真的，很值得，你们说对吧。）</p>
        <h3 class="title2">音频</h3>
        <p class="text">我们通过统一以下客观因素：同一演奏家 - 同一系列演奏曲目 - 统一录音设备 - 统一无后期 -
            统一压制320k上传网页，把真实的主观感受交给各位，通过在GuitarCIA.com上传AU压制320k/mp3试听，完成“较为”有意义的对比，争取后期网络系统带宽完善无压力后我们提供无损音频供大家下载。</p>
        <h2 class="title">跋文</h2>
        <p class="text">
            国内吉他制造业相比国外同行和其他前沿行业着实慢了一丢，但是今年我们看到了非常多类似于教育在线平台，线上线下平台整合，乐器厂家的互联网营销，乐手自媒体等等不断探索的信号，相信在大家的共同努力下，国内不到3%的乐器普及率会向发达国家30%的覆盖率慢慢靠拢。私以为2017年应该就是乐器行业互联网化的元年。最后，为上新入库更多品牌的量产产品，为大家提供查询便利，在此放上联系方式，希望更多国内一二线厂家/国际品牌国内总代理和我们取得联系。我们会提供表格协议，符合相关条件的制造厂家即可安排网站产品入库。</p>
    </section>

    <script type="text/javascript" src="/wp-content/themes/CIA/dist/js/about.bundle.js"></script>
<?php get_footer(); ?>