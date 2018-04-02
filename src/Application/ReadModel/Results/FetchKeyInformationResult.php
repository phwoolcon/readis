<?php declare(strict_types=1);

namespace hollodotme\Readis\Application\ReadModel\Results;

use hollodotme\Readis\Application\Interfaces\ProvidesKeyInformation;

final class FetchKeyInformationResult extends AbstractResult
{
	/** @var string */
	private $rawKeyData;

	/** @var string */
	private $keyData;

	/** @var ProvidesKeyInformation */
	private $keyInfo;

	public function getRawKeyData() : string
	{
		return $this->rawKeyData;
	}

	public function setRawKeyData( string $rawKeyData ) : void
	{
		$this->rawKeyData = $rawKeyData;
	}

	public function getKeyData() : string
	{
		return $this->keyData;
	}

	public function setKeyData( string $keyData ) : void
	{
		$this->keyData = $keyData;
	}

	public function getKeyInfo() : ProvidesKeyInformation
	{
		return $this->keyInfo;
	}

	public function setKeyInfo( ProvidesKeyInformation $keyInfo ) : void
	{
		$this->keyInfo = $keyInfo;
	}
}
