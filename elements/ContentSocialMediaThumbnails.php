<?php

/*
 * Contao Open Source CMS
 * Copyright (C) 2005-2012 Leo Feyer
 *
 */
 
namespace sioweb\contao\extensions\social;
use Contao;

/**
* @file ContentSocialMediaThumbnails.php
* @class ContentSocialMediaThumbnails
* @author Sascha Weidner
* @version 2.11.7
* @package sioweb.contao.extensions.socialmedia
* @copyright Sioweb - Sascha Weidner
*/

class ContentSocialMediaThumbnails extends \ContentElement
{


	/**
	 * Return if there are no files
	 * @return string
	 */
	public function generate()
	{
		$this->multiSRC = deserialize($this->multiSRC);
		
		if (!is_array($this->multiSRC) || empty($this->multiSRC))
		{
			return '';
		}

		return parent::generate();
	}


	/**
	 * Generate the content element
	 */
	protected function compile()
	{
		if(preg_match('/'.implode('|',array_keys($GLOBALS['sozialnetworks'])).'/is',$this->Environment->httpUserAgent) || $_GET['dev'] == 1)
		{
			foreach($this->multiSRC as $iKey => $image)
			{
				if(!preg_match('/[ ]+/',urldecode($image)))
				{
					$image = \FilesModel::findByPk($image);
					$newImage = false;
					if(is_file(TL_ROOT .'/'.$image->path ))
						$newImage = parent::getImage($image->path,200,200,'crop',null,0);
					$Meta = '<meta property="og:image" content="http://'.$this->Environment->httpHost.'/'.$newImage.'" />';
					if(!in_array($Meta,(array)$GLOBALS['TL_HEAD']) && $newImage)
						$GLOBALS['TL_HEAD'][] = $Meta;
				}
			}
		}
	}
}
