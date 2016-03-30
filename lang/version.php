<?php
/**
 * Export activity grades to CSV file
 *
 * Version information
 *
 * @package    local_rtoactivitygradeexport
 * @author     Bevan Holman <bevan@pukunui.com>, Pukunui
 * @copyright  2015 onwards, Pukunui
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$plugin->version   = 2015100202;
$plugin->requires  = 2014050100;
$plugin->component = 'local_rtoactivitygradeexport';
$plugin->cron      = 60;
$plugin->maturity  = MATURITY_STABLE;
