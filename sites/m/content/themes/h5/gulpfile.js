/*Load plugins*/
var gulp          = require('gulp'),
    autoprefixer  = require('gulp-autoprefixer'),
    minifycss     = require('gulp-minify-css'),
    jshint        = require('gulp-jshint'),
    uglify        = require('gulp-uglify'),
    imagemin      = require('gulp-imagemin'),
    rename        = require('gulp-rename'),
    concat        = require('gulp-concat'),
    cache         = require('gulp-cache'),
    livereload    = require('gulp-livereload'),
    clean         = require('gulp-clean');

/*Set URI*/
var branch      = 'dev',
    stylesURI   = [
        'lib/bootstrap3/css/bootstrap.css',
        'lib/iconFront/iconfont.css',
        'lib/formValidation/css/formValidation.css',
        'lib/menu/css/styles.css',
        'lib/winderCheck/css/winderCheck.css',
        'css/*.css'],
    // skinsURI    = 'css/skin/*.css',
    scriptsURI  = [
        /*必须放在顶部的JS*/
        'lib/jquery/jquery.js',
        'lib/jquery/jquery.cookie.js',
        'lib/bootstrap3/js/bootstrap.js',
        'lib/jquery/jquery.pjax.js',
        // 'lib/jquery-form/jquery.form.min.js',
        'js/ecjia.js',
        /*可以放在底部的JS*/
        'lib/Validform/Validform_v5.3.2.js',
        'lib/swiper/js/swiper.js',
        // 'lib/iscroll/js/iscroll.js',
        'lib/winderCheck/js/winderCheck.js',
        /*TouchUI系列JS*/
        'js/ecjia.touch.js',
        // 'js/ecjia.touch.history.js',
        'js/ecjia.touch.others.js',
        'js/ecjia.touch.goods.js',
        'js/ecjia.touch.user.js',
        'js/ecjia.touch.flow.js'],
    fontsURI    = [
        'lib/iconFront/*',
        'lib/bootstrap3/fonts/*'],
    othersURI   = [
        'lib/swiper/css/swiper.min.css'],
    imagesURI   = [
        'images/*'];

gulp.task('default', ['build', 'watch']);
gulp.task('develop', ['build-develop', 'watch']);

/*Styles*/
gulp.task('styles', function() {
    if (branch == 'dev') {
        return gulp.src(stylesURI)
        .pipe(autoprefixer('last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
        .pipe(rename({ suffix: '.min' }))
        .pipe(minifycss())
        .pipe(gulp.dest('dist/css'));
    } else {
        return gulp.src(stylesURI)
        .pipe(autoprefixer('last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
        .pipe(concat('main.css'))
        .pipe(rename({ suffix: '.min' }))
        .pipe(minifycss())
        .pipe(gulp.dest('dist/css'));
    }
});

/*Scripts*/
gulp.task('scripts', function() {
    if (branch == 'dev') {
        return gulp.src(scriptsURI)
        .pipe(jshint())
        // .pipe(jshint.reporter('default'))
        .pipe(rename({ suffix: '.min' }))
        .pipe(uglify())
        .pipe(gulp.dest('dist/js'));
    } else {
        return gulp.src(scriptsURI)
        .pipe(jshint())
        // .pipe(jshint.reporter('default'))
        .pipe(concat('main.js'))
        .pipe(rename({ suffix: '.min' }))
        .pipe(uglify())
        .pipe(gulp.dest('dist/js'));
    }
});

// /*Skins*/
// gulp.task('skins', function() {
//     return gulp.src(skinsURI)
//     .pipe(autoprefixer('last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
//     .pipe(rename({ suffix: '.min' }))
//     .pipe(minifycss())
//     .pipe(gulp.dest('dist/skin'));
// });

/*fonts*/
gulp.task('fonts', function() {
    return gulp.src(fontsURI)
    .pipe(gulp.dest('dist/fonts'));
});

/*Images*/
gulp.task('images', function() {
    return gulp.src(imagesURI)
    // .pipe(cache(imagemin({ optimizationLevel: 3, progressive: true, interlaced: true })))
    .pipe(gulp.dest('dist/images'));
});

/*other*/
gulp.task('others', function() {
    return gulp.src(othersURI)
    .pipe(gulp.dest('dist/other'));
});

/*Clean*/
gulp.task('clean', function() { 
    return gulp.src(['dist/css', 'dist/skin', 'dist/js', 'dist/fonts', 'dist/images'], {read: false})
    .pipe(clean());
});

/*tmp*/
gulp.task('tmp', function() {
    return gulp.src('touch.dwt.'+branch+'.php')
    .pipe(rename('touch.dwt.php'))
    .pipe(gulp.dest('./'))/*压缩JS存放*/
});

/*Default task*/
gulp.task('build', ['clean'], function() {/*开发模式下*/
    gulp.start('tmp', 'styles', 'scripts', 'fonts', 'images', 'others');
});

/*develop task*/
gulp.task('build-develop', ['clean'], function() {/*合并到develop分支前操作*/
    branch = 'develop';
    gulp.start('tmp', 'styles', 'scripts', 'fonts', 'images', 'others');
});

/*Clean-develop*/
gulp.task('clean-develop', function() { 
    return gulp.src('default', {read: false})
    .pipe(clean());
});

/*develop task*/
gulp.task('develop-move', ['clean-develop'], function() {/*合并到develop分支前操作*/
    var developURI = [
        '**',
        '!js/**',
        '!css/**',
        '!node_modules/**',
        '!lib/**',
        '!images/**',
        '!default/**',
        '!js',
        '!css',
        '!node_modules',
        '!lib',
        '!images',
        '!default',
        '!touch.dwt.develop.php',
        '!touch.dwt.dev.php',
        '!gulpfile.js',
        '!package.json',
        'images/screenshot.png'
    ];
    return gulp.src(developURI)
    .pipe(gulp.dest('default'));
});

/*Watch*/
gulp.task('watch', function() {
    /*Watch .css files*/
    gulp.watch(stylesURI, ['styles']);
    /*Watch .js files*/
    gulp.watch(scriptsURI, ['scripts']);
    // /*Watch .css files*/
    // gulp.watch(skinsURI, ['skins']);

    /*Create LiveReload server*/
    livereload.listen();
});
