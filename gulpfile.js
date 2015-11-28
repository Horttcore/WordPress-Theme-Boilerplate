/**
 *
 * Gulp Plugins
 *
 */
var gulp = require('gulp'),
	// PostCSS
	postcss = require('gulp-postcss'),
	lost = require('lost'),
	rucksack = require('gulp-rucksack'),
	nano = require('gulp-cssnano'),
	// Stylus
	stylus = require('gulp-stylus'),
	minifyCSS = require('gulp-minify-css'),
	prefix = require('gulp-autoprefixer'),
	rupture = require('rupture'),
	typographic = require('typographic'),
	// Bower
	// JavaScript
	concat = require('gulp-concat'),
	uglify = require('gulp-uglify'),
	sourcemaps = require('gulp-sourcemaps'),
	// Image optimization
	imageop = require('gulp-image-optimization'),
	// SVG Sprite
	svgSprite = require('gulp-svg-sprite');
	svgSprites = require('gulp-svg-sprites'),
	svg2png   = require('gulp-svg2png'),
	// Utils
	browserSync = require('browser-sync').create(),
	debug = require('gulp-debug'),
	del = require('del'),
	flatten = require('gulp-flatten'),
	filter    = require('gulp-filter'),
	fs = require("fs"),
	notify = require("gulp-notify"),
	plumber = require('gulp-plumber'),
	rename = require('gulp-rename'),
	replace = require('gulp-replace'),
	watch = require('gulp-watch');



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
		proxy: "localhost/WP_SLUG/",
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
	return gulp.src([
			'./src/vendor/**/**.css',
			'./src/styles/plugins/**.styl',
			'./src/styles/modules/**.styl',
			'./src/styles/styles.styl'
		])
		.pipe(plumber({errorHandler: notify.onError("Error: <%= error.message %>")}))
		//.pipe(debug({title: 'Files:'}))
		.pipe(concat('styles.combined.styl'))
		.pipe(sourcemaps.init())
		.pipe(stylus({
			use: [
				rupture(),
				typographic(),
			]
		}))
		.pipe(postcss([
			lost(),
		]))
		.pipe(rucksack())
		.pipe(prefix('last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
		.pipe(replace('url(\'images', 'url(\'../images'))
		.pipe(replace('url("images', 'url("../images'))
		.pipe(replace('../images/fancyBox/', '../images/'))
		.pipe(gulp.dest('dist/styles'))
		.pipe(nano())
		.pipe(rename({suffix: '.min'}))
		.pipe(sourcemaps.write('.'))
		.pipe(gulp.dest('dist/styles'))
		.pipe(notify("Styles updated"))
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
		.pipe(plumber({errorHandler: notify.onError("Error: <%= error.message %>")}))
		//.pipe(debug({title: 'Files:'}))
		.pipe(sourcemaps.init())
		.pipe(stylus({
			use: [
				rupture(),
				typographic(),
			]
		}))
		.pipe(postcss([
			lost(),
		]))
		.pipe(rucksack())
		.pipe(prefix('last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
		.pipe(gulp.dest('dist/styles'))
		.pipe(nano())
		.pipe(minifyCSS())
		.pipe(rename({suffix: '.min'}))
		.pipe(sourcemaps.write('.'))
		.pipe(gulp.dest('dist/styles'))
		.pipe(notify("Login styles updated"))
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
	return gulp.src([
			'src/vendor/jquery/jquery.js',
			'src/vendor/**/!(jquery.js)*.js',
			'!src/vendor/fancybox/jquery.fancybox.js', // No main files in bower.json
			'src/scripts/**/*.js',
		])
		.pipe(plumber({errorHandler: notify.onError("Error: <%= error.message %>")}))
		.pipe(debug({title: 'Files:'}))
		.pipe(sourcemaps.init())
		.pipe(concat('scripts.combined.js'))
		.pipe(gulp.dest('dist/scripts'))
		.pipe(rename({suffix: '.min'}))
		.pipe(uglify())
		.pipe(sourcemaps.write('./'))
		.pipe(gulp.dest('dist/scripts'))
		.pipe(notify("Scripts updated"))
		.pipe(browserSync.stream());
});

gulp.task('bower', function(){

});



/**
 *
 * Task: SVG Sprites
 *
 */
gulp.task('sprites', ['styles'], function () {
    return gulp.src('src/svg/*.svg')
        .pipe(svgSprites({
			cssFile: "../../../src/styles/plugins/sprite.styl",
			templates: {
        		css: fs.readFileSync("src/svg/style.tpl", "utf-8")
		    },
			padding: 2
		}))
        .pipe(gulp.dest('dist/images/sprites')) // Write the sprite-sheet + CSS + Preview
        .pipe(filter("**/*.svg"))  // Filter out everything except the SVG file
        .pipe(svg2png())           // Create a PNG
        .pipe(gulp.dest('dist/images/sprites'))
		.pipe(notify("Sprites updated"))
		.pipe(browserSync.stream());
});

/* WIP */
gulp.task('sprites-new', function () {
    return gulp.src('src/svg/*.svg')
    	.pipe(debug({title: 'Files:'}))
    	.pipe(svgSprite({
			mode : {
				css                 : true,     // Create a «css» sprite
				view                : true,     // Create a «view» sprite
				defs                : true,     // Create a «defs» sprite
				symbol              : true,     // Create a «symbol» sprite
				stack               : true      // Create a «stack» sprite
			}
		}))
        .pipe(gulp.dest('dist/images/sprites')) // Write the sprite-sheet + CSS + Preview
		.pipe(browserSync.stream());
});



/**
 *
 * Task: Images
 *
 * - Get gif, jpg and png files and optimize them
 *
 */
gulp.task('images', function(cb) {
    return gulp.src([
    		'src/bower_components/fancyBox/source/*.png', // Missing main files in bower.json
    		'src/bower_components/fancyBox/source/*.gif', // Missing main files in bower.json
    		'src/vendor/**/*.png',
    		'src/vendor/**/*.jpg',
    		'src/vendor/**/*.gif',
    		'src/vendor/**/*.jpeg',
    		'src/images/**/*.png',
    		'src/images/**/*.jpg',
    		'src/images/**/*.gif',
    		'src/images/**/*.jpeg',
    	])
    	//.pipe(debug({title: 'Files:'}))
    	.pipe(plumber({errorHandler: notify.onError("Error: <%= error.message %>")}))
        .pipe(imageop({
			optimizationLevel: 5,
			progressive: true,
			interlaced: true
		}))
		.pipe(flatten())
        .pipe(gulp.dest('dist/images'))
		.pipe(notify("Images optimized"))
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
	del(['dist/**'], cb);
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
