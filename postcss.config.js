const colors = require('./private/scss/vars.js');

module.exports = {
	plugins: [
		require("postcss-import"),
		require('postcss-mixins'),
		require('autoprefixer'),
		require('postcss-preset-env')({
			stage: 1
		}),
		require('css-prefers-color-scheme'),
		require('postcss-simple-vars')({
			variables: colors
		}),
		require('postcss-import'),
		require('postcss-nesting')({
			noIsPseudoSelector: true
		}),
		require('@csstools/postcss-stepped-value-functions'),
		require('cssnano')({
			preset: ["default", { discardComments: { removeAll: true, }, }],
		}),
	],
};