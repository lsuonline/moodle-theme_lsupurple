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
 * Primary navigation for the LSU Purple child theme.
 *
 * @package    theme_lsupurple
 * @copyright  2026 onwards Louisiana State University
 * @copyright  2026 onwards Robert Russo
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace theme_lsupurple\output;

defined('MOODLE_INTERNAL') || die();

/*
 * Extends the core primary navigation.
*/
class primary extends \core\navigation\output\primary {

    // Flags the custom menu nodes before merging back to core.
    protected function merge_primary_and_custom(array $primary, array $custom, bool $expandedmenu = false): array {
        if (!$expandedmenu) {
            foreach ($custom as $node) {
                $this->force_node_into_moremenu($node);
            }
        }
        return parent::merge_primary_and_custom($primary, $custom, $expandedmenu);
    }

    // Sets the forceintomoremenu flag on a custom menu node.
    protected function force_node_into_moremenu(object $node): void {
        $node->forceintomoremenu = true;

        foreach ($node->children ?? [] as $child) {
            $this->force_node_into_moremenu($child);
        }
    }
}
