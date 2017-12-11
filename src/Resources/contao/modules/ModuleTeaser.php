<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2017 Leo Feyer
 *
 * @license LGPL-3.0+
 */

namespace Dehil;

use Contao\CoreBundle\Exception\PageNotFoundException;
use Patchwork\Utf8;


/**
 * Front end module "calendar".
 *
 * @property int    $cal_startDay
 * @property array  $cal_calendar
 * @property string $cal_ctemplate
 *
 * @author Leo Feyer <https://github.com/leofeyer>
 */
class ModuleTeaser extends \Module
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_teaser_default';


	/**
	 * Do not show the module if no calendar has been selected
	 *
	 * @return string
	 */
	// public function generate()
	// {
	// 	// if (TL_MODE == 'BE')
	// 	// {
	// 	// 	/** @var BackendTemplate|object $objTemplate */
	// 	// 	$objTemplate = new \BackendTemplate('be_wildcard');

	// 	// 	$objTemplate->wildcard = '### ' . Utf8::strtoupper($GLOBALS['TL_LANG']['FMD']['teaseritems'][0]) . ' ###';
	// 	// 	$objTemplate->title = $this->title;
	// 	// 	$objTemplate->id = $this->id;
	// 	// 	$objTemplate->link = $this->name;
	// 	// 	$objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

	// 	// 	return $objTemplate->parse();
	// 	// }

	// 	return parent::generate();

	// }


	/**
	 * Generate the module
	 */
	protected function compile()
	{
		$this->Template->helloworld = 'helloworld';
		echo 'hurz';
	}
}
