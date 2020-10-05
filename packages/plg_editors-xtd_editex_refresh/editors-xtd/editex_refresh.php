<?php
/**
 * @package    ConverTex
 * @subpackage Editors-xtd.EdiTex
 * @author     Patrick Oliveira do Carmo <patrick.carmo@aluno.ufop.edu.br>
 * @copyright  Copyright (C) - 2020 - Patrick Oliveira do Carmo
 * @license    GNU General Public License version 2 or later; see LICENSE.txt.txt
 * @link       https://triki.ufop.br/
 */

defined('_JEXEC') or die;

class PlgButtonEdiTexRefresh extends JPlugin
{
	protected $autoloadLanguage = true;

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

	public function onDisplay($name)
	{
		// Creation of a JObject of a button to insert in the chosen editor
		$button          = new JObject;
		$button->modal   = false;
		$button->class   = 'btn';
		$button->onclick = 'refreshMathJax(' . $this->_subject->getContent($name) . ');return false;';
		$button->link    = '#';
		$button->text    = 'Refresh';
		$button->name    = 'reload';

		return $button;
	}
}