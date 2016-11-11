var gulp = require('gulp');

gulp.task('default', function() {	 
	console.log('Use the following commands');
	console.log('--------------------------');
	console.log('gulp sass           to compile the style.scss to style.css');
	console.log('gulp admin-sass     to compile the admin.scss to admin.css');
	console.log('gulp compile-sass   to compile both of the above.');
	console.log('gulp js             to compile the custom.js to custom.min.js');
	console.log('gulp compile-js     to compile both of the above.');
	console.log('gulp watch          to continue watching all files for changes, and build when changed');
	console.log('gulp wordpress-pot  to compile the lsx-customizer.pot');
});

var sass = require('gulp-sass');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var sort = require('gulp-sort');
var wppot = require('gulp-wp-pot');

gulp.task('sass', function () {
    gulp.src('assets/css/lsx-customizer.scss')
        .pipe(sass())
        .pipe(gulp.dest('assets/css/'));
});

gulp.task('admin-sass', function () {
    gulp.src('assets/css/lsx-customizer-admin.scss')
        .pipe(sass())
        .pipe(gulp.dest('assets/css/'));
});

gulp.task('js', function () {
	gulp.src('assets/js/lsx-customizer.js')
	.pipe(concat('lsx-customizer.min.js'))
	.pipe(uglify())
	.pipe(gulp.dest('assets/js'));
});

gulp.task('admin-js', function () {
	gulp.src('assets/js/lsx-customizer-admin.js')
	.pipe(concat('lsx-customizer-admin.min.js'))
	.pipe(uglify())
	.pipe(gulp.dest('assets/js'));
});
 
gulp.task('compile-sass', (['sass', 'admin-sass']));
gulp.task('compile-js', (['js', 'admin-js']));

gulp.task('watch', function() {
	gulp.watch('assets/css/lsx-customizer.scss', ['sass']);
	gulp.watch('assets/css/lsx-customizer-admin.scss', ['admin-sass']);
	gulp.watch('assets/js/lsx-customizer.js', ['js']);
	gulp.watch('assets/js/lsx-customizer-admin.js', ['admin-js']);
});

gulp.task('wordpress-lang', function () {
	return gulp.src('**/*.php')
		.pipe(sort())
		.pipe(wppot({
			domain: 'lsx-customizer',
			destFile: 'lsx-customizer.pot',
			package: 'lsx-customizer',
			bugReport: 'https://bitbucket.org/feedmycode/lsx-customizer/issues',
			team: 'LightSpeed <webmaster@lsdev.biz>'
		}))
		.pipe(gulp.dest('languages'));
});
