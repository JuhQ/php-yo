const gulp = require('gulp');
const plumber = require('gulp-plumber');
const notify = require('gulp-notify');
const watch = require('gulp-watch');
const eslint = require('gulp-eslint');
const phplint = require('gulp-phplint');
const phpunit = require('gulp-phpunit');
const phpcs = require('gulp-phpcs');

const phpFiles = ['src/**/*.php', 'test/**/*.php'];

gulp.task('phpcs', () =>
  gulp.src(phpFiles)
    .pipe(phpcs({
      bin: './vendor/bin/phpcs',
      standard: 'PSR2',
      warningSeverity: 0
    }))
    .pipe(phpcs.reporter('log'))
);

gulp.task('lint-php', () =>
  gulp.src(phpFiles)
    .pipe(plumber())
    .pipe(phplint())
    .pipe(phplint.reporter('fail'))
    .on('error', notify.onError('Error: <%= error.message %>'))
);

// Doesn't work and runs phpunit twice
// use phpunit command instead
gulp.task('phpunit', () =>
  gulp.src('./phpunit.xml')
    .pipe(plumber())
    .pipe(phpunit())
    .on('error', notify.onError('Error: <%= error.message %>'))
);

gulp.task('lint-js', () =>
  gulp.src('gulpfile.js')
    .pipe(plumber())
    .pipe(eslint())
    .pipe(eslint.format())
    .pipe(eslint.failAfterError())
    .on('error', notify.onError('Error: <%= error.message %>'))
);

gulp.task('default', ['lint-js', 'phpcs', 'lint-php'], () => {
  watch(phpFiles, { usePolling: true }, () => gulp.run(['phpcs', 'lint-php']));
  watch('gulpfile.js', { usePolling: true }, () => gulp.run(['lint-js']));
});
