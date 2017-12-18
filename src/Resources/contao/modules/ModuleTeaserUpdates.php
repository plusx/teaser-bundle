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
	protected $strTemplate = 'mod_teaserupdates';

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
			$objTemplate->wildcard = '### ' . Utf8::strtoupper($GLOBALS['TL_LANG']['FMD']['teaserupdates'][0]) . ' ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;
			return $objTemplate->parse();
		}

		// Return if there are no categories
		if (empty($this->teaserCategory))
		{
			return '';
		}
		return parent::generate();
	}
	/**
	 * Generate the module
	 */
	protected function compile()
	{


		// get newest teaser from database
		$teaser = $this->Database->prepare("SELECT * FROM tl_teaser_items WHERE pid=? ORDER BY id DESC limit 3")->execute($this->teaserCategory);

		while($teaser->next())
		{
			$current = $teaser->row();
			if($current['published'] = 1)
			{
				$start = ($current['start'] ?: time());
				$stop = ($current['stop'] ?: time());
				if ($start <= ($now = time()) && $now <= $stop)
				{
					$updates[] = $current;
				}
			}
		}

		//parse updates to template
		$this->Template->updates = $updates;

	}
}
