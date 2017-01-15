var $ = require('cash-dom');

function textModel() {
    if($('.js-handle').length > 0 && $('.js-handle').text() != '') {
        var handle = $('.js-handle').text().replace('@', '');
        var self = this;
        self.handle = ko.observable(handle);
        self.textString = ko.observable('');
        self.sections = ko.observableArray([]);
        self.textString.subscribe(function(string) {
            if(string.length > 0) {
                var handleLength = self.handle().length;
                var sectionLength = 140 - handleLength;
                var firstTweet = string.match(new RegExp('.{1,' + 140 + '}', 'g'))[0];
                self.sections([firstTweet]);
                var remainingChars = string.slice(firstTweet.length);
                if(remainingChars) {
                    var otherTweets = remainingChars.match(new RegExp('.{1,' + sectionLength + '}', 'g'));
                    self.sections(self.sections().concat(otherTweets));
                }
            } else {
                self.sections([]);
            }
        });
    }
}

module.exports = {
    textModel: textModel
}
