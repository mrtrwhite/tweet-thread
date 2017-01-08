var $ = require('cash-dom');
var utils = require('./utils.js');

function home() {
    $('.js-authorise').on('click', function(e) {
        utils.req('GET', '/authorise', function(data) {
            window.location = data.url;
        });
    }, function(err) {
        console.log(err);
    });
}

function init() {
    home();
}

module.exports = {
    init: init
}
