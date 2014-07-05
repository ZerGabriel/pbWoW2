<?php

/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

/* Here we hook into the phpBB template chain in order to insert some extra values, which we can use in templates. */
function pbwow_global_style_append(&$hook, $handle, $include_once = true)
{
	//global $template, $cache, $user;
	global $template, $user, $phpbb_root_path;
	
	$pbwow_config = get_pbwow_config();
	if(isset($pbwow_config) && is_array($pbwow_config))
	{
		extract($pbwow_config);
	} else {
		return;
	}
	
	$board_url = generate_board_url() . '/';
	$web_path = (defined('PHPBB_USE_BOARD_URL_PATH') && PHPBB_USE_BOARD_URL_PATH) ? $board_url : $phpbb_root_path;
	$jspath = (isset($user->theme['template_inherit_path']) && $user->theme['template_inherit_path']) ? "{$web_path}styles/" . rawurlencode($user->theme['template_inherit_path']) . '/template/js/' : "{$web_path}styles/" . rawurlencode($user->theme['template_path']) . '/template/js/';

	if(isset($wowtips_script))
	{
		$src = $append = '';
		switch($wowtips_script)
		{
			case 1:
				$src = ($tooltips_local) ? $jspath . 'db.wowhead.js' : 'http://static.wowhead.com/widgets/power.js';
				$append = '<script>var wowhead_tooltips = { "colorlinks": true, "iconizelinks": true, "renamelinks": true }</script>';
			break;
			case 2:
				$src = ($tooltips_local) ? $jspath . 'db.openwow.js' : 'http://cdn.openwow.com/api/tooltip.js';
			break;
			case 3:
				$src = '';
			break;
			case 4:
				$src = ($tooltips_local) ? $jspath . 'db.vanilla.js' : 'http://db.vanillagaming.org/templates/wowhead/js/power.js';
			break;
		}
		$wowtips_script = (!empty($src)) ? '<script type="text/javascript" src="' . $src . '"></script>' : '';
		$wowtips_script .= (!empty($append)) ? $append : '';
	}

	if(isset($d3tips_script))
	{
		$src = '';
		$region = (isset($tooltips_region) && $tooltips_region > 0) ? 'eu' : 'us';
		switch($d3tips_script)
		{
			case 1:
				$src = ($tooltips_local) ? $jspath . 'db.battlenet.js' : 'http://'.$region.'.battle.net/d3/static/js/tooltips.js';
			break;
			case 2:
				$src = ($tooltips_local) ? $jspath . 'db.d3db.js' : 'http://d3db.com/static/js/external.js';
			break;
		}
		$d3tips_script = (!empty($src)) ? '<script type="text/javascript" src="' . $src . '"></script>' : '';
	}	

	$zamtips_script = '';
	if(isset($zamtips_enable) && ($zamtips_enable))
	{
		$src = ($tooltips_local) ? $jspath . 'db.zam.js' : 'http://zam.zamimg.com/j/tooltips.js';
		$zamtips_script = (!empty($src)) ? '<script type="text/javascript" src="' . $src . '"></script>' : '';
	}
	
	if(is_array($template->_tpldata['.']['0']))
	{
		$values = $template->_tpldata['.']['0'];

		if(isset($values['CREDIT_LINE']))
		{
			/** 
			* Really, please don't remove this line. I know some of you do.
			* PBWoW 2 has taken more than 200 hours to create, and is offered to you for free.
			* I know I can't stop you from trying to take credit yourself, but I urge you to reconsider.
			* Additionally, we won't be providing any support to those who remove it.
			**/
			$values['CREDIT_LINE'] = $values['CREDIT_LINE'] . '<br />Using <a href="http://pbwow.com/" target="_blank">PBWoW 2</a> style. All trademarks referenced herein are the properties of their respective owners.';
		}
		if(isset($values['SCRIPT_NAME']) && ($values['SCRIPT_NAME'] == 'index') && !isset($values['S_INDEX']))
		{
			$values += array('S_INDEX_PAGE' => true);
		}
		if($logo_enable && isset($logo_src) && isset($logo_size_width) && isset($logo_size_height) && $logo_size_width > 1 && $logo_size_height > 1)
		{
			$values += array(
				'S_PBLOGO' => true,
				'PBLOGO_SRC' => html_entity_decode($logo_src),
				'PBLOGO_WIDTH' => $logo_size_width,
				'PBLOGO_HEIGHT' => $logo_size_height,
				'PBLOGO_WIDTH_MOB' => floor(($logo_size_width * 0.8)),
				'PBLOGO_HEIGHT_MOB' => floor(($logo_size_height * 0.8)),
				'PBLOGO_MARGINS' => $logo_margins,
			);
			if(isset($logo_margins) && strlen($logo_margins) > 0)
			{
				$values += array(
					'PBLOGO_MARGINS' => $logo_margins,
				);
			}
		}
		if($topbar_enable && isset($topbar_code))
		{
			$values += array(
				'TOPBAR_CODE' => html_entity_decode($topbar_code)
			);
			if($topbar_fixed)
			{
				$values += array(
					'S_TOPBAR_FIXED' => true,
				);
			}
		}
		if($headerlinks_enable && isset($headerlinks_code))
		{
			$values += array(
				'HEADERLINKS_CODE' => html_entity_decode($headerlinks_code)
			);
		}
		if($navmenu_enable)
		{
			$values += array(
				'S_NAVMENU' => html_entity_decode($headerlinks_code)
			);
		}
		if($ie6message_enable && isset($ie6message_code))
		{
			$values += array(
				'IE6MESSAGE_CODE' => html_entity_decode($ie6message_code)
			);
		}
		if($videobg_enable)
		{
			$values += array(
				'S_VIDEOBG' => true,
			);
			if($videobg_allpages)
			{
				$values += array(
					'S_VIDEOBG_ALL' => true,
				);
			}
		}
		if($bg_fixed)
		{
			$values += array(
				'S_BG_FIXED' => true,
			);
			if($topbar_enable && isset($topbar_code) && !$topbar_fixed)
			{
				$values += array(
					'S_TOPBAR_FIXED' => true,
				);
			}
		}
		if(isset($wowtips_script))
		{
			$values += array(
				'WOWTIPS_SCRIPT' => $wowtips_script,
			);
		}
		if(isset($d3tips_script))
		{
			$values += array(
				'D3TIPS_SCRIPT' => $d3tips_script,
			);
		}
		if(isset($zamtips_script))
		{
			$values += array(
				'ZAMTIPS_SCRIPT' => $zamtips_script,
			);
		}
		if($tooltips_footer)
		{
			$values += array(
				'S_TOOLTIPS_FOOTER' => true,
			);
		}
		if($ads_index_enable && isset($ads_index_code))
		{
			$values += array(
				'ADS_INDEX_CODE' => html_entity_decode($ads_index_code)
			);
		}
		if($ads_top_enable && isset($ads_top_code))
		{
			$values += array(
				'ADS_TOP_CODE' => html_entity_decode($ads_top_code)
			);
		}
		if($ads_bottom_enable && isset($ads_bottom_code))
		{
			$values += array(
				'ADS_BOTTOM_CODE' => html_entity_decode($ads_bottom_code)
			);
		}
		if($ads_side_enable && isset($ads_side_code))
		{
			$values += array(
				'ADS_SIDE_CODE' => html_entity_decode($ads_side_code)
			);
		}
		if($tracking_enable && isset($tracking_code))
		{
			$values += array(
				'TRACKING_CODE' => html_entity_decode($tracking_code)
			);
		}
	}
	$template->_tpldata['.']['0'] = $values;
	
	if(isset($template->_tpldata['recent_topics']) && is_array($template->_tpldata['recent_topics']) && (count($template->_tpldata['recent_topics']) > 0))
	{
		foreach($template->_tpldata['recent_topics'] as &$entry)
		{
			if(!isset($entry['TOPIC_AUTHOR_COLOUR']))
			{
				preg_match('/(#[A-Fa-f0-9]{6}|#[A-Fa-f0-9]{3})/',$entry['TOPIC_AUTHOR_FULL'],$matches);
				$entry += array('TOPIC_AUTHOR_COLOUR' => (isset($matches[0]) ? $matches[0] : ''));
			}
		}
	}
	
	if($navmenu_enable)
		{
		if(isset($template->_tpldata['navlinks']) && isset($template->_tpldata['jumpbox_forums']) && (count($template->_tpldata['jumpbox_forums']) > 1)) {
			$breadcrumb_popup = '';
			$navlinks_data = &$template->_tpldata['navlinks'];
			$tree = build_jumpbox_tree($template->_tpldata['jumpbox_forums']);
			
			$parents = array();
			foreach ($navlinks_data as $crumb)
			{
				$parents[] = $crumb['FORUM_ID'];
			}
			foreach ($navlinks_data as $level => &$crumb)
			{
				$breadcrumb_popup = '<div class="nav-popup"><ul>';
				$breadcrumb_popup .= generate_advanced_breadcrumb($tree, $crumb['FORUM_ID'], $level, $parents);
				$breadcrumb_popup .= '</ul></div>';
				$crumb['POPUP'] = $breadcrumb_popup;
			}
		}
	}
}
$phpbb_hook->register(array('template','display'), 'pbwow_global_style_append', 'last');

