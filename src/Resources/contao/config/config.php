<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2017 Dennis Hilpmann
 *
 * @license LGPL-3.0+
 */

class_alias('Dehil\Teaser\TeaserItemsModel', 'TeaserItemsModel');
class_alias('Dehil\Teaser\TeaserCategoryModel', 'TeaserCategoryModel');

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
        'teaserlist'        => 'Dehil\Teaser\ModuleTeaserList',
        'teaserfilter'      => 'Dehil\Teaser\ModuleTeaserFilter',
        'teaserupdates'     => 'Dehil\Teaser\ModuleTeaserUpdates'
    )
));
/**
 * Backend stylesheet
 */
if (TL_MODE == 'FE')
{
    $GLOBALS['TL_JAVASCRIPT'][] = 'bundles/dehilteaser/js/filter.js|static';
}
/**
 * Backend stylesheet
 */
if (TL_MODE == 'BE')
{
    $GLOBALS['TL_CSS'][] = 'bundles/dehilteaser/css/backend.css|static';
}
/**
 * Add permissions
 */
$GLOBALS['TL_PERMISSIONS'][] = 'teasers';
$GLOBALS['TL_PERMISSIONS'][] = 'teaserp';