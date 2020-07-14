<?php
/**
 * @package    ConverTex
 * @subpackage com_convertex
 *
 * @author     Patrick Oliveira do Carmo <patrick.carmo@aluno.ufop.edu.br>
 * @copyright  Copyright (C) - 2020 - Patrick Oliveira do Carmo
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @link       https://triki.ufop.br/
 */

defined('_JEXEC') or die;

header('location:index.php?option=com_config&view=component&component=com_convertex');

?>

<form action="index.php" method="post" id="adminForm">

    <fieldset>
        <legend>
            <?php echo JText::sprintf('ConverTex component') ?>
        </legend>
        <p>
            <?php echo JText::sprintf('Required to manage the ConverTex button in editors'); ?>
        </p>
    </fieldset>
    <div>
        <input type="hidden" name="task" value=""/>
        <input type="hidden" name="boxchecked" value="0"/>
        <?php echo JHtml::_('form.token'); ?>

        <a class="btn btn-success"
           onclick="location.href='index.php?option=com_config&view=component&component=com_convertex'">Configure
            ConvertTex</a>
    </div>
</form>