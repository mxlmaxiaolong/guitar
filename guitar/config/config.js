const fs = require('fs');
const path = require("path");

const viewFolderNames = fs.readdirSync(path.join(process.cwd(), 'app', 'pages'));
const utils = {
    generateEntryObj: function (viewFolderNames) {
        entryObj = {};
        viewFolderNames.forEach(function (value) {
            entryObj[value] = path.join(path.join(process.cwd()), 'app', 'pages', value, 'index.js');
        })
        return entryObj;
    },
    generateHtmlArray: function (viewFolderNames) {
        HtmlArray = [];
        viewFolderNames.forEach(function (value) {
            HtmlArray.push(value);
        })
        return HtmlArray;
    }
};

module.exports = {
    HTMLDirs: utils.generateHtmlArray(viewFolderNames),
    cssPublicPath:'../',
    imgOutputPath:"images/",
    cssOutputPath:"./css/styles.css",
    devServerOutputPath:'../dist'
}