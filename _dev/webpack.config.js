/* https://webpack.js.org/configuration/ */
const path = require('path');

/*
 *	additional, standard plugins:
 *
 *	For extracting CSS out of JS: 
 *	https://github.com/webpack-contrib/mini-css-extract-plugin
 */
const MiniCssExtractPlugin = require("mini-css-extract-plugin");

/*
 *	For optmizing CSS:
 *	https://github.com/webpack-contrib/css-minimizer-webpack-plugin
 *  (for webpack v5 or above please use css-minimizer-webpack-plugin instead of optimize-css-assets-webpack-plugin)
 */
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");

const config = {
    entry: {
        'global.bundle' : './_js/global.js',
        //'index' : './_js/pages/index.js',
        //'admin/admin' : './_js/admin/admin.js'
    },
    output: {
        path: path.resolve(__dirname, '../assets/js'),
        filename: '[name].js'
    },
    module: {
        rules: [
            { 
                test: /\.(js|jsx)$/,
                //exclude: /(node_modules)/,
                exclude: [
                    path.resolve(__dirname, 'node_modules'), 
                    path.resolve(__dirname, 'webpack')
                ],            
                use: [
                    {
                        // https://github.com/babel/babel-loader
                        loader: "babel-loader",	                    
                        options: {
                            presets: ['@babel/preset-env', '@babel/preset-react']
                        }
                    }
                ] 
            },
            {
                test: /\.(sa|sc|c)ss$/,
                use: [
                    {
                        loader: MiniCssExtractPlugin.loader						
                    },
                    {
                        loader: 'css-loader',
                        options : {
                            url : false,
                            sourceMap : true,							
                        }
                    },
                    {
                        loader: 'sass-loader',
                        options : {
                            sourceMap : true,
                        }
                    },
                ],
            },
            //https://www.robinwieruch.de/react-svg-icon-components/#react-svg-icon-components-webpack
            {
                test: /\.svg$/,
                use: [
                    {
                        loader: '@svgr/webpack',
                        options: {
                            svgo: false, //disable additional prefixes for class and attributes (see: https://react-svgr.com/docs/options/)
                        },
                    }
                ],
            },							
        ]
    },

    devtool: "source-map", //development only?
    resolve: {
        extensions: ['*', '.js', '.jsx']
    },  
    plugins: [
        new MiniCssExtractPlugin({
            // Options similar to the same options in webpackOptions.output
            // both options are optional
            filename: "../css/[name].css",
            chunkFilename: "../css/[name].css"
        }),
    ],
    //https://webpack.js.org/configuration/optimization/
    optimization: {
        minimize: true,
        minimizer: [
          // For webpack@5 you can use the `...` syntax to extend existing minimizers (i.e. `terser-webpack-plugin`), uncomment the next line
          `...`, //use existing plugins, i.e. build-in TerserWebpackPlugin 
          new CssMinimizerPlugin(),
        ],
    },    
};

module.exports = config;
