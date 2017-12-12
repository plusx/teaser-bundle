<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2017 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Table tl_calendar
 */
$GLOBALS['TL_DCA']['tl_teaser'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'					=> 'Table',
		'ctable'						=> array('tl_teaser_items'),
		'switchToEdit'					=> true,
		'enableVersioning'				=> true,
		'onload_callback'				=> array
		(
			array('tl_teaser', 'checkPermission')
		),
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary'
			)
		)
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'						=> 1,
			'fields'					=> array('title'),
			'flag'						=> 1,
			'panelLayout'				=> 'filter;search,limit'
		),
		'label' => array
		(
			'fields'					=> array('title'),
			'format'					=> '%s'
		),
		'global_operations' => array
		(
			'all' => array
			(
				'label'					=> &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'					=> 'act=select',
				'class'					=> 'header_edit_all',
				'attributes'			=> 'onclick="Backend.getScrollOffset()" accesskey="e"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'					=> &$GLOBALS['TL_LANG']['tl_teaser']['edit'],
				'href'					=> 'table=tl_teaser_items',
				'icon'					=> 'edit.svg'
			),
			'editheader' => array
			(
				'label'					=> &$GLOBALS['TL_LANG']['tl_teaser']['editheader'],
				'href'					=> 'act=edit',
				'icon'					=> 'header.svg',
				'button_callback'		=> array('tl_teaser', 'editHeader')
			),
			'copy' => array
			(
				'label'					=> &$GLOBALS['TL_LANG']['tl_teaser']['copy'],
				'href'					=> 'act=copy',
				'icon'					=> 'copy.svg',
				'button_callback'		=> array('tl_teaser', 'copyTeaser')
			),
			'delete' => array
			(
				'label'					=> &$GLOBALS['TL_LANG']['tl_teaser']['delete'],
				'href'					=> 'act=delete',
				'icon'					=> 'delete.svg',
				'attributes'			=> 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"',
				'button_callback'		=> array('tl_teaser', 'deleteTeaser')
			),
			'show' => array
			(
				'label'					=> &$GLOBALS['TL_LANG']['tl_teaser']['show'],
				'href'					=> 'act=show',
				'icon'					=> 'show.svg'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'					=> array('protected', 'addFilter'),
		'default'						=> '{title_legend},title;{filter_legend:hide},addFilter;{protected_legend:hide},protected'
	),

	// Subpalettes
	'subpalettes' => array
	(
		'protected'						=> 'groups',
		'addFilter'					=> 'filterelements',
	),

	// Fields
	'fields' => array
	(
		'id' => array
		(
			'sql'						=> "int(10) unsigned NOT NULL auto_increment"
		),
		'tstamp' => array
		(
			'sql'						=> "int(10) unsigned NOT NULL default '0'"
		),
		'title' => array
		(
			'label'						=> &$GLOBALS['TL_LANG']['tl_teaser']['title'],
			'exclude'					=> true,
			'search'					=> true,
			'inputType'					=> 'text',
			'eval'						=> array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
			'sql'						=> "varchar(255) NOT NULL default ''"
		),
		'protected' => array
		(
			'label'						=> &$GLOBALS['TL_LANG']['tl_teaser']['protected'],
			'exclude'					=> true,
			'filter'					=> true,
			'inputType'					=> 'checkbox',
			'eval'						=> array('submitOnChange'=>true),
			'sql'						=> "char(1) NOT NULL default ''"
		),
		'groups' => array
		(
			'label'						=> &$GLOBALS['TL_LANG']['tl_teaser']['groups'],
			'exclude'					=> true,
			'inputType'					=> 'checkbox',
			'foreignKey'				=> 'tl_member_group.name',
			'eval'						=> array('mandatory'=>true, 'multiple'=>true),
			'sql'						=> "blob NULL",
			'relation'					=> array('type'=>'hasMany', 'load'=>'lazy')
		),
		'addFilter' => array
		(
			'label'						=> &$GLOBALS['TL_LANG']['tl_teaser']['addFilter'],
			'exclude'					=> true,
			'filter'					=> true,
			'inputType'					=> 'checkbox',
			'eval'						=> array('submitOnChange'=>true),
			'sql'						=> "char(1) NOT NULL default ''"
		),
		'filterelements' => array
		(
			'label'						=> &$GLOBALS['TL_LANG']['tl_teaser']['filterelements'],
			'exclude'					=> true,
			'inputType'					=> 'listWizard',
			'eval'						=> array('mandatory'=>true, 'allowHtml'=>false, 'helpwizard'=>false),
			'sql'						=> "blob NULL"
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
class tl_teaser extends Backend
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
	 * Check permissions to edit table tl_calendar
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
		if (!is_array($this->User->teaser) || empty($this->User->teaser))
		{
			$root = array(0);
		}
		else
		{
			$root = $this->User->teaser;
		}

		$GLOBALS['TL_DCA']['tl_teaser']['list']['sorting']['root'] = $root;

		// Check permissions to add calendars
		if (!$this->User->hasAccess('create', 'teaserp'))
		{
			$GLOBALS['TL_DCA']['tl_teaser']['config']['closed'] = true;
		}

		/** @var Symfony\Component\HttpFoundation\Session\SessionInterface $objSession */
		$objSession = System::getContainer()->get('session');

		// Check current action
		switch (Input::get('act'))
		{
			case 'create':
			case 'select':
				// Allow
				break;

			case 'edit':
				// Dynamically add the record to the user profile
				if (!in_array(Input::get('id'), $root))
				{
					/** @var Symfony\Component\HttpFoundation\Session\Attribute\AttributeBagInterface $objSessionBag */
					$objSessionBag = $objSession->getBag('contao_backend');

					$arrNew = $objSessionBag->get('new_records');

					if (is_array($arrNew['tl_teaser']) && in_array(Input::get('id'), $arrNew['tl_teaser']))
					{
						// Add the permissions on group level
						if ($this->User->inherit != 'custom')
						{
							$objGroup = $this->Database->execute("SELECT id, teasers, teaserp FROM tl_user_group WHERE id IN(" . implode(',', array_map('intval', $this->User->groups)) . ")");

							while ($objGroup->next())
							{
								$arrTeaserp = StringUtil::deserialize($objGroup->teaserp);

								if (is_array($arrTeaserp) && in_array('create', $arrTeaserp))
								{
									$arrTeasers = StringUtil::deserialize($objGroup->teasers, true);
									$arrTeasers[] = Input::get('id');

									$this->Database->prepare("UPDATE tl_user_group SET teasers=? WHERE id=?")
												   ->execute(serialize($arrTeasers), $objGroup->id);
								}
							}
						}

						// Add the permissions on user level
						if ($this->User->inherit != 'group')
						{
							$objUser = $this->Database->prepare("SELECT teasers, teaserp FROM tl_user WHERE id=?")
													   ->limit(1)
													   ->execute($this->User->id);

							$arrTeaserp = StringUtil::deserialize($objUser->teaserp);

							if (is_array($arrTeaserp) && in_array('create', $arrTeaserp))
							{
								$arrTeasers = StringUtil::deserialize($objUser->teasers, true);
								$arrTeasers[] = Input::get('id');

								$this->Database->prepare("UPDATE tl_user SET teasers=? WHERE id=?")
											   ->execute(serialize($arrTeasers), $this->User->id);
							}
						}

						// Add the new element to the user object
						$root[] = Input::get('id');
						$this->User->teasers = $root;
					}
				}
				// No break;

			case 'copy':
			case 'delete':
			case 'show':
				if (!in_array(Input::get('id'), $root) || (Input::get('act') == 'delete' && !$this->User->hasAccess('delete', 'teaserp')))
				{
					throw new Contao\CoreBundle\Exception\AccessDeniedException('Not enough permissions to ' . Input::get('act') . ' teaser ID ' . Input::get('id') . '.');
				}
				break;

			case 'editAll':
			case 'deleteAll':
			case 'overrideAll':
				$session = $objSession->all();
				if (Input::get('act') == 'deleteAll' && !$this->User->hasAccess('delete', 'teaserp'))
				{
					$session['CURRENT']['IDS'] = array();
				}
				else
				{
					$session['CURRENT']['IDS'] = array_intersect($session['CURRENT']['IDS'], $root);
				}
				$objSession->replace($session);
				break;

			default:
				if (strlen(Input::get('act')))
				{
					throw new Contao\CoreBundle\Exception\AccessDeniedException('Not enough permissions to ' . Input::get('act') . ' teasers.');
				}
				break;
		}
	}

	/**
	 * Return the edit header button
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
	public function editHeader($row, $href, $label, $title, $icon, $attributes)
	{
		return $this->User->canEditFieldsOf('tl_teaser') ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.StringUtil::specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.svg/i', '_.svg', $icon)).' ';
	}


	/**
	 * Return the copy teaser button
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
	public function copyTeaser($row, $href, $label, $title, $icon, $attributes)
	{
		return $this->User->hasAccess('create', 'teaserp') ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.StringUtil::specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.svg/i', '_.svg', $icon)).' ';
	}


	/**
	 * Return the delete teaser button
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
	public function deleteTeaser($row, $href, $label, $title, $icon, $attributes)
	{
		return $this->User->hasAccess('delete', 'teaserp') ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.StringUtil::specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.svg/i', '_.svg', $icon)).' ';
	}
}