/**
* Returns the user's avatar url, without <img> tags and such. This is usefull when we want 
* to display the avatar as a background image in a <div> or other HTML object.
*/
function get_user_avatar_src($avatar, $avatar_type)
{
	global $user, $config, $phpbb_root_path, $phpEx;

	if (empty($avatar) || !$avatar_type)
	{
		return '';
	}

	$avatar_img = '';

	switch ($avatar_type)
	{
		case AVATAR_UPLOAD:
			$avatar_img = $phpbb_root_path . "download/file.$phpEx?avatar=";
		break;

		case AVATAR_GALLERY:
			$avatar_img = $phpbb_root_path . $config['avatar_gallery_path'] . '/';
		break;
	}

	$avatar_img .= $avatar;
	return $avatar_img;
}

/**
* This is an exact copy of the get_user_rank function, as found in functions_display.php
* It has been put here so it can be called from any page, which is needed for some PBWoW
* features. It also greatlly reduces the risk of undefined function errors.
*
* @param int $user_rank the current stored users rank id
* @param int $user_posts the users number of posts
* @param string &$rank_title the rank title will be stored here after execution
* @param string &$rank_img the rank image as full img tag is stored here after execution
* @param string &$rank_img_src the rank image source is stored here after execution
*
* Note: since we do not want to break backwards-compatibility, this function will only 
* properly assign ranks to guests if you call it for them with user_posts == false
*/
function get_user_rank_global($user_rank, $user_posts, &$rank_title, &$rank_img, &$rank_img_src)
{
	global $ranks, $config, $phpbb_root_path;

	if (empty($ranks))
	{
		global $cache;
		$ranks = $cache->obtain_ranks();
	}

	if (!empty($user_rank))
	{
		$rank_title = (isset($ranks['special'][$user_rank]['rank_title'])) ? $ranks['special'][$user_rank]['rank_title'] : '';
		$rank_img = (!empty($ranks['special'][$user_rank]['rank_image'])) ? '<img src="' . $phpbb_root_path . $config['ranks_path'] . '/' . $ranks['special'][$user_rank]['rank_image'] . '" alt="' . $ranks['special'][$user_rank]['rank_title'] . '" title="' . $ranks['special'][$user_rank]['rank_title'] . '" />' : '';
		$rank_img_src = (!empty($ranks['special'][$user_rank]['rank_image'])) ? $phpbb_root_path . $config['ranks_path'] . '/' . $ranks['special'][$user_rank]['rank_image'] : '';
	}
	else if ($user_posts !== false)
	{
		if (!empty($ranks['normal']))
		{
			foreach ($ranks['normal'] as $rank)
			{
				if ($user_posts >= $rank['rank_min'])
				{
					$rank_title = $rank['rank_title'];
					$rank_img = (!empty($rank['rank_image'])) ? '<img src="' . $phpbb_root_path . $config['ranks_path'] . '/' . $rank['rank_image'] . '" alt="' . $rank['rank_title'] . '" title="' . $rank['rank_title'] . '" />' : '';
					$rank_img_src = (!empty($rank['rank_image'])) ? $phpbb_root_path . $config['ranks_path'] . '/' . $rank['rank_image'] : '';
					break;
				}
			}
		}
	}
}

