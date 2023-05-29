const sass = require('gulp-sass');
const autoprefixer = require('gulp-autoprefixer');
const cleanCSS = require('gulp-clean-css');
const size = require('gulp-size');
const rename = require('gulp-rename');

module.exports = function(gulp, config){

    gulp.task('app-scss-backend', function(){

        const scssBundle =  config.app_scss_backend.map(function (element){
            return  config.srcDir + '/scss/' + element + '.scss';
        });
        
        const resultDir = config.srcDir + '/css';

        console.log(scssBundle);

        return gulp.src(scssBundle)
            .pipe(sass({
                errLogToConsole: true,
                outputStyle: 'nested',
            }).on('error', sass.logError))
            .pipe(autoprefixer())
            .pipe(gulp.dest(resultDir))
            .pipe(cleanCSS())
            .pipe(rename({ suffix: '.min' }))
            .pipe(gulp.dest(resultDir))
            .pipe(size({ showFiles: true }))
            ;
    });
}