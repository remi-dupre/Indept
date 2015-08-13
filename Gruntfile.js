module.exports = function(grunt) {
    // Configuration
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        wget: {
            libs: {
                files: {
                    'libs/bootstrap.zip': 'https://github.com/twbs/bootstrap/releases/download/v3.3.5/bootstrap-3.3.5-dist.zip',
                    'libs/material-bootstrap.zip': 'https://github.com/FezVrasta/bootstrap-material-design/archive/master.zip',
                    'libs/jquery.js': 'http://code.jquery.com/jquery-2.1.4.min.js',
                    'libs/moment.js': 'http://momentjs.com/downloads/moment-with-locales.js'
                }
            }
        },
        unzip: {
            'libs': 'libs/*.zip'
        },
        rename: {
            libs: {
                files: [{
                    src: ['libs/bootstrap-3.3.5-dist'],
                    dest: 'libs/bootstrap'
                }, {
                    src: ['libs/bootstrap-material-design-master'],
                    dest: 'libs/bootstrap-material'
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
    grunt.registerTask('libs', ['clean:clean', 'wget:libs', 'unzip:libs', 'rename:libs', 'clean:libs']);
    grunt.registerTask('default', ['libs']);

};