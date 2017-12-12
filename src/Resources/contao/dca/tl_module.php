<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2017 Dennis Hilpmann
 *
 * @license LGPL-3.0+
 */

/**
 * Add palettes to tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['palettes']['teaserlist']      = '{title_legend},name,headline,type;{config_legend},getTeaserCategory;{template_legend:hide},customTpl;{expert_legend:hide},guests,cssID';
$GLOBALS['TL_DCA']['tl_module']['palettes']['teaserfilter']    = '{title_legend},name,headline,type;{config_legend},getTeaserCategory;{template_legend:hide},customTpl;{expert_legend:hide},guests,cssID';
/**
* Add fields to tl_module
*/
$GLOBALS['TL_DCA']['tl_module']['fields']['getTeaserCategory'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['getTeaserCategory'],
	'exclude'                 => true,
	'inputType'               => 'radio',
	'options_callback'        => array('tl_module_teaser_category', 'getTeaserCategory'),
	'eval'                    => array('mandatory'=>true),
	'sql'                     => "blob NULL"
);

class tl_module_teaser_category extends Backend
{
	/**
	 * Get all news archives and return them as array
	 * @return array
	 */
	public function getTeaserCategory()
	{
		$arrTeaser = array();
		$objTeaser = $this->Database->execute("SELECT id, title FROM tl_teaser ORDER BY title");
		while ($objTeaser->next())
		{
			$arrTeaser[$objTeaser->id] = $objTeaser->title;
		}
		return $arrTeaser;
	}
}