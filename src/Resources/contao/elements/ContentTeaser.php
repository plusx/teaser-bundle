<?php

namespace Dehil;

class ContentTeaser extends \ContentElement
{
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'ce_teaser';

    /**
     * Files model
     * @var FilesModel
     */
    protected $objFilesModel;

    /**
     * Return if the file does not exist
     *
     * @return string
     */
    public function generate()
    {
        // // Return if there is no file
        // if ($this->singleSRC == '')
        // {
        //     return '';
        // }

        // $objFile = \FilesModel::findByUuid($this->singleSRC);

        // if ($objFile === null)
        // {
        //     return '';
        // }

        // $allowedDownload = \StringUtil::trimsplit(',', strtolower(\Config::get('allowedDownload')));

        // // Return if the file type is not allowed
        // if (!in_array($objFile->extension, $allowedDownload))
        // {
        //     return '';
        // }

        // $file = \Input::get('file', true);

        // // Send the file to the browser and do not send a 404 header (see #4632)
        // if ($file != '' && $file == $objFile->path)
        // {
        //     \Controller::sendFileToBrowser($file);
        // }

        // $this->singleSRC = $objFile->path;

        // // Teaserimage
        // $objTeaser = \FilesModel::findByUuid($this->teaserimageSRC);

        // if ($objTeaser === null || !is_file(TL_ROOT . '/' . $objTeaser->path))
        // {
        //     return '';
        // }

        // $this->teaserimageSRC = $objTeaser->path;
        // $this->objTeaserModel = $objTeaser;

        // return parent::generate();
    }


    /**
     * Generate the content element
     */
    protected function compile()
    {
        // $objFile = new \File($this->singleSRC);

        // if ($this->linkTitle == '')
        // {
        //     $this->linkTitle = \StringUtil::specialchars($objFile->basename);
        // }

        // $strHref = \Environment::get('request');

        // // Remove an existing file parameter (see #5683)
        // if (preg_match('/(&(amp;)?|\?)file=/', $strHref))
        // {
        //     $strHref = preg_replace('/(&(amp;)?|\?)file=[^&]+/', '', $strHref);
        // }

        // $strHref .= (strpos($strHref, '?') !== false ? '&amp;' : '?') . 'file=' . \System::urlEncode($objFile->value);


        // $this->Template->link = $this->linkTitle;
        // $this->Template->title = \StringUtil::specialchars($this->titleText ?: sprintf($GLOBALS['TL_LANG']['MSC']['download'], $objFile->basename));
        // $this->Template->href = $strHref;
        // $this->Template->filesize = $this->getReadableSize($objFile->filesize, 1);
        // $this->Template->icon = \Image::getPath($objFile->icon);
        // $this->Template->mime = $objFile->mime;
        // $this->Template->extension = $objFile->extension;
        // $this->Template->path = $objFile->dirname;

        // // Extendet Fields
        // $this->addImageToTemplate($this->Template, $this->arrData, null, null, $this->objTeaserModel);
        // $this->Template->tags = $this->tags;

    }
}