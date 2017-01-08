function textModel() {
    var self = this;
    self.textString = ko.observable('');
    self.sections = ko.observableArray([]);
    self.firstSection = ko.observable('');
    self.textString.subscribe(function(string) {
        var sectionLength = 140;
        self.sections(string.match(new RegExp('.{1,' + 140 + '}', 'g')));
    });
}

function init() {
    var textSplitter = new textModel();
    ko.applyBindings(textSplitter);
}

module.exports = {
    init: init
}
