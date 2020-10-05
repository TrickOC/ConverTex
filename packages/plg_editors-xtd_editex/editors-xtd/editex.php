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

/**
 * Editor Editex button
 *
 * @since  1.0
 */
class PlgButtonEdiTex extends JPlugin
{
	/**
	 * Load the language file on instantiation.
	 *
	 * @var    boolean
	 * @since  3.1
	 */
	protected $autoloadLanguage = true;

	/**
	 * Editex button
	 *
	 * @param   string  $name  The name of the button to add
	 *
	 * @return  JObject  The button options as JObject
	 *
	 * @since   1.0
	 */
	public function onDisplay($name)
	{
		// Address for editor page in Joomla
		$link = 'index.php?option=com_convertex&view=convertex&layout=editor&tmpl=convertex&editor=' . $name;

		// Creation of a JObject of a button to insert in the chosen editor
		$button = new JObject;
		$button->set('modal', true);
		$button->set('class', 'btn');
		$button->set('link', $link);
		$button->set('text', 'ConverTex');
		$button->set('name', 'edit');
		$button->set('options', '{handler: \'iframe\', size: {x: 950, y: 500}}');

		return $button;
	}
}