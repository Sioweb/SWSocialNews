<?php

/*
 * Contao Open Source CMS
 * Copyright (C) 2005-2012 Leo Feyer
 *
 */

namespace sioweb\contao\extensions\social;
use Contao;

/**
* @file SWArticleModel.php
* @class SWArticleModel.php
* @author Sascha Weidner
* @version 3.0.0
* @package sioweb.contao.extensions.social
* @copyright Sioweb - Sascha Weidner
*/

if(!class_exists('SWArticleModel'))
{

class SWArticleModel extends \ArticleModel
{
	public static function findPublishedByPid($intPid, array $arrOptions=array())
	{
		$t = static::$strTable;
		$arrColumns = array("$t.pid=?");
		$arrValues = array($intPid);

		if (!BE_USER_LOGGED_IN)
		{
			$time = time();
			$arrColumns[] = "($t.start='' OR $t.start<$time) AND ($t.stop='' OR $t.stop>$time) AND $t.published=1";
		}

		if (!isset($arrOptions['order']))
		{
			$arrOptions['order'] = "$t.sorting";
		}

		return static::findBy($arrColumns, $arrValues, $arrOptions);
	}
}

}
