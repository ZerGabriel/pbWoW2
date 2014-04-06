<?php
/**
 * returns profile xml based on ajax call from planner_post_body_editor.js
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version $Id$
 */
define('IN_PHPBB', true);
$phpEx = substr(strrchr(__FILE__, '.'), 1);
// go up 5 directories to root
$phpbb_root_path = './../../../../../';
include($phpbb_root_path . 'common.' . $phpEx);

$team_id = request_var('team_id', 0);
$sql_array = array(
	    'SELECT'    => 'r.role_name, r.role_color, r.role_icon, 
	    				s.role_id, s.team_needed, t.team_name ' ,  
	    'FROM'      => array(
	        RP_ROLES   		=> 'r', 
	        RP_TEAMSIZE   	=> 's', 
	        RP_TEAMS   		=> 't'
	    ),
	    'WHERE'  	=> 's.role_id = r.role_id 
	    			AND t.teams_id = s.teams_id 
	    			AND s.teams_id = ' . (int) $team_id, 
	    'ORDER_BY'  => 'r.role_id'
);

$sql = $db->sql_build_query('SELECT', $sql_array);
$result = $db->sql_query($sql);
header('Content-type: text/xml');
$xml = '<?xml version="1.0" encoding="UTF-8"?>
<rolelist>';
while ($row = $db->sql_fetchrow($result))
// preparing xml
{
	 $xml .= '<role>'; 
	 $xml .= "<team_name>" . $row['team_name'] . "</team_name>";
	 $xml .= "<role_id>" . $row['role_id'] . "</role_id>";
	 $xml .= "<role_name>" . $row['role_name'] . "</role_name>";
	 $xml .= "<role_color>" . $row['role_color'] . "</role_color>";
	 $xml .= "<role_icon>" . $row['role_icon'] . "</role_icon>";
	 $xml .= "<role_needed>" . $row['team_needed'] . "</role_needed>";
	 $xml .= '</role>';
}
$db->sql_freeresult($result);
$xml .= '</rolelist>';
//return xml to ajax
echo($xml); 
?>
