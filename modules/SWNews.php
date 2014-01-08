<?php
	
/*
* Contao Open Source CMS
* Copyright (C) 2005-2012 Leo Feyer
*
*/

namespace sioweb\contao\extensions\news;
use Contao;

/**
* @file SWNews.php
* @class SWNews
* @author Sascha Weidner
* @version 3.0.0
* @package sioweb.contao.extensions.news
* @copyright Sascha Weidner, Sioweb
*/

class SWNews
{	
	public function extendArticle(&$objTemplate, $objArticle, $news)
	{
		$this->news = $news;
		if($objArticle['sw_socialnetworks'])
		{
			$objArticle['sw_socialnetworks'] = deserialize($objArticle['sw_socialnetworks']);
			$newSocialObj = new \FrontendTemplate('sw_sozialshare');
			$newSocialObj->setData($objArticle);				
			$newSocialObj->encUrl = rawurlencode(\Environment::get('url')).'/'.$objTemplate->link;
			$newSocialObj->encTitle = rawurlencode($objArticle['headline']);
			$objTemplate->sw_socialnetworks = $newSocialObj->parse();
		}
	}
}