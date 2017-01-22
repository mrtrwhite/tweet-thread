var $ = require('cash-dom');
var utils = require('./utils.js');
var textSplit = require('./textSplit.js');

function home() {
    $('.js-authorise').on('click', function(e) {
        utils.req('GET', '/authorise', function(data) {
            if(data.url) {
                window.location = data.url;
            }
        });
    }, function(err) {
        console.log(err);
    });
}

function tweet() {
    var textSplitter = new textSplit.textModel();
    ko.applyBindings(textSplitter);

    $('.js-send-tweets').on('click', function(e) {
        var sections = textSplitter.sections();
        var handle = $('.js-handle').text();
        utils.req('POST', '/send_tweets', function(data) {
            if(data.status === 200) {
                $('.js-chain-wrap').addClass('isHidden').on('transitionend', function() {
                    $('.js-results').removeClass('isError').text('Tweet thread successful.').addClass('isActive');
                });
            } else {
                $('.js-results').text('Tweet thread unsuccessful.').addClass('isError');
            }
        }, function(err) {
            if(err.status === 400) {
                window.location = '/';
            }
            if(err.status === 422) {
                $('.js-results').text('Missing required parameters.').addClass('isError');
            }
        }, {
            'sections': sections
        });
    }, function(err) {
        console.log(err);
    });
}

function init() {
    home();
    tweet();
}

module.exports = {
    init: init
}
