<?php
/**
 *
 * @author hollodotme
 */

namespace hollodotme\Readis;

use hollodotme\Readis\Configs\AppConfig;
use hollodotme\Readis\Configs\ServersConfig;
use hollodotme\Readis\StringUnserializers\NullUnserializer;

require(__DIR__ . '/../vendor/autoload.php');

error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

$appConfig    = new AppConfig();
$servers      = new ServersConfig();
$serverIndex  = intval( $_REQUEST['server'] );
$serverConfig = $servers->getServerConfigs()[ $serverIndex ];
$connection   = new ServerConnection( $serverConfig );
$manager      = new ServerManager( $connection );

switch ( $_REQUEST['action'] )
{
	case 'getKeys':
	{
		$database   = $_REQUEST['database'];
		$limit      = $_REQUEST['limit'];
		$keyPattern = $_REQUEST['keyPattern'] ?: '*';

		if ( $limit == 'all' )
		{
			$limit = null;
		}
		else
		{
			$limit = abs( intval( $limit ) );
		}

		$manager->selectDatabase( $database );
		$keyInfoObjects = $manager->getKeyInfoObjects( $keyPattern, $limit );

		$page = new TwigPage(
			'Includes/KeyList.twig',
			[
				'appConfig'      => $appConfig,
				'keyInfoObjects' => $keyInfoObjects,
				'database'       => $database,
				'serverIndex'    => $serverIndex,
			]
		);
		$page->respond();

		break;
	}

	case 'getKeyData':
	{
		$key      = $_REQUEST['key'];
		$hashKey  = $_REQUEST['hashKey'];
		$database = $_REQUEST['database'];

		$manager->selectDatabase( $database );

		if ( empty($hashKey) )
		{
			$keyData = $manager->getValueAsUnserializedString( $key, new NullUnserializer() );
		}
		else
		{
			$keyData = $manager->getHashValueAsUnserializedString( $key, $hashKey, new NullUnserializer() );
		}

		$keyInfo = $manager->getKeyInfoObject( $key );

		$page = new TwigPage(
			'Includes/KeyData.twig',
			[
				'appConfig'   => $appConfig,
				'keyData'     => $keyData,
				'keyInfo'     => $keyInfo,
				'database'    => $database,
				'serverIndex' => $serverIndex,
				'hashKey'     => $hashKey,
			]
		);
		$page->respond();

		break;
	}
}