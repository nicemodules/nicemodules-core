const concat = require('gulp-concat');
const fs = require('fs');
const size = require('gulp-size');
const merge = require('merge-stream');

module.exports = function (gulp, config) {

    gulp.task('concat-js-backend', function () {

        const jsBundle = [];
        const minJsBundle = [];

        for (let i = 0; i < config.concat_js_backend.length; i++) {
            let element = config.concat_js_backend[i];
            let css = config.srcDir + '/js/' + element + '.js';
            let minCss = config.srcDir + '/js/' + element + '.min.js';

            if (fs.existsSync(css)) {
                jsBundle.push(css);
            } else if (fs.existsSync(minCss)) {
                jsBundle.push(minCss);
            }

            if (fs.existsSync(minCss)) {
                minJsBundle.push(minCss);
            } else if (fs.existsSync(css)) {
                minJsBundle.push(css);
            }
        }

        const resultDir = config.resultDir + '/backend';

        console.log(jsBundle);
        console.log(minJsBundle);

        const stream1 = gulp.src(jsBundle)
            .pipe(concat('bundle.js'))
            .pipe(gulp.dest(resultDir))
            .pipe(size({showFiles: true}))
        ;

        const stream2 =  gulp.src(minJsBundle)
            .pipe(concat('bundle.min.js'))
            .pipe(gulp.dest(resultDir))
            .pipe(size({showFiles: true}))
        ;

        return merge(stream1, stream2);
    });
}