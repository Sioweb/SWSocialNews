<?php
	
/*
* Contao Open Source CMS
* Copyright (C) 2005-2012 Leo Feyer
*
*/

namespace sioweb\contao\extensions\news;
use Contao;

/**
* @file SWNewsArchive.php
* @class SWNewsArchive
* @author Sascha Weidner
* @version 3.0.0
* @package sioweb.contao.extensions.news
* @copyright Sascha Weidner, Sioweb
*/
class SWNewsArchive extends \ModuleNewsArchive
{

	/**
	 * Display a wildcard in the back end
	 * @return string
	 */
	public function generate()
	{
		return parent::generate();
	}


	/**
	 * Generate the module
	 */
	protected function compile()
	{
		parent::compile();
	}
	
	protected function parseArticle($objArticle, $blnAddArchive=false, $strClass='')
	{
		if($objArticle->sw_socialnetworks)
		{
			$newSocialObj = new \FrontendTemplate('sw_sozialshare');
			$newSocialObj->setData($objArticle->row());
			$newSocialObj->sw_socialnetworks = deserialize($objArticle->sw_socialnetworks);
			$newSocialObj->encUrl = rawurlencode(\Environment::get('url')).'/'.parent::generateNewsUrl($objArticle, $blnAddArchive);
			$newSocialObj->encTitle = rawurlencode($objArticle->headline);
			
			$objArticle->sw_socialnetworks = $newSocialObj->parse();
		}
		
		return parent::parseArticle($objArticle, $blnAddArchive, $strClass);
	}
	
}
