module.exports = function(grunt) {
    grunt.initConfig({
        uglify: {
            options: {
                preserveComments: 'some'
            },
            my_target: {
                files: {
                    'min/editeur.min.js': ['js/editeur.js', 'js/general.js']
                }
            }
        },
        cssmin: {
            options: {
                report: 'gzip'
            },
            combine: {
                files: {
                    'min/editeur.min.css': [
                        'css/editeur.css',
                        'css/global.css'
                    ]
                }
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-cssmin');

    grunt.registerTask('default', ['uglify', 'cssmin']);

};