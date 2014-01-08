<?php

/*
 * Contao Open Source CMS
 * Copyright (C) 2005-2012 Leo Feyer
 *
 */

/**
* @file autoload.php
* @author Sascha Weidner
* @version 3.0.0
* @package sioweb.contao.extensions.news
* @copyright Sioweb - Sascha Weidner
*/


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'sioweb\contao\extensions\news',
	'sioweb\contao\extensions\social'
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
	'sioweb\contao\extensions\social\ContentFacebook'				=> 'system/modules/SWSocialNews/classes/ContentFacebook.php',
	// Elements
	'sioweb\contao\extensions\social\ContentSocialMediaThumbnails'	=> 'system/modules/SWSocialNews/elements/ContentSocialMediaThumbnails.php',
	// Model
	'sioweb\contao\extensions\social\SWContentModel'				=> 'system/modules/SWSocialNews/models/SWContentModel.php',
	'sioweb\contao\extensions\social\SWArticleModel'				=> 'system/modules/SWSocialNews/models/SWArticleModel.php',
	
	// Modules
	'sioweb\contao\extensions\news\SWNews'							=> 'system/modules/SWSocialNews/modules/SWNews.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'sw_sozialshare'       => 'system/modules/SWSocialNews/templates',
	'ce_fb_gallery'        => 'system/modules/SWSocialNews/templates',
	'gallery_fb_default'   => 'system/modules/SWSocialNews/templates',
));
