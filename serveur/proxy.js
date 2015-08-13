var less = require('less');
var fs = require('fs');

function proxy(root) {
    return function(req, res) {
        var extension = req.originalUrl.split('.').reverse()[0];
        switch (extension) {
            case 'js':
                res.setHeader('Content-Type', 'application/javascript');
                break;
            case 'css':
                res.setHeader('Content-Type', 'text/css');
                break;
            case 'less':
                res.setHeader('Content-Type', 'text/css');
                break;
            case 'html':
                res.setHeader('Content-Type', 'text/html');
                break;
        }
        switch (extension) {
            case 'less':
                fs.readFile('../' + root + req.path, 'utf-8', function(err, lessdata) {
                        if (err) console.log(err);
                        else {
                            console.log(lessdata);
                            less.render(lessdata, {
                                    paths: ['../web/css'], // Specify search paths for @import directives
                                    filename: 'style.less', // Specify a filename, for better error messages
                                    compress: true // Minify CSS output
                                },
                                function(err, output) {
                                    if(err) console.log(err);
                                    res.end(output.css);
                                });
                        }
                    });
                break;
                
            default:
                res.sendFile(req.path, {
                    'root': '../' + root
                });
                break;
        }
    };
}

exports.proxy = proxy;