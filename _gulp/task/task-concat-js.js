const concat = require('gulp-concat');
const fs = require('fs');
const size = require('gulp-size');
const merge = require('merge-stream');

module.exports = function (gulp, config, env) {

    gulp.task('concat-js', function () {

        const cfg = config[env];

        const jsBundle = [];
        const minJsBundle = [];

        for (let i = 0; i < cfg.concat_js.length; i++) {
            let element = cfg.concat_js[i];
            let css = config.src_dir + '/js/' + element + '.js';
            let minCss = config.src_dir + '/js/' + element + '.min.js';

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

        const resultDir = config.result_dir + '/js/' + env;

        console.log(jsBundle);
        console.log(minJsBundle);

        const stream1 = gulp.src(jsBundle)
            .pipe(concat('bundle.js'))
            .pipe(gulp.dest(resultDir))
            .pipe(size({showFiles: true}))
        ;

        const stream2 = gulp.src(minJsBundle)
            .pipe(concat('bundle.min.js'))
            .pipe(gulp.dest(resultDir))
            .pipe(size({showFiles: true}))
        ;

        return merge(stream1, stream2);
    });
}