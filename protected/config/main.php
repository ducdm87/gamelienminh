<?php

define("TBL_MENU", "{{menus}}");
define("TBL_MENU_ITEM", "{{menu_item}}");
define("TBL_ARTICLES", "{{articles}}");
define("TBL_CATEGORIES", "{{categories}}");
define("TBL_EXTENSIONS", "{{extensions}}");
define("TBL_MODULES", "{{modules}}");
define("TBL_MODULE_MENUITEM_REF", "{{module_menuitem_ref}}");
define("TBL_SESSION", "{{session}}");
define("TBL_USERS", "{{users}}");
define("TBL_USERS_GROUP", "{{users_group}}");
define("TBL_VIDEOS", "{{videos}}");
define("TBL_LOCATIONS", "{{locations}}");
define("TBL_MODULE_POSITION", "{{module_position}}");
define("TBL_RSM_RESOURCES", "{{rsm_resources}}");
define("TBL_RSM_RESOURCE_XREF", "{{rsm_resource_xref}}");

define("TBL_GS_GROUPS", "{{gs_groups}}");
define("TBL_GS_MATCHES", "{{gs_matches}}");
define("TBL_GS_MATCHE_DETAIL", "{{gs_matche_detail}}");
define("TBL_GS_PLAYERS", "{{gs_players}}");
define("TBL_GS_PLAYER_REGISTER_TEAM", "{{gs_player_register_team}}");
define("TBL_GS_RANKS", "{{gs_ranks}}");
define("TBL_GS_TEAMS", "{{gs_teams}}");
define("TBL_GS_TEAM_REGISTER_TOUR", "{{gs_team_register_tour}}");
define("TBL_GS_TOURNAMEMANTS", "{{gs_tournamemants}}");

return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'My Web Application',
    'preload' => array('log'),
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.includes.*',
        'application.includes.jui.*',
        'application.includes.libs.*',
        'application.includes.html.*',
        'application.includes.html.elements.*',
        'application.includes.objects.*',
        ),
    'modules' => array(
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'admin',
            'generatorPaths' => array(
                'ext.gtc'),
            'ipFilters' => array('127.0.0.1', '::1'),
            'newFileMode' => 0666,
            'newDirMode' => 0777,
        ),
        'tophits',
    ),
    'defaultController' => 'index',
    'behaviors' => array(
        'runEnd' => array(
            'class' => 'application.components.WebApplicationEndBehavior',
        ),
    ),
    'components' => array(
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'caseSensitive' => false,
        ),
        'user' => array(
            'allowAutoLogin' => true,
        ),
        'db' => array(
            'connectionString' => 'mysql:dbname=dev_gamesport;host=192.168.1.12',
            'emulatePrepare' => true,
            'username' => 'dev_gamesport',
            'password' => 'dev_gamesport',
            'charset' => 'utf8',
            'tablePrefix' => 'tbl_',
        ),
        'errorHandler' => array(
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            ),
        ),
    ),
    'params' => array(
        'adminEmail' => 'ducdm87@gmail.com',
        'copyright' => '1',
        'permission' => '0',
    ),
);
