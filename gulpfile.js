// 引入 gulp
var gulp = require('gulp');

// 引入组件
var jshint = require('gulp-jshint');
var uglify = require('gulp-uglify');
var babel = require('gulp-babel');
var webpack = require('webpack-stream');
var run = require('gulp-run');

// 检查脚本
gulp.task('lint', function() {
    return gulp.src(['client/js/*.js', '!node_modules/**/*.js', '!bin/**/*.js'])
        .pipe(jshint({
            esnext: true
        }))
        .pipe(jshint.reporter('default', { verbose: true}))
        .pipe(jshint.reporter('fail'));
});

gulp.task('build', ['lint', 'move-client'], function () {
    return gulp.src(['client/js/app.js'])
        .pipe(uglify())
        .pipe(webpack(require('./webpack.config.js')))
        .pipe(babel())
        .pipe(gulp.dest('bin/client/js/'));
});


gulp.task('move-client', function () {
    return gulp.src(['./client/**/*.*', '!client/js/*.js'])
        .pipe(gulp.dest('./bin/client/'));
});


gulp.task('run', ['build'], function () {
    //run('php server.php').exec();
    //run('php hserver.php').exec();
});

// 默认任务
gulp.task('default', ['run']);
