const fs = require('fs')
const path = require('path')
const loaderUtils = require('loader-utils')
const defaultOptions = {
    placeholder: '{{__content__}}',
    decorator: 'layout'
}

const render = (source, placeholder, layoutHtml) => {
    return source.replace(placeholder, layoutHtml)
}

module.exports = function (source) {
    this.cacheable && this.cacheable()
    const options = Object.assign(loaderUtils.getOptions(this), defaultOptions)

    const { placeholder, decorator, layout } = options
    const reg = new RegExp(`(@${decorator}\\()(.*?)\\)`, "g");
    const regArr = source.match(reg);
    var callback = this.async();

    if (regArr !== null) {
        let layoutObj = {};

        for (let index = 0; index < regArr.length; index++) {
            layoutObj[`tpl${index}`] = reg.exec(regArr[index]);
            reg.exec(regArr[index])
        }
        let layoutHtml = source;

        for (const key in layoutObj) {
            let item = layoutObj[key];
            let rs = path.resolve(this.resourcePath, '../', loaderUtils.urlToRequest(item[2]));
            item.push(fs.readFileSync(rs, 'utf-8'));
            layoutHtml = render(layoutHtml, item[0], item[3]);
        };
        callback(null, layoutHtml);
    } else {
        callback(null, source)
    };
}