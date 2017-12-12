<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2017 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Back end modules
 */
array_insert($GLOBALS['BE_MOD']['content'], 1, array
(
	'teaser' => array
	(
		'tables'      => array('tl_teaser', 'tl_teaser_items')
		// 'table'       => array('TableWizard', 'importTable'),
		// 'list'        => array('ListWizard', 'importList')
	)
));


/**
 * Front end modules
 */
array_insert($GLOBALS['FE_MOD'], 2, array
(
	'teaser' => array
	(
		'teaserlist'		=> 'ModuleTeaserList',
		'teaserfilter'		=> 'ModuleTeaserFilter'
	)
));


/**
 * Style sheet
 */
// if (TL_MODE == 'BE')
// {
// 	$GLOBALS['TL_CSS'][] = 'bundles/contaocalendar/style.css|static';
// }


/**
 * Add permissions
 */
$GLOBALS['TL_PERMISSIONS'][] = 'teasers';
$GLOBALS['TL_PERMISSIONS'][] = 'teaserp';