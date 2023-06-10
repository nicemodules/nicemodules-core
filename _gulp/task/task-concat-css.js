const concat = require('gulp-concat');
const fs = require('fs');
const size = require('gulp-size');
const merge = require('merge-stream');


module.exports = function (gulp, config, env) {

    gulp.task('concat-css', function () {

        const cfg = config[env];
        
        const cssBundle = [];
        const minCssBundle = [];

        for (let i = 0; i < cfg.concat_css.length; i++) {
            let element = cfg.concat_css[i];
            let css = config.src_dir + '/css/' + element + '.css';
            let minCss = config.src_dir + '/css/' + element + '.min.css';

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

        const resultDir = config.result_dir + '/css/' + env;

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