function req(method, url, cb, err, data) {
    var request = new XMLHttpRequest();
    request.open(method, url, true);
    request.onload = function() {
        if (request.status >= 200 && request.status < 400) {
            var resp = JSON.parse(request.responseText);
            cb(resp);
        } else {
            err(request)
        }
    };
    if(method === 'POST' && data) {
        request.setRequestHeader('Content-Type', 'application/json; charset=UTF-8');
        request.send(JSON.stringify(data));
    } else {
        request.send();
    }
}

module.exports = {
    req: req
}
