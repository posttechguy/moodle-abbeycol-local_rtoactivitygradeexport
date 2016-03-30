<?php
/**
 * Export grades to CSV file
 *
 * Class definition for scheduled task execution
 *
 * @package    local_rtoactivitygradeexport
 * @author     Bevan Holman <bevan@pukunui.com>, Pukunui
 * @copyright  2015 onwards, Pukunui
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_rtoactivitygradeexport\task;

require_once($CFG->dirroot.'/local/rtoactivitygradeexport/locallib.php');

/**
 * Extend core scheduled task class
 */
class exporttocsv extends \core\task\scheduled_task {

    /**
     * Return name of the task
     *
     * @return string
     */
    public function get_name() {
        return get_string('pluginname', 'local_rtoactivitygradeexport');
    }

    /**
     * Perform the task
     */
    public function execute() {
        local_rtoactivitygradeexport_write_csv_to_file('auto');
    }
}
