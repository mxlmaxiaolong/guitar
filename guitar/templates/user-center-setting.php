<?php
/**
 * Template Name: 个人中心设置
 *
 * @package WordPress
 */


get_header(); ?>

    <section class="main">
        <div class="upload-head"> <img src="http://p1.music.126.net/SU6A6Wn6QMe1XK6ji3m-hQ==/18970973626241990.jpg?param=150y150" alt=""> </div>
        <section class="datum-list">
            <h2>基本资料</h2>
            <div class="item">
                <div class="fl"> <span class="label">用户名：</span> <span class="value">蓝天白云配绿树</span> </div>
                <button type="button" class="operation-btn defalt">修改</button>
            </div>
            <div class="item">
                <div class="fl"> <span class="label">验证手机：</span> <span class="value no">未设置</span> </div>
                <button type="button" class="operation-btn" id="setUpPhoneFormBtn">立即设置</button>
                <script type="text/template" id="validatePhoneFormTpl">
                    <form id="validatePhoneForm">
                        <div class="form-wrap form-wrap-reg">
                            <div class="form-item">
                                <input type="text" maxlength="11" name="phoneNumber" class="phone-number-input" id="phoneNumberInput" placeholder="请输入手机号码"> </div>
                            <div class="form-item form-item-columnX2">
                                <div class="input-item fl">
                                    <input type="text" name="code" class="code-input" id="codeInput" placeholder="输入验证码"> </div>
                                <button class="fr send-code-btn" id="sendCode" type="button" disabled="disabled">发送验证码
                                    <button>
                            </div>
                            <div class="form-item">
                                <input type="submit" id="submit" class="submit" value="确认" disabled="disabled" style="margin-top: 30px"> </div>
                        </div>
                    </form>
                    <style>
                        .modal-popup .form-wrap input[type="text"],
                        .modal-popup .form-wrap input[type="password"] {
                            margin-bottom: 35px;
                        }
                    </style>
                </script>
            </div>
            <div class="item">
                <div class="fl"> <span class="label">登录密码：</span> <span class="value no">未设置</span> </div>
                <!-- <button type="button" class="operation-btn" id="setUpPass">立即设置</button> -->
                <button type="button" class="operation-btn defalt" id="revisePass">修改</button>
                <script type="text/template" id="setUpPassFormTpl">
                    <form id="setUpPassForm">
                        <div class="form-wrap form-wrap-reg">
                            <div class="form-item">
                                <input type="password" name="pass" class="pass-input" placeholder="设置登录密码 (密码由大小写字母和数字组"> </div>
                            <div class="form-item">
                                <input type="password" name="confirmPass" class="pass-input" placeholder="确认密码"> </div>
                            <div class="form-item">
                                <input type="submit" id="submit" class="submit" value="确认" disabled="disabled" style="margin-top: 84px"> </div>
                        </div>
                    </form>
                </script>
                <script type="text/template" id="reviseFormTpl">
                    <form id="revisePassForm">
                        <div class="form-wrap form-wrap-reg" style="padding-top: 40px;">
                            <div class="form-item">
                                <input type="password" name="used" class="pass-input" placeholder="原密码"> </div>
                            <div class="form-item">
                                <input type="password" name="pass" class="pass-input" placeholder="设置登录密码 (密码由大小写字母和数字组"> </div>
                            <div class="form-item">
                                <input type="password" name="confirmPass" class="pass-input" placeholder="确认密码"> </div>
                            <div class="form-item">
                                <input type="submit" id="submit" class="submit" value="确认" disabled="disabled" style="margin-top: 40px"> </div>
                        </div>
                    </form>
                </script>
            </div>
        </section>
        <section class="datum-list">
            <h2>第三方账号绑定</h2>
            <div class="item">
                <div class="fl"> <span class="label"> <img width="50" src="/wp-content/themes/CIA/dist/images/7d0fdc0c2257e24c55090d77a9594f70.png" alt=""><span class="pd-right-20">QQ</span></span> <span class="value no">未绑定</span> </div>
                <button type="button" class="operation-btn">绑定</button>
            </div>
            <div class="item">
                <div class="fl"> <span class="label"><img width="50" src="/wp-content/themes/CIA/dist/images/4775490823d757f3cac20c6c736aee49.png" alt=""><span class="pd-right-20">微信</span></span> <span class="value">已绑定</span> </div>
                <button type="button" class="operation-btn defalt">取消绑定</button>
            </div>
        </section>
    </section>


    <script type="text/javascript" src="/wp-content/themes/CIA/dist/js/memberSetUp.bundle.js"></script>
<?php get_footer(); ?>