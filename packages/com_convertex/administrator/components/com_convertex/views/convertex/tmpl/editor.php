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

// Bootstrap and JQuery files
JHtml::_('stylesheet', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css', array('integrity' => 'sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk'), array('crossorigin' => 'anonymous'));
JHtml::_('script', 'https://code.jquery.com/jquery-3.5.1.slim.min.js', array('integrity' => 'sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj'), array('crossorigin' => 'anonymous'));
JHtml::_('script', 'https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js', array('integrity' => 'sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo'), array('crossorigin' => 'anonymous'));
JHtml::_('script', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js', array('integrity' => 'sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI'), array('crossorigin' => 'anonymous'));

// Editor files
JHtml::_('stylesheet', 'administrator/components/com_convertex/assets/css/editex.css');
JHtml::_('script', 'administrator/components/com_convertex/assets/js/editex.js');

// MathJax files
JHtml::_('script', 'https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-svg-full.js', array('id' => 'MathJax-script'), array('refer' => 'refer'));
?>
<div id="ct_popup">
    <div id="ct_discipline" role="toolbar" class="btn-toolbar" aria-label="Toolbar" aria-labelledby="ct_course"
         tabindex="-1">
        <div class="btn-group" role="group" aria-label="Discipline selector">
            <div class="input-group-prepend">
                <span class="input-group-text"><?php echo JText::sprintf('COM_CONVERTEX_DISCIPLINE') ?></span>
            </div>
            <button class="btn btn-primary btn-lg dropdown-toggle" type="button" id="selector" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                Disciplines
            </button>
            <div class="dropdown-menu" aria-labelledby="selector">
                <a class="dropdown-item active" href="#">
					<?php echo JText::sprintf('COM_CONVERTEX_DISCIPLINE_BASIC_MATH') ?>
                </a>
                <a class="dropdown-item" href="#">
					<?php echo JText::sprintf('COM_CONVERTEX_DISCIPLINE_PRE-ALGEBRA') ?>
                </a>
                <a class="dropdown-item" href="#">
					<?php echo JText::sprintf('COM_CONVERTEX_DISCIPLINE_TRIGONOMETRY') ?>
                </a>
                <a class="dropdown-item" href="#">
					<?php echo JText::sprintf('COM_CONVERTEX_DISCIPLINE_PRECALCULUS') ?>
                </a>
                <a class="dropdown-item" href="#">
					<?php echo JText::sprintf('COM_CONVERTEX_DISCIPLINE_CALCULUS') ?>
                </a>
                <a class="dropdown-item" href="#">
					<?php echo JText::sprintf('COM_CONVERTEX_DISCIPLINE_STATISTICS') ?>
                </a>
                <a class="dropdown-item" href="#">
					<?php echo JText::sprintf('COM_CONVERTEX_DISCIPLINE_FINITE_MATH') ?>
                </a>
                <a class="dropdown-item" href="#">
					<?php echo JText::sprintf('COM_CONVERTEX_DISCIPLINE_LINEAR_ALGEBRA') ?>
                </a>
                <a class="dropdown-item" href="#">
					<?php echo JText::sprintf('COM_CONVERTEX_DISCIPLINE_CHEMISTRY') ?>
                </a>
            </div>
        </div>
    </div>

    <hr class="clearfix">

    <div id="ct_toolbar" role="toolbar" class="btn-toolbar" aria-label="Toolbar" aria-labelledby="ct_toolbar"
         tabindex="-1">
        <div class="btn-group btn-group-sm mr-1" role="group" aria-label="Operators">
            <button type="button" class="btn btn-secondary" data-operator="+">\[+\]</button>
            <button type="button" class="btn btn-secondary" data-operator="-">\[-\]</button>
            <button type="button" class="btn btn-secondary" data-operator="*">\[*\]</button>
            <button type="button" class="btn btn-secondary" data-operator="/">\[/\]</button>
            <button type="button" class="btn btn-secondary" data-operator="\frac{?}{?}">\[\frac{\Box}{\Box}\]</button>
            <button type="button" class="btn btn-secondary" data-operator="\sqrt{?}">\[\sqrt{\Box}\]</button>
            <button type="button" class="btn btn-secondary" data-operator="^{?}">\[x^\Box\]</button>
        </div>
    </div>

    <div id="ct_editarea" role="textbox" class="input-group justify-content-center" tabindex="-1">
        <div class="input-group-prepend">
            <span class="input-group-text latex">\[\LaTeX\]</span>
        </div>
        <textarea id="ct_editarea_box" class="form-control" name="LaTeX input" aria-label="LaTeX input"></textarea>
    </div>

    <hr class="clearfix">

    <div id="ct_preview" role="presentation" class="input-group" tabindex="-1">
        <div class="input-group-prepend">
            <span class="input-group-text">
                <?php echo JText::sprintf('COM_CONVERTEX_PREVIEW') ?>
            </span>
        </div>
        <div id="ct_preview_box" class="form-control"
             aria-label="<?php echo JText::sprintf('COM_CONVERTEX_PREVIEW') ?>">
            <span class="latex"></span>
        </div>
    </div>

    <hr class="clearfix">

    <div class="container-fluid" tabindex="-1">
        <button type="button" id="ct_insert" class="btn btn-success">
            <span><?php echo JText::sprintf('COM_CONVERTEX_INSERT') ?></span>
        </button>
    </div>
    <input type="hidden" id="editor_name" name="editor_name" value="<?php echo (new JInput)->get('editor') ?>">
</div>