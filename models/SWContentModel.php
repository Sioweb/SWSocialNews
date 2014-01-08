<?php

/*
 * Contao Open Source CMS
 * Copyright (C) 2005-2012 Leo Feyer
 *
 */

namespace sioweb\contao\extensions\social;
use Contao;

/**
* @file SWContentModel.php
* @class SWContentModel.php
* @author Sascha Weidner
* @version 3.0.0
* @package sioweb.contao.extensions.social
* @copyright Sioweb - Sascha Weidner
*/

if(!class_exists('SWContentModel'))
{
	
class SWContentModel extends \ContentModel
{
	public static function findMultiblePid($pids, array $arrOptions=array())
	{
		if (!is_array($pids) || empty($pids))
			return null;
		
		$t = static::$strTable;
		return static::findBy(array("$t.pid IN(" . implode(',', array_map('intval', $pids)) . ")"), null, array('order'=>\Database::getInstance()->findInSet("$t.id", $pids)));
	}
}

}
