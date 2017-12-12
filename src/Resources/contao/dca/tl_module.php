<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2017 Leo Feyer
 *
 * @license LGPL-3.0+
 */

/**
 * Add palettes to tl_module
 */
// $GLOBALS['TL_DCA']['tl_module']['palettes']['teaserlist']      = '{title_legend},name,type;{config_legend},getTeaser;{template_legend:hide},tea_list_template,customTpl;{expert_legend:hide},guests,cssID';
// $GLOBALS['TL_DCA']['tl_module']['palettes']['teaserfilter']    = '{title_legend},name,type;{config_legend},getTeaser;{template_legend:hide},tea_filt_template,customTpl;{expert_legend:hide},guests,cssID';
$GLOBALS['TL_DCA']['tl_module']['palettes']['teaserlist']      = '{title_legend},name,type;{config_legend},getTeaser;{expert_legend:hide},guests,cssID';
$GLOBALS['TL_DCA']['tl_module']['palettes']['teaserfilter']    = '{title_legend},name,type;{config_legend},getTeaser;{expert_legend:hide},guests,cssID';

$GLOBALS['TL_DCA']['tl_module']['fields']['getTeaser'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['getTeaser'],
	'exclude'                 => true,
	'inputType'               => 'radio',
	'options_callback'        => array('tl_module_teaser', 'getTeaser'),
	'eval'                    => array('mandatory'=>true),
	'sql'                     => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['tea_list_template'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['tea_list_template'],
	'default'                 => 'tea_list_default',
	'exclude'                 => true,
	'inputType'               => 'select',
	'options_callback'        => array('tl_module_teaser', 'getTeaserListTemplates'),
	'eval'                    => array('tl_class'=>'w50'),
	'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['tea_filt_template'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['tea_filt_template'],
	'default'                 => 'tea_filt_default',
	'exclude'                 => true,
	'inputType'               => 'select',
	'options_callback'        => array('tl_module_teaser', 'getTeaserFilterTemplates'),
	'eval'                    => array('tl_class'=>'w50'),
	'sql'                     => "varchar(64) NOT NULL default ''"
);


class tl_module_teaser extends Backend
{


	/**
	 * Return all list templates as array
	 *
	 * @return array
	 */
	public function getTeaserListTemplates()
	{
		return $this->getTemplateGroup('tea_list_');
	}

	/**
	 * Return all list templates as array
	 *
	 * @return array
	 */
	public function getTeaserFilterTemplates()
	{
		return $this->getTemplateGroup('tea_filt_');
	}

	/**
	 * Get all news archives and return them as array
	 * @return array
	 */
	public function getTeaser()
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