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

	static function convertSave($tag)
	{
		if (stripos($tag[1], 'teximg') !== false)
		{
			return "[tex]$tag[2][/tex]";
		}

		return $tag;
	}

	protected function updateArticle(&$article)
	{
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		$conditions = array(
			'id=' . $article->id,
		);

		// Fields to update.
		$fields = array(
			'introtext=' . $db->quote($article->introtext)
		);

		// update query
		$query->update($db->quoteName('#__content'))->set($fields)->where($conditions);

		// set the query
		$db->setQuery($query);

		// execute, throw an exception if we have a problem
		if (!$db->execute())
		{
			return false;
		}

		return true;
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

	public function onContentAfterSave($context, $article, $isnew)
	{
		if (stripos($article->introtext, 'teximg') === false) return;

		// For avoid getting any content being saved
		if ($context === 'com_content.article')
		{
			// Replace all images back to latex language
			$article->introtext = preg_replace_callback(
				'/<img class="((?:.|\n)*)" title="((?:.|\n)*)"((?:.|\n)*)>/U',
				array('plgContentConverTex', 'convertSave'),
				$article->introtext
			);
			// Update the article
			$this->updateArticle($article);
		}
	}
}