var path = require('path');
var webpack = require('webpack');
var merge = require('webpack-merge');

const TARGET = process.env.npm_lifecycle_event;
const PATHS = {
  app: path.join(__dirname, 'app'),
  build: path.join(__dirname, 'build')
};

const common = {
  entry: [
    'webpack/hot/dev-server',
    path.join(PATHS.app, 'main.js')
  ],
  output: {
    path: path.resolve(PATHS.build),
    publicPath: 'https://localhost:8080/', // this enables hot-update.json to be found.
    filename: 'bundle.js',
  }
};

// Default configuration
if(TARGET === 'dev' || !TARGET) {
  module.exports = merge(common, {
    devtool: 'eval-source-map',
    devServer: {
      historyApiFallback: true,
      colors: true,
      progress: true,
      hot: true,
      inline: true,
      // Display only errors to reduce the amount of output.
      stats: 'errors-only'
    }
  });
}

if(TARGET === 'build') {
  module.exports = merge(common, {});
}
