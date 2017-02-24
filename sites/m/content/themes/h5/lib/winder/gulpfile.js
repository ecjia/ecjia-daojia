var gulp = require('gulp'),
    less = require('gulp-less'),
    concat = require('gulp-concat'),
    rename = require('gulp-rename'),
    minifycss = require('gulp-minify-css');

gulp.task('build-less', function(){
  gulp.src('./src/less/*.less')
    .pipe(less({ compress: true }))
    .on('error', function(e){console.log(e);} )
    .pipe(gulp.dest('./src/css/'));

});

// 合并、压缩、重命名css
// gulp.task('min-styles',['build-less'], function() {
//   gulp.src(['./public/css/*.css'])
//     .pipe(concat('all.css')) // 合并文件为all.css
//     .pipe(gulp.dest('./public/css/')) // 输出all.css文件
//     .pipe(rename({ suffix: '.min' })) // 重命名all.css为 all.min.css
//     .pipe(minifycss()) // 压缩css文件
//     .pipe(gulp.dest('./public/css/')); // 输出all.min.css
// });

gulp.task('default', function() {
  // gulp.watch('./public/less/*.less', ['build-less', 'min-styles']);
  gulp.watch('./src/less/*.less', ['build-less']);
});
