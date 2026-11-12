const mix = require('laravel-mix')

const path = require('path')
const directory = path.basename(path.resolve(__dirname))

const source = 'platform/themes/' + directory
const dist = 'public/themes/' + directory

mix.sass(`${source}/assets/sass/theme.scss`, dist + '/css')
    .js(`${source}/assets/js/app.js`, dist + '/js')
    .js(`${source}/assets/js/theme.js`, dist + '/js')
    .js(`${source}/assets/js/ecommerce.js`, dist + '/js')
    .js(`${source}/assets/js/page.js`, dist + '/js')

if (mix.inProduction()) {
    mix.copy(`${dist}/css/theme.css`, `${source}/public/css`)
        .copy(`${dist}/js/app.js`, `${source}/public/js`)
        .copy(`${dist}/js/theme.js`, `${source}/public/js`)
        .copy(`${dist}/js/ecommerce.js`, `${source}/public/js`)
        .copy(`${dist}/js/page.js`, `${source}/public/js`)
}
