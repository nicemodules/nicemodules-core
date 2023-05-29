const concat = require('gulp-concat');
const fs = require('fs');
const size = require('gulp-size');
const merge = require('merge-stream');



module.exports = function (gulp, config) {

    gulp.task('concat-css-backend', function () {

        const cssBundle = [];
        const minCssBundle = [];

        for (let i = 0; i < config.concat_css_backend.length; i++) {
            let element = config.concat_css_backend[i];
            let css = config.srcDir + '/css/' + element + '.css';
            let minCss = config.srcDir + '/css/' + element + '.min.css';

            if (fs.existsSync(css)) {
                cssBundle.push(css);
            } else if (fs.existsSync(minCss)) {
                cssBundle.push(minCss);
            }

            if (fs.existsSync(minCss)) {
                minCssBundle.push(minCss);
            } else if (fs.existsSync(css)) {
                minCssBundle.push(css);
            }
        }

        const resultDir = config.resultDir + '/backend';

        console.log(cssBundle);
        console.log(minCssBundle);

        const stream1 = gulp.src(cssBundle)
            .pipe(concat('bundle.css'))
            .pipe(gulp.dest(resultDir))
            .pipe(size({showFiles: true}))
        ;
        
        const stream2 =  gulp.src(minCssBundle)
            .pipe(concat('bundle.min.css'))
            .pipe(gulp.dest(resultDir))
            .pipe(size({showFiles: true}))
            ;
        
        return merge(stream1, stream2);
    });
}