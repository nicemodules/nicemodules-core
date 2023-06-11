const gulp = require('gulp');

const env = process.argv[process.argv.length - 1].includes('frontend') ? 'frontend' : 'backend';

const config = { // The file names are without extensions, but the extensions will be handle automatically.
    src_dir: 'src',
    result_dir: '..',
    backend: { // Create bundles for backend using filies:
        app_scss: [ // This scss files will be compiled into separate ↓ css files ↓. 
            'backend/reset',
            'backend/style'
        ],
        concat_css: [ // This files will be concatenated into one css bundle.
            'reset',
            'materialdesignicons',
            'vuetify',
            'style',
        ],
        app_js: [ // This files will be compiled into app_[env].js and app_[env].min.js file.
            'crud/filters',
            'crud/app'
        ],
        concat_js: [ // This files will be concatenated into one js bundle.
            'vue',
            'vuetify',
            'app-backend'
        ]
    },
    frontend: { // Analogous frontend files configuration 
        app_scss: [],
        concat_css: [],
        app_js: [],
        concat_js_backend: []
    }
};

require('./task/task-app-scss')(gulp, config, env);
require('./task/task-concat-css')(gulp, config, env);
require('./task/task-app-js')(gulp, config, env);
require('./task/task-concat-js')(gulp, config, env);

gulp.task(
    'backend',
    gulp.parallel(
        gulp.series('app-scss', 'concat-css'),
        gulp.series('app-js', 'concat-js'),
    )
);

gulp.task(
    'frontend',
    gulp.parallel(
        gulp.series('app-scss', 'concat-css'),
        gulp.series('app-js', 'concat-js'),
    )
);

gulp.task('watch-backend', function () {
    gulp.watch([
            config.src_dir + '/scss/backend',
            config.src_dir + '/js/backend',
            config.src_dir + '/js/crud'
        ],
        gulp.parallel('backend')
    );
});

gulp.task('watch-frontend', function () {
    gulp.watch([
            config.src_dir + '/scss/frontend',
            config.src_dir + '/js/frontend',
            config.src_dir + '/js/crud',
        ],
        gulp.parallel('frontend'));
}); 