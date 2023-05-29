

var ftp = require('vinyl-ftp'),
    log = require('fancy-log'),
//    debug = require('gulp-debug'),
//    notify = require('gulp-notify'),
    assign = require('object-assign');

var connBrowserReload = null,
    conn = null,
    globalConfig = null;

function createFtpBrowserReload() {
    return ftp.create(assign(globalConfig.ftpData, {
            log: function (v, ext) {
                if (v.includes('UP')) {
                    if (!!globalConfig.browserSync)
                        globalConfig.browserSync.reload();

                    log('Upload Ftp with reload : ' + ext);
                }
            }
        })
    );
}

function createFtp() {
    return ftp.create(assign(globalConfig.ftpData, {
            log: function (v, ext) {
                if (v.includes('UP')) {
                    log('Upload Ftp : ' + ext);
                }
            }
        })
    );
}

module.exports = function (gulp, config) {

    globalConfig = config;

    gulp.task('watch:ftp', function (cb) {
        log('use FTP: ' + config.useFtp);
        if (!config.useFtp)
            return cb();
        console.log(globalConfig);
        const watcherReload = gulp.watch(config.blobFtpWithReload);
        watcherReload.on('all', function (ev, path, stats) {

            if (connBrowserReload === null)
                connBrowserReload = createFtpBrowserReload();

            if (['change', 'add'].indexOf(ev) < 0)
                return;

            gulp.src(path)
                .pipe(connBrowserReload.dest(globalConfig.ftpData.ftpDir))
                .on('error', function (error) {
                    console.error('' + error);
                })
            // .pipe(notify({title: "FTP B", message: "<%= file.relative %>"}))
            ;
        });

        const watcher = gulp.watch(config.blobFtp);
        watcher.on('all', function (ev, path, stats) {

            if (conn === null)
                conn = createFtp();

            if (['change', 'add'].indexOf(ev) < 0)
                return;

            gulp.src(path)
                .pipe(conn.dest(globalConfig.ftpData.ftpDir))
                .on('error', function (error) {
                    console.error('' + error);
                })
            // .pipe(notify({title: "FTP B", message: "<%= file.relative %>"}))
            ;
        });

        return cb();
    });

    return {}
};
module.exports.createFtpBrowserReload = createFtpBrowserReload;
module.exports.createFtp = createFtp;
