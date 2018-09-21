const enterModalTpl = `
      <section class="modal-popup enter-modal-popup" id="modalPopup">
            <div class="modal-header">
                <!-- <div class="yes-login">
                    <img class="fl img" width="44" height="44" src="http://p3.music.126.net/gK0nqK8iiG1o6axkHmmqrQ==/109951163416312552.jpg?param=50y50" alt="">
                    <p class="name">蓝天绿树配白云</p>
                </div> -->
                <div class="no-login">
                    <p>您还没有登录，请先登录！</p>
                    <a href="javascript:void(0);" class="clickLogin login-btn">立即登录</a>
                </div>
                
                <img width="25" class="closeModal vip-close" src="${require('./../images/icon/icon-close2.png')}" alt="">
            </div>
            <div class="modal-main">
                
                <form class="layui-form" id="enterForm">
                    
                    <div class="form-wrap">

                        <h1 class="title">入驻GUITARCIA</h1>
                        <div class="layui-form-item">
                            <label class="layui-form-label">门店名称</label>
                            <div class="layui-input-block">
                                <input type="text" name="title" required lay-verify="required" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">联系人</label>
                            <div class="layui-input-block">
                                <input type="text" name="title" required lay-verify="required" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">联系方式</label>
                            <div class="layui-input-block">
                                <input type="text" name="title" required lay-verify="required" autocomplete="off" class="layui-input">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">选择地区</label>
                            <div class="layui-input-inline layui-input-inline-select">
                                <select name="provid" id="provid" lay-filter="provid">
                                    <option value="">请选择省</option>
                                </select>
                            </div>
                            <div class="layui-input-inline layui-input-inline-select">
                                <select name="cityid" id="cityid" lay-filter="cityid">
                                    <option value="">请选择市</option>
                                </select>
                            </div>
                            <!-- <div class="layui-input-inline">
                                <select name="areaid" id="areaid" lay-filter="areaid">
                                    <option value="">请选择县/区</option>
                                </select>
                            </div> -->
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">详细地址</label>
                            <div class="layui-input-block">
                                <input type="text" name="title" required lay-verify="required"autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">授权品牌</label>
                            <div class="layui-input-block">
                                <input type="text" name="title" required lay-verify="required" autocomplete="off" class="layui-input">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label" style=" line-height: 26px; ">上传授权 品牌证书</label>
                            <div class="layui-input-block" style="text-align:left;">
                                <button type="button" class="layui-btn-file"><img src="${require('./../images/icon/icon-add999999.png')}" alt=""></button>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label" style=" line-height: 26px; ">上传营业 执照</label>
                            <div class="layui-input-block" style="text-align:left;">
                                <button type="button" class="layui-btn-file">
                                    <img src="${require('./../images/icon/icon-add999999.png')}" alt="">
                                </button>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label" style=" line-height: 26px; ">上传门店 照片</label>
                            <div class="layui-input-block" style="text-align:left;">
                                <button type="button" class="layui-btn-file" style="height:139px;">
                                    <img src="${require('./../images/icon/icon-add999999.png')}" alt="">
                                </button>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <button class="layui-btn enterForm-submit" lay-submit lay-filter="formDemo">立即提交</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
`;

const throwCraftModalTpl = `
    <div class="toast" style="width:600px;height:430px;">
        <p style="font-size:20px;color:#333;margin-top:100px;line-height:39px;"> 如有投稿需求，请把文章发送到邮箱</p>
        <p style="font-size:24px;color:#CDAF6E;line-height:39px;">hi@guitarcia.com</p>
        <p style="font-size:20px;color:#333;line-height:39px;">我们收到后邮件后会及时回复您</pp>

        <button type="button" class="close" style="cursor: pointer;display:block;margin:90px auto 0;outline:none;width:190px;height:42px;background:#CDAF6E;border-radius:4px;color:#fff;font-size:16px;">好的，知道了</button>
    </div>
`;

module.exports = {
    enterModalTpl,
    throwCraftModalTpl
}