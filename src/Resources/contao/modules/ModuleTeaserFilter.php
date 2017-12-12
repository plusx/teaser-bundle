<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2017 Dennis Hilpmann
 *
 * @license LGPL-3.0+
 */
namespace Dehil\Teaser;
use Psr\Log\LogLevel;
use Contao\CoreBundle\Monolog\ContaoContext;
use Patchwork\Utf8;

class ModuleTeaserFilter extends \Module
{
	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_teaserfilter';

	/**
	 * Do not show the module if no category
	 *
	 * @return string
	 */
	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			/** @var BackendTemplate|object $objTemplate */
			$objTemplate = new \BackendTemplate('be_wildcard');
			$objTemplate->wildcard = '### ' . Utf8::strtoupper($GLOBALS['TL_LANG']['FMD']['teaserfilter'][0]) . ' ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;
			return $objTemplate->parse();
		}
		// $this->belegungsplan_category = \StringUtil::deserialize($this->belegungsplan_categories);
		// $this->belegungsplan_month = \StringUtil::deserialize($this->belegungsplan_month);
		// // aktuelle Seiten URL
		// $this->strUrl = preg_replace('/\?.*$/', '', \Environment::get('request'));

		// // Return if there are no categories
		// if (!is_array($this->belegungsplan_category) || empty($this->belegungsplan_category))
		// {
		// 	return '';
		// }
		// // Return if there are no month
		// if (!is_array($this->belegungsplan_month) || empty($this->belegungsplan_month))
		// {
		// 	return '';
		// }
		return parent::generate();
	}
	/**
	 * Generate the module
	 */
	protected function compile()
	{

	}
}
