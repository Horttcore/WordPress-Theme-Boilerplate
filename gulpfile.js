// Gulp
var gulp = require('gulp'),
	// Stylus
	stylus = require('gulp-stylus'),
	minifyCSS = require('gulp-minify-css'),
	prefix = require('gulp-autoprefixer'),
	rupture = require('rupture'),
	jeet = require('jeet'),
	axis = require('axis'),
	typographic = require('typographic'),
	// Javascript combine and minify
	concat = require('gulp-concat'),
	uglify = require('gulp-uglify'),
	sourcemaps = require('gulp-sourcemaps'),
	// Image optimization
	imagemin = require('gulp-imagemin'),
	pngcrush = require('imagemin-pngcrush'),
	// SVG Sprite
	svgSprite = require('gulp-svg-sprites'),
	filter    = require('gulp-filter'),
	svg2png   = require('gulp-svg2png'),
	// Livereload
	livereload = require('gulp-livereload'),
	// Utils
	del = require('del'),
	watch = require('gulp-watch'),
	rename = require('gulp-rename'),
	fs = require("fs"),
	plumber = require('gulp-plumber'),
	notify = require("gulp-notify");

// SVG spriting
gulp.task('sprites', function () {
    return gulp.src('src/svg/*.svg')
        .pipe(svgSprite({
			cssFile: "../../src/styles/plugins/sprite.styl",
			templates: {
        		css: fs.readFileSync("src/svg/style.tpl", "utf-8")
		    },
			padding: 2
		}))
        .pipe(gulp.dest('dest/images/sprites')) // Write the sprite-sheet + CSS + Preview
        .pipe(filter("**/*.svg"))  // Filter out everything except the SVG file
        .pipe(svg2png())           // Create a PNG
        .pipe(gulp.dest('dest/images/sprites'));
});

// Image optimization
gulp.task('images', function(cb) {
    return gulp.src('src/images/**/*')
        .pipe(imagemin({
            progressive: true,
            svgoPlugins: [{removeViewBox: false}],
            use: [pngcrush()]
        }))
        .pipe(gulp.dest('dest/images'));
});

// Get and render all .styl files recursively
gulp.task('styles', function () {
	gulp.src('./src/styles/styles.styl')
		.pipe(stylus({
			use: [
				jeet(),
				rupture(),
				axis(),
				typographic(),
			]
		}))
		.pipe(prefix('last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
		.pipe(rename({suffix: '.min'}))
		.pipe(minifyCSS())
		.pipe(gulp.dest('dest/styles'));
});

gulp.task('loginstyles', function () {
	gulp.src('./src/styles/login.styl')
		.pipe(stylus({
			use: [
				jeet(),
				rupture(),
				axis(),
				typographic(),
			]
		}))
		.pipe(prefix('last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
		.pipe(gulp.dest('dest/styles'))
		.pipe(rename({suffix: '.min'}))
		.pipe(minifyCSS())
		.pipe(gulp.dest('dest/styles'));
});

// Concat and minify scripts with sourcemap
gulp.task('scripts', function() {
    return gulp.src('src/scripts/**/*.js')
		.pipe(sourcemaps.init())
        .pipe(concat('scripts.combined.js'))
        .pipe(rename({suffix: '.min'}))
        .pipe(uglify())
		.pipe(sourcemaps.write('./'))
        .pipe(gulp.dest('dest/scripts'));
});

// Cleanup
gulp.task('clean', function(cb) {
	del(['styles/**', 'images/**', 'scripts/**'], cb);
});

// Default gulp task to run
gulp.task('default', ['clean'], function(){
	gulp.start( 'styles', 'scripts', 'images', 'sprites', 'watch' );
});

// Watch Files For Changes
gulp.task('watch', function() {
    gulp.watch('src/scripts/*.js', ['scripts']);
    gulp.watch('src/styles/*.styl', ['styles', 'loginstyles']);
    gulp.watch('src/images/*', ['images']);
    gulp.watch('src/svg/*.svg', ['sprites']);

	livereload.listen();
	gulp.watch('styles/*').on('change', livereload.changed);
	gulp.watch('scripts/*').on('change', livereload.changed);
	gulp.watch('images/*').on('change', livereload.changed);
	gulp.watch('**/*.php').on('change', livereload.changed);
});

// Developer gulp task to run
gulp.task('dev', ['clean'], function(){
	gulp.start('sprites', 'images', 'scripts', 'styles', 'loginstyles'  );
});
