<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2015 Leo Feyer
 *
 * @package TeaserBundle
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'Dehil',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Modules
	'Dehil\TeaserBundle\ModuleTeaser' => 'vendor/dehil/teaser-bundle/src/Resources/contao/modules/ModuleTeaser.php',
	'Dehil\TeaserBundle\ModuleTeaserFilter' => 'vendor/dehil/teaser-bundle/src/Resources/contao/modules/ModuleTeaserFilter.php',

	// Models
	'Dehil\TeaserBundle\TeaserModel'                           => 'vendor/dehil/teaser-bundle/src/Resources/contao/models/TeaserModel.php',
	'Dehil\TeaserBundle\TeaserFilterModel'                     => 'vendor/dehil/teaser-bundle/src/Resources/contao/models/TeaserFilterModel.php'
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'mod_teaser_default' => 'vendor/dehil/teaser-bundle/src/Resources/contao/templates/modules/',
	'mod_teaser_defaultfilter' => 'vendor/dehil/teaser-bundle/src/Resources/contao/templates/modules/'
));