/* Battle.net API processing function */
function process_pbwow_bnet($users_id, $cpf_data)
{
	global $db;
	
	$pbwow_config = get_pbwow_config(); // make a config to disable all this stuff
	
	if(isset($pbwow_config['bnetchars_enable']) && $pbwow_config['bnetchars_enable']) {

		$cachelife = isset($pbwow_config['bnetchars_cachetime']) ? intval($pbwow_config['bnetchars_cachetime']) : 86400;
		$apitimeout = isset($pbwow_config['bnetchars_timeout']) ? intval($pbwow_config['bnetchars_timeout']) : 1;
	
		$sql = 'SELECT *
			FROM ' . PBWOW2_CHARS_TABLE . '
			WHERE ' . $db->sql_in_set('user_id', $users_id);
		$result = $db->sql_query($sql);
	
		$db_data = array();
		while ($row = $db->sql_fetchrow($result))
		{
			$db_data[$row['user_id']] = $row;
		}
		$db->sql_freeresult($result);
	
		foreach($users_id as $user_id) {
			$bneth = (isset($cpf_data[$user_id]["pf_pbbnethost"])) ? $cpf_data[$user_id]["pf_pbbnethost"] -1 : 0;
			$bnetr = (isset($cpf_data[$user_id]["pf_pbbnetrealm"])) ? $cpf_data[$user_id]["pf_pbbnetrealm"] : '';
			$bnetn = (isset($cpf_data[$user_id]["pf_pbbnetname"])) ? $cpf_data[$user_id]["pf_pbbnetname"] : '';
	
			if($bneth && $bneth !== 0 && $bnetr && $bnetn) {
				$callAPI = FALSE;

				// Determine if the API should be called, based on cache TTL, # of tries, and character change
				if(isset($db_data[$user_id])) {
					$age = time() - $db_data[$user_id]['updated'];

					switch($db_data[$user_id]["tries"]) {
						case 0: break;
						case 1: $callAPI = ($age > 60) ? TRUE : FALSE ; break;
						case 2: $callAPI = ($age > 600) ? TRUE : FALSE ; break;
						case 3: $callAPI = ($age > ($cachelife / 24)) ? TRUE : FALSE ; break;
						case 4: $callAPI = ($age > ($cachelife / 4)) ? TRUE : FALSE ; break;
						default: break; // More than 4 tries > just wait for TTL
					}

					if($age > $cachelife) {
						$callAPI = TRUE;
					}
					
					if($bnetn !== $db_data[$user_id]['name']) {
						$callAPI = TRUE;
					}
				} else {
					$callAPI = TRUE;
				}
	
				if($callAPI == TRUE) {
					// CPF values haven't been assigned yet, so have to do it manually
					$loc = FALSE;
					switch($bneth) {
						case 1: $bneth = "us.battle.net"; $loc = "us"; break;
						case 2: $bneth = "eu.battle.net"; $loc = "eu"; break;
						case 3: $bneth = "kr.battle.net"; $loc = "ko"; break;
						case 4: $bneth = "tw.battle.net"; $loc = "tw"; break;
						case 5: $bneth = "www.battlenet.com.cn"; $loc = "cn"; break;
						default: $bneth = "us.battle.net"; $loc = "us"; break;
					}
					
					// Sanitize
					$bnetr = strtolower($bnetr);
					$bnetr = str_replace("'", "", $bnetr);
					$bnetr = str_replace(" ", "-", $bnetr);
					$bnetn = str_replace(" ", "-", $bnetn);
	
					// Get API data (should use CURL instead, but I'll do it later)
					$URL = "http://" . $bneth . "/api/wow/character/" . $bnetr . "/" . $bnetn . "?fields=guild";
					$context = stream_context_create(array('http'=>
						array('timeout' => $apitimeout)
					));
					$response = @file_get_contents($URL, false, $context);

					if($response === FALSE) {
						// If the API data cannot be retrieved, register the number of tries to prevent flooding
						if(isset($db_data[$user_id]) && $db_data[$user_id]['tries'] < 10) {
							$sql_ary = array(
								'user_id'	=> $user_id,
								'updated'	=> time(),
								'tries'		=> $db_data[$user_id]['tries'] + 1,
								'name'		=> $bnetn,
								'realm'		=> $bnetr,
								'guild'		=> "Battle.net API error",
							);
							$sql = 'UPDATE ' . PBWOW2_CHARS_TABLE . '
								SET ' . $db->sql_build_array('UPDATE', $sql_ary) . '
								WHERE user_id = ' . $user_id;
							$db->sql_query($sql);
						} else {
							$sql_ary = array(
								'user_id'	=> $user_id,
								'updated'	=> time(),
								'tries'		=> 1,
								'name'		=> $bnetn,
								'realm'		=> $bnetr,
								'guild'		=> "Battle.net API error",
							);
							$sql = 'INSERT INTO ' . PBWOW2_CHARS_TABLE . ' ' . $db->sql_build_array('INSERT', $sql_ary);
							$db->sql_query($sql);
						}

						$cpf_data[$user_id]['pf_pbguild'] = "Battle.net API error";
					} else {
						$data = json_decode($response, TRUE);
						
						// Set avatar path
						$avatar = (!empty($data['thumbnail'])) ? $data['thumbnail'] : '';
						if($avatar) {
							$avatarURL = "http://" . $bneth . "/static-render/" . $loc . "/" . $avatar;
							//$avatarIMG = @file_get_contents($IMGURL);
						}
						
						// Conform Blizzard's race ID numbers to PBWoW 2, so the CPF will work correctly
						$data_race = $data['race'];
						switch($data_race) {
							case 22: $data_race = 12; break;
							case 24:
							case 25:
							case 26: $data_race = 13; break;
							//default: $data_race; break;
						}
						$data_race += 1;
						$data_class = $data['class'] + 1;
						$data_gender = $data['gender'] + 2;
						$data_guild = (is_array($data['guild'])) ? $data['guild']['name'] : "";
						$data_level = $data['level'];
						
						// Insert into character DB table
						$sql_ary = array(
							'user_id'			=> $user_id,
							'updated'			=> time(),
							'tries'				=> 0,
							'game'				=> "wow",
							'lastModified'		=> $data['lastModified'],
							'name'				=> $data['name'],
							'realm'				=> $data['realm'],
							'battlegroup'		=> $data['battlegroup'],
							'class'				=> $data_class,
							'race'				=> $data_race,
							'gender'			=> $data_gender,
							'level'				=> $data_level,
							'achievementPoints'	=> $data['achievementPoints'],
							'avatar'			=> $avatar,
							'avatarURL'			=> $avatarURL,
							'calcClass'			=> $data['calcClass'],
							'totalHK'			=> $data['totalHonorableKills'],
							'guild'				=> $data_guild,
						);
	
						if(isset($db_data[$user_id])) {
							$sql = 'UPDATE ' . PBWOW2_CHARS_TABLE . '
								SET ' . $db->sql_build_array('UPDATE', $sql_ary) . '
								WHERE user_id = ' . $user_id;
						} else {
							$sql = 'INSERT INTO ' . PBWOW2_CHARS_TABLE . ' ' . $db->sql_build_array('INSERT', $sql_ary);
						}
						$db->sql_query($sql);
						
						// Merge with rest of CPF values
						$cpf_data[$user_id]['pf_pbguild'] = $data_guild;
						//$cpf_data[$user_id]['pf_pbrealm'] = $data['realm'];
						$cpf_data[$user_id]['pf_pbclass'] = $data_class;
						$cpf_data[$user_id]['pf_pbrace'] = $data_race;
						$cpf_data[$user_id]['pf_pbgender'] = $data_gender;
						$cpf_data[$user_id]['pf_pblevel'] = $data_level;
						$cpf_data[$user_id]['pf_pbbnetavatar'] = $avatarURL;
					}
				} elseif($db_data[$user_id]['avatarURL']) {
					// Merge with rest of CPF values
					$cpf_data[$user_id]['pf_pbguild'] = $db_data[$user_id]['guild'];
					//$cpf_data[$user_id]['pf_pbrealm'] = $db_data[$user_id]['realm'];
					$cpf_data[$user_id]['pf_pbclass'] = $db_data[$user_id]['class'];
					$cpf_data[$user_id]['pf_pbrace'] = $db_data[$user_id]['race'];
					$cpf_data[$user_id]['pf_pbgender'] = $db_data[$user_id]['gender'];
					$cpf_data[$user_id]['pf_pblevel'] = $db_data[$user_id]['level'];
					$cpf_data[$user_id]['pf_pbbnetavatar'] = $db_data[$user_id]['avatarURL'];
				} else {
					$cpf_data[$user_id]['pf_pbguild'] = $db_data[$user_id]['guild'];
				}
			}
		}
	}
	return $cpf_data;
}
	
