module.exports = function(grunt) {
    // Configuration
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        wget: {
            libs: {
                files: {
                    'libs/bootstrap.zip': 'https://github.com/twbs/bootstrap/releases/download/v3.3.5/bootstrap-3.3.5-dist.zip',
                    'libs/material-bootstrap.zip': 'http://cdn.jsdelivr.net/bootstrap.material-design/0.3.0/bootstrap.material-design.zip',
                    'libs/nprogress.zip': 'https://github.com/rstacruz/nprogress/archive/master.zip',
                    'libs/jquery.min.js': 'http://code.jquery.com/jquery-2.1.4.min.js',
                    'libs/moment.min.js': 'http://momentjs.com/downloads/moment-with-locales.js'
                }
            }
        },
        unzip: {
            'libs': 'libs/{bootstrap,nprogress}.zip',
            'libs/material': 'libs/material-bootstrap.zip'
        },
        rename: {
            libs: {
                files: [{
                    src: ['libs/bootstrap-3.3.5-dist'],
                    dest: 'libs/bootstrap'
                }, {
                    src: ['libs/nprogress-master'],
                    dest: 'libs/nprogress'
                }]
            }
        },
        clean: {
            clean: ["libs"],
            libs: ["libs/*.zip"]
        }
    });

    // Chargement des plugins
    grunt.loadNpmTasks('grunt-wget');
    grunt.loadNpmTasks('grunt-zip');
    grunt.loadNpmTasks('grunt-contrib-rename');
    grunt.loadNpmTasks('grunt-contrib-clean');

    // Tâches
    //grunt.registerTask('clean', ['clean:clean']);
    grunt.registerTask('libs', ['clean:clean', 'wget:libs', 'unzip', 'rename:libs', 'clean:libs']);
    grunt.registerTask('default', ['libs']);

};