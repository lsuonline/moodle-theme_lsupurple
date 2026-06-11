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
 * @package    theme_lsupurple
 * @copyright  2026 onwards Louisiana State University
 * @copyright  2026 onwards Robert Russo
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$THEME->name = 'lsupurple';
$THEME->parents = ['boost'];

// No flat stylesheets. Everything compiles through SCSS.
$THEME->sheets = [];
$THEME->editor_sheets = [];
$THEME->usefallback = true;

// Main SCSS: the parent Boost preset.
$THEME->scss = function($theme) {
    return theme_lsupurple_get_main_scss_content($theme);
};

// Tokens injected before Bootstrap compiles.
$THEME->prescsscallback = 'theme_lsupurple_get_pre_scss';

// Visual overrides appended after the parent styles.
$THEME->extrascsscallback = 'theme_lsupurple_get_extra_scss';

// Inherit Boost behavior.
$THEME->rendererfactory = 'theme_overridden_renderer_factory';
$THEME->haseditswitch = true;
$THEME->usescourseindex = true;
$THEME->iconsystem = \core\output\icon_system::FONTAWESOME;