/* Process the user's CPF input, and generate the appropriate avatar url and other game related attributes */
function process_pbwow_cpf($tpl_fields, $user_id)
{
	global $phpbb_hook;

	if ($phpbb_hook->call_hook(__FUNCTION__, $tpl_fields))
	{
		if ($phpbb_hook->hook_return(__FUNCTION__))
		{
			return $phpbb_hook->hook_return_result(__FUNCTION__);
		}
	}

	$portrait = $path = $faction = '';
	$valid = false; // determines whether a specific race/class combination is valid (for the game)
	$avail = false; // determines whether (old) avatars are available for the race/class combination
	
	if(!empty($tpl_fields['row'])){
		$r = (isset($tpl_fields['row']['PROFILE_PBRACE_VALUEID'])) ? $tpl_fields['row']['PROFILE_PBRACE_VALUEID'] - 1 : NULL ; // Get the WoW race ID
		$c = (isset($tpl_fields['row']['PROFILE_PBCLASS_VALUEID'])) ? $tpl_fields['row']['PROFILE_PBCLASS_VALUEID'] - 1 : NULL ; // Get the WoW class ID
		$g = (isset($tpl_fields['row']['PROFILE_PBGENDER_VALUEID'])) ? $tpl_fields['row']['PROFILE_PBGENDER_VALUEID'] - 1 : NULL ; // Get the WoW gender ID
		$l = (isset($tpl_fields['row']['PROFILE_PBLEVEL_VALUE'])) ? $tpl_fields['row']['PROFILE_PBLEVEL_VALUE'] : NULL ; // Get the WoW level
		$d = (isset($tpl_fields['row']['PROFILE_PBDCLASS_VALUEID'])) ? $tpl_fields['row']['PROFILE_PBDCLASS_VALUEID'] - 1 : NULL ; // Get the Diablo class ID
		$df = (isset($tpl_fields['row']['PROFILE_PBDFOLLOWER_VALUEID'])) ? $tpl_fields['row']['PROFILE_PBDFOLLOWER_VALUEID'] - 1 : NULL ; // Get the Diablo class ID
		$dg = (isset($tpl_fields['row']['PROFILE_PBDGENDER_VALUEID'])) ? $tpl_fields['row']['PROFILE_PBDGENDER_VALUEID'] - 1 : NULL ; // Get the Diablo gender ID
		$wsr = (isset($tpl_fields['row']['PROFILE_PBWSRACE_VALUEID'])) ? $tpl_fields['row']['PROFILE_PBWSRACE_VALUEID'] - 1 : NULL ; // Get the Wildstar race ID
		$wsc = (isset($tpl_fields['row']['PROFILE_PBWSCLASS_VALUEID'])) ? $tpl_fields['row']['PROFILE_PBWSCLASS_VALUEID'] - 1 : NULL ; // Get the Wildstar class ID
		$wsg = (isset($tpl_fields['row']['PROFILE_PBWSGENDER_VALUEID'])) ? $tpl_fields['row']['PROFILE_PBWSGENDER_VALUEID'] - 1 : NULL ; // Get the Wildstar class ID
		//$bneth = (isset($tpl_fields['row']['PROFILE_PBBNETHOST_VALUE'])) ? $tpl_fields['row']['PROFILE_PBBNETHOST_VALUE'] : NULL ; // Get the Battle.net host
		//$bnetr = (isset($tpl_fields['row']['PROFILE_PBBNETREALM_VALUE'])) ? $tpl_fields['row']['PROFILE_PBBNETREALM_VALUE'] : NULL ; // Get the Battle.net realm
		//$bnetn = (isset($tpl_fields['row']['PROFILE_PBBNETNAME_VALUE'])) ? $tpl_fields['row']['PROFILE_PBBNETNAME_VALUE'] : NULL ; // Get the Battle.net character name
		$bneta = (isset($tpl_fields['row']['PROFILE_PBBNETAVATAR_VALUEID'])) ? $tpl_fields['row']['PROFILE_PBBNETAVATAR_VALUEID'] : NULL ; // Get the Battle.net avatar
		
		// I know it looks silly, but we need this to fix icons in templates
		$tpl_fields['row']['PROFILE_PBRACE_VALUEID'] = $r;
		$tpl_fields['row']['PROFILE_PBCLASS_VALUEID'] = $c;
		$tpl_fields['row']['PROFILE_PBGENDER_VALUEID'] = $g;
		$tpl_fields['row']['PROFILE_PBDCLASS_VALUEID'] = $d;
		$tpl_fields['row']['PROFILE_PBDFOLLOWER_VALUEID'] = $df;
		$tpl_fields['row']['PROFILE_PBDGENDER_VALUEID'] = $dg;
		$tpl_fields['row']['PROFILE_PBWSRACE_VALUEID'] = $wsr;
		$tpl_fields['row']['PROFILE_PBWSCLASS_VALUEID'] = $wsc;
		$tpl_fields['row']['PROFILE_PBWSGENDER_VALUEID'] = $wsg;

		/* Battle.net API */
		//if($bneth !== NULL && $bnetr !== NULL && $bnetn !== NULL && $user_id !== 0 && $bneta !== NULL) {
		if($user_id !== 0 && $bneta !== NULL) {

			if(isset($r)) {
				$faction = (in_array($r, array(1,3,4,7,11,12))) ? 1 : 2;
			}

			$tpl_fields['row'] += array(
				'PROFILE_PBAVATAR_VALUE'	=> $bneta,
				'PROFILE_PBFACTION_VALUE'	=> $faction,
				'S_PROFILE_PBAVATAR'		=> true,
				'S_PROFILE_PBFACTION'		=> true
			);
		}

		/* WoW without Battle.net */
		elseif($r !== NULL) {
			
			/* Remapping options */
			// $R = $r;
			// $r = ($R == 1) ? 4 : $r; // first item in CPF (with "none" = 0), map to race 4 (Night Elf)
			// $r = ($R == 2) ? 9 : $r; // second item in CPF, map to race 9 (Goblin)
			// $r = ($R == 3) ? 12 : $r; // third item in CPF, map to race 12 (Worgen)
			// $r = ($R == 4) ? 2 : $r; // fourth item in CPF, map to race 2 (Orc)
			// etc. etc.
			
			// $C = $c;
			// $c = ($C == 1) ? 1 : $c; // first item in CPF (with "none" = 0), map to class 1 (Warrior)
			// $c = ($C == 2) ? 4 : $c; // second item in CPF, map to class 4 (Rogue)
			// $c = ($C == 3) ? 6 : $c; // third item in CPF, map to class 6 (Death Knight)
			// etc. etc.
			
			/* For reference 
			r = 1 > Human
			r = 2 > Orc
			r = 3 > Dwarf
			r = 4 > Night Elf
			r = 5 > Undead
			r = 6 > Tauren
			r = 7 > Gnome
			r = 8 > Troll
			r = 9 > Goblin
			r = 10 > Blood Elf
			r = 11 > Draenei
			r = 12 > Worgen
			r = 13 > Pandaren
			
			c = 1 > Warrior
			c = 2 > Paladin
			c = 3 > Hunter
			c = 4 > Rogue
			c = 5 > Priest
			c = 6 > Death Knight
			c = 7 > Shaman
			c = 8 > Mage
			c = 9 > Warlock
			c = 10 > Monk
			c = 11 > Druid
			*/
			
			$faction = 3; // Set faction to neutral, until we can determine correct faction
			switch($r)
			{
				case 1: // Human
					$valid = (in_array($c, array(1,2,3,4,5,6,8,9,10))) ? true : false;
					$avail = (in_array($c, array(1,2,4,5,6,8,9))) ? true : false;
					$faction = 1;
				break;
				
				case 2: // Orc
					$valid = (in_array($c, array(1,3,4,6,7,8,9,10))) ? true : false;
					$avail = (in_array($c, array(1,3,4,6,7,9))) ? true : false;
					$faction = 2;
				break;
				
				case 3: // Dwarf
					$valid = (in_array($c, array(1,2,3,4,5,6,7,8,9,10))) ? true : false;
					$avail = (in_array($c, array(1,2,3,4,5,6))) ? true : false;
					$faction = 1;
				break;
				
				case 4: // Night Elf
					$valid = (in_array($c, array(1,3,4,5,6,8,10,11))) ? true : false;
					$avail = (in_array($c, array(1,3,4,5,6,11))) ? true : false;
					$faction = 1;
				break;
				
				case 5: // Undead
					$valid = (in_array($c, array(1,3,4,5,6,8,9,10))) ? true : false;
					$avail = (in_array($c, array(1,4,5,6,8,9))) ? true : false;
					$faction = 2;
				break;
				
				case 6: // Tauren
					$valid = (in_array($c, array(1,2,3,5,6,7,10,11))) ? true : false;
					$avail = (in_array($c, array(1,3,6,7,11))) ? true : false;
					$faction = 2;
				break;
				
				case 7: // Gnome
					$valid = (in_array($c, array(1,4,5,6,8,9,10))) ? true : false;
					$avail = (in_array($c, array(1,4,6,8,9))) ? true : false;
					$faction = 1;
				break;
				
				case 8:  // Troll
					$valid = (in_array($c, array(1,3,4,5,6,7,8,9,10,11))) ? true : false;
					$avail = (in_array($c, array(1,3,4,5,6,7,8))) ? true : false;
					$faction = 2;
				break;

				case 9: // Goblin
					$valid = (in_array($c, array(1,3,4,5,6,7,8,9))) ? true : false;
					//$avail = (in_array($c, array())) ? true : false;
					$faction = 2;
				break;
				
				case 10:  // Blood Elf
					$valid = (in_array($c, array(1,2,3,4,5,6,8,9,10))) ? true : false;
					$avail = (in_array($c, array(2,3,4,5,6,8,9))) ? true : false;
					$faction = 2;
				break;
				
				case 11: // Draenei
					$valid = (in_array($c, array(1,2,3,5,6,7,8,10))) ? true : false;
					$avail = (in_array($c, array(1,2,3,5,6,7,8))) ? true : false;
					$faction = 1;
				break;
				
				case 12:  // Worgen
					$valid = (in_array($c, array(1,3,4,5,6,8,9,11))) ? true : false;
					//$avail = (in_array($c, array())) ? true : false;
					$faction = 1;
				break;
				
				case 13: // Pandaren
					$valid = (in_array($c, array(1,3,4,5,7,8,10))) ? true : false;
					//$avail = (in_array($c, array())) ? true : false;
					$faction = 3;
				break;
			}
			
			$g = max(0, $g-1); // 0 = none, 1 = male, 2 = female, but we need a 0/1 map

			if($valid && $avail) {
				if ($l >= 90) {
					$path = 'wow-80'; // Don't have any higher (yet)
				} 
				elseif ($l >= 80) {
					$path = 'wow-80';
				}					
				elseif ($l >= 70) {
					$path = 'wow-70';
				}
				elseif ($l >= 60) {
					$path = 'wow-60';
				}
				else {
					$path = 'wow-default';
				}
				
				$portrait = $path . '/' . $g . '-' . $r . '-' . $c . '.gif';
			} 
			elseif($valid && !$avail) {
				$portrait = 'wow-default-new/' . $r . '-' . $g . '.jpg'; // Valid, but missing
			}
			else {
				$portrait = 'wow-default-new/' . $r . '-' . $g . '.jpg';  // Invalid, completely messed up
			}
			
			$tpl_fields['row'] += array(
				'PROFILE_PBAVATAR_VALUE'	=> $portrait,
				'PROFILE_PBFACTION_VALUE'	=> $faction,
				'S_PROFILE_PBAVATAR'		=> true,
				'S_PROFILE_PBFACTION'		=> true
			);
		}
		
		/* Diablo */
		elseif($d !== NULL) {
			
			$portrait = 'beta-avatar.jpg';
			
			$tpl_fields['row'] += array(
				'PROFILE_PBAVATAR_VALUE'	=> $portrait,
				'PROFILE_PBFACTION_VALUE'	=> 3,
				'S_PROFILE_PBAVATAR'		=> true,
				'S_PROFILE_PBFACTION'		=> true
			);
		}
		
		/* Wildstar */
		elseif($wsr !== NULL) {

			/* For reference 
			wsr = 1 > Human
			wsr = 2 > Cassian
			wsr = 3 > Granok
			wsr = 4 > Draken
			wsr = 5 > Aurin
			wsr = 6 > Chua
			wsr = 7 > Mordesh
			wsr = 8 > Mechari
			
			wsc = 1 > Warrior
			wsc = 2 > Esper
			wsc = 3 > Spellslinger
			wsc = 4 > Stalker
			wsc = 5 > Medic
			wsc = 6 > Engineer
			*/

			$faction = 3; // Set faction to neutral, until we can determine correct faction
			switch($wsr)
			{
				case 1: // Human
					$valid = $avail = (in_array($wsc, array(1,2,3,4,5,6))) ? true : false;
					$faction = 1;
				break;
				
				case 2: // Cassian
					$valid = $avail = (in_array($wsc, array(1,2,3,4,5,6))) ? true : false;
					$faction = 2;
				break;
				
				case 3: // Granok
					$valid = $avail = (in_array($wsc, array(1,5,6))) ? true : false;
					$faction = 1;
				break;
				
				case 4: // Draken
					$valid = $avail = (in_array($wsc, array(1,3,4))) ? true : false;
					$faction = 2;
				break;
				
				case 5: // Aurin
					$valid = $avail = (in_array($wsc, array(2,3,4))) ? true : false;
					$faction = 1;
				break;
				
				case 6: // Chua
					$valid = $avail = (in_array($wsc, array(2,3,5,6))) ? true : false;
					$faction = 2;
				break;
				
				case 7: // Mordesh
					$valid = $avail = (in_array($wsc, array(1,3,4,5,6))) ? true : false;
					$faction = 1;
				break;
				
				case 8:  // Mechari
					$valid = $avail = (in_array($wsc, array(1,4,5,6))) ? true : false;
					$faction = 2;
				break;
			}
			
			$wsg = max(0, $wsg-1); // 0 = none, 1 = male, 2 = female, but we need a 0/1 map

			if($valid) {
				//$portrait = 'wildstar/' . $wsr . '-' . $wsg . '-' . $wsc . '.jpg'; // Valid
				$portrait = 'wildstar/' . $wsr . '.jpg'; // Valid
			}
			else {
				$portrait = 'wildstar/' . $wsr . '.jpg';  // Invalid, show generic race avatar
			}
			
			$tpl_fields['row'] += array(
				'PROFILE_PBAVATAR_VALUE'	=> $portrait,
				'PROFILE_PBFACTION_VALUE'	=> $faction,
				'S_PROFILE_PBAVATAR'		=> true,
				'S_PROFILE_PBFACTION'		=> true
			);
		}
	}

	return $tpl_fields;
}
$phpbb_hook->add_hook('process_pbwow_cpf');

