import threeSelectData from './area.js';

/**
 * 验证手机号码
 * @param {String} num 手机号码
 */

const isPoneAvailable = num => {
    const reg = /^[1][3,4,5,7,8][0-9]{9}$/;
    if (!reg.test(num)) {
        return false;
    } else {
        return true;
    }
};

/**
 * 验证密码 至少包含大写字母，小写字母，数字，且不少于1位
 * @param {String} str 密码
*/
const validatePass = str => {
    return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[^]{1,30}$/.test(str);
};

function treeSelect($,config, $form, form) {
    config.v1 = config.v1 ? config.v1 : 110000;
    config.v2 = config.v2 ? config.v2 : 110100;
    config.v3 = config.v3 ? config.v3 : 110101;
    $.each(threeSelectData, function (k, v) {
        appendOptionTo($form.find('select[name=' + config.s1 + ']'), k, v.val, config.v1);
    });
    form.render();
    cityEvent(config);
    areaEvent(config);
    form.on('select(' + config.s1 + ')', function (data) {
        cityEvent(data);
        form.on('select(' + config.s2 + ')', function (data) {
            areaEvent(data);
        });
    });

    function cityEvent(data) {
        $form.find('select[name=' + config.s2 + ']').html("");
        config.v1 = data.value ? data.value : config.v1;
        $.each(threeSelectData, function (k, v) {
            if (v.val == config.v1) {
                if (v.items) {
                    $.each(v.items, function (kt, vt) {
                        appendOptionTo($form.find('select[name=' + config.s2 + ']'), kt, vt.val, config.v2);
                    });
                }
            }
        });
        form.render();
        config.v2 = $('select[name=' + config.s2 + ']').val();
        areaEvent(config);
    }
    function areaEvent(data) {
        $form.find('select[name=' + config.s3 + ']').html("");
        config.v2 = data.value ? data.value : config.v2;
        $.each(threeSelectData, function (k, v) {
            if (v.val == config.v1) {
                if (v.items) {
                    $.each(v.items, function (kt, vt) {
                        if (vt.val == config.v2) {
                            $.each(vt.items, function (ka, va) {
                                appendOptionTo($form.find('select[name=' + config.s3 + ']'), ka, va, config.v3);
                            });
                        }
                    });
                }
            }
        });
        form.render();
        form.on('select(' + config.s3 + ')', function (data) { });
    }
    function appendOptionTo($o, k, v, d) {
        var $opt = $("<option>").text(k).val(v);
        if (v == d) { $opt.attr("selected", "selected") }
        $opt.appendTo($o);
    }
}

/**
 * Ativate submit button
 */

const needActiateSubmitBtn = function () {

    if($('#regForm').length > 0 ) {
        if (isPoneAvailable($('#phoneNumberInput').val()) && $('#codeInput').val().length === 5 && $('#passInput').val().length > 6 ) {
            $('.modal-popup .form-wrap .submit').addClass('active').removeAttr("disabled");
        }
    } else {
        if (isPoneAvailable($('#phoneNumberInput').val()) && $('#passInput').val().length > 6 ) {
            $('.modal-popup .form-wrap .submit').addClass('active').removeAttr("disabled");
        }
    }

}

module.exports = {
    isPoneAvailable,
    validatePass,
    treeSelect,
    needActiateSubmitBtn
}