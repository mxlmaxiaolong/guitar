// 引入基础配置文件
const webpackBase = require("./webpack.config.base");
// 引入 webpack-merge 插件
const webpackMerge = require("webpack-merge");
// 引入配置文件
const config = require("./config");
const webpack = require("webpack");
// 合并配置文件
webpackBase.output = Object.assign(webpackBase.output, { publicPath: "/wp-content/themes/CIA/dist/"});
module.exports = webpackMerge(webpackBase, {
    //plugins: [
        //代码压缩

        //new webpack.SourceMapDevToolPlugin({})
        //提取公共 JavaScript 代码
        // new webpack.optimize.CommonsChunkPlugin({
        //     // chunk 名为 commons
        //     name: "commons", filename: "[name].bundle.js",
        // }),]
});

