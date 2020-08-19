<?php
/**
 * @package    ConverTex
 *
 * @author     Patrick Oliveira do Carmo <patrick.carmo@aluno.ufop.edu.br>
 * @copyright  Copyright (C) - 2020 - Patrick Oliveira do Carmo
 * @license    GNU General Public License version 2 or later; see LICENSE.txt.txt
 * @link       https://triki.ufop.br/
 */

use Joomla\CMS\Plugin\CMSPlugin;

defined('_JEXEC') or die;

class plgContentConverTex extends CMSPlugin
{
	protected $autoloadLanguage = true;
	protected $app = null;

	public function __construct(&$subject, $config = array())
	{
		// Get the parameters.
		if (isset($config['params']))
		{
			if ($config['params'] instanceof JRegistry)
			{
				$this->params = $config['params'];
			}
			else
			{
				$this->params = new JRegistry;
				$this->params->loadString($config['params']);
			}
		}

		// Get the plugin name.
		if (isset($config['name']))
		{
			$this->_name = $config['name'];
		}

		// Get the plugin type.
		if (isset($config['type']))
		{
			$this->_type = $config['type'];
		}

		// Load the language files if needed. Note whilst this method is in the
		// JPlugin class it has been left out of the docs for code clarity.
		if ($this->autoloadLanguage)
		{
			$this->loadLanguage();
		}

		parent::__construct($subject, $config);
	}

	// Function for prepare content for the chosen plugin
	static function mimetex($tex)
	{
		$app       = JFactory::getApplication();
		$plgParams = new JRegistry($app);
		$mimetex   = $plgParams->get('mimetex');

		// Format the data for display
		$content_urlencoded = rawurlencode(html_entity_decode($tex[1]));

		return "<img src=\"$mimetex?formdata=$content_urlencoded\" alt=\"{$tex[1]}\" title=\"{$tex[1]}\"/>";
	}

	public function onContentPrepare($context, &$article, $params, $page = 0)
	{
		// Verify the option selected for otimize the load of document
		if ($this->get('optrender') == 'mathjax' || $this->get('mimetex') == '')
		{
			// Add the script config for Mathjax
			JHtml::_('script', 'plugins/content/convertex/js/mathjax-options.js', array('id' => 'Mathjax-options'), array('refer' => 'refer'));
		}
		else
		{
			// Find the Tex tag and prepare content in conveTex function
			$article->text = preg_replace_callback("/\[tex]((?:.|\n)*)\[\/tex]/U", array('plgContentConverTex', 'mimetex'), $article->text);
		}

		return true;
	}

	public function onContentBeforeSave($context, &$article, $isnew)
	{
		return true;
	}
}
