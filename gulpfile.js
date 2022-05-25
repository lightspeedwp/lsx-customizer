const gulp         = require('gulp');
const rtlcss       = require('gulp-rtlcss');
const sass         = require('gulp-sass')(require('node-sass'));
const sourcemaps   = require('gulp-sourcemaps');
const jshint       = require('gulp-jshint');
const concat       = require('gulp-concat');
const uglify       = require('gulp-uglify');
const sort         = require('gulp-sort');
const wppot        = require('gulp-wp-pot');
const gettext      = require('gulp-gettext');
const plumber      = require('gulp-plumber');
const autoprefixer = require('gulp-autoprefixer');
const gutil        = require('gulp-util');
const rename       = require('gulp-rename');
const map          = require('map-stream');
const browserlist  = ['last 2 version', '> 1%'];

const errorreporter = map(function(file, cb) {
	if (file.jshint.success) {
		return cb(null, file);
	}

	console.log('JSHINT fail in', file.path);

	file.jshint.results.forEach(function (result) {
		if (!result.error) {
			return;
		}

		const err = result.error
		console.log(`  line ${err.line}, col ${err.character}, code ${err.code}, ${err.reason}`);
	});

	cb(null, file);
});

gulp.task('default', function() {
	console.log('Use the following commands');
	console.log('--------------------------');
	console.log('gulp compile-css    to compile the scss to css');
	console.log('gulp compile-js     to compile the js to min.js');
	console.log('gulp watch          to continue watching the files for changes');
	console.log('gulp wordpress-lang to compile the lsx-customizer.pot, en_EN.po and en_EN.mo');
});

gulp.task('styles', function(done) {
	return gulp.src('assets/css/scss/*.scss')
		.pipe(plumber({
			errorHandler: function(err) {
				console.log(err);
				this.emit('end');
			}
		}))
		.pipe(sourcemaps.init())
		.pipe(sass({
			outputStyle: 'compact',
			includePaths: ['assets/css/scss']
		}).on('error', gutil.log))
		.pipe(autoprefixer({
			browsers: browserlist,
			casacade: true
		}))
		.pipe(sourcemaps.write('maps'))
		.pipe(gulp.dest('assets/css')),
		done();
});

gulp.task('styles-rtl', function (done) {
	return gulp.src('assets/css/scss/*.scss')
		.pipe(plumber({
			errorHandler: function(err) {
				console.log(err);
				this.emit('end');
			}
		}))
		.pipe(sass({
			outputStyle: 'compact',
			includePaths: ['assets/css/scss']
		}).on('error', gutil.log))
		.pipe(autoprefixer({
			browsers: browserlist,
			casacade: true
		}))
		.pipe(rtlcss())
		.pipe(rename({
			suffix: '-rtl'
		}))
		.pipe(gulp.dest('assets/css')),
		done();
});

gulp.task('compile-css', gulp.series( ['styles', 'styles-rtl'], function(done) {
	done();
}));


// 3rd Party Styles.
gulp.task('events-styles', gulp.series( function () {
    return gulp.src('assets/css/the-events-calendar/the-events-calendar.scss')
        .pipe(plumber({
            errorHandler: function(err) {
                console.log(err);
                this.emit('end');
            }
        }))
        .pipe(sourcemaps.init())
        .pipe(sass({
            outputStyle: 'compressed',
            includePaths: ['assets/css/the-events-calendar']
        }).on('error', gutil.log))
        .pipe(autoprefixer({
            browsers: browserlist,
            casacade: true
        }))
        .pipe(sourcemaps.write('maps'))
        .pipe(gulp.dest('assets/css/the-events-calendar'))
}));

gulp.task('events-styles-5', gulp.series(function () {
    return gulp.src('assets/css/the-events-calendar/the-events-calendar-5.scss')
        .pipe(plumber({
            errorHandler: function(err) {
                console.log(err);
                this.emit('end');
            }
        }))
        .pipe(sourcemaps.init())
        .pipe(sass({
            outputStyle: 'compressed',
            includePaths: ['assets/css/the-events-calendar']
        }).on('error', gutil.log))
        .pipe(autoprefixer({
            browsers: browserlist,
            casacade: true
        }))
        .pipe(sourcemaps.write('maps'))
        .pipe(gulp.dest('assets/css/the-events-calendar'))
}));

gulp.task('sensei-styles', gulp.series(function () {
    return gulp.src('assets/css/sensei/sensei.scss')
        .pipe(plumber({
            errorHandler: function(err) {
                console.log(err);
                this.emit('end');
            }
        }))
        .pipe(sourcemaps.init())
        .pipe(sass({
            outputStyle: 'compressed',
            includePaths: ['assets/css/sensei']
        }).on('error', gutil.log))
        .pipe(autoprefixer({
            browsers: browserlist,
            casacade: true
        }))
        .pipe(sourcemaps.write('maps'))
        .pipe(gulp.dest('assets/css/sensei'))
}));

