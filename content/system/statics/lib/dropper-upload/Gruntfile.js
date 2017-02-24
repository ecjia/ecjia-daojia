/*global module:false*/

// Less

module.exports = function(grunt) {

	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		meta: {
			banner: '/* \n' +
					' * <%= pkg.name %> v<%= pkg.version %> - <%= grunt.template.today("yyyy-mm-dd") %> \n' +
					' * <%= pkg.description %> \n' +
					' * <%= pkg.homepage %> \n' +
					' * \n' +
					' * Copyright <%= grunt.template.today("yyyy") %> <%= pkg.author.name %>; <%= pkg.license %> Licensed \n' +
					' */\n'
		},
		// JS Hint
		jshint: {
			options: {
				globals: {
					'jQuery': true,
					'$'     : true
				},
				browser:   true,
				curly:     true,
				eqeqeq:    true,
				forin:     true,
				freeze:    true,
				immed:	   true,
				latedef:   true,
				newcap:    true,
				noarg:     true,
				nonew:     true,
				smarttabs: true,
				sub:       true,
				undef:     true,
				validthis: true
			},
			files: [
				'src/<%= pkg.codename %>.js'
			]
		},
		// Copy
		copy: {
			main: {
				files: [
					{
						src: 'src/<%= pkg.codename %>.js',
						dest: '<%= pkg.codename %>.js'
					}
				]
			}
		},
		// Uglify
		uglify: {
			options: {
				report: 'min'
			},
			target: {
				files: {
					'<%= pkg.codename %>.min.js': [ '<%= pkg.codename %>.js' ]
				}
			}
		},
		// jQuery Manifest
		jquerymanifest: {
			options: {
				source: grunt.file.readJSON('package.json'),
				overrides: {
					name:     '<%= pkg.id %>',
					keywords: '<%= pkg.keywords %>',
					homepage: '<%= pkg.homepage %>',
					docs: 	  '<%= pkg.homepage %>',
					demo: 	  '<%= pkg.homepage %>',
					download: '<%= pkg.repository.url %>',
					bugs: 	  '<%= pkg.repository.url %>/issues',
					dependencies: {
						jquery: '>=1.7'
					}
				}
			}
		},
		// LESS
		less: {
			main: {
				files: {
					'<%= pkg.codename %>.css': 'src/<%= pkg.codename %>.less'
				}
			},
			min: {
				options: {
					report: 'min',
					cleancss: true
				},
				files: {
					'<%= pkg.codename %>.min.css': 'src/<%= pkg.codename %>.less'
				}
			}
		},
		// Auto Prefixer
		autoprefixer: {
			options: {
				borwsers: [ '> 1%', 'last 5 versions', 'Firefox ESR', 'Opera 12.1', '>= ie 8' ]
			},
			no_dest: {
				 src: '*.css'
			}
		},
		// Banner
		usebanner: {
			options: {
				position: 'top',
				banner: '<%= meta.banner %>'
			},
			files: {
				src: [
					'<%= pkg.codename %>.css',
					'<%= pkg.codename %>.js',
					'<%= pkg.codename %>.min.css',
					'<%= pkg.codename %>.min.js'
				]
			}
		},
		//Bower sync
		sync: {
			all: {
				options: {
					sync: [ 'name', 'version', 'description', 'author', 'license', 'homepage' ],
					overrides: {
						main: [
							'<%= pkg.codename %>.js',
							'<%= pkg.codename %>.css'
						],
						ignore: [ "*.jquery.json" ]
					}
				}
			}
		}
	});

	// Load tasks
	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-contrib-copy');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-jquerymanifest');
	grunt.loadNpmTasks('grunt-contrib-less');
	grunt.loadNpmTasks('grunt-autoprefixer');
	grunt.loadNpmTasks('grunt-banner');
	grunt.loadNpmTasks('grunt-npm2bower-sync');

	// Readme
	grunt.registerTask('buildReadme', 'Build Formstone README.md file.', function () {
		var pkg = grunt.file.readJSON('package.json'),
			extra = grunt.file.exists('src/README.md') ? '\n\n---\n\n' + grunt.file.read('src/README.md') : '';
			destination = "README.md",
			markdown = '<a href="http://gruntjs.com" target="_blank"><img src="https://cdn.gruntjs.com/builtwith.png" alt="Built with Grunt"></a> \n' +
					   '# ' + pkg.name + ' \n\n' +
					   pkg.description + ' \n\n' +
					   '- [Demo](' + pkg.demo + ') \n' +
					   '- [Documentation](' + pkg.homepage + ') \n\n' +
					   '#### Bower Support \n' +
					   '`bower install ' + pkg.name + '` ' +
					   extra;

		grunt.file.write(destination, markdown);
		grunt.log.writeln('File "' + destination + '" created.');
	});

	// Default task.
	grunt.registerTask('default', [ 'jshint', 'copy', 'uglify', 'jquerymanifest', 'less', 'autoprefixer', 'usebanner', 'sync', 'buildReadme' ]);

};