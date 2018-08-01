'use strict';

let gulp         = require('gulp'),
	rename       = require('gulp-rename'),
	notify       = require('gulp-notify'),
	autoprefixer = require('gulp-autoprefixer'),
	sass         = require('gulp-sass'),
	plumber      = require('gulp-plumber'),
	checktextdomain = require('gulp-checktextdomain');

//css
gulp.task('css', () => {
	return gulp.src('./assets/scss/jet-widgets.scss')
		.pipe(
			plumber( {
				errorHandler: function ( error ) {
					console.log('=================ERROR=================');
					console.log(error.message);
					this.emit( 'end' );
				}
			})
		)
		.pipe(sass( { outputStyle: 'compressed' } ))
		.pipe(autoprefixer({
				browsers: ['last 10 versions'],
				cascade: false
		}))

		.pipe(rename('jet-widgets.css'))
		.pipe(gulp.dest('./assets/css/'))
		.pipe(notify('Compile Sass Done!'));
});

gulp.task('css-skin', () => {
	return gulp.src('./assets/scss/jet-widgets-skin.scss')
		.pipe(
			plumber( {
				errorHandler: function ( error ) {
					console.log('=================ERROR=================');
					console.log(error.message);
					this.emit( 'end' );
				}
			})
		)
		.pipe(sass( { outputStyle: 'compressed' } ))
		.pipe(autoprefixer({
				browsers: ['last 10 versions'],
				cascade: false
		}))

		.pipe(rename('jet-widgets-skin.css'))
		.pipe(gulp.dest('./assets/css/'))
		.pipe(notify('Compile Sass Done!'));
});

gulp.task('css-admin', () => {
	return gulp.src('./assets/scss/jet-widgets-admin.scss')
		.pipe(
			plumber( {
				errorHandler: function ( error ) {
					console.log('=================ERROR=================');
					console.log(error.message);
					this.emit( 'end' );
				}
			})
		)
		.pipe(sass( { outputStyle: 'compressed' } ))
		.pipe(autoprefixer({
				browsers: ['last 10 versions'],
				cascade: false
		}))

		.pipe(rename('jet-widgets-admin.css'))
		.pipe(gulp.dest('./assets/css/'))
		.pipe(notify('Compile Sass Done!'));
});

gulp.task('css-rtl', () => {
	return gulp.src('./assets/scss/jet-widgets-rtl.scss')
			   .pipe(
				   plumber( {
					   errorHandler: function ( error ) {
						   console.log('=================ERROR=================');
						   console.log(error.message);
						   this.emit( 'end' );
					   }
				   })
			   )
			   .pipe(sass( { outputStyle: 'compressed' } ))
			   .pipe(autoprefixer({
				   browsers: ['last 10 versions'],
				   cascade: false
			   }))

			   .pipe(rename('jet-widgets-rtl.css'))
			   .pipe(gulp.dest('./assets/css/'))
			   .pipe(notify('Compile Sass Done!'));
});

//watch
gulp.task('watch', () => {
	gulp.watch('./assets/scss/**', ['css']);
	gulp.watch('./assets/scss/**', ['css-skin']);
	gulp.watch('./assets/scss/**', ['css-admin']);
	gulp.watch('./assets/scss/**', ['css-rtl']);
});

gulp.task( 'checktextdomain', () => {
	return gulp.src( ['**/*.php', '!cherry-framework/**/*.php'] )
		.pipe( checktextdomain( {
			text_domain: 'jetwidgets-for-elementor',
			keywords: [
				'__:1,2d',
				'_e:1,2d',
				'_x:1,2c,3d',
				'esc_html__:1,2d',
				'esc_html_e:1,2d',
				'esc_html_x:1,2c,3d',
				'esc_attr__:1,2d',
				'esc_attr_e:1,2d',
				'esc_attr_x:1,2c,3d',
				'_ex:1,2c,3d',
				'_n:1,2,4d',
				'_nx:1,2,4c,5d',
				'_n_noop:1,2,3d',
				'_nx_noop:1,2,3c,4d',
				'translate_nooped_plural:1,2c,3d'
			],
		} ) );
} );
