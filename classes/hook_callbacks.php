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
 * Hook callbacks for the LSU Purple child theme.
 *
 * @package    theme_lsupurple
 * @copyright  2026 onwards Louisiana State University
 * @copyright  2026 onwards Robert Russo
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace theme_lsupurple;

defined('MOODLE_INTERNAL') || die();

class hook_callbacks {

    // Adds the Source Sans 3 font links to the page head. Loading the
    // font here instead of inside the SCSS keeps the stylesheet compile
    // safe and lets the browser preconnect for faster font delivery.
    public static function add_font_links(\core\hook\output\before_standard_head_html_generation $hook): void {
        global $PAGE;

        // Only act when this theme is the one being rendered.
        if ($PAGE->theme->name !== 'lsupurple') {
            return;
        }

        $hook->add_html('<link rel="preconnect" href="https://fonts.googleapis.com">');
        $hook->add_html('<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>');
        $hook->add_html('<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Source+Sans+3:ital,wght@0,400;0,600;0,700;0,800;1,400&display=swap">');
    }
}
