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
$GLOBALS['TL_DCA']['tl_module']['palettes']['teaserlist']      = '{title_legend},name,headline,type;{config_legend},teaserCategory;{template_legend:hide},customTpl;{expert_legend:hide},guests,cssID';
$GLOBALS['TL_DCA']['tl_module']['palettes']['teaserfilter']    = '{title_legend},name,headline,type;{config_legend},teaserCategory;{template_legend:hide},customTpl;{expert_legend:hide},guests,cssID';
$GLOBALS['TL_DCA']['tl_module']['palettes']['teaserupdate']    = '{title_legend},name,headline,type;{config_legend},teaserCategory,jumpTo;{template_legend:hide},customTpl;{expert_legend:hide},guests,cssID';
/**
* Add fields to tl_module
*/
$GLOBALS['TL_DCA']['tl_module']['fields']['teaserCategory'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['teaserCategory'],
	'exclude'                 => true,
	'inputType'               => 'radio',
	'options_callback'        => array('tl_module_teaser', 'getTeaserCategory'),
	'eval'                    => array('mandatory'=>true),
	'sql'                     => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['jumpTo'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['jumpTo'],
	'exclude'                 => false,
	'inputType'               => 'pageTree',
	'foreignKey'              => 'tl_page.title',
	'eval'                    => array('mandatory'=>true, 'fieldType'=>'radio'),
	'sql'                     => "int(10) unsigned NOT NULL default '0'",
	'relation'                => array('type'=>'belongsTo', 'load'=>'lazy')
);

class tl_module_teaser extends Backend
{
	/**
	 * Get all news archives and return them as array
	 * @return array
	 */
	public function getTeaserCategory()
	{
		$arrTeaser = array();
		$objTeaser = $this->Database->execute("SELECT id, title FROM tl_teaser_category ORDER BY title");
		while ($objTeaser->next())
		{
			$arrTeaser[$objTeaser->id] = $objTeaser->title;
		}
		return $arrTeaser;
	}
}