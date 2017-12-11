<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2017 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Load tl_content language file
 */
System::loadLanguageFile('tl_content');


/**
 * Table tl_calendar_events
 */
$GLOBALS['TL_DCA']['tl_teaser_items'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'ptable'                      => 'tl_teaser',
		'ctable'                      => array('tl_content'),
		'switchToEdit'                => true,
		'enableVersioning'            => true,
		'onload_callback' => array
		(
			array('tl_teaser_items', 'checkPermission')
		)
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary',
				'alias' => 'index',
				'pid,start,stop,published' => 'index'
			)
		)
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 4,
			'fields'                  => array('startTime DESC'),
			'headerFields'            => array('title', 'tstamp', 'protected'),
			'panelLayout'             => 'filter;sort,search,limit',
			'child_record_callback'   => array('tl_teaser_items', 'listTeaseritems')
		),
		'global_operations' => array
		(
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="e"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_teaser_items']['edit'],
				'href'                => 'table=tl_content',
				'icon'                => 'edit.svg'
			),
			'editheader' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_teaser_items']['editmeta'],
				'href'                => 'act=edit',
				'icon'                => 'header.svg'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_teaser_items']['copy'],
				'href'                => 'act=paste&amp;mode=copy',
				'icon'                => 'copy.svg'
			),
			'cut' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_teaser_items']['cut'],
				'href'                => 'act=paste&amp;mode=cut',
				'icon'                => 'cut.svg'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_teaser_items']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.svg',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			),
			'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_teaser_items']['toggle'],
				'icon'                => 'visible.svg',
				'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
				'button_callback'     => array('tl_calendar_events', 'toggleIcon')
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_teaser_items']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.svg'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'                => array('chooseTeaserType', 'applyFilter'),
		'default'                     => '{type_legend},chooseTeaserType;
										  {teaser_legend},headline,singleSRC,subHeadline,teaserItemText;
										  {filter_legend},applyFilter;
										  {publish_legend},published,start,stop'
	),

	// Subpalettes
	'subpalettes' => array
	(
		'chooseTeaserType_link'           => 'jumpTo,linkText',
		'chooseTeaserType_download'       => 'fileSRC',
		'chooseTeaserType_downloadvideo'  => 'fileSRC,youtube',
		'applyFilter'                     => 'availableFilter'
	),

	// Fields
	'fields' => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'pid' => array
		(
			'foreignKey'              => 'tl_teaser.title',
			'sql'                     => "int(10) unsigned NOT NULL default '0'",
			'relation'                => array('type'=>'belongsTo', 'load'=>'eager')
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'chooseTeaserType' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_teaser_items']['chooseTeaserType'],
			'default'                 => 'page',
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'radio',
			'options_callback'        => array('tl_teaser_items', 'getSourceOptions'),
			'reference'               => &$GLOBALS['TL_LANG']['tl_teaser_items']['reference']['chooseTeaserType'],
			'eval'                    => array('submitOnChange' => true, 'helpwizard' => true, 'mandatory' => true),
			'sql'                     => "varchar(12) NOT NULL default ''",
		),
		'jumpTo' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_teaser_items']['jumpTo'],
			'exclude'                 => true,
			'inputType'               => 'pageTree',
			'foreignKey'              => 'tl_page.title',
			'eval'                    => array('mandatory'=>true, 'fieldType'=>'radio'),
			'sql'                     => "int(10) unsigned NOT NULL default '0'",
			'relation'                => array('type'=>'belongsTo', 'load'=>'lazy')
		),
		'linkText' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_teaser_items']['linkText'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'fileSRC'                     => array(
			'label'                   => &$GLOBALS['TL_LANG']['tl_teaser_items']['fileSRC'],
			'exclude'                 => true,
			'inputType'               => 'fileTree',
			'eval'                    => array('filesOnly' => true, 'fieldType' => 'radio', 'mandatory' => true, 'tl_class' => 'clr'),
			'load_callback'           => array(
			    array('tl_teaser_items', 'setSingleSrcFlags'),
			),
			'sql'                     => "binary(16) NULL",
		),
		'youtube' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_teaser_items']['youtube'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'decodeEntities'=>true, 'tl_class'=>'w50'),
			'save_callback' => array
			(
				array('tl_teaser_items', 'extractYouTubeId')
			),
			'sql'                     => "varchar(16) NOT NULL default ''"
		),
		'headline' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_teaser_items']['headline'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'input',
			'eval'                    => array('maxlength'=>200, 'tl_class'=>'w50 clr'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'singleSRC' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_teaser_items']['singleSRC'],
			'exclude'                 => true,
			'inputType'               => 'fileTree',
			'eval'                    => array('filesOnly'=>true, 'fieldType'=>'radio', 'mandatory'=>true, 'tl_class'=>'clr'),
			'load_callback' => array
			(
				array('tl_teaser_items', 'setSingleSrcFlags')
			),
			'sql'                     => "binary(16) NULL"
		),
		'subHeadline' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_teaser_items']['subHeadline'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'input',
			'eval'                    => array('maxlength'=>200, 'tl_class'=>'w50 clr'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'teaserItemText' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_teaser_items']['teaserItemText'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('mandatory'=>true, 'allowHtml'=>false),
			'sql'                     => "mediumtext NULL"
		),
		'applyFilter' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_teaser_items']['addTime'],
			'exclude'                 => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('submitOnChange'=>true, 'doNotCopy'=>true),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'availableFilter' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_teaser_items']['availableFilter'],
			'exclude'                 => true,
			'inputType'               => 'checkbox',
			'options_callback'        => array('tl_teaser_items', 'getAvailableFilter'),
			'eval'                    => array('multiple'=>true),
			'sql'                     => "blob NULL",
		),
		'published' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_calendar_events']['published'],
			'exclude'                 => true,
			'filter'                  => true,
			'flag'                    => 2,
			'inputType'               => 'checkbox',
			'eval'                    => array('doNotCopy'=>true),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'start' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_calendar_events']['start'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'datim', 'datepicker'=>true, 'tl_class'=>'w50 wizard'),
			'sql'                     => "varchar(10) NOT NULL default ''"
		),
		'stop' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_calendar_events']['stop'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'datim', 'datepicker'=>true, 'tl_class'=>'w50 wizard'),
			'sql'                     => "varchar(10) NOT NULL default ''"
		)
	)
);


