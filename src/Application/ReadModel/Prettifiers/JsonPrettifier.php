<?php declare(strict_types=1);

namespace hollodotme\Readis\Application\ReadModel\Prettifiers;

use hollodotme\Readis\Application\ReadModel\Interfaces\PrettifiesString;
use function json_decode;
use function json_encode;
use function json_last_error;
use function preg_match;
use const JSON_ERROR_NONE;
use const JSON_PRETTY_PRINT;
use const JSON_UNESCAPED_SLASHES;

final class JsonPrettifier implements PrettifiesString
{
	public function canPrettify( string $data ) : bool
	{
		return (bool)preg_match( '#^({|\[).+(}|\])$#', $data );
	}

	public function prettify( string $data ) : string
	{
		$jsonData  = json_decode( $data );
		$jsonError = json_last_error();

		if ( JSON_ERROR_NONE === $jsonError )
		{
			return json_encode( $jsonData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES );
		}

		return $data;
	}
}
