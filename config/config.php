<?php

/*
 * Contao Open Source CMS
 * Copyright (C) 2005-2012 Leo Feyer
 *
 */

/**
* @file config.php
* @author Sascha Weidner
* @version 3.0.0
* @package sioweb.contao.extensions.news
* @copyright Sioweb - Sascha Weidner
*/

$GLOBALS['sozialnetworks'] = array('facebook'=>'Facebook','twitter'=>'Twitter','gplus'=>'Google+');

$GLOBALS['TL_HOOKS']['parseArticles'][] 	= array('SWNews','extendArticle');
$GLOBALS['TL_HOOKS']['getContentElement'][] = array('ContentFacebook', 'FacebookContentImage');

/**
 * Back end modules
 */

$GLOBALS['TL_CTE']['media']['socialmedia_thumbnails'] = 'ContentSocialMediaThumbnails';