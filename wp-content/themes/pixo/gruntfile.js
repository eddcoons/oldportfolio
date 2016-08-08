module.exports = function(grunt) {
  grunt.initConfig({
    watch: {
      live: {
        // WARNING: Too files with the same name in different location can break the live reload
        files: ['**/*.js', '**/*.php', 'framework/*.php', 'framework/**/*.php', 'framework/**/*', 'partials/*.php', '**/*.css', 'css/*.php', 'rtl.css', 'css/*.css' ],
        options: {
          livereload: true
        }
      },
      coffee: {
        files: ['vc_templates/*.coffee', 'framework/js/*.coffee'],
        tasks: ['coffee:compile']
      },
      concat: {
        files: ['assets/*.js'],
        tasks: ['concat:dist']
      },
      uglify: {
        files: ['assets/*.js'],
        tasks: ['uglify:scripts']
      },
      scss: {
        files: ['sass/*.scss', ],
        tasks: ['sass'],
        options: {
          livereload: false
        }
      }

    },
    coffee: {
      compile: {
        files: {
          'vc_templates/vc_zx_range.js': 'vc_templates/vc_zx_range.coffee',
          'framework/js/framework.js': 'framework/js/framework.coffee'
        },
        'framework/js/framework.js': 'framework/js/framework.coffee'
      }
    },
    validation: {
      options: {
        charset: 'utf-8'
      },
      reset: grunt.option('reset') || true,
      stoponerror: false,
      remotePath: 'http://localhost/~admin/wp_horizon/',
      remoteFiles: ['home', 'portfolio', 'blog'],
      relaxerror: ["Bad value X-UA-Compatible for attribute http-equiv on element meta.", 'Section lacks heading. Consider using h2-h6 elements to add identifying headings to all sections.', 'Consider using the h1 element as a top-level heading only'],
      files: {
        src: ['*.php']
      }
    },

    concat: {
      dist: {
        options: {
          separator: grunt.util.linefeed + ';' + grunt.util.linefeed
        },
        src: ['assets/*.js', 'assets/ytplayer/*.js', 'assets/tipsy/*.js', 'assets/prettyphoto/js/*.js', 'assets/bxslider/*.js', 'assets/isotope/*.js', 'assets/animate/*.js',  'assets/select2/*.js'],
        dest: 'js/scripts.js'
      },
      vp: {
        // options: {
        //   separator: grunt.util.linefeed + ';' + grunt.util.linefeed
        // },
        src: ['framework/vafpress-framework/public/css/vendor/font-awesome.min.css', 'framework/vafpress-framework/public/css/vendor/reveal.css', 'framework/vafpress-framework/public/css/vendor/select2.css',  'framework/vafpress-framework/public/css/vendor/tipsy.css', 'framework/vafpress-framework/public/css/shortcode.min.css', 'framework/vafpress-framework/public/css/metabox.min.css'],
        dest: 'framework/vafpress-framework/public/css/pagesposts-concat.min.css'
      },
      less: {
        src: ['css/theme.css', 'css/woocommerce.css'],
        dest: 'css/theme-style.css'
      }
    },

    uglify: {
      options: {
        compress: {
          drop_console: true
        },
        preserveComments: true
      },
      uglify: {
        files: [
          {
            expand: true,
            src: ['js/scripts.js', 'js/plugins.js']
          }
        ]
      }
    },
    chmod: {
      options: {
        mode: '755'
      },
      fix: {
        src: ['framework/**/*']
      }
    },

    // Copy
    copy: {
	    release: {
	        files: [{
	            expand: true,
	            src: ['**' ],
	            dest: 'horizon/'
	        }]
	    },
    demo: {
      files: [{
              expand: true,
              src: ['horizon/**' ],
              dest: '/Users/admin/Sites/wp-demo/wp-content/themes/demo_themes/'
          }]
    },
     demo2: {
      files: [{
              expand: true,
              src: ['horizon/**' ],
              dest: '/Users/admin/Sites/wp-demo2/wp-content/themes/'
          }]
    },
    // Copy to wp-horizon-testing
    testing_data: {
      files: [{
              expand: true,
              src: ['horizon/**' ],
              dest: '/Users/admin/Sites/wp-horizon-testing/wp-content/themes/'
          }]
    },
    // Copy to WMPL
    wpml: {
      files: [{
              expand: true,
              src: ['horizon/**' ],
              dest: '/Users/admin/Sites/wpml/wp-content/themes/'
          }]
    },
    // Copy to woocommerce
    woocommerce: {
      files: [{
              expand: true,
              src: ['horizon/**' ],
              dest: '/Users/admin/Sites/woocommerce/wp-content/themes/'
          }]
    },

      wp_horizon_upload: {
      files: [{
              expand: true,
              src: ['horizon/**' ],
              dest: '/Users/admin/Documents/Themeing/theme_uploads/wp_horizon_upload/'
          }]
    }
	},
	// End Copy

	// Clean
	clean: {
		options: {
			 dot: true,
			 // 'no-write': true,
       force: true,
		},
    release_delete: ['horizon'],
		release: ['horizon/*.todo', 'horizon/*.json', 'horizon/*.po', 'horizon/horizon', 'horizon/**/.*', 'horizon/log', 'horizon/gruntfile.js', 'horizon/node_modules', 'horizon/bower_components'],
    demo: ['/Users/admin/Sites/wp-demo/wp-content/themes/horizon'],
    demo2: ['/Users/admin/Sites/wp-demo2/wp-content/themes/horizon'],
    testing_data: ['/Users/admin/Sites/wp-horizon-testing/wp-content/themes/horizon'],
    wpml: ['/Users/admin/Sites/wpml/wp-content/themes/horizon'],
    upload_folder: ['/Users/admin/Documents/Themeing/theme_uploads/wp_horizon_upload/horizon'],
    delete_created_folder: ['horizon']
	},
	// End Clean


	// Rename
  rename: {
        release: {
            src: 'horizon.zip',
            dest: '/Users/admin/Documents/Themeing/theme_uploads/wp_horizon_upload/horizon.zip'
        },
	},
	// End Rename

	// Compress
	compress: {
		release: {
			options: {
				archive: 'horizon.zip'
				},
				files: [
					{ src: ['horizon/**'] }, // includes files in path
				]
			}
		},
	// End Compress

  // Make pot
  makepot: {
    target: {
      options: {
                  domainPath: '/languages/',    // Where to save the POT file.
                  potFilename: 'horizon.pot',   // Name of the POT file.
                  type: 'wp-theme',  // Type of project (wp-plugin or wp-theme).
                  exclude: ['framework/vafpress-framework/.*'],
                }
              }
            },
    // End Make pot

    flipcss: {
      app: {
        files: {
          'rtl.css': 'css/theme-style.css'
        }
      }
    },

// Sass
  sass: {
    dist: {
      files: {
        'css/woo-styling.css': 'sass/woo-styling.scss',
          'css/theme-style.css': 'sass/theme-theme-style.scss'
      }
    }
  }
// Sass End

  });

  grunt.loadNpmTasks('grunt-flipcss');
  grunt.loadNpmTasks('grunt-pot');
  grunt.loadNpmTasks( 'grunt-wp-i18n' ); // MAkepot
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-coffee');
  grunt.loadNpmTasks('grunt-html-validation');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-devtools');
  grunt.loadNpmTasks('grunt-chmod');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-copy');
  grunt.loadNpmTasks("grunt-php2html");
grunt.loadNpmTasks('grunt-contrib-clean');
grunt.loadNpmTasks('grunt-contrib-rename');
grunt.loadNpmTasks('grunt-contrib-compress');

grunt.loadNpmTasks('grunt-contrib-sass');

  grunt.registerTask('live', 'watch:live');
  grunt.registerTask('val', 'validation');
  grunt.registerTask('cc', 'concat');

   grunt.registerTask('export',[
    'clean:release_delete',
    'copy:release',
    'clean:release',
    'compress:release',
    'rename:release',
    // 'clean:release_test',
    'clean:demo',
    'clean:demo2',
    'clean:testing_data',
    'clean:wpml',
    'clean:upload_folder',
    'copy:demo',
    'copy:demo2',
    'copy:testing_data',
    'copy:wpml',
    'copy:wp_horizon_upload',
    'copy:woocommerce',
    'clean:delete_created_folder'
    ]);



  return grunt.registerTask('default', 'Try Logging', function() {
    return grunt.log.write('Running the default task');
  });
};
