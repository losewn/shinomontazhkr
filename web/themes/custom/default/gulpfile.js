let gulp = require('gulp'),
  sass = require('gulp-sass'),
  sourcemaps = require('gulp-sourcemaps'),
  $ = require('gulp-load-plugins')(),
  cleanCss = require('gulp-clean-css'),
  rename = require('gulp-rename'),
  postcss = require('gulp-postcss'),
  autoprefixer = require('autoprefixer'),
  postcssInlineSvg = require('postcss-inline-svg'),
  browserSync = require('browser-sync').create();

const paths = {
  scss: {
    src: './scss/*.scss',
    dest: './css',
    watch: './scss/**/*.scss',
  }
}

// Compile sass into CSS & auto-inject into browsers
function styles () {
  return gulp.src([paths.scss.src], {allowEmpty: true})
    .pipe(sourcemaps.init())
    .pipe(sass({
      includePaths: []
    }).on('error', sass.logError))
    .pipe(postcss([autoprefixer({
      browsers: [
        'Chrome >= 35',
        'Firefox >= 38',
        'Edge >= 12',
        'Explorer >= 10',
        'iOS >= 8',
        'Safari >= 8',
        'Android 2.3',
        'Android >= 4',
        'Opera >= 12']
    })]))
    .pipe(sourcemaps.write())
    .pipe(gulp.dest(paths.scss.dest))
    .pipe(cleanCss())
    .pipe(rename({ suffix: '.min' }))
    .pipe(gulp.dest(paths.scss.dest))
    .pipe(browserSync.stream())
}


// Watching scss/html files
function watch () {
  browserSync.init({
    proxy: 'http://webhouse.docksal',
    ws: true
  })

  gulp.watch([paths.scss.watch,], styles).on('change', browserSync.reload)
}

const build = gulp.series(styles)

exports.styles = styles
exports.watch = watch

exports.default = build
