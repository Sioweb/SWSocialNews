<?php

/*
 * Contao Open Source CMS
 * Copyright (C) 2005-2012 Leo Feyer
 *
 */
 
namespace sioweb\contao\extensions\social;
use Contao;


/**
* @file ContentFacebook.php
* @class ContentFacebook
* @author Sascha Weidner
* @version 3.0.0
* @package sioweb.contao.extensions.social
* @copyright Sioweb - Sascha Weidner
*/


class ContentFacebook extends \Frontend
{

	public function __construct()
	{
		global $objPage;
		
		parent::__construct();
		$this->_checkThumbnails();
		
		if(preg_match('/'.implode('|',array_keys($GLOBALS['sozialnetworks'])).'/is',$_SERVER['HTTP_USER_AGENT']) || $_GET['dev'] == 1)
		{

			$OGTags = array(
				'title' => $this->replaceInsertTags('{{page::pageTitle}}'), 
				'url' => $this->replaceInsertTags('{{env::url}}').'/'.$this->replaceInsertTags('{{page::alias}}').'.html',
				'description' => strip_tags($objPage->description)
			);

			// Set the item from the auto_item parameter
			if ($GLOBALS['TL_CONFIG']['useAutoItem'] && isset($_GET['auto_item']))
			{
				\Input::setGet('items', \Input::get('auto_item'));
			}
			if(\Input::get('items'))
			{
				$NewsArchive = \NewsArchiveModel::findAll();
				if($NewsArchive)
				{
					$arrNews = array();
					while($NewsArchive->next())
						$arrNews[] = $NewsArchive->id;
					$objArticle = \NewsModel::findPublishedByParentAndIdOrAlias(\Input::get('items'),$arrNews);
					if($objArticle)
					{
						$OGTags = array(
							'title' => $objArticle->headline,
							'url' => $this->replaceInsertTags('{{env::url}}').'/'.$this->replaceInsertTags('{{env::request}}'),
							'description' => strip_tags($objArticle->teaser ? $objArticle->teaser : $objPage->description)
						);
					}
				}
			}


			foreach($OGTags as $tKey => $tag)
				if(str_replace(' ','',trim($tag)) != '' && !in_array('<meta property="og:'.$tKey.'" content="'.$tag.'" />'."\n", $GLOBALS['TL_HEAD']))
					$GLOBALS['TL_HEAD'][] = '<meta property="og:'.$tKey.'" content="'.$tag.'" />'."\n";
		}
	}
	
	private function _checkThumbnails()
	{
		global $objPage;
		$GLOBALS['socialmedia_thumbnails'] = false;
		if((preg_match('/'.implode('|',array_keys($GLOBALS['sozialnetworks'])).'/is',$this->Environment->httpUserAgent) || $_GET['dev'] == 1))
		{
			$hasElement = false;
			$parents = array();
			$Article = \SWArticleModel::findPublishedByPid($objPage->id);
			if($Article)
			{
				while($Article->next())
					$parents[] = $Article->id;
			
				$hasElement = \SWContentModel::findMultiblePid($parents);
				if($hasElement)
					while($hasElement->next())
					{
						if($hasElement->type == 'alias')
						{
							$hasAliasElement = \ContentModel::findById($hasElement->cteAlias);
							if($hasAliasElement->type == 'socialmedia_thumbnails')
							{
								$GLOBALS['socialmedia_thumbnails'] = 2;
								break;
							}
						}
						if($hasElement->type == 'socialmedia_thumbnails')
						{
							$GLOBALS['socialmedia_thumbnails'] = 2;
							break;
						}
					}
			}
		}
		
		return $GLOBALS['socialmedia_thumbnails'];
	}
	
	public function FacebookContentImage($objElement, $strBuffer)
	{	
		if(((preg_match('/'.implode('|',array_keys($GLOBALS['sozialnetworks'])).'/is',$this->Environment->httpUserAgent) || $_GET['dev'] == 1)) && !$GLOBALS['socialmedia_thumbnails'])
		{
			if($objElement->multiSRC)
			{
				$Images = deserialize($objElement->multiSRC);
				foreach($Images as $iKey => $image)
				{
					$image = \FilesModel::findByPk($image);
					#$newImage = $image;
					if(!preg_match('/[ ]+/',urldecode($image->path)))
					{
						$newImage = false;
						if(is_file(TL_ROOT .'/'.$image->path ))
							$newImage = parent::getImage($image->path,200,200,'crop',null,0);
						$Meta = '<meta property="og:image" content="http://'.$this->Environment->httpHost.'/'.$newImage.'" />';
						if(!in_array($Meta,(array)$GLOBALS['TL_HEAD']) && $newImage && is_file(TL_ROOT .'/'.$newImage ))
							$GLOBALS['TL_HEAD'][] = $Meta;
					}
				}
			}
			
			if($objElement->singleSRC)
			{
				$image = \FilesModel::findByPk($objElement->singleSRC);
				if(!preg_match('/[ ]+/',urldecode($image->pdf)))
				{
					$newImage = false;
					if(is_file(TL_ROOT .'/'.$image->pdf ))
						$newImage = parent::getImage($image->pdf,200,200,'crop');
					$Meta = '<meta property="og:image" content="http://'.$this->Environment->httpHost.'/'.$newImage.'" />';
					if(!in_array($Meta,(array)$GLOBALS['TL_HEAD']) && $newImage && is_file(TL_ROOT .'/'.$newImage ))
						$GLOBALS['TL_HEAD'][] = $Meta;
				}
			}/**/
		}
	    return $strBuffer;
	}
	

}