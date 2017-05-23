module.exports = function(grunt) {
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		concat: {
			options: {
				separator: '\n;'
			},
			basic: {
				src: ['webroot/js/bootstrap.js',
					  'webroot/js/permissionsKeyPress.js', 
					  'webroot/js/views.js',
					  'webroot/plugins/placeholder.js', 
					  'webroot/plugins/untInput.js'],
				dest: 'webroot/js/main.min.js'
			},
			vendor: {
				src: [
					  'webroot/js/lib/jquery-1.11.0.min.js', 
					  'webroot/js/lib/jquery-ui.min.js',
					  'webroot/js/lib/jquery.cookie.min.js', 
					  'webroot/js/lib/jquery.jscrollpane.min.js',
					  'webroot/js/lib/jquery.mousewheel.min.js', 
					  'webroot/js/lib/jquery.qtip.min.js', 
					  'webroot/js/lib/modernizr.min.js',
					  'webroot/js/lib/jquery.validate.min.js',
					  'webroot/plugins/validate.password.js'],
				dest: 'webroot/js/lib/vendors.min.js'
			},
			i18n: {
				files: {
					'webroot/locale/es_ES.js':'webroot/locale/_es_ES.js'
				}
			}
		},
		uglify: {
			options: {

			},
			dist: {
				files: {
					'<%= concat.basic.dest%>':['<%= concat.basic.dest%>'],					
					'webroot/locale/es_ES.js':['webroot/locale/_es_ES.js'],
				}
			}
		}
	});

	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-concat');

	grunt.registerTask('default', ['concat', 'uglify']);
}