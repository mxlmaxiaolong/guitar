<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
?>

<footer class="footer">
    <section class="center">
        <div class="left-wrap fl">
            <div class="title">品牌合作</div>
            <div class="con-list">
                <ul>
                    <li><a href="#">Mayson曼森</a></li>
                    <li><a href="#">Magic麦杰克</a></li>
                    <li><a href="#">TYMA泰玛</a></li>
                    <li><a href="#">LEGPAP莱柏</a></li>
                    <li><a href="#">Brook布鲁克</a></li>
                    <li><a href="#">Enya恩雅</a></li>
                    <li><a href="#">Kepma卡马</a></li>
                    <li><a href="#">Sagewood赛捷</a></li>
                    <li><a href="#">Randon蓝盾</a></li>
                    <li><a href="#">Eplay玩易</a></li>
                    <li><a href="#">ALAYA伊莱雅</a></li>
                    <li><a href="#">Crafter卡夫特</a></li>
                    <li><a href="#">Meridaextrema美丽达</a></li>
                    <li><a href="#">SUNSTORM太阳风</a></li>
                    <li><a href="#">BSG</a></li>
                </ul>
            </div>
        </div>
        <div class="right-wrap fr"><a href=""> <img class="logo"
                                                    src="/wp-content/themes/CIA/dist/images/171a7e2b87b3bd8beb04d4d99f501a0d.png"
                                                    width="147" height="20" alt=""> </a>            <h4 class="title">
                少研究器材，多和音乐做朋友</h4>
            <div class="footer-mune">
                <ul>
                    <li><a href="#">隐私政策</a></li>
                    <li><a href="#">条款</a></li>
                    <li><a href="<?php echo get_permalink(109);?>">关于我们</a></li>
                </ul>
            </div>
        </div>
    </section>
</footer>

<?php wp_footer(); ?>


<style>
    html #wpadminbar {
        display: none!important;
    }
</style>

</body>
</html>
