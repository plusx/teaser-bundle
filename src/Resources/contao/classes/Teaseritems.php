<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2017 Leo Feyer
 *
 * @license LGPL-3.0+
 */

namespace Dehil;


/**
 * Provide methods to get all events of a certain period from the database.
 *
 * @property bool $cal_noSpan
 *
 * @author Leo Feyer <https://github.com/leofeyer>
 */
abstract class Teaseritems extends \Module
{

	/**
	 * Current URL
	 * @var string
	 */
	protected $strUrl;

	/**
	 * Current events
	 * @var array
	 */
	protected $arrTeaser = array();

	/**
	 * URL cache array
	 * @var array
	 */
	private static $arrUrlCache = array();

}