gulp.task('popup-maker-styles', gulp.series(function () {
    return gulp.src('assets/css/popup-maker/popup-maker.scss')
        .pipe(plumber({
            errorHandler: function(err) {
                console.log(err);
                this.emit('end');
            }
        }))
        .pipe(sourcemaps.init())
        .pipe(sass({
            outputStyle: 'compressed',
            includePaths: ['assets/css/popup-maker']
        }).on('error', gutil.log))
        .pipe(autoprefixer({
            browsers: browserlist,
            casacade: true
        }))
        .pipe(sourcemaps.write('maps'))
        .pipe(gulp.dest('assets/css/popup-maker'))
}));

gulp.task('bbpress-styles', gulp.series(function () {
    return gulp.src('assets/css/bb-press/bb-press.scss')
        .pipe(plumber({
            errorHandler: function(err) {
                console.log(err);
                this.emit('end');
            }
        }))
        .pipe(sourcemaps.init())
        .pipe(sass({
            outputStyle: 'compressed',
            includePaths: ['assets/css/bb-press']
        }).on('error', gutil.log))
        .pipe(autoprefixer({
            browsers: browserlist,
            casacade: true
        }))
        .pipe(sourcemaps.write('maps'))
        .pipe(gulp.dest('assets/css/bb-press'))
}));

gulp.task('woocommerce-styles', gulp.series(function () {
    return gulp.src('assets/css/woocommerce/*.scss')
        .pipe(plumber({
            errorHandler: function(err) {
                console.log(err);
                this.emit('end');
            }
        }))
        .pipe(sourcemaps.init())
        .pipe(sass({
            outputStyle: 'compressed',
            includePaths: ['assets/css/woocommerce']
        }).on('error', gutil.log))
        .pipe(autoprefixer({
            browsers: browserlist,
            casacade: true
        }))
        .pipe(sourcemaps.write('maps'))
        .pipe(gulp.dest('assets/css/woocommerce'))
}));

gulp.task('compile-css', gulp.series( ['events-styles', 'events-styles-5', 'sensei-styles', 'popup-maker-styles', 'bbpress-styles', 'woocommerce-styles'], function(done) {
	done();
}));

gulp.task('js', function(done) {
	return gulp.src('assets/js/src/lsx-customizer.js')
		.pipe(plumber({
			errorHandler: function(err) {
				console.log(err);
				this.emit('end');
			}
		}))
		.pipe(jshint())
		//.pipe(errorreporter)
		.pipe(concat('lsx-customizer.min.js'))
		.pipe(uglify())
		.pipe(gulp.dest('assets/js')),
		done();
});

gulp.task('admin-js', function(done) {
	return gulp.src('assets/js/src/lsx-customizer-admin.js')
		.pipe(plumber({
			errorHandler: function(err) {
				console.log(err);
				this.emit('end');
			}
		}))
		.pipe(jshint())
		//.pipe(errorreporter)
		.pipe(concat('lsx-customizer-admin.min.js'))
		.pipe(uglify())
		.pipe(gulp.dest('assets/js')),
		done();
});

gulp.task('editor-js', function(done) {
	return gulp.src('assets/js/src/lsx-customizer-editor.js')
		.pipe(plumber({
			errorHandler: function(err) {
				console.log(err);
				this.emit('end');
			}
		}))
		.pipe(jshint())
		//.pipe(errorreporter)
		.pipe(concat('lsx-customizer-editor.min.js'))
		.pipe(uglify())
		.pipe(gulp.dest('assets/js')),
		done();
});

gulp.task('compile-js', gulp.series( ['js', 'admin-js', 'editor-js'] , function(done) {
	done();
}));

gulp.task('watch-css', function (done) {
	done();
	return gulp.watch('assets/css/**/*.scss', gulp.series('compile-css'));
});

gulp.task('watch-js', function (done) {
	done();
	return gulp.watch('assets/js/src/**/*.js', gulp.series('compile-js'));
});

gulp.task('watch', gulp.series( ['watch-css', 'watch-js'] , function(done) {
	done();
}));

gulp.task('wordpress-pot', function(done) {
	return gulp.src('**/*.php')
		.pipe(sort())
		.pipe(wppot({
			domain: 'lsx-customizer',
			package: 'lsx-customizer',
			team: 'LightSpeed <webmaster@lsdev.biz>'
		}))
		.pipe(gulp.dest('languages/lsx-customizer.pot')),
		done();
});

gulp.task('wordpress-po', function(done) {
	return gulp.src('**/*.php')
		.pipe(sort())
		.pipe(wppot({
			domain: 'lsx-customizer',
			package: 'lsx-customizer',
			team: 'LightSpeed <webmaster@lsdev.biz>'
		}))
		.pipe(gulp.dest('languages/en_EN.po')),
		done();
});

gulp.task('wordpress-po-mo', gulp.series( ['wordpress-po'], function(done) {
	return gulp.src('languages/en_EN.po')
		.pipe(gettext())
		.pipe(gulp.dest('languages')),
		done();
}));

gulp.task('wordpress-lang', gulp.series( ['wordpress-pot', 'wordpress-po-mo'] , function(done) {
	done();
}));
