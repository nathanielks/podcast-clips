const path = require('path');
const merge = require('webpack-merge');
const webpack = require('webpack');
const node_modules_dir = path.resolve(__dirname, 'node_modules');

const TARGET = process.env.npm_lifecycle_event;
const PATHS = {
  app: path.join(__dirname, 'js/src'),
  build: path.join(__dirname, 'js/build')
};

process.env.BABEL_ENV = TARGET;

const common = {
  entry: {
    app: PATHS.app,
    vendors: ['react']
  },
  resolve: {
    extensions: ['', '.js', '.jsx'],
    root: path.resolve(PATHS.app)
  },
  output: {
    path: PATHS.build,
    publicPath: 'https://localhost:8080/js/build/', // this enables hot-update.json to be found.
    filename: 'bundle.js'
  },
  module: {
    loaders: [
      {
        test: /\.jsx?$/,
        loaders: ['babel?cacheDirectory'],
        exclude: [node_modules_dir],
        include: PATHS.app
      }
    ]
  },
  plugins: [
    new webpack.optimize.CommonsChunkPlugin('vendors', 'vendors.js')
  ]
};

if(TARGET === 'start' || !TARGET) {
  module.exports = merge(common, {
    devtool: 'eval-source-map',
    devServer: {
      historyApiFallback: true,
      hot: true,
      inline: true,
      progress: true,
      colors: true,

      // display only errors to reduce the amount of output
      stats: 'errors-only',

      // parse host and port from env so this is easy
      // to customize
      host: process.env.HOST,
      port: process.env.PORT
    },
    plugins: [
      new webpack.HotModuleReplacementPlugin()
    ]
  });
}

if(TARGET === 'build') {
  module.exports = merge(common, {});
}
