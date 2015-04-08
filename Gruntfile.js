module.exports = function(grunt) {
	// Your grunt code goes in here.
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		lint: {
			files: [
				'templates/assets/js/src/**/*.js'
			]
		},
		concat: {
			dist: {
				src: '<%= lint.files %>',
				dest: 'templates/assets/js/<%= pkg.name %>.js',
				separator: ';'
			}
		},
		min: {
			dist: {
				src: ['templates/assets/js/<%= pkg.name %>.js'],
				dest: 'templates/assets/js/<%= pkg.name %>.min.js'
			}
		},
		watch: {
			scripts: {
				files: ['<%= lint.files %>'],
				tasks: ['concat', 'uglify']
			},
			sass: {
				files: ['templates/assets/scss/**/*.{scss,sass}'],
				tasks: ['sass:dist']
			}
		},
		sass: {
			dist: {
				files: {
					'templates/assets/css/style.css': 'templates/assets/scss/style.scss'
				}
			}
		},
		uglify: {
			options: {
				banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-dd-mm") %> */\n'
			},
			dist: {
				files: {
					'templates/assets/js/<%= pkg.name %>.min.js': ['<%= concat.dist.dest %>']
				}
			}
		}
  });

  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-qunit');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.loadNpmTasks('grunt-contrib-coffee');
  grunt.loadNpmTasks('grunt-sass');

  grunt.registerTask('default', ['concat', 'uglify', 'watch']);

};