/**
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 * @property Contao\Calendar $Calendar
 *
 * @author Leo Feyer <https://github.com/leofeyer>
 */
class tl_teaser_items extends Backend
{

	/**
	 * Import the back end user object
	 */
	public function __construct()
	{
		parent::__construct();
		$this->import('BackendUser', 'User');
	}


	/**
	 * Check permissions to edit table tl_calendar_events
	 *
	 * @throws Contao\CoreBundle\Exception\AccessDeniedException
	 */
	public function checkPermission()
	{
		$bundles = System::getContainer()->getParameter('kernel.bundles');

		if ($this->User->isAdmin)
		{
			return;
		}

		// Set root IDs
		if (!is_array($this->User->teasers) || empty($this->User->teasers))
		{
			$root = array(0);
		}
		else
		{
			$root = $this->User->teasers;
		}

		$id = strlen(Input::get('id')) ? Input::get('id') : CURRENT_ID;

		// Check current action
		switch (Input::get('act'))
		{
			case 'paste':
				// Allow
				break;

			case 'create':
				if (!strlen(Input::get('pid')) || !in_array(Input::get('pid'), $root))
				{
					throw new Contao\CoreBundle\Exception\AccessDeniedException('Not enough permissions to create teaseritems in teaser ID ' . Input::get('pid') . '.');
				}
				break;

			case 'cut':
			case 'copy':
				if (!in_array(Input::get('pid'), $root))
				{
					throw new Contao\CoreBundle\Exception\AccessDeniedException('Not enough permissions to ' . Input::get('act') . ' teaseritem ID ' . $id . ' to teaser ID ' . Input::get('pid') . '.');
				}
				// NO BREAK STATEMENT HERE

			case 'edit':
			case 'show':
			case 'delete':
			case 'toggle':
				$objTeaser = $this->Database->prepare("SELECT pid FROM tl_teaser_items WHERE id=?")
											  ->limit(1)
											  ->execute($id);

				if ($objTeaser->numRows < 1)
				{
					throw new Contao\CoreBundle\Exception\AccessDeniedException('Invalid teaser ID ' . $id . '.');
				}

				if (!in_array($objTeaser->pid, $root))
				{
					throw new Contao\CoreBundle\Exception\AccessDeniedException('Not enough permissions to ' . Input::get('act') . ' teaseritem ID ' . $id . ' of teaser ID ' . $objTeaser->pid . '.');
				}
				break;

			case 'select':
			case 'editAll':
			case 'deleteAll':
			case 'overrideAll':
			case 'cutAll':
			case 'copyAll':
				if (!in_array($id, $root))
				{
					throw new Contao\CoreBundle\Exception\AccessDeniedException('Not enough permissions to access teaser ID ' . $id . '.');
				}

				$objTeaser = $this->Database->prepare("SELECT id FROM tl_teaser_items WHERE pid=?")
											  ->execute($id);

				if ($objTeaser->numRows < 1)
				{
					throw new Contao\CoreBundle\Exception\AccessDeniedException('Invalid teaser ID ' . $id . '.');
				}

				/** @var Symfony\Component\HttpFoundation\Session\SessionInterface $objSession */
				$objSession = System::getContainer()->get('session');

				$session = $objSession->all();
				$session['CURRENT']['IDS'] = array_intersect($session['CURRENT']['IDS'], $objTeaser->fetchEach('id'));
				$objSession->replace($session);
				break;

			default:
				if (strlen(Input::get('act')))
				{
					throw new Contao\CoreBundle\Exception\AccessDeniedException('Invalid command "' . Input::get('act') . '".');
				}
				elseif (!in_array($id, $root))
				{
					throw new Contao\CoreBundle\Exception\AccessDeniedException('Not enough permissions to access teaser ID ' . $id . '.');
				}
				break;
		}
	}

