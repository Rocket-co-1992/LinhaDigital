const path = require('path');

module.exports = {
  entry: './assets/js/app.js',
  output: {
    filename: 'app.js',
    path: path.resolve(__dirname, 'build/js'),
    clean: true
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: {
          loader: 'babel-loader',
          options: {
            presets: ['@babel/preset-env']
          }
        }
      }
    ]
  },
  resolve: {
    extensions: ['.js']
  }
};
