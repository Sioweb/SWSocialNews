<?php

/*
 * Contao Open Source CMS
 * Copyright (C) 2005-2012 Leo Feyer
 *
 */

/**
* @file tl_news.php
* @author Sascha Weidner
* @version 3.0.0
* @package sioweb.contao.extensions.news
* @copyright Sioweb - Sascha Weidner
*/


/**
 * Table tl_news
 */
$GLOBALS['TL_DCA']['tl_news']['palettes']['default'] = str_replace('{date_legend}','{social_legend},sw_socialnetworks;{date_legend}',$GLOBALS['TL_DCA']['tl_news']['palettes']['default']);

$GLOBALS['TL_DCA']['tl_news']['fields']['sw_socialnetworks'] = array(
	'label'                   => &$GLOBALS['TL_LANG']['tl_news']['sw_socialnetworks'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'options_callback'		  => array('tl_social_news','sozial_networks'),
	'eval'                    => array('multiple'=>true),
	'sql'                     => "text NULL"
);

class tl_social_news extends tl_news {
	
	public function sozial_networks()
	{
		return $GLOBALS['sozialnetworks'];
	}
	
}