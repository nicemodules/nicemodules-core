const babel = require('gulp-babel');
const uglify = require('gulp-uglify');
const concat = require('gulp-concat');
const babelPresetEnv = require('@babel/preset-env');
const size = require('gulp-size');


module.exports = function (gulp, config, env) {
    gulp.task('app-js', function () {

        const cfg = config[env];

        const jsBundle = cfg.app_js.map(function (element) {
            return config.src_dir + '/js/' + element + '.js';
        });

        const resultDir = config.src_dir + '/js';

        console.log(jsBundle);

        return gulp.src(jsBundle)
            .pipe(babel({presets: [babelPresetEnv]}))
            .pipe(concat('app-' + env + '.js'))
            .pipe(size({showFiles: true}))
            .pipe(gulp.dest(resultDir))
            .pipe(uglify())
            .pipe(concat('app-' + env + '.min.js'))
            .pipe(gulp.dest(resultDir))
            .pipe(size({showFiles: true}))
            ;
    });
}
