function req(method, url, cb, err) {
    var request = new XMLHttpRequest();
    request.open(method, url, true);
    request.onload = function() {
        if (request.status >= 200 && request.status < 400) {
            var resp = JSON.parse(request.responseText);
            cb(resp);
        } else {
            err(request.statusText)
        }
    };
    request.send();
}

module.exports = {
    req: req
}
