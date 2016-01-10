var path = require('path');

const PATHS = {
  app: path.join(__dirname, 'app'),
  build: path.join(__dirname, 'build')
};

module.exports = {
  entry: [
    'webpack/hot/dev-server',
    path.join(PATHS.app, 'main.js')
  ],
  output: {
    path: path.resolve(PATHS.build),
    publicPath: 'https://localhost:8080/', // this enables hot-update.json to be found.
    filename: 'bundle.js',
  },
};
