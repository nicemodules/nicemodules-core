const sass = require('gulp-sass');
const autoprefixer = require('gulp-autoprefixer');
const cleanCSS = require('gulp-clean-css');
const size = require('gulp-size');
const rename = require('gulp-rename');

module.exports = function(gulp, config, env){

    gulp.task('app-scss', function(){

        const cfg = config[env];
        
        const scssBundle =  cfg.app_scss.map(function (element){
            return  config.src_dir + '/scss/' + element + '.scss';
        });
        
        const resultDir = config.src_dir + '/css';

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