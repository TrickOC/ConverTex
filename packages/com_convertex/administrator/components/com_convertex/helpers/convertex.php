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

// No direct access
defined('_JEXEC') or die;

/**
 * ConverTex helper.
 */
class ConverTexHelper
{
	/**
	 * Configure the Linkbar.
	 */
	public static function addSubmenu($vName = '')
	{
		// Nothing setting yet
	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @return    JObject
	 * @since    1.6
	 */
	public static function getActions()
	{
		// Get the user logged
		$user = JFactory::getUser();
		// Initialized result of the query
		$result = new JObject;

		// Set the name of the component
		$assetName = 'com_convertex';

		// Set the permissions for used
		$actions = array(
			'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
		);

		// Verify if the user get this permissions
		foreach ($actions as $action)
		{
			$result->set($action, $user->authorise($action, $assetName));
		}

		return $result;
	}
}
