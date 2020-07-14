<?php
/**
 * @package    ConverTex
 * @subpackage com_convertex
 *
 * @author     Patrick Oliveira do Carmo <patrick.carmo@aluno.ufop.edu.br>
 * @copyright  Copyright (C) - 2020 - Patrick Oliveira do Carmo
 * @license    GNU General Public License version 2 or later; see LICENSE.txt.txt
 * @link       https://triki.ufop.br/
 */

defined('_JEXEC') or die;

class ConverTexController extends JControllerLegacy
{
	/**
	 * Method to display a view.
	 *
	 * @param   boolean  $cachable   If true, the view output will be cached
	 * @param   array    $urlparams  An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return    JController        This object to support chaining.
	 * @since    1.5
	 */
	public function display($cachable = false, $urlparams = false)
	{
		// Get the helper of the component
		require_once JPATH_COMPONENT . '/helpers/convertex.php';

		// Get the "view" of the component and set
		$view = JFactory::getApplication()->input->getCmd('view', '');
		JFactory::getApplication()->input->set('view', $view);

		// Display the page
		parent::display($cachable, $urlparams);

		return $this;
	}
}