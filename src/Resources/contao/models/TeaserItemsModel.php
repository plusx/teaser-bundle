<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2017 Dennis Hilpmann
 *
 * @license LGPL-3.0+
 */
namespace Dehil\Teaser;

class TeaserItemsModel extends \Model
{
    /**
     * Table name
     * @var string
     */
    protected static $strTable = 'tl_teaser_items';

    /**
     * Find published teaser items by their parent ID
     *
     * @param integer $intPid     The category ID
     * @param array   $arrOptions An optional options array
     *
     * @return Model\Collection|TeaserItemsModel[]|TeaserItemsModel|null A collection of models or null if there are no teaser items
     */
    public static function findPublishedByPid($intPid, array $arrOptions=array())
    {
        $t = static::$strTable;
        $arrColumns = array("$t.pid=?");
        if (!static::isPreviewMode($arrOptions))
        {
            $time = \Date::floorToMinute();
            $arrColumns[] = "($t.start='' OR $t.start<='$time') AND ($t.stop='' OR $t.stop>'" . ($time + 60) . "') AND $t.published='1'";
        }
        if (!isset($arrOptions['order']))
        {
            $arrOptions['order'] = "$t.sorting";
        }
        return static::findBy($arrColumns, $intPid, $arrOptions);
    }

    /**
     * Find all published teaser items
     *
     * @return Collection|null
     */
    public static function findPublished(array $arrOptions=array())
    {
        $t = static::$strTable;
        $arrColumns = array("$t.published=?");

        if (!static::isPreviewMode($arrOptions))
        {
            $time = \Date::floorToMinute();
            $arrColumns[] = "($t.start='' OR $t.start<='$time') AND ($t.stop='' OR $t.stop>'" . ($time + 60) . "') AND $t.pid != 2";
        }

        if (!isset($arrOptions['order']))
        {
            $arrOptions['order'] = "$t.tstamp DESC";
        }

        if (BE_USER_LOGGED_IN) {
            return static::findAll($arrOptions);
        }

        return static::findBy($arrColumns, 1, $arrOptions);
    }
}
