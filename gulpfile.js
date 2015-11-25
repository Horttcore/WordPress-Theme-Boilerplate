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
	// Javascript combine and minify
	concat = require('gulp-concat'),
	uglify = require('gulp-uglify'),
	sourcemaps = require('gulp-sourcemaps'),
	// Image optimization
	imageop = require('gulp-image-optimization'),
	pngquant = require('imagemin-pngquant'),
	// SVG Sprite
	svgSprite = require('gulp-svg-sprite');
	svgSprites = require('gulp-svg-sprites'),
	filter    = require('gulp-filter'),
	svg2png   = require('gulp-svg2png'),
	// Utils
	browserSync = require('browser-sync').create(),
	del = require('del'),
	watch = require('gulp-watch'),
	rename = require('gulp-rename'),
	fs = require("fs"),
	plumber = require('gulp-plumber'),
	notify = require("gulp-notify"),
	debug = require('gulp-debug');


/**
 *
 * Task: Browser Sync
 *
 */
gulp.task('browser-sync', function() {

	//watch files
	var files = [
		'./dist/**/*.css',
		'./dist/**/*.js',
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
 */
gulp.task('styles', function () {
	gulp.src(['./src/styles/plugins/**.styl','./src/styles/modules/**.styl','./src/styles/styles.styl'])
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
		.pipe(gulp.dest('dist/styles'))
		.pipe(nano())
		.pipe(minifyCSS())
		.pipe(rename({suffix: '.min'}))
		.pipe(sourcemaps.write('.'))
		.pipe(gulp.dest('dist/styles'))
		.pipe(browserSync.stream());
});



/**
 *
 * Task: Login styles
 *
 */
gulp.task('loginstyles', function () {
	gulp.src('./src/styles/login.styl')
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
		.pipe(minifyCSS())
		.pipe(rename({suffix: '.min'}))
		.pipe(sourcemaps.write('.'))
		.pipe(gulp.dest('dist/styles'))
		.pipe(browserSync.stream());
});



/**
 *
 * Task: Scripts
 *
 */
gulp.task('scripts', function() {
    return gulp.src('src/scripts/**/*.js')
    	.pipe(plumber({errorHandler: notify.onError("Error: <%= error.message %>")}))
		.pipe(sourcemaps.init())
        .pipe(concat('scripts.combined.js'))
        .pipe(rename({suffix: '.min'}))
        .pipe(uglify())
		.pipe(sourcemaps.write('./'))
        .pipe(gulp.dest('dist/scripts'))
		.pipe(browserSync.stream());
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
 * Get gif, jpg and png files and optimize them
 *
 */
gulp.task('images', function(cb) {
    return gulp.src(['src/images/**/*.png','src/images/**/*.jpg','src/images/**/*.gif','src/images/**/*.jpeg'])
    	.pipe(plumber({errorHandler: notify.onError("Error: <%= error.message %>")}))
        .pipe(imageop({
			optimizationLevel: 5,
			progressive: true,
			interlaced: true
		}))
        .pipe(gulp.dest('dist/images'))
		.pipe(browserSync.stream());
});



/**
 *
 * Task: Clean
 *
 */
gulp.task('clean', function(cb) {
	del(['dist/**'], cb);
});



/**
 *
 * Task: Watch
 *
 * Watch file changes and start corresponding tasks
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
 * Run all tasks and start watching
 *
 */
gulp.task('default', ['clean'], function(){
	gulp.start( 'styles', 'scripts', 'images', 'sprites', 'watch', 'browser-sync' );
});



/**
 *
 * Task: Dev
 *
 * Run default task once
 *
 */
gulp.task('dev', ['clean'], function(){
	gulp.start('sprites', 'images', 'scripts', 'styles', 'loginstyles'  );
});
