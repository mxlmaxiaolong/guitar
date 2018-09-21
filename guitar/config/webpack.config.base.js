const path = require("path")
const HTMLWebpackPlugin = require("html-webpack-plugin");
const CleanWebpackPlugin = require("clean-webpack-plugin");
const ExtractTextPlugin = require("extract-text-webpack-plugin");
const webpack = require('webpack');

const config = require("./config");
let HTMLPlugins = [];
let Entries = {}

config.HTMLDirs.forEach((page,index) => {
    const htmlPlugin = new HTMLWebpackPlugin({
        //生成的文件名
        filename: `${page}.html`,
        //根据自己的指定的模板文件来生成特定的 html 文件
        template: path.resolve(__dirname, `../app/pages/${page}/index.html`),
        //生成html的title
        title:'hello'+page,
        //生成的favicon.ico
        //给生成的 js 文件一个独特的 hash 值,是文件名后带？的那个hash,output中的[chunkhash]是文件名中带hash
        hash:false, //不需要 hash, 后端会增加
        //chunks 选项的作用主要是针对多入口(entry)文件。当你有多个入口文件的时候，对应就会生成多个编译后的 js 文件。那么 chunks 选项就可以决定是否都使用这些生成的 js 文件。
        //chunks 默认会在生成的 html 文件中引用所有的 js 文件，当然你也可以指定引入哪些特定的文件。
        chunks: [page, 'commons'],
        inject: 'head'
    });
    HTMLPlugins.push(htmlPlugin);
    Entries[page] = path.resolve(__dirname, `../app/pages/${page}/index.js`);
})

module.exports = {
    entry: Entries,
    devtool: 'cheap-module-source-map',
    output:{
        filename:"js/[name].bundle.js",
        path:path.resolve(__dirname,"../dist")
    },
    module: {
        rules: [
            // { // 对 css 后缀名进行处理
            //     test: /\.(scss|css)$/,
            //     // 不处理 node_modules 文件中的 css 文件
            //     exclude: /node_modules/,
            //     // 抽取 css 文件到单独的文件夹
            //     use: ExtractTextPlugin.extract({
            //         fallback: "style-loader",
            //         publicPath: config.cssPublicPath,
            //         use: [
            //             {loader: "css-loader", options: {minimize: true,}},
            //             {
            //                 loader: "sass-loader" // compiles Sass to CSS
            //             },
            //             {loader: "postcss-loader",}
            //         ]
            //     })

            // },
            {
                test: /\.(scss|css)$/,
                use: [
                    {
                        loader: "style-loader" // creates style nodes from JS strings
                    },
                    {
                        loader: "css-loader" // translates CSS into CommonJS
                    },
                    {
                        loader: "sass-loader" // compiles Sass to CSS
                    },
                    { 
                        loader: "postcss-loader"
                    }
                ]
            },
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['env']
                    }
                }
            },
            {
                test: /\.(png|jpg|gif)/,
                use: [
                    {
                        loader: 'url-loader',
                        options: {
                            limit: 100,
                            outputPath: 'images/'
                        },
                    }
                ]
            },
            {
                test: /\.(htm|html)$/,
                use: 'html-withimg-loader'
            },
            {
                test: /\.(woff|woff2|eot|ttf|otf)$/,
                use:["file-loader"]
            },
            {
                test: /\.(html)$/,
                loader: path.resolve(__dirname, `./loader/html-layout-loader.js`),
                options: {
                    layout: path.resolve(__dirname, `../app/template`) // the path of default layout html
                }
            }
        ]
    },
    plugins: [
        new webpack.ProvidePlugin({ //加载jq
            $: 'jquery',
            jQuery: "jquery",
            "window.jQuery": "jquery"
        }),
        // 自动清理 dist 文件夹
        new CleanWebpackPlugin(["dist"]),
        // 将 css 抽取到某个文件夹
        new ExtractTextPlugin(config.cssOutputPath),
        // 自动生成 HTML 插件
        ...HTMLPlugins


    ]
}