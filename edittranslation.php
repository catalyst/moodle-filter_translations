<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package filter_translations
 * @author Andrew Hancox <andrewdchancox@googlemail.com>
 * @author Open Source Learning <enquiries@opensourcelearning.co.uk>
 * @link https://opensourcelearning.co.uk
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright 2021, Andrew Hancox
 */

use core\notification;
use filter_translations\edittranslationform;
use filter_translations\translation;

require_once(__DIR__ . '../../../config.php');

$id = optional_param('id', null, PARAM_INT);
$generatedhash = optional_param('generatedhash', null, PARAM_TEXT);
$foundhash = optional_param('foundhash', null, PARAM_TEXT);
$rawtext = optional_param('rawtext', null, PARAM_RAW);

if (empty($id)) {
    $title = get_string('createtranslation', 'filter_translations');
} else {
    $title = get_string('edittranslation', 'filter_translations');
}

$context = context_system::instance();
$url = new moodle_url('/filter/translations/edittranslation.php');
$return_url = new moodle_url('/filter/translations/managetranslations.php');

$persistent = null;
if (empty($id)) {
    $persistent = new translation();
    $persistent->set('md5key', empty($foundhash) ? $generatedhash : $foundhash);
    $persistent->set('targetlanguage', current_language());
} else {
    $persistent = new translation($id);
    $url->param('id', $id);
}

$istranslationdirty = !empty($generatedhash) && !empty($persistent->get('id')) && $persistent->get('lastgeneratedhash') !== $generatedhash;
if (!empty($generatedhash)) {
    $persistent->set('lastgeneratedhash', $generatedhash);
}

$PAGE->set_context($context);
$PAGE->set_title($title);
$PAGE->set_heading($title);
$PAGE->set_url($url);

$form = new edittranslationform($url->out(false), ['persistent' => $persistent]);

if ($data = $form->get_data()) {
    $persistent->from_record($form->filter_data_for_persistent($data));
    $persistent->save();

    $data = file_postupdate_standard_editor($data, 'substitutetext', $form->get_substitute_test_editoroptions(), $context,
            'filter_translations',
            'substitutetext', $persistent->get('id'));

    $persistent->set('substitutetext', $data->substitutetext_editor['text']);
    $persistent->set('substitutetextformat', $data->substitutetext_editor['format']);
    $persistent->update();

    redirect($return_url);
} else if ($form->is_cancelled()) {
    redirect($return_url);
}

echo $OUTPUT->header();

if ($istranslationdirty) {
    echo $OUTPUT->notification(get_string('dirtytranslation', 'filter_translations'), notification::WARNING);
}

if (!empty($rawtext)) {
    echo html_writer::tag('h2', get_string('rawtext', 'filter_translations'));
    echo html_writer::div(urldecode($rawtext));

    echo html_writer::tag('h2', get_string('translation', 'filter_translations'));
}

$form->display();

echo $OUTPUT->footer();