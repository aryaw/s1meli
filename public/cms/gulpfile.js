let gulp = require('gulp');
let concat = require('gulp-concat');
let cleanCss = require('gulp-clean-css')
let uglify = require('gulp-uglify');
let babel = require('gulp-babel');

let config = require('./gulpconfig')
let cssOptions = {
    level: 1,
    compatibility: 'ie8',
    level: {
        1: {
            specialComments:0,
        }
    }
};

function defaultTask(cb) {
    cb();
}


// VENDOR
function vendorCss(cb){    
    return gulp
        .src(config.path.css.vendor)
        .pipe(concat(config.name.css.vendor))
        .pipe(cleanCss(cssOptions))
        .pipe(gulp.dest(config.path.destination.css))
}
function vendorJs(cb){
    return gulp
        .src(config.path.js.vendor)
        .pipe(concat(config.name.js.vendor))
        .pipe(uglify())
        .pipe(gulp.dest(config.path.destination.js));
}
function vendorFile(cb){
    var length = (config.path.vendor_file).length;
    for(var i = 0; i<length; i++){
        var each = config.path.vendor_file[i];            
        gulp
            .src(each.source)        
            .pipe(gulp.dest(each.destination));
    }
    cb();
}
// END VENDOR



// LOGIN
function loginJs(cb){
    return gulp
        .src(config.path.js.login)
        .pipe(concat(config.name.js.login))
        .pipe(uglify())
        .pipe(gulp.dest(config.path.destination.js));        
}
function loginCss(cb){    
    return gulp
        .src(config.path.css.login)
        .pipe(concat(config.name.css.login))
        .pipe(cleanCss(cssOptions))
        .pipe(gulp.dest(config.path.destination.css))    
}
// END LOGIN



// APP
function appJs(cb){
    return gulp
        .src(config.path.js.app)
        .pipe(concat(config.name.js.app))
        .pipe(babel({
			presets: ['@babel/preset-env']
		}))
        .pipe(uglify())
        .pipe(gulp.dest(config.path.destination.js));        
}
function appCss(cb){    
    return gulp
        .src(config.path.css.app)
        .pipe(concat(config.name.css.app))
        .pipe(cleanCss(cssOptions))
        .pipe(gulp.dest(config.path.destination.css))    
}
function appFile(cb){
    var length = (config.path.app_file).length;
    for(var i = 0; i<length; i++){
        var each = config.path.app_file[i];
        gulp
            .src(each.source)        
            .pipe(gulp.dest(each.destination));
    }
    cb();
}
// END APP



module.exports = 
{
    default: defaultTask,
    vendor: gulp.parallel(vendorJs, vendorCss, vendorFile),
    login: gulp.parallel(loginJs, loginCss),
    app: gulp.parallel(appJs, appCss, appFile),
}