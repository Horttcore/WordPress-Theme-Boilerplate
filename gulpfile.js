/**
 *
 * Gulp Plugins
 *
 */
var gulp = require('gulp'),
	plugins = require('gulp-load-plugins')({
		pattern: ['gulp-*', 'gulp.*',
			'rupture', 'typographic', 'lost', 'del', 'fs'
		],
	}),
	mainBowerFiles = require('main-bower-files'),
	browserSync = require('browser-sync').create();



/**
 *
 * Task: Browser Sync
 *
 * - Watch for file changes in dist folder
 * - Watch for a php file change
 * - Update browsers
 *
 */
gulp.task('browser-sync', function() {

	//watch files
	var files = [
		'./dist/**/*',
		'./**/*.php',
	];

	//initialize browsersync
	browserSync.init(files, {
		//browsersync with a php server
		proxy: "localhost/TEXTDOMAIN/",
		notify: false
	});

});



/**
 *
 * Task: Styles
 *
 * - Sourcemap
 * - Combine
 * - Concat
 * - Minify
 * - Sync browsers
 *
 */
gulp.task('styles', function () {
	var filterCSS = plugins.filter(['**/*.css']); // Broken by fancy
	return gulp.src(mainBowerFiles({
		    paths: {
		        bowerDirectory: 'src/bower_components',
		        bowerrc: '.bowerrc',
		        bowerJson: 'bower.json'
		    }
		}))
		.pipe(filterCSS)
		.pipe(plugins.addSrc.prepend('./src/styles/vars.styl'))
		.pipe(plugins.addSrc.append('./src/styles/plugins/**.styl'))
		.pipe(plugins.addSrc.append('./src/styles/modules/**.styl'))
		.pipe(plugins.addSrc.append('./src/styles/styles.styl'))
		.pipe(plugins.plumber({errorHandler: plugins.notify.onError("Error: <%= error.message %>")}))
		//.pipe(plugins.debug({title: 'Files:'}))
		.pipe(plugins.concat('styles.combined.styl'))
		.pipe(plugins.sourcemaps.init())
		.pipe(plugins.stylus({
			use: [
				plugins.rupture(),
				plugins.typographic(),
			]
		}))
		.pipe(plugins.postcss([
			plugins.lost(),
		]))
		.pipe(plugins.rucksack())
		.pipe(plugins.autoprefixer('last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
		.pipe(plugins.replace('url(\'images', 'url(\'../images'))
		.pipe(plugins.replace('url("images', 'url("../images'))
		.pipe(plugins.replace('../images/fancyBox/', '../images/'))
		.pipe(plugins.replace('../images/bxSlider/', '../images/'))
		.pipe(gulp.dest('dist/styles'))
		.pipe(plugins.cssnano())
		.pipe(plugins.rename({suffix: '.min'}))
		.pipe(plugins.sourcemaps.write('.'))
		.pipe(gulp.dest('dist/styles'))
		.pipe(plugins.notify("Styles updated"))
		.pipe(browserSync.stream());
});



/**
 *
 * Task: Login styles
 *
 * - Sourcemap
 * - Combine
 * - Concat
 * - Minify
 * - Sync browsers
 *
 */
gulp.task('loginstyles', function () {
	return gulp.src('./src/styles/login.styl')
		.pipe(plugins.addSrc.prepend('./src/styles/vars.styl'))
		.pipe(plugins.plumber({errorHandler: plugins.notify.onError("Error: <%= error.message %>")}))
		//.pipe(debug({title: 'Files:'}))
		.pipe(plugins.sourcemaps.init())
		.pipe(plugins.stylus({
			use: [
				plugins.rupture(),
				plugins.typographic(),
			]
		}))
		.pipe(plugins.postcss([
			plugins.lost(),
		]))
		.pipe(plugins.rucksack())
		.pipe(plugins.autoprefixer('last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
		.pipe(gulp.dest('dist/styles'))
		.pipe(plugins.cssnano())
		.pipe(plugins.minifyCss())
		.pipe(plugins.rename({suffix: '.min'}))
		.pipe(plugins.sourcemaps.write('.'))
		.pipe(gulp.dest('dist/styles'))
		.pipe(plugins.notify("Login styles updated"))
		.pipe(browserSync.stream());
});



/**
 *
 * Task: Scripts
 *
 * - Sourcemap
 * - Modernizr
 * - Combine
 * - Concat
 * - Minify
 * - Sync browsers
 *
 */
gulp.task('scripts', function() {
	var filterJS = plugins.filter(['**/*.js','!jquery.fancybox.pack.js']); // Broken by fancy
	return gulp.src(mainBowerFiles({
		    paths: {
		        bowerDirectory: 'src/bower_components',
		        bowerrc: '.bowerrc',
		        bowerJson: 'bower.json'
		    },
		}))
		.pipe(filterJS)
		.pipe(plugins.addSrc.append('src/scripts/plugins/*.js'))
		.pipe(plugins.addSrc.append('src/scripts/*.js'))
		.pipe(plugins.plumber({errorHandler: plugins.notify.onError("Error: <%= error.message %>")}))
		.pipe(plugins.sourcemaps.init())
		.pipe(plugins.concat('scripts.combined.js'))
		.pipe(gulp.dest('dist/scripts'))
		.pipe(plugins.rename({suffix: '.min'}))
		.pipe(plugins.uglify())
		.pipe(plugins.sourcemaps.write('./'))
		.pipe(gulp.dest('dist/scripts'))
		.pipe(plugins.notify("Scripts updated"))
		.pipe(browserSync.stream());
});

/**
 *
 * Task: SVG Sprites
 *
 */
gulp.task('sprites', function () {
    gulp.src('src/svg/*.svg')
    	//.pipe(plugins.debug({title: 'Files:'}))
    	.pipe(plugins.svgSprite({
			mode : {
				css                 : {
					render 			: {
						styl		: {
							template: 'src/svg/style.tpl',
							dest	: '../../styles/plugins/sprite.styl',
						}
					},
					bust: false,
				},
				view                : false,     // Create a «view» sprite
				defs                : false,     // Create a «defs» sprite
				symbol              : false,     // Create a «symbol» sprite
				stack               : false      // Create a «stack» sprite
			}
		}))
        .pipe(gulp.dest('src/sprites')); // Write the sprite-sheet + CSS + Preview

	// Move svg to image dist
	gulp.src('src/sprites/css/svg/*.svg')
	 	.pipe(gulp.dest('dist/images'));

});




/**
 *
 * Task: Images
 *
 * - Get gif, jpg and png files and optimize them
 *
 */
gulp.task('images', function(cb) {
	var filterImages = plugins.filter(['**/*.png','**/*.gif','**/*.jpg','**/*.jpeg']); // Broken by fancy
	return gulp.src(mainBowerFiles({
		    paths: {
		        bowerDirectory: 'src/bower_components',
		        bowerrc: '.bowerrc',
		        bowerJson: 'bower.json'
		    },
		}))
		.pipe(plugins.addSrc('src/images/*.png'))
		.pipe(plugins.addSrc('src/images/*.jpg'))
		.pipe(plugins.addSrc('src/images/*.jpeg'))
		.pipe(plugins.addSrc('src/images/*.gif'))
		.pipe(filterImages)
    	//.pipe(debug({title: 'Files:'}))
    	.pipe(plugins.plumber({errorHandler: plugins.notify.onError("Error: <%= error.message %>")}))
        .pipe(plugins.imageOptimization({
			optimizationLevel: 5,
			progressive: true,
			interlaced: true
		}))
		.pipe(plugins.flatten())
        .pipe(gulp.dest('dist/images'))
		.pipe(plugins.notify("Images optimized"))
		.pipe(browserSync.stream());
});



/**
 *
 * Task: Clean
 *
 * - Delete dist folder
 *
 */
gulp.task('clean', function(cb) {
	plugins.del(['dist/**'], cb);
});



/**
 *
 * Task: Watch
 *
 * - Watch file changes and start corresponding tasks
 *
 */
gulp.task('watch', function() {
    gulp.watch('src/scripts/*.js', ['scripts']);
    gulp.watch('src/styles/*.styl', ['styles', 'loginstyles']);
    gulp.watch('src/styles/**/*.styl', ['styles', 'loginstyles']);
    gulp.watch('src/images/*', ['images']);
    gulp.watch('src/svg/*.svg', ['sprites']);
});



/**
 *
 * Task: Default task
 *
 * - Run all tasks and start watching
 *
 */
gulp.task('default', ['clean'], function(){
	gulp.start( 'styles', 'scripts', 'images', 'sprites', 'watch', 'browser-sync' );
});



/**
 *
 * Task: Dev
 *
 * - Run default task once
 *
 */
gulp.task('dev', ['clean'], function(){
	gulp.start('sprites', 'images', 'scripts', 'styles', 'loginstyles'  );
});
