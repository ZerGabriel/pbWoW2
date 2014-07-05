<?php
/**
 *
 * @author PayBas (PayBas) admin@pbwow.com
 * @author Sajaki sajaki9@gmail.com
 * @copyright (c) 2013 PayBas
 * @copyright (c) 2014 Sajaki
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version 2.1.0
 *
 */

/**
 * @ignore
 */
define('UMIL_AUTO', true);
define('IN_PHPBB', true);
define('IN_INSTALL', true);
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : '../';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($phpbb_root_path . 'common.' . $phpEx);

$user->session_begin();
$auth->acl($user->data);
$user->setup();

if (!file_exists($phpbb_root_path . 'umil/umil_auto.' . $phpEx))
{
	trigger_error('Please download the latest UMIL (Unified MOD Install Library) from: <a href="http://www.phpbb.com/mods/umil/">phpBB.com/mods/umil</a>', E_USER_ERROR);
}

$mod_name = 'PBWOW2_MOD';
$version_config_name = 'pbwow2_version';
$language_file = 'mods/info_acp_pbwow';

$versions = array(
	'2.0.0' => array(

		'table_add' => array(
			array('phpbb_pbwow2_config', array(
				'COLUMNS' => array(
					'config_name' => array('VCHAR', ''),
					'config_value' => array('MTEXT', ''),
					'config_default' => array('MTEXT', ''),
				),
				'PRIMARY_KEY'	=> 'config_name',
			)),
		),

		'table_row_insert'	=> array(
			array('phpbb_pbwow2_config', array(
				array(
					'config_name' => 'blizz_enable',
					'config_value' => '0',
					'config_default' => '0',
				),
				array(
					'config_name' => 'blizz_ranks',
					'config_value' => '',
					'config_default' => '5',
				),
				array(
					'config_name' => 'blizz_color',
					'config_value' => '#00C0FF',
					'config_default' => '#00C0FF',
				),
				array(
					'config_name' => 'propass_enable',
					'config_value' => '0',
					'config_default' => '0',
				),
				array(
					'config_name' => 'propass_ranks',
					'config_value' => '',
					'config_default' => '',
				),
				array(
					'config_name' => 'propass_color',
					'config_value' => '#9988FF',
					'config_default' => '#9988FF',
				),
				array(
					'config_name' => 'red_enable',
					'config_value' => '0',
					'config_default' => '0',
				),
				array(
					'config_name' => 'red_ranks',
					'config_value' => '',
					'config_default' => '',
				),
				array(
					'config_name' => 'red_color',
					'config_value' => '#FF3222',
					'config_default' => '#FF3222',
				),
				array(
					'config_name' => 'green_enable',
					'config_value' => '0',
					'config_default' => '0',
				),
				array(
					'config_name' => 'green_ranks',
					'config_value' => '',
					'config_default' => '',
				),
				array(
					'config_name' => 'green_color',
					'config_value' => '#5DF644',
					'config_default' => '#5DF644',
				),

				array(
					'config_name' => 'ads_index_enable',
					'config_value' => '1',
					'config_default' => '1',
				),
				array(
					'config_name' => 'ads_index_code',
					'config_value' => '<a class="donate-button" href="http://pbwow.com/donate/" style="display: block"></a>',
					'config_default' => '<a class="donate-button" href="http://pbwow.com/donate/" style="display: block"></a>',
				),
				array(
					'config_name' => 'ads_top_enable',
					'config_value' => '0',
					'config_default' => '0',
				),
				array(
					'config_name' => 'ads_top_code',
					'config_value' => '',
					'config_default' => '',
				),
				array(
					'config_name' => 'ads_side_enable',
					'config_value' => '0',
					'config_default' => '0',
				),
				array(
					'config_name' => 'ads_side_code',
					'config_value' => '',
					'config_default' => '',
				),
			)),
		),

		'module_add' => array(
			array('acp', 'ACP_CAT_DOT_MODS', 'ACP_PBWOW2_CATEGORY',
				array('module_basename'	=> 'pbwow2'),
			),
			array('acp', 'ACP_PBWOW2_CATEGORY', array(
					'module_basename'	=> 'pbwow2',
					'module_langname'	=> 'ACP_PBWOW2_OVERVIEW',
					'module_mode'		=> 'overview',
					'module_auth'		=> 'acl_a_board',
				),
			),
			array('acp', 'ACP_PBWOW2_CATEGORY', array(
					'module_basename'	=> 'pbwow2',
					'module_langname'	=> 'ACP_PBWOW2_CONFIG',
					'module_mode'		=> 'config',
					'module_auth'		=> 'acl_a_board',
				),
			),
			array('acp', 'ACP_PBWOW2_CATEGORY', array(
					'module_basename'	=> 'pbwow2',
					'module_langname'	=> 'ACP_PBWOW2_ADS',
					'module_mode'		=> 'ads',
					'module_auth'		=> 'acl_a_board',
				),
			),
		),

	),
	'2.0.1' => array(
		'table_row_insert'	=> array(
			array('phpbb_pbwow2_config', array(
				array(
					'config_name' => 'ads_bottom_enable',
					'config_value' => '0',
					'config_default' => '0',
				),
				array(
					'config_name' => 'ads_bottom_code',
					'config_value' => '',
					'config_default' => '',
				),
				array(
					'config_name' => 'tracking_enable',
					'config_value' => '0',
					'config_default' => '0',
				),
				array(
					'config_name' => 'tracking_code',
					'config_value' => '',
					'config_default' => '',
				),
			)),
		),
	),
	'2.0.3' => array(
		'table_row_insert'	=> array(
			array('phpbb_pbwow2_config', array(
				array(
					'config_name' => 'headerlinks_enable',
					'config_value' => '1',
					'config_default' => '1',
				),
				array(
					'config_name' => 'headerlinks_code',
					'config_value' => '<li class="icon-portal">
	<a href="http://board3.de/" target="_blank">Portal</a>
</li>
<li class="icon-dkp">
	<a href="http://eqdkp-plus.eu/" target="_blank">DKP</a>
</li>
<li class="icon-custom1">
	<a href="http://pbwow.com/" target="_blank">PBWoW</a>
</li>
<li class="icon-custom2">
	<a href="http://www.phpbb.com/" target="_blank">phpBB</a>
</li>',
					'config_default' => '<li class="icon-custom1">
	<a href="http://pbwow.com/" target="_blank">PBWoW</a>
</li>
<li class="icon-custom2">
	<a href="http://www.phpbb.com/" target="_blank">phpBB</a>
</li>',
				),
				array(
					'config_name' => 'ie6message_enable',
					'config_value' => '1',
					'config_default' => '1',
				),
				array(
					'config_name' => 'ie6message_code',
					'config_value' => '<!--[if lt IE 8]>
<div style="border: 1px solid #F7941D; background: #FEEFDA; text-align: center; clear: both; height: 75px; position: relative;">
	<div style="position: absolute; right: 3px; top: 3px; font-family: courier new; font-weight: bold;"><a href="#" onclick="javascript:this.parentNode.parentNode.style.display="none"; return false;"><img src="styles/pbwow2/imageset/images/ie6nomore/cornerx.jpg" style="border: none;" alt="Close this notice"/></a></div>
	<div style="width: 640px; margin: 0 auto; text-align: left; padding: 0; overflow: hidden; color: black;">
		<div style="width: 75px; float: left;"><img src="styles/pbwow2/imageset/images/ie6nomore/warning.jpg" alt="Warning!"/></div>
		<div style="width: 275px; float: left; font-family: Arial, sans-serif;">
		<div style="font-size: 14px; font-weight: bold; margin-top: 12px;">You are using an outdated browser</div>
		<div style="font-size: 12px; margin-top: 6px; line-height: 12px;">For a better experience using this site, please upgrade to a modern web browser.</div>
	</div>
	<div style="width: 75px; float: left;"><a href="http://www.firefox.com" target="_blank"><img src="styles/pbwow2/imageset/images/ie6nomore/firefox.jpg" style="border: none;" alt="Get Firefox"/></a></div>
	<div style="width: 75px; float: left;"><a href="http://microsoft.com/ie" target="_blank"><img src="styles/pbwow2/imageset/images/ie6nomore/ie.jpg" style="border: none;" alt="Get Internet Explorer"/></a></div>
	<div style="width: 73px; float: left;"><a href="http://www.apple.com/safari/download/" target="_blank"><img src="styles/pbwow2/imageset/images/ie6nomore/safari.jpg" style="border: none;" alt="Get Safari"/></a></div>
	<div style="float: left;"><a href="http://www.google.com/chrome" target="_blank"><img src="styles/pbwow2/imageset/images/ie6nomore/chrome.jpg" style="border: none;" alt="Get Google Chrome"/></a></div>
	</div>
</div>
<![endif]-->',
					'config_default' => '',
				),
			)),
		),
		'custom'	=> 'update_pbgender',
	),
	'2.0.4' => array(
		'module_add' => array(
			array('acp', 'ACP_PBWOW2_CATEGORY', array(
					'module_basename'	=> 'pbwow2',
					'module_langname'	=> 'ACP_PBWOW2_POSTSTYLING',
					'module_mode'		=> 'poststyling',
					'module_auth'		=> 'acl_a_board',
				),
			),
		),
		'table_row_insert'	=> array(
			array('phpbb_pbwow2_config', array(
				array(
					'config_name' => 'videobg_enable',
					'config_value' => '1',
					'config_default' => '1',
				),
				array(
					'config_name' => 'videobg_allpages',
					'config_value' => '0',
					'config_default' => '0',
				),
				array(
					'config_name' => 'wowheadtips_enable',
					'config_value' => '0',
					'config_default' => '0',
				),
				array(
					'config_name' => 'd3dbtips_enable',
					'config_value' => '0',
					'config_default' => '0',
				),
				array(
					'config_name' => 'd3bnettips_enable',
					'config_value' => '0',
					'config_default' => '0',
				),
				array(
					'config_name' => 'd3bnettips_region',
					'config_value' => '0',
					'config_default' => '0',
				),
				array(
					'config_name' => 'zamtips_enable',
					'config_value' => '0',
					'config_default' => '0',
				),
			)),
		),
	),
	'2.0.5' => array(
		/*'table_row_remove'	=> array(
			array('phpbb_pbwow2_config', array(
				array(
					'config_name' => 'wowheadtips_enable',
					'config_value' => '0',
					'config_default' => '0',
				),
				array(
					'config_name' => 'd3dbtips_enable',
					'config_value' => '0',
					'config_default' => '0',
				),
				array(
					'config_name' => 'd3bnettips_enable',
					'config_value' => '0',
					'config_default' => '0',
				),
				array(
					'config_name' => 'd3bnettips_region',
					'config_value' => '0',
					'config_default' => '0',
				),
			)),
		),*/
		'table_row_insert'	=> array(
			array('phpbb_pbwow2_config', array(
				array(
					'config_name' => 'topbar_enable',
					'config_value' => '1',
					'config_default' => '1',
				),
				array(
					'config_name' => 'topbar_code',
					'config_value' => '<span>Hi there! This is a welcome message</span>
<a class="cell" class="custom-top1" href="http://pbwow.com/forum/">PBWoW</a>
<a class="cell" class="custom-top2" href="https://www.phpbb.com/">phpBB</a>',
					'config_default' => '',
				),
				array(
					'config_name' => 'wowtips_script',
					'config_value' => '0',
					'config_default' => '0',
				),
				array(
					'config_name' => 'd3tips_script',
					'config_value' => '0',
					'config_default' => '0',
				),
				array(
					'config_name' => 'tooltips_region',
					'config_value' => '0',
					'config_default' => '0',
				),
				array(
					'config_name' => 'tooltips_footer',
					'config_value' => '0',
					'config_default' => '0',
				),
				array(
					'config_name' => 'tooltips_local',
					'config_value' => '0',
					'config_default' => '0',
				),
			)),
		),
	),
	'2.0.6' => array(
		'table_row_insert'	=> array(
			array('phpbb_pbwow2_config', array(
				array(
					'config_name' => 'bg_fixed',
					'config_value' => '0',
					'config_default' => '0',
				),
				array(
					'config_name' => 'topbar_fixed',
					'config_value' => '0',
					'config_default' => '0',
				),
				array(
					'config_name' => 'navmenu_enable',
					'config_value' => '0',
					'config_default' => '0',
				),
			)),
		),
	),
	'2.0.7' => array(
		'table_row_insert'	=> array(
			array('phpbb_pbwow2_config', array(
				array(
					'config_name' => 'logo_enable',
					'config_value' => '0',
					'config_default' => '0',
				),
				array(
					'config_name' => 'logo_src',
					'config_value' => 'images/logo.png',
					'config_default' => 'images/logo.png',
				),
				array(
					'config_name' => 'logo_size_width',
					'config_value' => '300',
					'config_default' => '300',
				),
				array(
					'config_name' => 'logo_size_height',
					'config_value' => '180',
					'config_default' => '180',
				),
				array(
					'config_name' => 'logo_margins',
					'config_value' => '10px 10px 25px 10px',
					'config_default' => '10px 10px 25px 10px',
				),
			)),
		),
	),
	'2.0.8' => array(
		// no updates
	),
	'2.0.9' => array(
		'table_add' => array(
			array('phpbb_pbwow2_chars', array(
				'COLUMNS' => array(
					'id' 				=> array('UINT', NULL, 'auto_increment'),
					'user_id' 			=> array('UINT', NULL),
					'updated'			=> array('BINT', 0),
					'tries'				=> array('TINT:3', 0),
					'game'				=> array('VCHAR', ''),
					'lastModified'		=> array('BINT', 0),
					'name'				=> array('VCHAR', ''),
					'realm'				=> array('VCHAR', ''),
					'battlegroup'		=> array('VCHAR', ''),
					'class'				=> array('TINT:3', 0),
					'race'				=> array('TINT:3', 0),
					'gender'			=> array('TINT:3', 0),
					'level'				=> array('TINT:3', 0),
					'achievementPoints'	=> array('UINT', 0),
					'avatar'			=> array('VCHAR', ''),
					'avatarURL'			=> array('VCHAR', ''),
					'calcClass'			=> array('VCHAR', ''),
					'totalHK'			=> array('UINT', 0),
					'guild'				=> array('VCHAR', ''),
				),
				'PRIMARY_KEY'	=> 'id',
				'KEYS'            => array(
					'user_id'    => array('INDEX', 'user_id'),
				),
			)),
		),
		'table_row_insert'	=> array(
			array('phpbb_pbwow2_config', array(
				array(
					'config_name' => 'bnetchars_enable',
					'config_value' => '0',
					'config_default' => '0',
				),
				array(
					'config_name' => 'bnetchars_cachetime',
					'config_value' => '86400',
					'config_default' => '86400',
				),
				array(
					'config_name' => 'bnetchars_timeout',
					'config_value' => '1',
					'config_default' => '1',
				),
			)),
		),
		'cache_purge' => '',
	),
    '2.1.0' => array(

          'custom' => array(
                'tableupdates',
                'clear_caches'
            ),
    ),

);

