module.exports = {
	plugins: [
		require('autoprefixer'),
		require('postcss-preset-env')({
			stage: 1
		}),
		require('precss'),
		require('postcss-import'),
		require('postcss-assets')({
			loadPaths: ['public/img'],
			relative: 'logans-books/public'
		}),
		// require('cssnano')({
		// 	preset: ["default", { discardComments: { removeAll: true, }, }],
		// }),
	],
};