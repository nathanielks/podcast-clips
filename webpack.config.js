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
  resolve: {
    extensions: ['', '.js', '.jsx']
  },
  output: {
    path: path.resolve(PATHS.build),
    publicPath: 'https://localhost:8080/', // this enables hot-update.json to be found.
    filename: 'bundle.js',
  },
  module: {
    loaders: [

    // Set up jsx. This accepts js too thanks to RegExp
    {
      test: /\.jsx?$/,
      // Enable caching for improved performance during development
      // It uses default OS directory by default. If you need something
      // more custom, pass a path to it. I.e., babel?cacheDirectory=<path>
      loaders: ['babel?cacheDirectory'],
      include: PATHS.app
    }

    ]
  },
};

// Default configuration
if(TARGET === 'dev' || !TARGET) {
  module.exports = merge(common, {
    devtool: 'eval-source-map',
    devServer: {
      historyApiFallback: true,
      colors: true,
      progress: true,

      // Display only errors to reduce the amount of output.
      stats: 'errors-only'
    }
  });
}

if(TARGET === 'build') {
  module.exports = merge(common, {});
}
