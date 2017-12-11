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
		'tables'      => array('tl_teaser', 'tl_teaser_items'),
		'table'       => array('TableWizard', 'importTable'),
		'list'        => array('ListWizard', 'importList')
	)
));


/**
 * Front end modules
 */
array_insert($GLOBALS['FE_MOD'], 2, array
(
	'teaseritems' => array
	(
		'teaser'			=> 'ModuleTeaser',
		'teaserfilter'		=> 'ModuleTeaserFilter',
		// 'teaserpagination'	=> 'ModuleTeaserPagination',
	)
));


/**
 * Cron jobs
 */
// $GLOBALS['TL_CRON']['daily']['generateCalendarFeeds'] = array('Calendar', 'generateFeeds');


/**
 * Style sheet
 */
// if (TL_MODE == 'BE')
// {
// 	$GLOBALS['TL_CSS'][] = 'bundles/contaocalendar/style.css|static';
// }


/**
 * Register hooks
 */
// $GLOBALS['TL_HOOKS']['removeOldFeeds'][] = array('Calendar', 'purgeOldFeeds');
// $GLOBALS['TL_HOOKS']['getSearchablePages'][] = array('Calendar', 'getSearchablePages');
// $GLOBALS['TL_HOOKS']['generatePage'][] = array('contao_calendar.listener.generate_page', 'onGeneratePage');
// $GLOBALS['TL_HOOKS']['generateXmlFiles'][] = array('Calendar', 'generateFeeds');
// $GLOBALS['TL_HOOKS']['replaceInsertTags'][] = array('contao_calendar.listener.insert_tags', 'onReplaceInsertTags');


/**
 * Add permissions
 */
$GLOBALS['TL_PERMISSIONS'][] = 'teasers';
$GLOBALS['TL_PERMISSIONS'][] = 'teaserp';
// $GLOBALS['TL_PERMISSIONS'][] = 'calendarfeeds';
// $GLOBALS['TL_PERMISSIONS'][] = 'calendarfeedp';