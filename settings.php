<?php
/**
 * Export activity grades to CSV file
 *
 * Administration settings
 *
 * @package    local_rtoactivitygradeexport
 * @author     Bevan Holman <bevan@pukunui.com>, Pukunui
 * @copyright  2015 onwards, Pukunui
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if (has_capability('local/rtoactivitygradeexport:config', context_system::instance())) {

    $settings = new admin_settingpage('local_rtoactivitygradeexport_settings',
                                      new lang_string('pluginname', 'local_rtoactivitygradeexport'),
                                      'local/rtoactivitygradeexport:config');

    $settings->add(new admin_setting_configdirectory(
                'local_rtoactivitygradeexport/csvlocation',
                new lang_string('csvlocation', 'local_rtoactivitygradeexport'),
                new lang_string('csvlocationdesc', 'local_rtoactivitygradeexport'),
                $CFG->dataroot.'/rtoactivitygradeexport',
                PARAM_RAW,
                80
                ));

    $settings->add(new admin_setting_configtext(
                'local_rtoactivitygradeexport/csvprefix',
                new lang_string('csvprefix', 'local_rtoactivitygradeexport'),
                new lang_string('csvprefixdesc', 'local_rtoactivitygradeexport'),
                'rtoactivitygradeexport_',
                PARAM_RAW,
                80
                ));

    $settings->add(new admin_setting_configcheckbox(
                'local_rtoactivitygradeexport/ismanual',
                new lang_string('ismanual', 'local_rtoactivitygradeexport'),
                new lang_string('ismanualdesc', 'local_rtoactivitygradeexport'),
                'Automatic grade export (not checked)'
                ));

    $ADMIN->add('root', new admin_category('local_rtoactivitygradeexport', get_string('pluginname', 'local_rtoactivitygradeexport')));

    $ADMIN->add('local_rtoactivitygradeexport', new admin_externalpage('activitymanualexport', get_string('manualexport', 'local_rtoactivitygradeexport'),
                new moodle_url('/local/rtoactivitygradeexport/manual.php'),
                'local/rtoactivitygradeexport:config'));

    $ADMIN->add('localplugins', $settings);
}
