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
 * Privacy Subsystem implementation for filter_translations.
 *
 * @package filter_translations
 * @author Andrew Hancox <andrewdchancox@googlemail.com>
 * @author Open Source Learning <enquiries@opensourcelearning.co.uk>
 * @link https://opensourcelearning.co.uk
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright 2021, Andrew Hancox
 */

namespace filter_translations\privacy;

use core_privacy\local\metadata\collection;
use core_privacy\local\request\approved_contextlist;
use core_privacy\local\request\approved_userlist;
use core_privacy\local\request\contextlist;
use core_privacy\local\request\userlist;

/**
 * Privacy provider for the Translations filter plugin.
 *
 * @package filter_translations
 */
class provider implements 
    \core_privacy\local\metadata\provider,
    \core_privacy\local\request\plugin\provider,
    \core_privacy\local\request\core_userlist_provider {

    /**
     * Return the fields which contain personal data.
     *
     * @param collection $items a reference to the collection to use to store the metadata.
     * @return collection the updated collection of metadata items.
     */
    public static function get_metadata(collection $items): collection {
        $items->add_database_table(
            'filter_translations',
            [
                'usermodified' => 'privacy:metadata:filter_translations:usermodified',
                'timecreated' => 'privacy:metadata:filter_translations:timecreated',
                'timemodified' => 'privacy:metadata:filter_translations:timemodified',
            ],
            'privacy:metadata:filter_translations'
        );

        $items->add_database_table(
            'filter_translation_issues',
            [
                'usermodified' => 'privacy:metadata:filter_translation_issues:usermodified',
                'timecreated' => 'privacy:metadata:filter_translation_issues:timecreated',
                'timemodified' => 'privacy:metadata:filter_translation_issues:timemodified',
            ],
            'privacy:metadata:filter_translation_issues'
        );

        $items->add_database_table(
            'filter_translations_history',
            [
                'usermodified' => 'privacy:metadata:filter_translations_history:usermodified',
                'timecreated' => 'privacy:metadata:filter_translations_history:timecreated',
                'timemodified' => 'privacy:metadata:filter_translations_history:timemodified',
            ],
            'privacy:metadata:filter_translations_history'
        );

        return $items;
    }

    /**
     * Get the list of contexts that contain user information for the specified user.
     *
     * @param int $userid the userid.
     * @return contextlist the list of contexts containing user info for the user.
     */
    public static function get_contexts_for_userid(int $userid): contextlist {
        $contextlist = new contextlist();
        // TODO: Implement context gathering for user data.
        return $contextlist;
    }

    /**
     * Get the list of users who have data within a context.
     *
     * @param userlist $userlist the userlist containing the list of users who have data in this context/plugin combination.
     */
    public static function get_users_in_context(userlist $userlist) {
        // TODO: Implement user list gathering for context.
    }

    /**
     * Export personal data for the given approved_contextlist.
     *
     * @param approved_contextlist $contextlist a list of contexts approved for export.
     */
    public static function export_user_data(approved_contextlist $contextlist) {
        // TODO: Implement user data export.
    }

    /**
     * Delete all data for all users in the specified context.
     *
     * @param \context $context the context to delete in.
     */
    public static function delete_data_for_all_users_in_context(\context $context) {
        // TODO: Implement deletion of all user data in context.
    }

    /**
     * Delete all user data for the specified user, in the specified contexts.
     *
     * @param approved_contextlist $contextlist a list of contexts approved for deletion.
     */
    public static function delete_data_for_user(approved_contextlist $contextlist) {
        // TODO: Implement user data deletion for specific user.
    }

    /**
     * Delete multiple users within a single context.
     *
     * @param approved_userlist $userlist the approved context and user information to delete information for.
     */
    public static function delete_data_for_users(approved_userlist $userlist) {
        // TODO: Implement user data deletion for multiple users in context.
    }
}
