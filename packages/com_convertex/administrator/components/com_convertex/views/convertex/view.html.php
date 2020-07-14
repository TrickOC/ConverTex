<?php
/**
 * @package     ConverTex
 * @subpackage  com_convertex
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * View class for a list of search terms.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_search
 * @since       1.5
 */
class convertexViewConverTex extends JViewLegacy
{

	/**
	 * Display the view
	 */
	public function display($tpl = null)
    {
        JToolbarHelper::title(JText::sprintf('ConverTex parameters'));
        JToolbarHelper::preferences('com_convertex');

        // Display the template
        parent::display($tpl);
    }

}
