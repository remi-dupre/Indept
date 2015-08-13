function proxy(root) {
    return function(req, res) {
        var extension = req.originalUrl.split('.').reverse()[0];
        switch( extension ) {
            case 'js':
                res.setHeader('Content-Type', 'application/javascript');
                break;
            case 'css':
                res.setHeader('Content-Type', 'text/css');
                break;
            case 'html':
                res.setHeader('Content-Type', 'text/html');
                break;
        }
        
        res.sendFile(req.path, {'root': '../' + root});
    };
}

exports.proxy = proxy;