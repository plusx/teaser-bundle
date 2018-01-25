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

class ModuleTeaserUpdates extends \Module
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

        $arrElements = array();
        $objCte = \TeaserItemsModel::findPublished(array('limit' => 3));

        if ($objCte !== null)
        {
            $intCount = 0;
            $intLast = $objCte->count() - 1;

            while ($objCte->next())
            {
                /** @var TeaserItemsModel $objRow */
                $objRow = $objCte->current();

                // Add the "first" and "last" classes (see #2583)
                if ($intCount == 0 || $intCount == $intLast)
                {
                    if ($intCount == 0)
                    {
                        $arrCss[] = 'first';
                    }
                    if ($intCount == $intLast)
                    {
                        $arrCss[] = 'last';
                    }
                }
                $objRow->classes = $arrCss;

                $objCategory = \TeaserCategoryModel::findByPK($objRow->pid);
                $pageModel = \PageModel::findByPK($objCategory->jumpTo);
                $url = \Controller::generateFrontendUrl($pageModel->row(),'/id/' . $objRow->id);

                $updates[$intCount]['id'] = $objRow->id;
                $updates[$intCount]['tstamp'] = $objRow->tstamp;
                $updates[$intCount]['subHeadline'] = $objRow->subHeadline;
                $updates[$intCount]['url'] = $url;

                $arrElements[] = $updates[$intCount];
                ++$intCount;
            }
        }

        $this->Template->updates = $arrElements;
    }
}
