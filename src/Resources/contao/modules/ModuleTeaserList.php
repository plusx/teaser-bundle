<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2017 Leo Feyer
 *
 * @license LGPL-3.0+
 */
namespace Dehil\Teaser;
use Psr\Log\LogLevel;
use Contao\CoreBundle\Monolog\ContaoContext;
use Patchwork\Utf8;

class ModuleTeaserList extends \ContentElement
{
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'mod_teaserlist';
    /**
     * Do not show the module if no category
     *
     * @return string
     */
    public function generate()
    {


        $file = \Input::get('file', true);

        // Send the file to the browser and do not send a 404 header (see #4632)
        if ($file != '')
        {
            \Controller::sendFileToBrowser($file);
        }

        return parent::generate();

    }


    /**
     * Generate the module
     */
    protected function compile()
    {

        $arrElements = array();
        $objCte = \ContentModel::findPublishedByPidAndTable($this->id, 'tl_teaser_items');

        if ($objCte !== null)
        {
            $intCount = 0;
            $intLast = $objCte->count() - 1;

            while ($objCte->next())
            {
                /** @var ContentModel $objRow */
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


                if($objRow->teaserType == 'download' || $objRow->teaserType == 'video')
                {
                    $objFile = new \File(\FilesModel::findByUuid($objRow->fileSRC)->path);

                    // Remove an existing file parameter (see #5683)
                    $strHref = \Environment::get('request');
                    if (preg_match('/(&(amp;)?|\?)file=/', $strHref))
                    {
                        $strHref = preg_replace('/(&(amp;)?|\?)file=[^&]+/', '', $strHref);
                    }
                    $strHref .= (strpos($strHref, '?') !== false ? '&amp;' : '?') . 'file=' . $objFile->path;
                    $filesize = $this->getReadableSize($objFile->filesize, 1);
                    $teaserarray[$intCount]['title']        = 'Download (' . $filesize . ')';
                    $teaserarray[$intCount]['href']         = $strHref;
                    $teaserarray[$intCount]['filesize']     = $filesize;
                    $teaserarray[$intCount]['icon']         = \Image::getPath($objFile->icon);
                    $teaserarray[$intCount]['mime']         = $objFile->mime;
                    $teaserarray[$intCount]['extension']    = $objFile->extension;
                    $teaserarray[$intCount]['path']         = $objFile->dirname;
                }
                if($objRow->teaserType == 'video') {
                    $teaserarray[$intCount]['youtube']      = $objRow->youtube;
                }
                if($objRow->teaserType == 'link') {
                    $pageModel = \PageModel::findByPK($objRow->jumpTo);
                    $url = \Controller::generateFrontendUrl($pageModel->row());
                    $teaserarray[$intCount]['link']         = $url;
                    $teaserarray[$intCount]['linkText']     = $objRow->linkText;
                }
                $teaserarray[$intCount]['teaserType']       = $objRow->teaserType;
                $teaserarray[$intCount]['headline']         = $objRow->headline;
                $teaserarray[$intCount]['teaserImage']      = \FilesModel::findByUuid($objRow->singleSRC)->path;
                if($objRow->subHeadline) {
                    $teaserarray[$intCount]['subHeadline']  = $objRow->subHeadline;
                }
                $teaserarray[$intCount]['teaserText']       = nl2br($objRow->teaserItemText);

                if(\StringUtil::deserialize($objRow->availableFilter)) {
                    $filterarray = \StringUtil::deserialize($objRow->availableFilter);
                    $filtercss = '';
                    foreach ($filterarray as $filter) {
                        $filtercss .= preg_replace('/\W+/','',strtolower(strip_tags($filter))) . ' ';
                    }
                }
                $teaserarray[$intCount]['filter']   = $filtercss;
                $teaserarray[$intCount]['id']       = $objRow->id;

                $arrElements[] = $teaserarray[$intCount];
                ++$intCount;
            }
        }

        /*//get teaser
        $teaser = $this->Database->prepare("SELECT * FROM tl_teaser_items WHERE pid=? ORDER BY sorting ASC")->execute($this->teaserCategory);


        // create array with all published teaser
        $i = 0;
        while($teaser->next())
        {
            $current = $teaser->row();
            if($current['published'] == 1)
            {
                $start = ($current['start'] ?: time());
                $stop = ($current['stop'] ?: time());
                if ($start <= ($now = time()) && $now <= $stop)
                {
                    if($current['teaserType'] == 'download' || $current['teaserType'] == 'video')
                    {
                        $objFile = new \File(\FilesModel::findByUuid($current['fileSRC'])->path);

                        // Remove an existing file parameter (see #5683)
                        $strHref = \Environment::get('request');
                        if (preg_match('/(&(amp;)?|\?)file=/', $strHref))
                        {
                            $strHref = preg_replace('/(&(amp;)?|\?)file=[^&]+/', '', $strHref);
                        }
                        $strHref .= (strpos($strHref, '?') !== false ? '&amp;' : '?') . 'file=' . $objFile->path;
                        $filesize = $this->getReadableSize($objFile->filesize, 1);
                        $teaserarray[$i]['title']               = 'Download (' . $filesize . ')';
                        $teaserarray[$i]['href']                = $strHref;
                        $teaserarray[$i]['filesize']            = $filesize;
                        $teaserarray[$i]['icon']                = \Image::getPath($objFile->icon);
                        $teaserarray[$i]['mime']                = $objFile->mime;
                        $teaserarray[$i]['extension']           = $objFile->extension;
                        $teaserarray[$i]['path']                = $objFile->dirname;
                    }
                    if($current['teaserType'] == 'video') {
                        $teaserarray[$i]['youtube']             = $current['youtube'];
                    }
                    if($current['teaserType'] == 'link') {
                        $pageModel = \PageModel::findByPK($current['jumpTo']);
                        $url = \Controller::generateFrontendUrl($pageModel->row());
                        $teaserarray[$i]['link']                = $url;
                        $teaserarray[$i]['linkText']            = $current['linkText'];
                    }
                    $teaserarray[$i]['teaserType']              = $current['teaserType'];
                    $teaserarray[$i]['headline']                = $current['headline'];
                    $teaserarray[$i]['teaserImage']             = \FilesModel::findByUuid($current['singleSRC'])->path;
                    if($current['subHeadline']) {
                        $teaserarray[$i]['subHeadline']         = $current['subHeadline'];
                    }
                    $teaserarray[$i]['teaserText']              = nl2br($current['teaserItemText']);

                    if(\StringUtil::deserialize($current['availableFilter'])) {
                        $filterarray = \StringUtil::deserialize($current['availableFilter']);
                        $filtercss = '';
                        foreach ($filterarray as $filter) {
                            $filtercss .= preg_replace('/\W+/','',strtolower(strip_tags($filter))) . ' ';
                        }
                    }
                    $teaserarray[$i]['filter']              = $filtercss;
                    $teaserarray[$i]['id']                  = $current['id'];
                    $i++;
                }
            }
        }
        $this->Template->teaserarray = $arrElements;*/
    }
}
