webpackJsonp([3],{68:function(t,e,r){"use strict";(function(t){var e=r(2),i=r(5);r(69),layui.define(["form","layer"],function(){function r(){(0,e.hideModal)(),(0,e.showModal)({title:"设置密码"},t("#setUpPassFormTpl").html());var r=t("#setUpPassForm .pass-input"),a=t("#submit"),o="";r.eq(0).on("input propertychange",function(r){if(o=t(this).val(),!(0,i.validatePass)(o))return a.removeClass("active").attr("disabled",!0),(0,e.showInputErrror)(t(this),"密码格式不正确"),!1;(0,e.hideInputErrror)(t(this)),a.addClass("active").removeAttr("disabled")}),r.eq(1).on("input propertychange",function(r){if(o!==t(this).val())return(0,e.showInputErrror)(t(this),"两次密码不一致"),!1;(0,e.hideInputErrror)(t(this))}),t("#setUpPassForm").submit(function(i){i.preventDefault();var a=t(this).serializeArray();if(a[0].value!==a[1].value)return(0,e.showInputErrror)(r.eq(1),"两次密码不一致"),!1})}function r(){(0,e.hideModal)(),(0,e.showModal)({title:"修改密码"},t("#reviseFormTpl").html());var r=t("#revisePassForm .pass-input"),a=t("#submit"),o="";r.eq(0).on("input propertychange",function(r){if(!(0,i.validatePass)(o))return a.removeClass("active").attr("disabled",!0),(0,e.showInputErrror)(t(this),"密码格式不正确"),!1;(0,e.hideInputErrror)(t(this)),a.addClass("active").removeAttr("disabled")}),r.eq(1).on("input propertychange",function(r){if(o=t(this).val(),!(0,i.validatePass)(o))return a.removeClass("active").attr("disabled",!0),(0,e.showInputErrror)(t(this),"密码格式不正确"),!1;(0,e.hideInputErrror)(t(this)),a.addClass("active").removeAttr("disabled")}),r.eq(2).on("input propertychange",function(r){if(o!==t(this).val())return(0,e.showInputErrror)(t(this),"两次密码不一致"),!1;(0,e.hideInputErrror)(t(this))}),t("#revisePassForm").submit(function(i){i.preventDefault();var a=t(this).serializeArray();if(a[0].value!==a[1].value)return(0,e.showInputErrror)(r.eq(1),"两次密码不一致"),!1})}t("#setUpPass").click(function(t){r()}),t("#revisePass").click(function(t){r()}),t("#setUpPhoneFormBtn").click(function(r){var a=(0,e.showModal)({title:"忘记密码"},t("#validatePhoneFormTpl").html()),o=a.find("#phoneNumberInput"),n=a.find("#submit"),s=a.find("#sendCode"),d=a.find("#codeInput"),l="",u=null,p=60;o.blur(function(t){if(l=o.val(),!(0,i.isPoneAvailable)(l))return(0,e.showInputErrror)(o,"请输入正确手机号码"),s.attr("disabled",!0),(0,e.hideInputSuccess)(o),!1;null===u&&s.removeAttr("disabled"),(0,e.hideInputErrror)(o),(0,e.showInputSuccess)(o)}),s.click(function(t){s.attr("disabled",!1),u=setInterval(function(){if(p<1)return clearInterval(u),u=null,p=60,void s.text("重新获取").attr("disabled",!1);p--,s.attr("disabled",!0).text("重新获取("+p+"S)")},1e3)}),d.on("input propertychange",function(t){if(""===d.val())return n.removeClass("active").attr("disabled"),!1;n.addClass("active").removeAttr("disabled",!0)}),t("#validatePhoneForm").submit(function(e){e.preventDefault();var r=t(this).serializeArray();console.log(r),resetPassModal()})})})}).call(e,r(3))},69:function(t,e,r){var i=r(70);"string"==typeof i&&(i=[[t.i,i,""]]);var a={};a.transform=void 0,r(1)(i,a),i.locals&&(t.exports=i.locals)},70:function(t,e,r){var i=r(4);e=t.exports=r(0)(!1),e.push([t.i,'.header{background:#1c1c1c}.main{width:800px;margin:auto;padding-top:80px}.upload-head{overflow:hidden;border-radius:50%;width:150px;height:150px;margin:auto;position:relative;cursor:pointer;margin-top:140px}.upload-head:after{width:100%;height:100%;background:rgba(0,0,0,.5)}.upload-head:after,.upload-head:before{content:"";position:absolute;top:0;left:0}.upload-head:before{bottom:0;right:0;margin:auto;width:40px;height:34px;background:url('+i(r(71))+") no-repeat 50%;z-index:1}.datum-list{padding-top:70px}.datum-list h2{font-size:22px;color:#333;line-height:46px}.datum-list .item{border-bottom:1px solid #ddd;padding:56px 0 20px;line-height:44px;overflow:hidden}.datum-list .item .pd-right-20{padding-right:20px}.datum-list .item .label{font-size:20px;color:#666}.datum-list .item .label span{padding-left:15px}.datum-list .item .value{font-size:20px;color:#1c1c1c;padding-left:40px}.datum-list .item .value.no{color:#fb6e3a}.datum-list .item .operation-btn{float:right;width:120px;height:46px;background:#cdaf6e;border-radius:2px;color:#fff;font-size:20px;cursor:pointer}.datum-list .item .operation-btn.defalt{background:none;border:1px solid #cdaf6e;color:#cdaf6e}.modal-popup{height:440px}",""])},71:function(t,e,r){t.exports=r.p+"images/1f42fc2c63a26d3f33d81eff8b9751dc.png"}},[68]);
//# sourceMappingURL=memberSetUp.bundle.js.map