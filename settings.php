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
 *
 * Settings for the LSU Purple child theme.
 *
 * @package    theme_lsupurple
 * @copyright  2026 onwards Louisiana State University
 * @copyright  2026 onwards Robert Russo
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {

    $settings = new theme_boost_admin_settingspage_tabs('themesettinglsupurple',
        get_string('configtitle', 'theme_lsupurple'));

    // General tab: the two brand colors.
    $page = new admin_settingpage('theme_lsupurple_general',
        get_string('generalsettings', 'theme_lsupurple'));

    $name = 'theme_lsupurple/brandcolor';
    $title = get_string('brandcolor', 'theme_lsupurple');
    $description = get_string('brandcolordesc', 'theme_lsupurple');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '#3a1867');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_lsupurple/accentcolor';
    $title = get_string('accentcolor', 'theme_lsupurple');
    $description = get_string('accentcolordesc', 'theme_lsupurple');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '#FDD023');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $settings->add($page);

    // Advanced tab: raw SCSS escape hatches, same as Boost offers.
    $page = new admin_settingpage('theme_lsupurple_advanced',
        get_string('advancedsettings', 'theme_lsupurple'));

    $name = 'theme_lsupurple/scsspre';
    $title = get_string('rawscsspre', 'theme_lsupurple');
    $description = get_string('rawscsspredesc', 'theme_lsupurple');
    $setting = new admin_setting_scsscode($name, $title, $description, '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_lsupurple/scss';
    $title = get_string('rawscss', 'theme_lsupurple');
    $description = get_string('rawscssdesc', 'theme_lsupurple');
    $setting = new admin_setting_scsscode($name, $title, $description, '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $settings->add($page);
}
