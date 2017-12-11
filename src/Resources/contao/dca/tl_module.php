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
$GLOBALS['TL_DCA']['tl_module']['palettes']['teaser']          = '{title_legend},name,type;{config_legend},getTeaser;{template_legend:hide},teaser_template;{expert_legend:hide},guests,cssID';
$GLOBALS['TL_DCA']['tl_module']['palettes']['teaserfilter']    = '{title_legend},name,type;{config_legend},getTeaser;{template_legend:hide},teaserFilter_template;{expert_legend:hide},guests,cssID';


$GLOBALS['TL_DCA']['tl_module']['fields']['getTeaser'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['getTeaser'],
	'exclude'                 => true,
	'inputType'               => 'radio',
	'options_callback'        => array('tl_module_teaser', 'getTeaser'),
	'eval'                    => array('mandatory'=>true),
	'sql'                     => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['teaser_template'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['teaser_template'],
	'default'                 => 'news_latest',
	'exclude'                 => true,
	'inputType'               => 'select',
	'options_callback'        => array('tl_module_teaser', 'getTeaserTemplates'),
	'eval'                    => array('tl_class'=>'w50'),
	'sql'                     => "varchar(32) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['teaserFilter_template'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['teaserFilter_template'],
	'default'                 => 'news_latest',
	'exclude'                 => true,
	'inputType'               => 'select',
	'options_callback'        => array('tl_module_teaser', 'getTeaserFilterTemplates'),
	'eval'                    => array('tl_class'=>'w50'),
	'sql'                     => "varchar(32) NOT NULL default ''"
);


class tl_module_teaser extends Backend
{


	/**
	 * Return all list templates as array
	 *
	 * @return array
	 */
	public function getTeaserTemplates()
	{
		return $this->getTemplateGroup('mod_teaser_');
	}

	/**
	 * Return all list templates as array
	 *
	 * @return array
	 */
	public function getTeaserFilterTemplates()
	{
		return $this->getTemplateGroup('mod_teaserfilter_');
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