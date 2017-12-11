<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2017 Leo Feyer
 *
 * @license LGPL-3.0+
 */

namespace Dehil;


/**
 * Provide methods regarding calendars.
 *
 * @author Leo Feyer <https://github.com/leofeyer>
 */
class Teaser extends \Frontend
{

	/**
	 * Current events
	 * @var array
	 */
	protected $arrTeaser = array();

	/**
	 * Add an event to the array of active events
	 *
	 * @param CalendarEventsModel $objTeaseritem
	 * @param integer             $intStart
	 * @param integer             $intEnd
	 * @param string              $strUrl
	 * @param string              $strBase
	 */
	protected function addTeaseritem($objTeaseritem, $intStart, $intEnd, $strUrl, $strBase='')
	{
		if ($intEnd < time()) // see #3917
		{
			return;
		}

		/** @var PageModel $objPage */
		global $objPage;

		// Called in the back end (see #4026)
		if ($objPage === null)
		{
			$objPage = new \stdClass();
			$objPage->dateFormat = \Config::get('dateFormat');
			$objPage->datimFormat = \Config::get('datimFormat');
			$objPage->timeFormat = \Config::get('timeFormat');
		}

		$intKey = date('Ymd', $intStart);
		$span = self::calculateSpan($intStart, $intEnd);
		$format = $objTeaseritem->addTime ? 'datimFormat' : 'dateFormat';

		// Add date
		if ($span > 0)
		{
			$title = \Date::parse($objPage->$format, $intStart) . $GLOBALS['TL_LANG']['MSC']['cal_timeSeparator'] . \Date::parse($objPage->$format, $intEnd);
		}
		else
		{
			$title = \Date::parse($objPage->dateFormat, $intStart) . ($objTeaseritem->addTime ? ' (' . \Date::parse($objPage->timeFormat, $intStart) . (($intStart < $intEnd) ? $GLOBALS['TL_LANG']['MSC']['cal_timeSeparator'] . \Date::parse($objPage->timeFormat, $intEnd) : '') . ')' : '');
		}

		// Add title and link
		$title .= ' ' . $objTeaseritem->title;

		// Backwards compatibility (see #8329)
		if ($strBase != '' && !preg_match('#^https?://#', $strUrl))
		{
			$strUrl = $strBase . $strUrl;
		}

		$link = '';

		switch ($objTeaseritem->source)
		{
			case 'external':
				$link = $objTeaseritem->url;
				break;

			case 'internal':
				if (($objTarget = $objTeaseritem->getRelated('jumpTo')) instanceof PageModel)
				{
					/** @var PageModel $objTarget */
					$link = $objTarget->getAbsoluteUrl();
				}
				break;

			case 'article':
				if (($objArticle = \ArticleModel::findByPk($objTeaseritem->articleId, array('eager'=>true))) !== null && ($objPid = $objArticle->getRelated('pid')) instanceof PageModel)
				{
					/** @var PageModel $objPid */
					$link = ampersand($objPid->getAbsoluteUrl('/articles/' . ($objArticle->alias ?: $objArticle->id)));
				}
				break;

			default:
				$link = sprintf($strUrl, ($objTeaseritem->alias ?: $objTeaseritem->id));
				break;
		}

		// Store the whole row (see #5085)
		$arrTeaseritem = $objTeaseritem->row();

		// Override link and title
		$arrTeaseritem['link'] = $link;
		$arrTeaseritem['title'] = $title;

		// Clean the RTE output
		$arrTeaseritem['teaser'] = \StringUtil::toHtml5($objTeaseritem->teaser);

		// Reset the enclosures (see #5685)
		$arrTeaseritem['enclosure'] = array();

		// Add the article image as enclosure
		if ($objTeaseritem->addImage)
		{
			$objFile = \FilesModel::findByUuid($objTeaseritem->singleSRC);

			if ($objFile !== null)
			{
				$arrTeaseritem['enclosure'][] = $objFile->path;
			}
		}

		// Enclosures
		if ($objTeaseritem->addEnclosure)
		{
			$arrEnclosure = \StringUtil::deserialize($objTeaseritem->enclosure, true);

			if (is_array($arrEnclosure))
			{
				$objFile = \FilesModel::findMultipleByUuids($arrEnclosure);

				if ($objFile !== null)
				{
					while ($objFile->next())
					{
						$arrTeaseritem['enclosure'][] = $objFile->path;
					}
				}
			}
		}

		$this->arrEvents[$intKey][$intStart][] = $arrTeaseritem;
	}


	/**
	 * Calculate the span between two timestamps in days
	 *
	 * @param integer $intStart
	 * @param integer $intEnd
	 *
	 * @return integer
	 */
	public static function calculateSpan($intStart, $intEnd)
	{
		return self::unixToJd($intEnd) - self::unixToJd($intStart);
	}


	/**
	 * Convert a UNIX timestamp to a Julian day
	 *
	 * @param integer $tstamp
	 *
	 * @return integer
	 */
	public static function unixToJd($tstamp)
	{
		list($year, $month, $day) = explode(',', date('Y,m,d', $tstamp));

		// Make year a positive number
		$year += ($year < 0 ? 4801 : 4800);

		// Adjust the start of the year
		if ($month > 2)
		{
			$month -= 3;
		}
		else
		{
			$month += 9;
			--$year;
		}

		$sdn  = floor((floor($year / 100) * 146097) / 4);
		$sdn += floor((($year % 100) * 1461) / 4);
		$sdn += floor(($month * 153 + 2) / 5);
		$sdn += $day - 32045;

		return $sdn;
	}

}
