const { watch, src, dest} = require('gulp');
const sass = require('gulp-sass');
const postcss = require('gulp-postcss');

const scss = () => {
    const tailwindcss = require('tailwindcss');
    return src('source/**/*.scss')
        .pipe(sass()
        .on('error', sass.logError))
        .pipe(postcss([
            tailwindcss('./tailwind.config.js'),
            require('autoprefixer'),
        ]))
        .pipe(dest('./source/', { sourcemaps: true }));
}

exports.watch = () => {
    return watch('source/**/*.scss', scss);
}

exports.default = scss;
