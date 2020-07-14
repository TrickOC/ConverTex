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
	static function converTex($tex)
	{
		$app       = JFactory::getApplication();
		$plgParams = new JRegistry($app);
		$mimetex   = $plgParams->get('mimetex');
		$opt       = $plgParams->get('optrender');

		// Format the data for display
		$content_urlencoded = rawurlencode(html_entity_decode($tex[1]));
		$html               = '';
		// Check the chosen option and if mimetex url is set
		if ($opt == 'mathjax' || !isset($mimetex))
			$html .= "<span class=\"latex\">\[$tex[1]\]</span>";
		else
			$html .= "<img src=\"$mimetex?formdata=$content_urlencoded\" alt=\"{$tex[1]}\" title=\"{$tex[1]}\"/>";

		return $html;
	}

	public function onContentPrepare($context, &$article, &$params, $page = 0)
	{
		// Find the Tex tag and prepare content in conveTex function
		$article->text = preg_replace_callback("/\{tex\}((?:.|\n)*)\{\/tex\}/U", array('plgContentConverTex', 'converTex'), $article->text);

		// Verify the option selected for otimize the load of document
		if ($this->get('optrender') == 'mathjax' || $this->get('mimetex') == '')
		{
			// URL for the Mathjax API
			$mathjax = $this->params->get('mathjax', 'https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-svg-full.js');
			// Add the script config for Mathjax
			JHtml::_('script', 'plugins/content/convertex/js/mathjax-options.js', array('id' => 'Mathjax-options'), array('refer' => 'refer'));
			JHtml::_('script', $mathjax, array('id' => 'MathJax-script'), array('refer' => 'refer'));
			JHtml::_('stylesheet', 'plugins/content/convertex/css/tex.css');
		}

		return true;
	}

}
