var gulp = require('gulp'),
    less = require('gulp-less'),
    clean = require('gulp-clean'),
    concatJs = require('gulp-concat'),
    minifyJs = require('gulp-uglify');
gulp.task('less', function() {
    return gulp.src(['web-src/less/*.less'])
        .pipe(less({compress: true}))
        .pipe(gulp.dest('web/css/'));
});
gulp.task('css', function() {
    return gulp.src(['web-src/css/*.css'])
        .pipe(less({compress: true}))
        .pipe(gulp.dest('web/css/'));
});
gulp.task('images', function () {
    return gulp.src([
            'web-src/images/*'
        ])
        .pipe(gulp.dest('web/images/'))
});
gulp.task('images_flags', function () {
    return gulp.src([
            'web-src/images/flags/*'
        ])
        .pipe(gulp.dest('web/images/flags/'))
});
gulp.task('fonts', function () {
    return gulp.src(['bower_components/bootstrap/fonts/*'])
        .pipe(gulp.dest('web/fonts/'))
});
gulp.task('lib-js', function() {
    return gulp.src([
            'bower_components/jquery/dist/jquery.js',
            'bower_components/bootstrap/dist/js/bootstrap.js'
        ])
        .pipe(concatJs('app.js'))
        .pipe(minifyJs())
        .pipe(gulp.dest('web/js/'));
});
gulp.task('pages-js', function() {
    return gulp.src([
            'web-src/js/*.js'
        ])
        .pipe(minifyJs())
        .pipe(gulp.dest('web/js/'));
});
gulp.task('clean', function () {
    return gulp.src(['web/css/*', 'web/js/*', 'web/images/*', 'web/images/flags/*', 'web/fonts/*'])
        .pipe(clean());
});
gulp.task('default', ['clean'], function () {
    var tasks = ['images', 'images_flags', 'fonts', 'less', 'css', 'lib-js', 'pages-js'];
    tasks.forEach(function (val) {
        gulp.start(val);
    });
});
gulp.task('watch', function () {
    var less = gulp.watch('web-src/less/*.less', ['less']),
        css = gulp.watch('web-src/css/*.css', ['css']),
        js = gulp.watch('web-src/js/*.js', ['pages-js']);
});