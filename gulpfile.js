var gulp = require('gulp'),
    sass = require('gulp-sass'),
    autoprefixer = require('gulp-autoprefixer'),
    rename = require('gulp-rename'),
    concat = require('gulp-concat'),
    notify = require('gulp-notify'),
    cache = require('gulp-cache'),
    vinylpaths = require('vinyl-paths'),
    cleancss = require('gulp-clean-css'),
    cmq = require('gulp-combine-mq'),
    uglify = require('gulp-uglify'),
    foreach = require('gulp-flatmap'),
    runSequence = require('run-sequence'),
    del = require('del');

// CSS
gulp.task('styles', function(){
    return gulp.src('public/scss/shortcode.scss')
        .pipe(sass.sync().on('error', sass.logError))
        .pipe(autoprefixer('last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
        .pipe(cmq())
        .pipe(gulp.dest('temp/css'))
        .pipe(rename('shortcode.css'))
        .pipe(cleancss())
        .pipe(gulp.dest('public/css'))
        .pipe(notify({ message: 'Styles task complete' }));
} );

// Vendor JS
gulp.task('scripts', function(){
    return gulp.src([
        'public/js/sources/*.js',
        'bower_components/jquery.countdown/dist/jquery.countdown.js',
        'bower_components/veinjs/vein.js'
    ])
    .pipe(foreach(function (stream, file) {
        return stream
            .pipe(uglify())
            .pipe(rename({ suffix: '.min' }))
    }))
    .pipe(gulp.dest('temp/js'))
    .pipe(gulp.dest('public/js'))
    .pipe(notify({ message: 'Scripts task complete' }));
});

// Clean temp folder
gulp.task('clean', function(){
    return gulp.src('temp/*')
    .pipe(vinylpaths(del))
});

// Default task
gulp.task('default', function() {
    // gulp.start('styles', 'lint', 'scripts', 'watch');
    runSequence(
        'clean',
        ['styles', 'scripts'],
        'watch'
    );
});

// Watch
gulp.task('watch', function() {
    // Watch .scss files
    gulp.watch(['public/scss/*.scss', 'public/sass/**/*.scss'], ['styles']);
    gulp.watch(['public/js/sources/*.js'], ['scripts']);
});