/* Determine if any PBWoW2 special styling should be applied to a user, based on his rank */
function check_rank_special_styling($rank, &$styling, &$color)
{
	$pbwow_config = get_pbwow_config();
	
	$cfg_blizz_ranks = explode(',', $pbwow_config['blizz_ranks']);
	$cfg_blizz_color = $pbwow_config['blizz_color'];
	$cfg_propass_ranks = explode(',', $pbwow_config['propass_ranks']);
	$cfg_propass_color = $pbwow_config['propass_color'];
	$cfg_red_ranks = explode(',', $pbwow_config['red_ranks']);
	$cfg_red_color = $pbwow_config['red_color'];
	$cfg_green_ranks = explode(',', $pbwow_config['green_ranks']);
	$cfg_green_color = $pbwow_config['green_color'];

	$styling = $color = '';

	if(isset($cfg_green_ranks) && strlen($cfg_green_ranks > 0) && ($pbwow_config['green_enable']))
	{
		if(in_array($rank, $cfg_green_ranks)) {
			$styling = 'green';
			if(isset($cfg_green_color)) {
				$color = $cfg_green_color;
			}
		}
	}
	if(isset($cfg_propass_ranks) && strlen($cfg_propass_ranks > 0) && ($pbwow_config['propass_enable']))
	{
		if(in_array($rank, $cfg_propass_ranks)) {
			$styling = 'propass';
			if(isset($cfg_propass_color)) {
				$color = $cfg_propass_color;
			}
		}
	}
	if(isset($cfg_red_ranks) && strlen($cfg_red_ranks > 0) && ($pbwow_config['red_enable']))
	{
		if(in_array($rank, $cfg_red_ranks)) {
			$styling = 'red';
			if(isset($cfg_red_color)) {
				$color = $cfg_red_color;
			}
		}
	}
	if(isset($cfg_blizz_ranks) && strlen($cfg_blizz_ranks > 0) && ($pbwow_config['blizz_enable']))
	{
		if(in_array($rank, $cfg_blizz_ranks)) {
			$styling = 'blizz';
			if(isset($cfg_blizz_color)) { //  && strlen($cfg_blizz_color > 0) not working?!?
				$color = $cfg_blizz_color;
			}
		}
	}
}

