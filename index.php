<?php
/**
 * This is the primary bootstrapper for CiiMS. Almost every option is derived from the
 * configuration file or the default configuration file. This bootstrapper also disables error
 * reporting so that E_NOTICES and non-fatal errors don't crash it.
 *
 * You should _never_ have to change _anything_ in this file _ever_
 *
 * @package    CiiMS Content Management System
 * @author     Charles R. Portwood II <charlesportwoodii@ethreal.net>
 * @copyright  Charles R. Portwood II <https://www.erianna.com> 2012-2014
 * @license    http://opensource.org/licenses/MIT  MIT LICENSE
 * @link       https://github.com/charlesportwoodii/CiiMS
 */

// Disable Error Reporting and set some constants
error_reporting(0);
ini_set('display_errors', 'false');
defined('DS') or define('DS', DIRECTORY_SEPARATOR);

// This is the configuration file
$config=__DIR__.DS.'protected'.DS.'config'.DS.'main.php';
$defaultConfig=__DIR__.DS.'protected'.DS.'config'.DS.'main.default.php';

// If we don't have a configuration file, run the installer.
if (!file_exists($config) && file_exists('install.php'))
{
	require('install.php');
	exit();
}

$params = require($config);
defined('YII_DEBUG') or define('YII_DEBUG',isset($params['params']['debug']) ? $params['params']['debug'] : false);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',isset($params['params']['trace']) ? $params['params']['trace'] : 0);

// Load the config file
$config = require($config);
$defaultConfig = require($defaultConfig);

// Include the composer dependencies
require_once __DIR__.DS.'vendor'.DS.'autoload.php';
require_once __DIR__.DS.'vendor'.DS.'yiisoft'.DS.'yii'.DS.'framework'.DS.(YII_DEBUG ? 'yii.php' : 'yiilite.php');

Yii::setPathOfAlias('vendor', __DIR__.DS.'vendor');

// Merge it with our default config file
$config = CMap::mergeArray($defaultConfig, $config);

// Include the ClassMap for enhanced performance if we're not in debug mode
if (!YII_DEBUG)
	require_once __DIR__.DS.'protected'.DS.'config'.DS.'classmap.php';

$config['components']['db']['enableProfiling'] = YII_DEBUG;
$config['components']['db']['enableParamLogging'] = YII_DEBUG;

// If debug mode is enabled, show us every possible error anywhere.
if (YII_DEBUG && YII_TRACE_LEVEL == 3)
{
	error_reporting(-1);
	ini_set('display_errors', 'true');

	// Enable WebLogRouteLogging
	$config['preload'][] = 'log';

	// Enable all the logging routes
	foreach ($config['components']['log']['routes'] as $k=>$v)
		$config['components']['log']['routes'][$k]['enabled'] = YII_DEBUG;
}

// Run the Yii application instance
Yii::createWebApplication($config)->run();
