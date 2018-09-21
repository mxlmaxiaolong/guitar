import './../css/common.scss';
import { isPoneAvailable, validatePass, treeSelect, needActiateSubmitBtn } from './util.js';
import { enterModalTpl, throwCraftModalTpl } from './htmlTemplate.js';

/**
 * 显示 input 错误
 * @param {object} domObj 
 * @param {String} msg 
 */
const showInputErrror = (domObj, msg) => {
    hideInputErrror(domObj);
    $(domObj).parent().append(`<i class="input-msg error-msg"><img src="${require('./../images/icon/icon-error.png')}" width="18" height="18" alt=""><span>${msg}</span></i>`);
};
const hideInputErrror = domObj => {
    $(domObj).parent().find('.error-msg').remove();
}

/**
 * 显示 input 正确
 * @param {object} domObj 
 * @param {String} msg 
 */
const showInputSuccess = (domObj, msg) => {
    hideInputErrror(domObj);
    $(domObj).parent().append(`<i class="input-msg success-msg"><img src="${require('./../images/icon/icon-success.png')}" width="18" height="18" alt=""></i>`);
};
const hideInputSuccess = domObj => {
    $(domObj).parent().find('.success-msg').remove();
}

/**
 * 公共 弹窗模版
 * @param {object} opt 
 * @param {String} mainHtml 
 */
const showModal = (opt, mainHtml) => {
    const template = `
            <section class="modal-popup" id="modalPopup">
                <div class="top">
                    <img class="logo fl" src="${require('./../images/logo.png')}" width="147" height="20" alt="">
                    <a href="javascript:void(0);" class="closeModal close fr">关闭</a>
                </div>
                <div class="modal-header">
                    <h2>${opt.title}</h2>
                </div>
                <div class="modal-main">${mainHtml}</div>
            </section>
        `;

    layer.open({
        type: 1,
        title: false,
        area: ['auto', 'auto'],
        closeBtn: 0,
        shade: [0.8, '#000'],
        shadeClose: true,
        content: template
    });

    $('.closeModal').click(function () {
        layer.closeAll();
    });

    return $('html');
};
const hideModal = () => {
    layer.closeAll();
};
    
