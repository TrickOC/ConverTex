<?php
/**
 * @package    ConverTex
 * @subpackage Editors-xtd.EdiTex_Mathjax
 * @author     Patrick Oliveira do Carmo <patrick.carmo@aluno.ufop.edu.br>
 * @copyright  Copyright (C) - 2020 - Patrick Oliveira do Carmo
 * @license    GNU General Public License version 2 or later; see LICENSE.txt.txt
 * @link       https://triki.ufop.br/
 */

defined('_JEXEC') or die;

/**
 * Editor Editex_Mathjax button
 *
 * @since  1.0
 */
class PlgButtonEdiTexMathjax extends JPlugin
{
	/**
	 * Load the language file on instantiation.
	 *
	 * @var    boolean
	 * @since  3.1
	 */
	protected $autoloadLanguage = true;

	/**
	 * Editex_Mathjax button
	 *
	 * @param   string  $name  The name of the button to add
	 *
	 * @return  JObject  The button options as JObject
	 *
	 * @since   1.0
	 */
	public function onDisplay($name)
	{
		// Pass some data to javascript
		JFactory::getDocument()->addScriptOptions(
			'editex-mathjax',
			array(
				'editor' => $this->_subject->getContent($name),
			)
		);

		// Creation of a JObject of a button to insert in the chosen editor
		$button          = new JObject;
		$button->modal   = false;
		$button->class   = 'btn';
		$button->onclick = 'refreshMathJax(\'' . $name . '\');return false;';
		$button->text    = 'MathJax';
		$button->name    = 'refresh';
		$button->link    = '#';

		return $button;
	}
}