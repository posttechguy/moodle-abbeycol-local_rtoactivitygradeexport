<?php
/**
 * Export grades to CSV file
 *
 * String definitions
 *
 * @package    local_rtoactivitygradeexport
 * @author     Priya Ramakrishnan <priya@pukunui.com>, Pukunui
 * @author     Bevan Holman <bevan@pukunui.com>, Pukunui
 * @copyright  2015 onwards, Pukunui
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['batch'] = 'Batch';
$string['classid'] = 'Class ID';
$string['classstartdate'] = 'Class start date';
$string['completedtime'] = 'Completed Time';
$string['coursetype'] = 'Course';
$string['csvlocation'] = 'CSV File Location';
$string['csvlocationdesc'] = 'Full server path where CSV files should be created. This directory must be writeable by the web user';
$string['csvprefix'] = 'CSV File Name Prefix';
$string['csvprefixdesc'] = 'The CSV files will be created with a name of the current date in the format YYYYMMDD and an extension of ".csv". The prefix will be prepended to the beginning of the name';
$string['errorcourse'] = 'Please choose a course';
$string['errorgroup'] = 'Please choose a group';
$string['exporterror'] = 'Error: An error has occurred while exporting the csv file, please return to the export page and try again';
$string['exportnow'] = 'Export Now';
$string['exportsuccess'] = 'Success: your file has successfully exported as a csv file';
$string['firstname'] = 'Firstname';
$string['grouptype'] = 'Group';
$string['idnumber'] = 'IDnumber';
$string['ismanual'] = 'Is Activity Grade Export manual?';
$string['ismanualdesc'] = 'The activity grade export can be configured as a manual process or a automatic process, Tick the box to make the process manual<br>Turn off to make the process run automatically again';
$string['isnotmanual'] = 'The manual RTO Grade Export is unavailable, you will be redirected to change the settings';
$string['lastname'] = 'Lastname';
$string['local/rtoactivitygradeexport:config'] = 'Configure RTO Activity Grade Export';
$string['manualexport'] = 'Manual Export';
$string['manualexportheader'] = 'Manually Export RTO Activity Grades';
$string['marks'] = 'Marks';
$string['notattempted'] = 'Not Attempted';
$string['outcome'] = 'Outcome';
$string['percentageresult'] = '% Result';
$string['pluginname'] = 'RTO Activity Grade Export';
$string['programcourseid'] = 'Program/CourseID';
$string['resultdate'] = 'Results Date';
$string['results'] = 'Results';
$string['selectacourse'] = 'Select a course';
$string['selectagroup'] = 'Select a group';
$string['selectallgroups'] = 'All groups';
$string['studentid'] = 'StudentID';
$string['subjectid'] = 'SubjectID';
$string['taskname'] = 'TaskName';
$string['unitcode'] = 'Unitcode';
$string['userteacherid'] = 'User/TeacherID';