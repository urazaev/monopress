'use strict';

var gulp = require('gulp');
var sass = require('gulp-sass');
var sassGlob = require('gulp-sass-glob');
var sourcemaps = require('gulp-sourcemaps');
var plumber = require('gulp-plumber');
var postcss = require('gulp-postcss');
var autoprefixer = require('autoprefixer');
var mqpacker = require('css-mqpacker');
var minifycss = require('gulp-csso');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var UglifyJS = require("uglify-es");
var rename = require('gulp-rename');
var rigger = require('gulp-rigger');
var del = require('del');


// CSS

gulp.task('style', function (done) {
  return gulp.src('source/sass/style.scss')
    .pipe(plumber())
    // .pipe(sourcemaps.init())
    // .pipe(sassGlob())
    .pipe(sass({
      includePaths: require("node-normalize-scss").includePaths
    }))
    .pipe(postcss([
      autoprefixer(),
      mqpacker({
        sort: true
      })
    ]))
    .pipe(rename('bcn_style.css'))
    // .pipe(gulp.dest('source/css'))
    .pipe(gulp.dest('css'))
    .pipe(minifycss())
    // .pipe(sourcemaps.write())
    .pipe(rename('bcn_style.min.css'))
    .pipe(gulp.dest('css'))
  done();
});

// JS
gulp.task('js:del', function (done) {
  return del('js', done);
});

gulp.task('js:libraries', function (done) {
  return gulp.src('source/js/libraries/*.js')
    .pipe(plumber())
    // .pipe(UglifyJS.minify())
    .pipe(gulp.dest('js/libraries'))
  done();
});


gulp.task('js:scripts', function (done) {
  return gulp.src('source/js/scripts/*.js')
    .pipe(plumber())
    // .pipe(sourcemaps.init())
    .pipe(concat('app.js'))
    .pipe(gulp.dest('js'))
    .pipe(uglify())
    // .pipe(sourcemaps.write())
    .pipe(rename('app.min.js'))
    .pipe(gulp.dest('js'))
  done();
});

gulp.task('js', gulp.series('js:del', 'js:libraries', 'js:scripts'));

// LIVE SERVER

gulp.task('reload', function (done) {
  done();
});

gulp.task('serve', function (done) {
  gulp.watch('source/sass/**/*.{scss,sass}', gulp.series('style'));
  gulp.watch('source/js/**/*.js', gulp.series('js', 'reload'));
  done();
});
