var $ = require('cash-dom');

function textModel() {
    if($('.js-handle').length > 0 && $('.js-handle').text() != '') {
        var handle = $('.js-handle').text().replace('@', '');
        var self = this;
        self.handle = ko.observable(handle);
        self.textString = ko.observable('');
        self.sections = ko.observableArray([]);
        self.textString.subscribe(function(string) {
            self.sections(string.match(new RegExp('.{1,' + 140 + '}', 'g')));
        });
    }
}

module.exports = {
    textModel: textModel
}