// Include the UMIL Auto file, it handles the rest
include($phpbb_root_path . 'umil/umil_auto.' . $phpEx);


/**
 * custom SQL updates
 */
function tableupdates($action, $version)
{

    global $user, $table_prefix, $umil;
    switch ($action)
    {

        case 'install' :
        case 'update':
            switch ($version)
            {
                case '2.1.0':
                    $umil->table_row_remove(
                        $table_prefix . 'pbwow2_config',
                        array(
                            'config_name'  => 'headerlinks_code',
                        ));

                    $umil->table_row_insert(
                        $table_prefix . 'pbwow2_config',
                        array( 'config_name'  => 'headerlinks_code',
                               'config_value' => '<li class="icon-custom1"> <a href="http://pbwow.com/" target="_blank">PBWoW</a> </li> 
                                                  <li class="icon-custom2"> <a href="http://www.bbdkp.com/" target="_blank">bbDKP</a> </li>',
                               'config_default' => '<li class="icon-custom1"><a href="http://pbwow.com/" target="_blank">PBWoW</a></li><li class="icon-custom2"><a href="http://www.bbdkp.com/" target="_blank">bbDKP</a></li>',
                            )
                        );

                    break;
            }
            break;
        case 'uninstall' :
            switch ($version)
            {
                case '2.1.0':
                    break;
            }
            break;
    }
    return array('command' => sprintf($user->lang['UMIL_UPDTABLES'], $action, $version) , 'result' => 'SUCCESS');
}


/* Just a quick fix for boards that were using a male/female CPF instead of a none/male/female */
function update_pbgender($action, $version) {

	global $db, $table_prefix, $umil;

	if($umil->table_column_exists($table_prefix.'profile_fields_data', 'pf_pbgender'))
	{
		$umil->table_row_update($table_prefix.'profile_fields_data',
			array(
				'pf_pbgender'  => 2,
			),
			array(
				'pf_pbgender'  => 3,
			)
		);
	}
}


/**
 * global function for clearing cache
 */
function clear_caches($action, $version)
{
    global $umil;
    $umil->cache_purge();
    $umil->cache_purge('imageset');
    $umil->cache_purge('template');
    $umil->cache_purge('theme');
    $umil->cache_purge('auth');
    return 'UMIL_CACHECLEARED';
}