/* Generate a forum array tree, based on an unordered array like the jumpbox data */
function build_jumpbox_tree($list) {
	$tree = $parent_memory = array();
	$prev_id = $prev_level = 0;

	foreach($list as $item => $vars) {
		$forum_id = $vars['FORUM_ID'];
		$level = (isset($vars['level']) && is_array($vars['level'])) ? count($vars['level']) : 0;

		if ($level == 0) {
			$parent_memory = array(0);
		} elseif ($level > $prev_level) {
			$parent_memory[$level] = $prev_id;
		} elseif ($level < $prev_level) {
			unset($parent_memory[$prev_level]);
			unset($parent_memory[$prev_level + 1]); // clean up
			unset($parent_memory[$prev_level + 2]); // clean up
		}

		$current = (isset($vars['SELECTED']) && !empty($vars['SELECTED']) ? true : false);
		
		$values = array('parent_id' => $parent_memory[$level], 'level' => $level, 'forum_name' => $vars['FORUM_NAME'], 'current' => $current);
		
		switch($level) {
			case 0:
				$tree[$forum_id] = $values;
			break;
			case 1:
				$tree[$parent_memory[$level]]['children'][$forum_id] = $values;
			break;
			case 2:
				$tree[$parent_memory[$level-1]]['children'][$parent_memory[$level]]['children'][$forum_id] = $values;
			break;
			case 3:
				$tree[$parent_memory[$level-2]]['children'][$parent_memory[$level-1]]['children'][$parent_memory[$level]]['children'][$forum_id] = $values;
			break;
		}

		$prev_id = $forum_id;
		$prev_level = $level;
	}

	unset($tree[-1]);
	return $tree;
}

