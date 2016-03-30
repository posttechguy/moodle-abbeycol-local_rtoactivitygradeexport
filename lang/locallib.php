<?php
/**
  * Export activity grades to CSV file
  *
  * Local library definitions
  *
  * @package    local_rtoactivitygradeexport
  * @author     Bevan Holman <bevan@pukunui.com>, Pukunui
  * @copyright  2015 onwards, Pukunui
  * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
*/

/**
  * Write the CSV output to file
  *
  * @param string $csv  the csv data
  * @return boolean  success?
*/
function local_rtoactivitygradeexport_write_csv_to_file($runhow, $data) {
  global $CFG, $DB;

  $config = get_config('local_rtoactivitygradeexport');

  if (($runhow == 'auto' and $config->ismanual) or ($runhow == 'manual' and empty($config->ismanual))) {
    return false;
  }

  if (empty($config->csvlocation)) {
      $config->csvlocation = $CFG->dataroot.'/rtoactivitygradeexport';
  }
  if (!isset($config->csvprefix)) {
      $config->csvprefix = '';
  }
  if (!isset($config->lastrun)) {
      // First time run we get all data.
      $config->lastrun = 0;
  }
  // Open the file for writing.
  $filename = $config->csvlocation.'/'.$config->csvprefix.date("Ymd").'-'.date("His").'.csv';
  if ($fh = fopen($filename, 'w')) {

      // Write the headers first.
      fwrite($fh, implode(',', local_rtoactivitygradeexport_get_csv_headers())."\r\n");

      $rs = local_rtoactivitygradeexport_get_data($config->lastrun, $data);

      if ($rs->valid()) {

          $strnotattempted = get_string('notattempted', 'local_rtoactivitygradeexport');

          // Cycle through data and add to file.
          foreach ($rs as $r) {
              // Manually manipulate the grade.
              // We could do this via the grade API but that level of complexity is not required here.
              if (!empty($r->finalgrade)) {
                  if (!empty($r->scale)) {
                      $scalearray = explode(',', $r->scale);
                      $result = $scalearray[$r->finalgrade - 1];
                  } else {
                      $result = $r->finalgrade;
                  }
              } else {
                  $result = $strnotattempted;
              }

              // Format the time.
              if (!empty($s->timemodified)) {
                  $time = date('Y-m-d h:i:s', $r->timemodified);
              } else {
                  $time = '';
              }

              $grouplength = strlen($r->groupname);
              $strtempl = ($grouplength - 8);
              $teachername = substr($r->groupname, 0, $strtempl-1);
              $startdate = substr($r->groupname, $strtempl);

              // Write the line to CSV file.
              fwrite($fh,
                      implode(',',
                              array($r->idnumber,
                                    $r->department,
                                    $r->courseid,
                                    $r->groupname,
                                    $startdate,
                                    $r->groupdesc,
                                    $teachername,
                                    $r->itemname,
                                    $r->finalgrade,
                                    $r->finalgradepercent,
                                    $r->cc_timecompleted
                              )
                      )."\r\n"
              );
          }

          // Close the recordset to free up RDBMS memory.
          $rs->close();
      }
      // Close the file.
      fclose($fh);

      // Set the last run time.
      if ($runhow == 'auto') set_config('local_rtoactivitygradeexport', 'lastrun', time());

      return true;
  } else {
      return false;
  }
}


/**
 * Return a recordset with the grade, group, enrolment data.
 * We use a recrodset to minimise memory usage as this report may get quite large.
 *
 * @param integer $from  timestamp
 * @return object  $DB recordset
 */
function local_rtoactivitygradeexport_get_data($from, $data = null) {
    global $DB;

    $sql = "
        SELECT
            CONCAT(c.id, u.idnumber, g.name, gi.id),  u.lastname, u.firstname,
            c.id as courseid, c.fullname as coursefullname,
            c.shortname as courseshortname,  u.idnumber, u.department,
            from_unixtime(cc.timecompleted) as cc_timecompleted,
            g.name as groupname, g.description as groupdesc,
            gi.itemname, gi.itemmodule, gg.finalgrade,gg.rawgrademax, round(gg.finalgrade/gg.rawgrademax*100) as finalgradepercent,
            from_unixtime(gg.timemodified) as quizcompleted
        FROM {course_completions}  cc
        JOIN {user} u on u.id = cc.userid
        JOIN {course} c on c.id = cc.course %%COURSECLAUSE%%
        JOIN {groups} g on c.id = g.courseid %%GROUPCLAUSE%%
        JOIN {groups_members} gm on g.id = gm.groupid and gm.userid = u.id
        JOIN {role_assignments} ra on ra.userid = u.id
        JOIN {context} cx on cx.id = ra.contextid and cx.instanceid = c.id
        JOIN {grade_items} gi on gi.courseid = c.id
        JOIN {grade_grades} gg on gg.itemid = gi.id and gg.userid = u.id
        WHERE cx.contextlevel = 50 and cc.timecompleted >= :from
        AND (gi.itemmodule = 'quiz'  OR gi.itemmodule = 'assignment')
        AND gi.hidden = 0
        ORDER BY 1,2, 3, 4, gi.sortorder
    ";

    $params = array();

    if ($data)
    {
        $params['from'] = 0;
        $params['course'] = $data->course;
        $params['group'] = $data->group;

        $sql = str_replace("%%COURSECLAUSE%%", ($data->course) ? " AND c.id = :course " : "", $sql);
        $sql = str_replace("%%GROUPCLAUSE%%", ($data->group != "All") ? " AND g.name = :group " : "", $sql);

    } else {
        $params['from'] = $from;

        $sql = str_replace("%%COURSECLAUSE%%", "", $sql);
        $sql = str_replace("%%GROUPCLAUSE%%", "", $sql);

    }
    /*
    if ($_SERVER['REMOTE_ADDR'] == '203.59.120.7')
    {
        print_object($params);
         echo "<pre>$sql</pre>";
    }
    */
    return $DB->get_recordset_sql($sql, $params);
}


/**
 * Return the CSV headers
 *
 * @return array
 */
function local_rtoactivitygradeexport_get_csv_headers() {
    return array(
        get_string('studentid',         'local_rtoactivitygradeexport'),
        get_string('programcourseid',   'local_rtoactivitygradeexport'),
        get_string('subjectid',         'local_rtoactivitygradeexport'),
        get_string('batch',             'local_rtoactivitygradeexport'),
        get_string('classstartdate',    'local_rtoactivitygradeexport'),
        get_string('classid',           'local_rtoactivitygradeexport'),
        get_string('userteacherid',     'local_rtoactivitygradeexport'),
        get_string('taskname',          'local_rtoactivitygradeexport'),
        get_string('marks',             'local_rtoactivitygradeexport'),
        get_string('percentageresult',  'local_rtoactivitygradeexport'),
        get_string('completedtime',     'local_rtoactivitygradeexport'),
    );
}
