/**
 *
 * Gulp Plugins
 *
 */
const gulp = require("gulp");
const plugins = require("gulp-load-plugins")({
    pattern: ["gulp-*", "gulp.*", "del", "fs"]
});
const env = require("dotenv").config();
const browserSync = require("browser-sync");
const server = browserSync.create();

const path = {
    dist: "./dist",
    css: {
        src: "./resources/scss",
        dest: "./dist/css"
    },
    fonts: {
        src: "./resources/fonts",
        dest: "./dist/fonts"
    },
    js: {
        src: "./resources/js",
        dest: "./dist/js"
    },
    img: {
        src: "./resources/img",
        dest: "./dist/img"
    },
    php: {
        src: "./views"
    }
};

/**
 *
 * Task: Browser Sync
 *
 * - Watch for file changes in dist folder
 * - Watch for a php file change
 * - Update browsers
 *
 */
function reload(done) {
    server.reload();
    done();
}
exports.reload = reload;

function sync(done) {
    done();
    server.init({
        proxy: process.env.HOST,
        notify: false,
        files: [
            `${path.css.dest}/app.css`,
            `${path.js.dest}/app.js`,
            `${path.img.dest}/**.*`
        ]
    });
}
exports.sync = sync;

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
function css() {
    return gulp
        .src([`${path.css.src}/app.scss`, `${path.css.src}/editor-styles.scss`, `${path.css.src}/login.scss`])
        .pipe(plugins.sourcemaps.init())
        .pipe(plugins.sassGlob())
        .pipe(plugins.sass())
        .pipe(plugins.postcss([
            require('postcss-custom-media'),
            require('postcss-easing-gradients'),
            require('autoprefixer'),
            require('cssnano')
        ]))
        .pipe(plugins.sourcemaps.write())
        .pipe(gulp.dest(path.css.dest))
        .pipe(browserSync.stream());
}
exports.css = css;

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
function js() {
    return gulp
        .src(`${path.js.src}/*.js`)
        .pipe(
            plugins.babel({
                presets: ["@babel/preset-env"]
            })
        )
        .pipe(plugins.terser())
        .pipe(gulp.dest(path.js.dest));
}
exports.js = js;

/**
 *
 * Task: Images
 *
 * - Get gif, jpg and png files and optimize them
 *
 */
function img() {
    return gulp
        .src([
            `${path.img.src}/**/*.png`,
            `${path.img.src}/**/*.gif`,
            `${path.img.src}/**/*.jpg`,
            `${path.img.src}/**/*.jpeg`,
            `${path.img.src}/**/*.svg`
        ])
        .pipe(plugins.image())
        .pipe(gulp.dest(path.img.dest))
        .pipe(browserSync.stream());
}
exports.img = img;

/**
 *
 * Task: Fonts
 *
 */
function localFonts() {
    return gulp
        .src([
            `${path.fonts.src}/**/*.eot`,
            `${path.fonts.src}/**/*.otf`,
            `${path.fonts.src}/**/*.ttf`,
            `${path.fonts.src}/**/*.woff`,
            `${path.fonts.src}/**/*.woff2`
        ])
        .pipe(gulp.dest(path.fonts.dest))
        .pipe(browserSync.stream());
}
exports.localFonts = localFonts;

/**
 *
 * Task: Google Fonts
 *
 */
function googleFonts() {
    return gulp
        .src("./fonts.list")
        .pipe(plugins.googleWebfonts({}))
        .pipe(gulp.dest(path.fonts.dest));
}
exports.googleFonts = googleFonts;

/**
 *
 * Task: Clean
 *
 * - Delete dist folder
 *
 */
function clean() {
    return plugins.del([`${path.dist}/**`]);
}
exports.clean = clean;

/**
 *
 * Task: Watch
 *
 * - Watch file changes and start corresponding tasks
 *
 */
// Watch files
function watchFiles() {
    gulp.watch(`${path.css.src}/**/*.scss`, css);
    gulp.watch(`${path.js.src}/**/*.js`, js);
    gulp.watch(`${path.img.src}/**/*.*`, img);
    gulp.watch(`${path.fonts.src}/**/*.*`, localFonts);
    gulp.watch("fonts.list", googleFonts);
}
exports.watchFiles = watchFiles;

// Complex tasks
const fonts = gulp.parallel(localFonts, googleFonts);
const build = gulp.series(
    clean,
    gulp.parallel(css, img, js, googleFonts, localFonts)
);
const watch = gulp.parallel(watchFiles, sync);
const dev = gulp.series(build, watch);

// Export tasks
exports.build = build;
exports.default = dev;
exports.fonts = fonts;
exports.watch = watch;