/* Generates menu blocks based on the forum array tree, to use for popup menus */
function generate_advanced_breadcrumb($tree, $crumb_current, $crumb_level = 0, $parents = array()) {
	$link = './viewforum.php?f=';
	$html = $childhtml = '';
	
	foreach ($tree as $id => $vars)
	{
		/*if (($crumb_level > $vars['level']) && $crumb_level !== 0)
		{
			continue;
		}*/
		
		if (isset($vars['children'])) {
			$childhtml = generate_advanced_breadcrumb($vars['children'], $crumb_current, $crumb_level, $parents);
		} else {
			$childhtml = '';
		}

		$parent_id = $vars['parent_id'];
		$level = $vars['level'];

		if (($crumb_level <= $vars['level'] && in_array($parent_id, $parents)) || $crumb_level == 0)
		{
			$class = (!empty($childhtml)) ? 'children' : '';
			$class .= ($vars['current'] == true || $id == $crumb_current) ? ' current' : '';

			$html .= '<li' . ((!empty($class)) ? (' class="' . $class . '">') : ('>'));

			$html .= '<a href="' . $link . $id .'">' . $vars['forum_name'] . '</a>';

			if (!empty($childhtml)) {
				$html .= '<div class="fly-out"><ul>';
				$html .= $childhtml;
				$html .= '</ul></div>';
			}

			$html .= "</li>\n";
		} else {
			$html .= $childhtml;
		}
	}

	return $html;
}

