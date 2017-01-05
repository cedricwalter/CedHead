<?php
/**
 * @package     CedLikeUs
 * @subpackage  com_cedhead
 * http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL 3.0</license>
 * @copyright   Copyright (C) 2013-2016 galaxiis.com All rights reserved.
 * @license     The author and holder of the copyright of the software is Cédric Walter. The licensor and as such issuer of the license and bearer of the
 *              worldwide exclusive usage rights including the rights to reproduce, distribute and make the software available to the public
 *              in any form is Galaxiis.com
 *              see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.plugin.plugin');

class plgSystemCedHead extends JPlugin
{

	function plgSystemCedHead(& $subject, $config)
	{
		parent::__construct($subject, $config);
		$this->loadLanguage();
	}

	public function onBeforeRender()
	{
		//Do not run in admin area and non HTML  (rss, json, error)
		$app = JFactory::getApplication();
		if ($app->isAdmin() || JFactory::getDocument()->getType() !== 'html')
		{
			return true;
		}

		$document = JFactory::getDocument();

		$css = $this->params->get('css');
		$css = explode("\n", $css);
		foreach ($css as $entry)
		{
			$document->addStyleSheet($entry);
		}
		$cssDeclaration = $this->params->get('cssDeclaration');
		if (strlen($cssDeclaration) > 0)
		{
			$document->addStyleDeclaration($cssDeclaration);
		}

		$js = $this->params->get('js');
		$js = explode("\n", $js);
		foreach ($js as $entry)
		{
			$document->addScript($entry);
		}
		$jsDeclaration = $this->params->get('jsDeclaration');
		if (strlen($jsDeclaration) > 0)
		{
			$document->addScriptDeclaration($jsDeclaration);
		}


		$metaDataList = $this->params->get('metadata');
		if (strlen($metaDataList) > 0)
		{
			$metaDataList = explode("\n", $metaDataList);
			foreach ($metaDataList as $metaData)
			{
				if (strlen($metaData) > 1)
				{
					$keyValue = explode(",", $metaData);
					$document->setMetaData($keyValue[0], $keyValue[1]);
				}
			}
		}

		$gProfile = $this->params->get('gprofile', '');
		if (strlen($gProfile) > 0)
		{
			$document->addHeadLink($gProfile, "text/html", "type", [
				"rel" => "meta",
			]);
		}

		$rdf = $this->params->get('rdf', '');
		if (strlen($rdf) > 0)
		{
			$document->addHeadLink($rdf, 'application/rdf+xml', 'type', [
				"title" => "FOAF",
				"rel"   => "meta",
			]);
		}

		$gPlus = $this->params->get('gplus', '');
		if (strlen($gPlus) > 0)
		{
			$document->addHeadLink($gPlus, 'publisher', 'rel', array());
		}

		$canonical = $this->params->get('canonical', '');
		if (strlen($canonical) > 0)
		{
			$document->addHeadLink($canonical, 'canonical', 'rel', array());
		}

		return;
	}

}
