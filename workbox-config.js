module.exports = {
	globDirectory: 'public/',
	globPatterns: [
		'**/*.{gif,png,css,ico,eot,ttf,woff,woff2,php,js,txt,json,config}'
	],
	swDest: 'public/sw.js',
	ignoreURLParametersMatching: [
		/^utm_/,
		/^fbclid$/
	]
};