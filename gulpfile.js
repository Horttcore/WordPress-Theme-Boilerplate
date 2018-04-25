/**
 *
 * Gulp Plugins
 *
 */
var gulp = require("gulp"),
    plugins = require("gulp-load-plugins")({
        pattern: ["gulp-*", "gulp.*", "del", "fs"]
    }),
    mainBowerFiles = require("main-bower-files"),
    browserSync = require("browser-sync").create();

/**
 *
 * Task: Browser Sync
 *
 * - Watch for file changes in dist folder
 * - Watch for a php file change
 * - Update browsers
 *
 */
gulp.task("serve", function() {
    browserSync.init({
        proxy: "http://WP_SLUG.localhost/",
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
gulp.task("styles", function() {
    return (gulp
            .src("src/sass/0-*/*.sass")
            .pipe(plugins.plumber())
            .pipe(plugins.addSrc.append("src/sass/1-*/*.sass"))
            .pipe(plugins.addSrc.append("src/sass/2-*/*.sass"))
            .pipe(plugins.addSrc.append("src/sass/3-*/*.sass"))
            .pipe(plugins.addSrc.append("src/sass/4-*/*.sass"))
            .pipe(plugins.addSrc.append("src/sass/5-*/*.sass"))
            .pipe(plugins.addSrc.append("src/sass/6-*/*.sass"))
            .pipe(plugins.addSrc.append("src/sass/7-*/*.sass"))
            .pipe(plugins.sourcemaps.init())
            .pipe(plugins.concat("styles.combined.sass"))
            .pipe(plugins.sass())
            .pipe(
                plugins.addSrc.prepend(
                    "src/vendor/normalize-css/normalize.css"
                )
            )
            .pipe(
                plugins.addSrc.append([
                    "src/vendor/**/*.css",
                    "!src/vendor/normalize-css/normalize.css"
                ])
            )
            //.pipe(plugins.debug({ title: "Files:" }))
            .pipe(plugins.concat("styles.combined.css"))
            .pipe(plugins.autoprefixer("last 2 version", "ie 10", "ie 11"))
            .pipe(gulp.dest("dist/css"))
            .pipe(plugins.cssnano())
            .pipe(plugins.rename({ suffix: ".min" }))
            .pipe(plugins.sourcemaps.write("."))
            .pipe(gulp.dest("dist/css"))
            .pipe(browserSync.stream()) );
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
gulp.task("scripts", function() {
    gulp
        .src("src/js/*.js")
        //.pipe(plugins.debug({title: 'Files:'}))
        .pipe(plugins.sourcemaps.init())
        .pipe(gulp.dest("dist/js/"))
        .pipe(plugins.rename({ suffix: ".min" }))
        .pipe(plugins.uglify())
        .pipe(plugins.sourcemaps.write("./"))
        .pipe(gulp.dest("dist/js/"));
});

/**
 *
 * Task: Images
 *
 * - Get gif, jpg and png files and optimize them
 *
 */
gulp.task("images", function(cb) {
    var filterImages = plugins.filter([
        "**/*.png",
        "**/*.gif",
        "**/*.jpg",
        "**/*.jpeg",
        "**/*.svg"
    ]);
    return (gulp
            .src(
                mainBowerFiles({
                    paths: {
                        bowerrc: ".bowerrc",
                        bowerJson: "bower.json"
                    }
                })
            )
            .pipe(plugins.addSrc("src/img/*"))
            .pipe(filterImages)
            //.pipe(plugins.debug({title: 'Files:'}))
            .pipe(
                plugins.image({
                    pngquant: true,
                    optipng: false,
                    zopflipng: true,
                    jpegRecompress: false,
                    jpegoptim: true,
                    mozjpeg: true,
                    //guetzli: true,
                    gifsicle: true,
                    svgo: true,
                    concurrent: 10
                })
            )
            .pipe(plugins.flatten())
            .pipe(gulp.dest("dist/img"))
            .pipe(browserSync.stream()) );
});

/**
 *
 * Task: Fonts
 *
 */
gulp.task("fonts", function() {
    var filter = plugins.filter([
        "**/*.eot",
        "**/*.otf",
        "**/*.ttf",
        "**/*.woff",
        "**/*.woff2"
    ]);
    return gulp
        .src(
            mainBowerFiles({
                paths: {
                    bowerrc: ".bowerrc",
                    bowerJson: "bower.json"
                }
            })
        )
        //.pipe(plugins.debug({ title: "Files:" }))
        .pipe(filter)
        .pipe(gulp.dest("dist/fonts"))
        .pipe(browserSync.stream());
});

/**
 *
 * Task: Google Fonts
 *
 */
gulp.task('googlefonts', function() {
    gulp.src('./fonts.list')
        .pipe(plugins.googleWebfonts({}))
        .pipe(gulp.dest('./dist/fonts'));

});

/**
 *
 * Task: Bower
 *
 */
gulp.task("bower", function() {
    var filterCSS = plugins.filter(["**/*.css"]);
    gulp
        .src(
            mainBowerFiles({
                paths: {
                    bowerDirectory: "./src/vendor",
                    bowerrc: ".bowerrc",
                    bowerJson: "bower.json"
                }
            }),
            {
                base: "./src/vendor"
            }
        )
        .pipe(filterCSS)
        .pipe(plugins.cssnano())
        .pipe(gulp.dest("dist/vendor"));

    var filterJS = plugins.filter(["**/*.js"]);
    gulp
        .src(
            mainBowerFiles({
                paths: {
                    bowerDirectory: "./src/vendor",
                    bowerrc: ".bowerrc",
                    bowerJson: "bower.json"
                }
            }),
            {
                base: "./src/vendor"
            }
        )
        .pipe(filterJS)
        .pipe(plugins.uglify())
        .pipe(gulp.dest("dist/vendor"));

    var filterImages = plugins.filter([
        "**/*.png",
        "**/*.gif",
        "**/*.jpg",
        "**/*.jpeg",
        "**/*.svg"
    ]);
    gulp
        .src(
            mainBowerFiles({
                paths: {
                    bowerDirectory: "./src/vendor",
                    bowerrc: ".bowerrc",
                    bowerJson: "bower.json"
                }
            }),
            {
                base: "./src/vendor"
            }
        )
        .pipe(filterImages)
        .pipe(
            plugins.image({
                pngquant: true,
                optipng: false,
                zopflipng: true,
                jpegRecompress: false,
                jpegoptim: true,
                mozjpeg: true,
                //guetzli: true,
                gifsicle: true,
                svgo: true,
                concurrent: 10
            })
        )
        .pipe(gulp.dest("dist/vendor"));
});

/**
 *
 * Task: Clean
 *
 * - Delete dist folder
 *
 */
gulp.task("clean", function(cb) {
    plugins.del(["dist/**"], cb);
});

/**
 *
 * Task: Watch
 *
 * - Watch file changes and start corresponding tasks
 *
 */
gulp.task("watch", ["serve"], function() {
    gulp.watch("src/js/*.js", ["scripts"]);
    gulp.watch("src/sass/*/**.sass", ["styles"]);
    gulp.watch("src/img/*", ["images"]);
    gulp.watch("src/vendor/**", ["bower"]);
    gulp.watch("src/fonts/*", ["fonts"]);
    gulp.watch("**.php").on("change", browserSync.reload);
});

/**
 *
 * Task: Default task
 *
 * - Run all tasks and start watching
 *
 */
gulp.task("default", function() {
    gulp.start("watch", "serve");
});

/**
 *
 * Task: Dev
 *
 * - Run default task once
 *
 */
gulp.task("build", function() {
    gulp.start("clean");
    gulp.start(["images", "scripts", "styles", "bower", "fonts"]);
});
