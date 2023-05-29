const babel = require('gulp-babel');
const uglify = require('gulp-uglify');
const concat = require('gulp-concat');
const babelPresetEnv = require('@babel/preset-env');
const size = require('gulp-size');


module.exports = function (gulp, config) {
    gulp.task('app-js-backend', function () {
        
        const jsBundle =  envConfig.app_js_backend.map(function (element){
            return envConfig.srcDir + '/js/' + element + '.js';
        });
        
        const resultDir = envConfig.srcDir + 'js';
        
        console.log(jsBundle);
        
        return  gulp.src(jsBundle)
            .pipe(babel({ presets: [babelPresetEnv] })) 
            .pipe(concat('app.js'))
            .pipe(size({ showFiles: true }))
            .pipe(gulp.dest(resultDir)) 
            .pipe(uglify())
            .pipe(concat('app.min.js')) 
            .pipe(gulp.dest(resultDir))
            .pipe(size({ showFiles: true }))
            ;
    });
}
