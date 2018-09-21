import { hideModal, showModal, showInputSuccess, hideInputSuccess, showInputErrror, hideInputErrror } from './../../js/common.js';
import { isPoneAvailable, validatePass, treeSelect } from './../../js/util.js';
import './index.scss';

layui.define(['form', 'layer'], () => {

    $('#setUpPass').click( e => {
        setUpPassModal();
    });

    $('#revisePass').click(e => {
        setUpPassModal();
    });

    /**
     * 点击打开设置密码 弹窗
     */
    function setUpPassModal() {
        hideModal();

        showModal({
            title: '设置密码'
        }, $('#setUpPassFormTpl').html());

        const $passInput = $('#setUpPassForm .pass-input');
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

        $('#setUpPassForm').submit(function (e) {
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
     * 点击打开修改密码 弹窗
     */
    function setUpPassModal() {
        hideModal();

        showModal({
            title: '修改密码'
        }, $('#reviseFormTpl').html());

        const $passInput = $('#revisePassForm .pass-input');
        const $submit = $('#submit');
        let pass = '';

        $passInput.eq(0).on('input propertychange', function (e) {
            if (!validatePass(pass)) {
                $submit.removeClass('active').attr("disabled", true);
                showInputErrror($(this), '密码格式不正确');
                return false;
            };

            hideInputErrror($(this));
            $submit.addClass('active').removeAttr("disabled");
        });

        $passInput.eq(1).on('input propertychange', function (e) {
            pass = $(this).val();
            if (!validatePass(pass)) {
                $submit.removeClass('active').attr("disabled", true);
                showInputErrror($(this), '密码格式不正确');
                return false;
            };

            hideInputErrror($(this));
            $submit.addClass('active').removeAttr("disabled");
        });

        $passInput.eq(2).on('input propertychange', function (e) {
            if (pass !== $(this).val()) {
                showInputErrror($(this), '两次密码不一致');
                return false;
            };
            hideInputErrror($(this));
        });

        $('#revisePassForm').submit(function (e) {
            e.preventDefault();
            const param = $(this).serializeArray();

            if (param[0].value !== param[1].value) {
                showInputErrror($passInput.eq(1), '两次密码不一致');
                return false;
            };

            /********  TODO 提交表单  *********/
        });
    };

    $('#setUpPhoneFormBtn').click( e => {
        let $forgetForm = showModal({title: '忘记密码'}, $('#validatePhoneFormTpl').html());

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


        $('#validatePhoneForm').submit(function (e) {
            e.preventDefault();
            const param = $(this).serializeArray();
            console.log(param)
            /********  TODO 提交表单  *********/
            resetPassModal();
        });
    });
});