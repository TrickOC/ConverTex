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

// Access check.
if (!JFactory::getUser()->authorise('core.edit.own', 'com_convertex'))
{
	throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
}

// Include dependancies
jimport('joomla.application.component.controller');

$controller = JControllerLegacy::getInstance('ConverTex');
$input      = JFactory::getApplication()->input;
$controller->execute($input->getCmd('task'));
$controller->redirect();