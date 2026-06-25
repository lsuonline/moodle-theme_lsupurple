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
 * Library functions for the LSU Purple child theme.
 *
 * @package    theme_lsupurple
 * @copyright  2026 onwards Louisiana State University
 * @copyright  2026 onwards Robert Russo
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// Returns the main SCSS content, which is the parent Boost preset.
function theme_lsupurple_get_main_scss_content($theme) {
    global $CFG;

    $filename = $CFG->dirroot . '/theme/boost/scss/preset/default.scss';
    return file_get_contents($filename);
}

// Returns the token variables, injected before Bootstrap compiles.
// Admin color settings are appended after the file so they win.
function theme_lsupurple_get_pre_scss($theme) {
    global $CFG;

    $filename = $CFG->dirroot . '/theme/lsupurple/scss/pre.scss';
    $scss = file_get_contents($filename);

    $brand = get_config('theme_lsupurple', 'brandcolor');
    if (!empty($brand)) {
        $scss .= "\n\$brand-primary: {$brand};";
        $scss .= "\n\$brand-primary-dark: darken({$brand}, 9%);";
        $scss .= "\n\$brand-primary-deep: darken({$brand}, 16%);";
        $scss .= "\n\$primary: {$brand};";
        $scss .= "\n\$link-color: {$brand};";
        $scss .= "\n\$link-hover-color: darken({$brand}, 9%);\n";
    }

    $accent = get_config('theme_lsupurple', 'accentcolor');
    if (!empty($accent)) {
        $scss .= "\n\$brand-gold: {$accent};";
        $scss .= "\n\$brand-gold-dark: darken({$accent}, 10%);\n";
    }

    $raw = get_config('theme_lsupurple', 'scsspre');
    if (!empty($raw)) {
        $scss .= "\n" . $raw . "\n";
    }

    return $scss;
}

// Returns the visual overrides, appended after the parent styles.
// Dark mode rules compile last so they win the cascade when active,
// and the raw SCSS setting goes after everything as the final word.
function theme_lsupurple_get_extra_scss($theme) {
    global $CFG;

    $scss = file_get_contents($CFG->dirroot . '/theme/lsupurple/scss/post.scss');
    $scss .= file_get_contents($CFG->dirroot . '/theme/lsupurple/scss/dark.scss');

    $imageurl = $theme->setting_file_url('backgroundimage', 'backgroundimage');
    if (!empty($imageurl)) {
        $scss .= "\n@media (min-width: 768px) { body { background-image: url('{$imageurl}'); background-size: cover; } }";
    }

    $loginbackgroundimageurl = $theme->setting_file_url('loginbackgroundimage', 'loginbackgroundimage');
    if (!empty($loginbackgroundimageurl)) {
        $scss .= "\nbody.pagelayout-login #page { background-image: url('{$loginbackgroundimageurl}'); background-size: cover; }";
    }

    $raw = get_config('theme_lsupurple', 'scss');
    if (!empty($raw)) {
        $scss .= "\n" . $raw . "\n";
    }

    return $scss;
}

/**
 * Serves any files associated with the theme settings.
 *
 * @param stdClass $course
 * @param stdClass $cm
 * @param context $context
 * @param string $filearea
 * @param array $args
 * @param bool $forcedownload
 * @param array $options
 * @return bool
 */
function theme_lsupurple_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = array()) {
    if ($context->contextlevel == CONTEXT_SYSTEM && ($filearea === 'logo' || $filearea === 'backgroundimage' ||
        $filearea === 'loginbackgroundimage')) {
        $theme = theme_config::load('lsupurple');
        // By default, theme files must be cache-able by both browsers and proxies.
        if (!array_key_exists('cacheability', $options)) {
            $options['cacheability'] = 'public';
        }
        return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
    } else {
        send_file_not_found();
    }
}

// Runs on every page before output. Tags the body with the dark
// mode class when the user has opted in via their profile.
function theme_lsupurple_page_init(moodle_page $page) {
    if (theme_lsupurple_wants_darkmode()) {
        $page->add_body_class('lsudark');
    }
}

// Reads the custom profile field named darkmode for the current user.
// Accepts 1, true, or the strings "1", "true", and "yes" as opted in.
function theme_lsupurple_wants_darkmode() {
    global $CFG, $USER;

    if (!isloggedin() || isguestuser()) {
        return false;
    }

    // Load the custom profile fields once per request if needed.
    if (!isset($USER->profile)) {
        require_once($CFG->dirroot . '/user/profile/lib.php');
        profile_load_custom_fields($USER);
    }

    if (empty($USER->profile['darkmode'])) {
        return false;
    }

    $value = strtolower(trim((string) $USER->profile['darkmode']));
    return in_array($value, ['1', 'true', 'yes'], true);
}
