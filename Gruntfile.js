module.exports = function(grunt) {
    grunt.initConfig({
        uglify: {
            options: {
                preserveComments: 'some'
            },
            my_target: {
                files: {
                    'web/js/editeur.min.js': ['web/js/src/editeur.js', 'web/js/src/general.js']
                }
            }
        },
        cssmin: {
            options: {
                report: 'gzip'
            },
            combine: {
                files: {
                    'web/css/editeur.min.css': [
                        'web/css/src/editeur.css',
                        'web/css/src/global.css'
                    ],
                    'web/css/login.min.css': [
                        'web/css/src/login.css'
                    ]
                }
            }
        },
        jshint: {
            all: ['Gruntfile.js', 'web/js/src/*.js']
        }
    });

    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-jshint');

    grunt.registerTask('default', ['uglify', 'cssmin', 'jshint']);
};