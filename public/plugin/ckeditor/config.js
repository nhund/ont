/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.extraPlugins = ['filebrowser','oembed','widget','mathjax'];
	config.removePlugins = 'easyimage';
	config.image_previewText = ' ';
	config.oembed_maxWidth = '560';
	config.oembed_maxHeight = '315';
	config.oembed_WrapperClass = 'embededContent';
	config.mathJaxLib = '/public/plugin/ckeditor/plugins/mathjax/MathJax.js?config=TeX-AMS_HTML';
	// config.toolbar = ['VideoDetector'];
};
