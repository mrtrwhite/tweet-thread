var fs = require('fs'),
	gulp = require('gulp'),
    sass = require('gulp-sass'),
    autoprefixer = require('gulp-autoprefixer'),
    rename = require('gulp-rename'),
    browserify = require('browserify'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglify'),
	cleanCSS = require('clean-css'),
    plumber = require('gulp-plumber'),
	imagemin = require('gulp-imagemin'),
	pngquant = require('imagemin-pngquant'),
	imageminJpegRecompress = require('imagemin-jpeg-recompress'),
	cssmin = require('gulp-cssmin'),
    babelify = require('babelify'),
	source = require('vinyl-source-stream'),
	buffer = require('vinyl-buffer');


function swallow(err) {
	console.log(err);
	this.emit('end');
}

var paths = {
	"src": {
		"js": "./resources/js/app.js",
        "sass": "./resources/sass/bundle.scss"
	},
	"dest": {
		"css": "./public/css",
        "js": "./public/js"
	},
	"watch": {
		"sass": "./resources/sass/**/*.scss",
        "js": "./resources/js/**/*.js"
	}
}

gulp.task('styles', function(){
	return gulp.src(paths.src.sass)
		.pipe(plumber({ errorHandler: swallow}))
		.pipe(sass({
			style: 'expanded',
			includePaths : [paths.src.sass]
		}))
		.pipe(autoprefixer('last 2 version', 'safari 5', 'ie 9', 'ios 6', 'android 4'))
		.pipe(rename('style.css'))
		.pipe(gulp.dest(paths.dest.css))
		.pipe(cssmin({
			keepSpecialComments: 0
		}))
		.pipe(rename({suffix: '.min'}))
		.pipe(gulp.dest(paths.dest.css));
});

gulp.task('scripts', function(){
	return browserify({
		entries: paths.src.js,
		extensions: ['.js']
	})
	.transform('babelify')
	.bundle()
	.pipe(source('bundle.js'))
	.pipe(buffer())
	.pipe(plumber({ errorHandler: swallow}))
	.pipe(gulp.dest(paths.dest.js))
	.pipe(uglify())
	.pipe(rename({suffix: '.min'}))
	.pipe(gulp.dest(paths.dest.js));
});

gulp.task('watch', function() {
	gulp.watch(paths.watch.sass, ['styles']);
	gulp.watch(paths.watch.js, ['scripts']);
	gulp.watch(paths.watch.img, ['images']);
})
