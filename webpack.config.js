let Encore = require('@symfony/webpack-encore');

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    // only needed for CDN's or sub-directory deploy
    //.setManifestKeyPrefix('build/')

    // CKEditor configs
    // .copyFiles([
    //     {from: './node_modules/ckeditor4/', to: 'ckeditor/[path][name].[ext]', pattern: /\.(js|css)$/, includeSubdirectories: false},
    //     {from: './node_modules/ckeditor4/adapters', to: 'ckeditor/adapters/[path][name].[ext]'},
    //     {from: './node_modules/ckeditor4/lang', to: 'ckeditor/lang/[path][name].[ext]'},
    //     {from: './node_modules/ckeditor4/plugins', to: 'ckeditor/plugins/[path][name].[ext]'},
    //     {from: './node_modules/ckeditor4/skins', to: 'ckeditor/skins/[path][name].[ext]'},
    //     {from: './node_modules/ckeditor4/vendor', to: 'ckeditor/vendor/[path][name].[ext]'}
    // ])

    /*
     * ENTRY CONFIG
     *
     * Add 1 entry for each "page" of your app
     * (including one that's included on every page - e.g. "app")
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if you JavaScript imports CSS.
     */
    .addEntry('js/app', './assets/app.js')
    .addEntry('js/layout', './assets/js/layout.js')
    .addEntry('js/image', './assets/js/image.js')
    .addEntry('js/ekko-lightbox', './assets/js/ekko-lightbox')
    .addEntry('js/select2', './assets/js/select2.js')
    .addEntry('js/product', './assets/js/product.js')
    .addEntry('js/user-thread', './assets/js/user-thread.js')    

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .enableSingleRuntimeChunk()

    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    //.splitEntryChunks()

    // enables Sass/SCSS support
    .enableSassLoader()

    // uncomment if you use TypeScript
    //.enableTypeScriptLoader()

    // uncomment if you're having problems with a jQuery plugin
    .autoProvidejQuery()

    // uncomment if you use API Platform Admin (composer req api-admin)
    //.enableReactPreset()

    .addStyleEntry('css/app', ['./assets/styles/app.scss'])
    .addStyleEntry('css/detail', ['./assets/styles/detail.scss'])
    .addStyleEntry('css/image', ['./assets/styles/image.scss'])
    .addStyleEntry('css/ekko-lightbox', ['./assets/styles/ekko-lightbox.scss'])
    .addStyleEntry('css/select2', ['./assets/styles/select2.scss'])

    //.enableIntegrityHashes()
    .configureBabel(null, {
        useBuiltIns: 'usage',
        corejs: 3
    })
    .configureDevServerOptions(options => {
        options.allowedHosts = 'all';
        options.hot = true;
    })
;

module.exports = Encore.getWebpackConfig();