layui.define(['form','layer'], function () {
    const form = layui.form;
    
    /**
     * 头部导航滚动效果
     */
    const $header = $('#header');
    const $window = $(window);

    $window.scroll(e => {
        if ($window.scrollTop() >= 138) {
            $header.addClass('active');
        } else {
            $header.removeClass('active');
        };
    });
    if ($window.scrollTop() >= 138) {
        $header.addClass('active');
    } else {
        $header.removeClass('active');
    };

    /**
     * 点击打开登录 弹窗
     */
    let $loginModal = null;
    $(document).on('click', '.clickLogin', e => {
        hideModal();
        $loginModal = null;
        layer.closeAll();

        $loginModal = showModal({
            title: '登录'
        },
            `<form id="loginForm">
                            <div class="form-wrap">
                                <div class="form-item">
                                    <input type="text" maxlength="11" name="phoneNumber" class="phone-number-input" id="phoneNumberInput" placeholder="请输入手机号码">
                                </div>
                                <div class="form-item">
                                    <input type="password" name="pass" class="pass-input" id="passInput" placeholder="请输入密码">
                                    <a href="javascript:void(0);" class="overlookclick overlook-pass">忘记密码？</a>
                                </div>

                                <div class="form-item">
                                    <input type="submit" id="submit" class="submit" value="登录" disabled="disabled">
                                </div>

                                <div class="form-footer">
                                    <div class="left-box fl">
                                        <label for="autoCheckbox" class="checkbox-label">
                                            <input type="checkbox" name="isAuto" class="auto-checkbox" id="autoCheckbox" checked="checked">
                                            <i class="icon-checkout"></i>
                                            下次自动登录
                                        </label>
                                    </div>
                                    <div class="right-box fr">
                                        还没有账号，<a class="clickReg" href="javascript:void(0);" >立即注册</a>
                                    </div>
                                </div>

                                <div class="form-item other-form-item">
                                    <span>其它方式登录：</span>
                                    <a href="#"> <img class="other-icon" width="19" height="22" src="${require('./../images/icon/icon-qq.png')}" alt=""> </a>
                                    <a href="/wp-json/wechat/login"> <img class="other-icon" width="22" height="22" src="${require('./../images/icon/icon-wx.png')}" alt=""> </a>
                                </div>
                            </div>
                        </form>`);

        window.setTimeout(function(){
            const $phoneNumberInput = $loginModal.find('#phoneNumberInput');
            const $passInput = $loginModal.find('#passInput');
            const $submit = $loginModal.find('#submit');
            let phoneNumber = '';
            let pass = '';

            $phoneNumberInput.blur(e => {
                phoneNumber = $phoneNumberInput.val();
                if (!isPoneAvailable(phoneNumber)) {
                    showInputErrror($phoneNumberInput, '请输入正确手机号码');
                    $submit.removeClass('active').attr("disabled", true);
                    return false;
                };

                $submit.addClass('active').removeAttr("disabled");
                hideInputErrror($phoneNumberInput);

                /***  TODO 验证手机号码是否注册 ***/
            });

            $passInput.blur('input propertychange', e => {
                pass = $passInput.val();
                if (pass === '' || !isPoneAvailable(phoneNumber)) {
                    $submit.removeClass('active').attr("disabled", true);
                    return false;
                };
                needActiateSubmitBtn()
            });

            $('#loginForm').submit(function (e) {
                e.preventDefault();
                const param = $(this).serializeArray();

                /********  TODO 提交表单  *********/
                window.logIn();
            });
        }, 1000);




    });

    /**
     * 点击打开注册 弹窗
     */
    let $regModal = null;
    $(document).on('click', '.clickReg', e => {
        hideModal();
        $regModal = null;
        layer.closeAll();

        $regModal = showModal({
            title: '注册'
        },
            `<form id="regForm">
            <div class="form-wrap form-wrap-reg">
                <div class="form-item">
                    <input type="text" maxlength="11" name="phoneNumber" class="phone-number-input" id="phoneNumberInput" placeholder="请输入手机号码">
                </div>
                <div class="form-item form-item-columnX2">
                    <div class="input-item fl">
                        <input type="text" name="code" class="code-input" id="codeInput" placeholder="输入验证码">
                    </div>
                    <button class="fr send-code-btn" id="sendCode" type="button" disabled="disabled">发送验证码<button>
                </div>
                <div class="form-item">
                    <input type="password" name="pass" class="pass-input" id="passInput" placeholder="设置密码 (密码由大小写字母和数字组成)">
                </div>

                <div class="form-footer">
                    <div class="left-box fl">
                        <label for="autoCheckbox" class="checkbox-label">
                            <input type="checkbox" name="isAuto" class="auto-checkbox" id="autoCheckbox" checked="checked">
                            <i class="icon-checkout"></i>
                            我已阅读并同意 <a href="#">用户协议</a>
                        </label>
                    </div>
                
                </div>

                <div class="form-item">
                    <input type="submit" id="submit" class="submit" value="注册" disabled="disabled">
                </div>

                <div class="right-box">
                    已有账号，<a href="javascript:void(0);" class="clickLogin">直接登录</a>
                </div>

                <div class="form-item other-form-item">
                    <span>其它方式登录：</span>
                    <a href="#"> <img class="other-icon" width="19" height="22" src="${require('./../images/icon/icon-qq.png')}" alt=""> </a>
                    <a href="/wp-json/wechat/login"> <img class="other-icon" width="22" height="22" src="${require('./../images/icon/icon-wx.png')}" alt=""> </a>
                </div>
            </div>
        </form>`);

        window.setTimeout(function () {
            const $phoneNumberInput = $regModal.find('#phoneNumberInput');
            const $passInput = $regModal.find('#passInput');
            const $submit = $regModal.find('#submit');
            const $sendCode = $regModal.find('#sendCode');
            let phoneNumber = '';
            let pass = '';
            let timeInterval = null;
            let timeWhile = 60;

            $phoneNumberInput.blur(e => {
                phoneNumber = $phoneNumberInput.val();
                if (!isPoneAvailable(phoneNumber)) {
                    showInputErrror($phoneNumberInput, '请输入正确手机号码');
                    $sendCode.attr("disabled", true);
                    hideInputSuccess($phoneNumberInput);
                    return false;
                };

                if (timeInterval === null) {
                    $sendCode.removeAttr("disabled");
                };
                hideInputErrror($phoneNumberInput);
                showInputSuccess($phoneNumberInput);

                /***  TODO 验证手机号码是否注册 ***/
            });

            $passInput.blur('input propertychange', e => {
                pass = $passInput.val();
                if (!validatePass(pass)) {
                    $submit.removeClass('active').attr("disabled", true);
                    showInputErrror($passInput, '密码格式不正确');
                    return false;
                };

                hideInputErrror($passInput);

                needActiateSubmitBtn()
            });

            /**
             * 点击发送验证码
             */
            $sendCode.click(e => {
                $sendCode.attr("disabled", false);
                let phone = $('#phoneNumberInput').val();

                // Todo: Call backend for code

                $.ajax({url: `/wp-json/account/code/${phone}`, success: function(data){

                }});

                /** 发送成功状态 **/
                timeInterval = setInterval(() => {
                    if (timeWhile < 1) {
                        clearInterval(timeInterval);
                        timeInterval = null;
                        timeWhile = 60;
                        $sendCode.text('重新获取');
                        $sendCode.attr("disabled", false);
                        return;
                    };
                    timeWhile--;
                    $sendCode.attr("disabled", true);
                    $sendCode.text(`重新获取(${timeWhile}S)`);
                }, 1000);
            });

            $('#regForm').submit(function (e) {
                e.preventDefault();
                const param = $(this).serializeArray();

                /********  TODO 提交表单  *********/
                window.register();
            });
        }, 1000)


    });

    /**
     * 点击打开忘记密码 弹窗
     */
    $(document).on('click', '.overlookclick', e => {
        hideModal();

        let $forgetForm = showModal({
            title: '忘记密码'
        },
            `<form id="overlookForm">
            <div class="form-wrap form-wrap-reg">
                <div class="form-item">
                    <input type="text" maxlength="11" name="phoneNumber" class="phone-number-input" id="phoneNumberInput" placeholder="请输入手机号码">
                </div>
                <div class="form-item form-item-columnX2">
                    <div class="input-item fl">
                        <input type="text" name="code" class="code-input" id="codeInput" placeholder="输入验证码">
                    </div>
                    <button class="fr send-code-btn" id="sendCode" type="button" disabled="disabled">发送验证码<button>
                </div>

                <div class="form-item">
                    <input type="submit" id="submit" class="submit" value="下一步" disabled="disabled" style="margin-top: 84px">
                </div>
            </div>
        </form>`);

        const $phoneNumberInput = $forgetForm.find('#phoneNumberInput');
        const $submit = $forgetForm.find('#submit');
        const $sendCode = $forgetForm.find('#sendCode');
        const $codeInput = $forgetForm.find('#codeInput');
        let phoneNumber = '';
        let timeInterval = null;
        let timeWhile = 60;

        $phoneNumberInput.blur(e => {
            phoneNumber = $phoneNumberInput.val();
            if (!isPoneAvailable(phoneNumber)) {
                showInputErrror($phoneNumberInput, '请输入正确手机号码');
                $sendCode.attr("disabled", true);
                hideInputSuccess($phoneNumberInput);
                return false;
            };

            if (timeInterval === null) {
                $sendCode.removeAttr("disabled");
            };
            hideInputErrror($phoneNumberInput);
            showInputSuccess($phoneNumberInput);

            /***  TODO 验证手机号码是否注册 ***/
        });

        /**
         * 点击发送验证码
         */
        $sendCode.click(e => {
            $sendCode.attr("disabled", false);

            /** 发送成功状态 **/
            timeInterval = setInterval(() => {
                if (timeWhile < 1) {
                    clearInterval(timeInterval);
                    timeInterval = null;
                    timeWhile = 60;
                    $sendCode.text('重新获取').attr("disabled", false);
                    return;
                };
                timeWhile--;
                $sendCode.attr("disabled", true).text(`重新获取(${timeWhile}S)`);
            }, 1000);
        });

        $codeInput.on('input propertychange', e => {
            if ($codeInput.val() === '') {
                $submit.removeClass('active').attr("disabled");
                return false;
            };

            $submit.addClass('active').removeAttr("disabled", true);
        });


        $('#overlookForm').submit(function (e) {
            e.preventDefault();
            const param = $(this).serializeArray();
            console.log(param)
            /********  TODO 提交表单  *********/
            resetPassModal();
        });
    });

    /**
     * 点击打开重置密码 弹窗
     */
    function resetPassModal(params) {
        hideModal();

        showModal({
            title: '忘记密码'
        },
            `<form id="resetPassForm">
            <div class="form-wrap form-wrap-reg">
                <div class="form-item">
                    <input type="password" name="pass" class="pass-input" placeholder="新密码 (密码由大小写字母和数字组成)">
                </div>
                <div class="form-item">
                    <input type="password" name="confirmPass" class="pass-input" placeholder="确认新密码">
                </div>

                <div class="form-item">
                    <input type="submit" id="submit" class="submit" value="完成" disabled="disabled" style="margin-top: 84px">
                </div>
            </div>
        </form>`);

        const $passInput = $('#resetPassForm .pass-input');
        const $submit = $('#submit');
        let pass = '';

        $passInput.eq(0).on('input propertychange', function (e) {
            pass = $(this).val();
            if (!validatePass(pass)) {
                $submit.removeClass('active').attr("disabled", true);
                showInputErrror($(this), '密码格式不正确');
                return false;
            };

            hideInputErrror($(this));
            $submit.addClass('active').removeAttr("disabled");
        });

        $passInput.eq(1).on('input propertychange', function (e) {
            if (pass !== $(this).val()) {
                showInputErrror($(this), '两次密码不一致');
                return false;
            };
            hideInputErrror($(this));
        });

        $('#resetPassForm').submit(function (e) {
            e.preventDefault();
            const param = $(this).serializeArray();

            if (param[0].value !== param[1].value) {
                showInputErrror($passInput.eq(1), '两次密码不一致');
                return false;
            };

            /********  TODO 提交表单  *********/
        });
    };

    /**
     * 密码眨眼睛效果
     */
    let imgSrc = [require('./../images/icon/icon-eyes.png'), require('./../images/icon/icon-visit.png')];
    $(document).on('input propertychange', '[type="password"]', function (params) {
        if ($(this).val() === '') {
            $(this).parent().find('.switch-input').remove();
            return false;
        };

        if (!($(this).parent().find('.switch-input').length > 0)) {
            $(this).parent().append(`
                <i class="switch-input" data-img="${imgSrc[1]}" data-off="1">
                    <img class="icon-arrow" src="${imgSrc[0]}" width="24" height="24" alt="">
                </i>
            `);
        };

    });
    $(document).on('click', '.switch-input', function (params) {
        if ($(this).attr('data-off') == 1) {
            $(this).find('img').attr('src', imgSrc[1]);
            $(this).attr('data-off', 0).siblings('[type="password"]').attr('type', 'text');
            return;
        };

        if ($(this).attr('data-off') == 0) {
            $(this).find('img').attr('src', imgSrc[0]);
            $(this).attr('data-off', 1).siblings('[type="text"]').attr('type', 'password');
        };
    });

    $('.clickThrowCraft').click(function (e) {
        
        layer.open({
            type: 1,
            title: false,
            area: ['auto', 'auto'],
            closeBtn: 0,
            shade: [0.8, '#000'],
            shadeClose: true,
            content: throwCraftModalTpl
        });

        $('.close').click(function (e) {
            layer.close(layer.index);
        });
    });

    $('.clickEnter').click( e => {
        layer.open({
            type: 1,
            title: false,
            area: ['auto', 'auto'],
            closeBtn: 0,
            shade: [0.8, '#000'],
            shadeClose: true,
            content: enterModalTpl
        });

        $('.closeModal').click(function (e) {
            layer.close(layer.index);
        });

        treeSelect($,{s1: 'provid',s2: 'cityid',s3: 'areaid',v1: null,v2: null,v3: null}, $('.layui-form'), form);
    });


});

module.exports = {
    hideModal,
    showModal,
    showInputSuccess,
    hideInputSuccess,
    showInputErrror,
    hideInputErrror
}