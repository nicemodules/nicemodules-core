const gulp = require('gulp');

const config = { // The file names are without extensions, but the extensions will be handle automatically.
    env: process.argv[process.argv.length - 1],
    srcDir: 'src',
    resultDir: 'result',
    minify: true, // If true produces also minified files.
    backend: {
        app_scss:[ // This files will be compiled into separate ↓ css files ↓. 
            'reset'
        ],
        concat_css: [ // This files will be concatenated into one css bundle.
            'reset',
            'materialdesignicons',
            'vuetify',
        ],
        app_js: [ // This files will be compiled into app.js and app.min.js file.
            'crud/locale/pl',
            'crud/filters',
            'crud/app'
        ],
        concat_js_backend: [ // This files will be concatenated into one js bundle.
            'vue',
            'vuetify',
            'app'
        ]
    },
    frontend: { // Same frontend configuration
        app_scss:[],
        concat_css: [ ],
        app_js: [],
        concat_js_backend: []
    },
    
};

require('./task/task-app-scss-backend')(gulp, config);
require('./task/task-concat-css-backend')(gulp, config);
require('./task/task-app-js-backend')(gulp, config);
require('./task/task-concat-js-backend')(gulp, config);

gulp.task(
    'backend',
    gulp.parallel(
        gulp.series('app-scss-backend', 'concat-css-backend'),
        gulp.series('app-js-backend', 'concat-js-backend'),
    )
    
);