/* Parses and modifies the topic preview output to include PBWoW 2 functionality such as game avatars */
function modify_topic_preview($row, $block, $profile_fields_cache, $tp_avatars = false, $cheat_cache = false)
{
	global $template, $phpbb_root_path, $cp, $config;
	
	if (class_exists('phpbb_topic_preview') && $config['load_cpf_viewtopic'])
	{
		// retroactive modification when we missed blockvar assignment (like recent topics), only called once
		if (!$row && !empty($template->_tpldata['recent_topics']) && !empty($cheat_cache)) {
			foreach ($template->_tpldata['recent_topics'] as &$rtrow)
			{
				$p1 = $cheat_cache[$rtrow['TOPIC_ID']]['tfp'];
				$p2 = $cheat_cache[$rtrow['TOPIC_ID']]['tlp'];
				
				$cp_p1 = (isset($profile_fields_cache[$p1])) ? $cp->generate_profile_fields_template('show', false, $profile_fields_cache[$p1]) : array();
				$cp_p2 = ($p2 == $p1) ? $cp_p2 = $cp_p1 : (isset($profile_fields_cache[$p2])) ? $cp->generate_profile_fields_template('show', false, $profile_fields_cache[$p2]) : array();
				if ($tp_avatars) {
					if (isset($cp_p1['row']) && sizeof($cp_p1['row'])) {
						$rtrow += array(
							'TOPIC_PREVIEW_PBAVATAR'	=> isset($cp_p1['row']['PROFILE_PBAVATAR_VALUE']) ? $cp_p1['row']['PROFILE_PBAVATAR_VALUE']: '',
							'S_TOPIC_PREVIEW_PBBNET'	=> isset($cp_p1['row']['PROFILE_PBBNETAVATAR_VALUE']) ? TRUE : FALSE // TODO
						);
					}
					if (isset($cp_p2['row']) && sizeof($cp_p2['row'])) {
						$rtrow += array(
							'TOPIC_PREVIEW_PBAVATAR2'	=> isset($cp_p2['row']['PROFILE_PBAVATAR_VALUE']) ? $cp_p2['row']['PROFILE_PBAVATAR_VALUE']: '',
							'S_TOPIC_PREVIEW_PBBNET2'	=> isset($cp_p2['row']['PROFILE_PBBNETAVATAR_VALUE']) ? TRUE : FALSE // TODO
						);
					}
				}
				if (!empty($rtrow['TOPIC_AUTHOR_FULL'])) {
					preg_match('/(#[A-Fa-f0-9]{6}|#[A-Fa-f0-9]{3})/',$rtrow['TOPIC_AUTHOR_FULL'],$matches);
					$rtrow += array('TOPIC_PREVIEW_COLOUR' => (isset($matches[0]) ? $matches[0] : ''));
				}
				$rtrow += array(
					'TOPIC_PREVIEW_COLOUR2'		=> (!empty($rtrow['LAST_POST_AUTHOR_COLOUR'])) ? $rtrow['LAST_POST_AUTHOR_COLOUR'] : '',
				);
				//var_dump($rtrow);
			}
		// normal blockvar operations, called for each row
		} else {
			$p1 = $row['topic_poster'];
			$p2 = $row['topic_last_poster_id'];

			$cp_p1 = (isset($profile_fields_cache[$p1])) ? $cp->generate_profile_fields_template('show', false, $profile_fields_cache[$p1]) : array();
			$cp_p2 = ($p2 == $p1) ? $cp_p2 = $cp_p1 : (isset($profile_fields_cache[$p2])) ? $cp->generate_profile_fields_template('show', false, $profile_fields_cache[$p2]) : array();
			
			$insert = array();

			if ($tp_avatars) {
				if (isset($cp_p1['row']) && sizeof($cp_p1['row'])) {
					$insert += array(
						'TOPIC_PREVIEW_PBAVATAR'	=> isset($cp_p1['row']['PROFILE_PBAVATAR_VALUE']) ? $cp_p1['row']['PROFILE_PBAVATAR_VALUE']: '',
						'S_TOPIC_PREVIEW_PBBNET'	=> isset($cp_p1['row']['PROFILE_PBBNETAVATAR_VALUE']) ? TRUE : FALSE // TODO
					);
				}
				if (isset($cp_p2['row']) && sizeof($cp_p2['row'])) {
					$insert += array(
						'TOPIC_PREVIEW_PBAVATAR2'	=> isset($cp_p2['row']['PROFILE_PBAVATAR_VALUE']) ? $cp_p2['row']['PROFILE_PBAVATAR_VALUE']: '',
						'S_TOPIC_PREVIEW_PBBNET2'	=> isset($cp_p2['row']['PROFILE_PBBNETAVATAR_VALUE']) ? TRUE : FALSE // TODO
					);
				}
			}
			$insert += array(
				'TOPIC_PREVIEW_COLOUR'		=> (!empty($row['first_user_colour'])) ? '#'.$row['first_user_colour'] : '',
				'TOPIC_PREVIEW_COLOUR2'		=> (!empty($row['last_user_colour'])) ? '#'.$row['last_user_colour'] : '',
			);

			$template->alter_block_array($block, $insert, true, 'change');
			//var_dump($template->_tpldata['topicrow']);
		}
	}
}

function get_pbwow_config()
{
	global $db, $cache, $phpbb_root_path, $phpEx;

	$pbwow_config = $cache->get('pbwow_config');

	if ($pbwow_config == false)
	{
		$pbwow_config = $cached_pbwow_config = array();

		if (!class_exists('phpbb_db_tools'))
		{
			include("$phpbb_root_path/includes/db/db_tools.$phpEx");
		}
		$db_tool = new phpbb_db_tools($db);
	
		if($db_tool->sql_table_exists(PBWOW2_CONFIG_TABLE)){

			$sql = 'SELECT config_name, config_value
				FROM ' . PBWOW2_CONFIG_TABLE;
			$result = $db->sql_query($sql);
	
			while ($row = $db->sql_fetchrow($result))
			{
				$cached_pbwow_config[$row['config_name']] = $row['config_value'];
				$pbwow_config[$row['config_name']] = $row['config_value'];
			}
			$db->sql_freeresult($result);
	
			$cache->put('pbwow_config', $cached_pbwow_config);
		}
	}
	return $pbwow_config;
}

?>