	/**
	 * Add the source options depending on the allowed fields (see #5498)
	 *
	 * @param DataContainer $dc
	 *
	 * @return array
	 */
	public function getSourceOptions(DataContainer $dc)
	{
		if ($this->User->isAdmin)
		{
			return array('link', 'download', 'downloadvideo');
		}
	}

	/**
	 * Return all filter elements as array
	 *
	 * @return array
	 */
	public function getAvailableFilter()
	{
		// $filter = $this->Database->prepare("SELECT rsce_data FROM tl_content WHERE type = 'rsce_filter' " )->execute($this->filterelemente);
		// if($filter->numRows)
		// {
		// 	$filters = $filter->fetchAllAssoc();
		// }
		// $data = json_decode($filters[0]['rsce_data']);
		// foreach ($data->filterelemente as $value) {
		// 	$filterarray[preg_replace('/\W+/','',strtolower(strip_tags($value->text)))] = $value->text;
		// }
		// return $filterarray;
	}

	/**
	 * Extract the YouTube ID from an URL
	 *
	 * @param mixed         $varValue
	 * @param DataContainer $dc
	 *
	 * @return mixed
	 */
	public function extractYouTubeId($varValue, DataContainer $dc)
	{
		if ($dc->activeRecord->singleSRC != $varValue)
		{
			$matches = array();

			if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $varValue, $matches))
			{
				$varValue = $matches[1];
			}
		}

		return $varValue;
	}

	/**
	 * Automatically set the end time if not set
	 *
	 * @param mixed         $varValue
	 * @param DataContainer $dc
	 *
	 * @return string
	 */
	public function setEmptyEndTime($varValue, DataContainer $dc)
	{
		if ($varValue === null)
		{
			$varValue = $dc->activeRecord->startTime;
		}

		return $varValue;
	}

	/**
	 * Dynamically add flags to the "singleSRC" field
	 *
	 * @param mixed         $varValue
	 * @param DataContainer $dc
	 *
	 * @return mixed
	 */
	public function setSingleSrcFlags($varValue, DataContainer $dc)
	{
		if ($dc->activeRecord)
		{
			switch ($dc->activeRecord->type)
			{
				case 'text':
				case 'hyperlink':
				case 'image':
				case 'accordionSingle':
					$GLOBALS['TL_DCA'][$dc->table]['fields'][$dc->field]['eval']['extensions'] = Config::get('validImageTypes');
					break;

				case 'download':
					$GLOBALS['TL_DCA'][$dc->table]['fields'][$dc->field]['eval']['extensions'] = Config::get('allowedDownload');
					break;
			}
		}

		return $varValue;
	}

	/**
	 * Add the type of input field
	 *
	 * @param array $arrRow
	 *
	 * @return string
	 */
	public function listTeaseritems($arrRow)
	{
		$span = Teaser::calculateSpan($arrRow['startTime'], $arrRow['endTime']);

		if ($span > 0)
		{
			$date = Date::parse(Config::get(($arrRow['addTime'] ? 'datimFormat' : 'dateFormat')), $arrRow['startTime']) . $GLOBALS['TL_LANG']['MSC']['cal_timeSeparator'] . Date::parse(Config::get(($arrRow['addTime'] ? 'datimFormat' : 'dateFormat')), $arrRow['endTime']);
		}
		elseif ($arrRow['startTime'] == $arrRow['endTime'])
		{
			$date = Date::parse(Config::get('dateFormat'), $arrRow['startTime']) . ($arrRow['addTime'] ? ' ' . Date::parse(Config::get('timeFormat'), $arrRow['startTime']) : '');
		}
		else
		{
			$date = Date::parse(Config::get('dateFormat'), $arrRow['startTime']) . ($arrRow['addTime'] ? ' ' . Date::parse(Config::get('timeFormat'), $arrRow['startTime']) . $GLOBALS['TL_LANG']['MSC']['cal_timeSeparator'] . Date::parse(Config::get('timeFormat'), $arrRow['endTime']) : '');
		}

		return '<div class="tl_content_left">' . $arrRow['title'] . ' <span style="color:#999;padding-left:3px">[' . $date . ']</span></div>';
	}

	/**
	 * Adjust start end end time of the event based on date, span, startTime and endTime
	 *
	 * @param DataContainer $dc
	 */
	public function adjustTime(DataContainer $dc)
	{
		// Return if there is no active record (override all)
		if (!$dc->activeRecord)
		{
			return;
		}

		$arrSet['startTime'] = $dc->activeRecord->startDate;
		$arrSet['endTime'] = $dc->activeRecord->startDate;

		// Set end date
		if (strlen($dc->activeRecord->endDate))
		{
			if ($dc->activeRecord->endDate > $dc->activeRecord->startDate)
			{
				$arrSet['endDate'] = $dc->activeRecord->endDate;
				$arrSet['endTime'] = $dc->activeRecord->endDate;
			}
			else
			{
				$arrSet['endDate'] = $dc->activeRecord->startDate;
				$arrSet['endTime'] = $dc->activeRecord->startDate;
			}
		}

		// Add time
		if ($dc->activeRecord->addTime)
		{
			$arrSet['startTime'] = strtotime(date('Y-m-d', $arrSet['startTime']) . ' ' . date('H:i:s', $dc->activeRecord->startTime));
			$arrSet['endTime'] = strtotime(date('Y-m-d', $arrSet['endTime']) . ' ' . date('H:i:s', $dc->activeRecord->endTime));
		}

		// Adjust end time of "all day" events
		elseif ((strlen($dc->activeRecord->endDate) && $arrSet['endDate'] == $arrSet['endTime']) || $arrSet['startTime'] == $arrSet['endTime'])
		{
			$arrSet['endTime'] = (strtotime('+ 1 day', $arrSet['endTime']) - 1);
		}

		$arrSet['repeatEnd'] = 0;

		// Recurring events
		if ($dc->activeRecord->recurring)
		{
			// Unlimited recurrences end on 2038-01-01 00:00:00 (see #4862)
			if ($dc->activeRecord->recurrences == 0)
			{
				$arrSet['repeatEnd'] = 2145913200;
			}
			else
			{
				$arrRange = StringUtil::deserialize($dc->activeRecord->repeatEach);

				if (is_array($arrRange) && isset($arrRange['unit']) && isset($arrRange['value']))
				{
					$arg = $arrRange['value'] * $dc->activeRecord->recurrences;
					$unit = $arrRange['unit'];

					$strtotime = '+ ' . $arg . ' ' . $unit;
					$arrSet['repeatEnd'] = strtotime($strtotime, $arrSet['endTime']);
				}
			}
		}

		$this->Database->prepare("UPDATE tl_teaser_items %s WHERE id=?")->set($arrSet)->execute($dc->id);
	}

	/**
	 * Return the "toggle visibility" button
	 *
	 * @param array  $row
	 * @param string $href
	 * @param string $label
	 * @param string $title
	 * @param string $icon
	 * @param string $attributes
	 *
	 * @return string
	 */
	public function toggleIcon($row, $href, $label, $title, $icon, $attributes)
	{
		if (strlen(Input::get('tid')))
		{
			$this->toggleVisibility(Input::get('tid'), (Input::get('state') == 1), (@func_get_arg(12) ?: null));
			$this->redirect($this->getReferer());
		}

		// Check permissions AFTER checking the tid, so hacking attempts are logged
		if (!$this->User->hasAccess('tl_teaser_items::published', 'alexf'))
		{
			return '';
		}

		$href .= '&amp;tid='.$row['id'].'&amp;state='.($row['published'] ? '' : 1);

		if (!$row['published'])
		{
			$icon = 'invisible.svg';
		}

		return '<a href="'.$this->addToUrl($href).'" title="'.StringUtil::specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label, 'data-state="' . ($row['published'] ? 1 : 0) . '"').'</a> ';
	}


	/**
	 * Disable/enable a user group
	 *
	 * @param integer        $intId
	 * @param boolean        $blnVisible
	 * @param DataContainer $dc
	 *
	 * @throws Contao\CoreBundle\Exception\AccessDeniedException
	 */
	public function toggleVisibility($intId, $blnVisible, DataContainer $dc=null)
	{
		// Set the ID and action
		Input::setGet('id', $intId);
		Input::setGet('act', 'toggle');

		if ($dc)
		{
			$dc->id = $intId; // see #8043
		}

		// Trigger the onload_callback
		if (is_array($GLOBALS['TL_DCA']['tl_teaser_items']['config']['onload_callback']))
		{
			foreach ($GLOBALS['TL_DCA']['tl_teaser_items']['config']['onload_callback'] as $callback)
			{
				if (is_array($callback))
				{
					$this->import($callback[0]);
					$this->{$callback[0]}->{$callback[1]}($dc);
				}
				elseif (is_callable($callback))
				{
					$callback($dc);
				}
			}
		}

		// Check the field access
		if (!$this->User->hasAccess('tl_teaser_items::published', 'alexf'))
		{
			throw new Contao\CoreBundle\Exception\AccessDeniedException('Not enough permissions to publish/unpublish teaseritem ID ' . $intId . '.');
		}

		// Set the current record
		if ($dc)
		{
			$objRow = $this->Database->prepare("SELECT * FROM tl_teaser_items WHERE id=?")
									 ->limit(1)
									 ->execute($intId);

			if ($objRow->numRows)
			{
				$dc->activeRecord = $objRow;
			}
		}

		$objVersions = new Versions('tl_teaser_items', $intId);
		$objVersions->initialize();

		// Trigger the save_callback
		if (is_array($GLOBALS['TL_DCA']['tl_teaser_items']['fields']['published']['save_callback']))
		{
			foreach ($GLOBALS['TL_DCA']['tl_teaser_items']['fields']['published']['save_callback'] as $callback)
			{
				if (is_array($callback))
				{
					$this->import($callback[0]);
					$blnVisible = $this->{$callback[0]}->{$callback[1]}($blnVisible, $dc);
				}
				elseif (is_callable($callback))
				{
					$blnVisible = $callback($blnVisible, $dc);
				}
			}
		}

		$time = time();

		// Update the database
		$this->Database->prepare("UPDATE tl_teaser_items SET tstamp=$time, published='" . ($blnVisible ? '1' : '') . "' WHERE id=?")
					   ->execute($intId);

		if ($dc)
		{
			$dc->activeRecord->tstamp = $time;
			$dc->activeRecord->published = ($blnVisible ? '1' : '');
		}

		// Trigger the onsubmit_callback
		if (is_array($GLOBALS['TL_DCA']['tl_teaser_items']['config']['onsubmit_callback']))
		{
			foreach ($GLOBALS['TL_DCA']['tl_teaser_items']['config']['onsubmit_callback'] as $callback)
			{
				if (is_array($callback))
				{
					$this->import($callback[0]);
					$this->{$callback[0]}->{$callback[1]}($dc);
				}
				elseif (is_callable($callback))
				{
					$callback($dc);
				}
			}
		}

		$objVersions->create();
	}
}
