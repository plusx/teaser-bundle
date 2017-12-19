<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2017 Dennis Hilpmann
 *
 * @license LGPL-3.0+
 */
/**
 * Back end modules
 */
array_insert($GLOBALS['BE_MOD']['content'], 99, array
(
	'teaser' => array
	(
		'tables'      => array('tl_teaser_category', 'tl_teaser_items')
	)
));
/**
 * Front end modules
 */
array_insert($GLOBALS['FE_MOD'], 99, array
(
	'teaser' => array
	(
		'teaserlist'		=> 'Dehil\Teaser\ModuleTeaserList',
		'teaserfilter'		=> 'Dehil\Teaser\ModuleTeaserFilter',
		'teaserupdates'		=> 'Dehil\Teaser\ModuleTeaserUpdates'
	)
));
/**
 * Style sheet
 */
if (TL_MODE == 'BE')
{
	$GLOBALS['TL_CSS'][] = 'bundles/dehilteaser/backend.css|static';
}
/**
* Style sheet Frontend
*/
// if (TL_MODE == 'FE')
// {
// 	$GLOBALS['TL_CSS'][] = 'bundles/dehilteaser/frontend.css|static';
// }
/**
 * Add permissions
 */
// $GLOBALS['TL_PERMISSIONS'][] = 'teasers';
// $GLOBALS['TL_PERMISSIONS'][] = 'teaserp';