<?php

/*
 * This file is part of MailSo.
 *
 * (c) 2014 Usenko Timur
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MailSo\Cache\Drivers;

/**
 * @category MailSo
 * @package Cache
 * @subpackage Drivers
 */
class APC implements \MailSo\Cache\DriverInterface
{
	/**
	 * @return \MailSo\Cache\Drivers\APC
	 */
	public static function NewInstance()
	{
		return new self();
	}

	/**
	 * @param string $sKey
	 * @param string $sValue
	 *
	 * @return bool
	 */
	public function Set($sKey, $sValue)
	{
		return \apc_store($this->generateCachedKey($sKey), (string) $sValue);
	}

	/**
	 * @param string $sKey
	 *
	 * @return string
	 */
	public function Get($sKey)
	{
		$sValue = \apc_fetch($this->generateCachedKey($sKey));
		return \is_string($sValue) ? $sValue : '';
	}

	/**
	 * @param string $sKey
	 *
	 * @return void
	 */
	public function Delete($sKey)
	{
		\apc_delete($this->generateCachedKey($sKey));
	}

	/**
	 * @param int $iTimeToClearInHours = 24
	 * 
	 * @return bool
	 */
	public function GC($iTimeToClearInHours = 24)
	{
		if (0 === $iTimeToClearInHours)
		{
			return \apc_clear_cache('user');
		}
		
		return false;
	}

	/**
	 * @param string $sKey
	 *
	 * @return string
	 */
	private function generateCachedKey($sKey)
	{
		return \sha1($sKey);
	}
}
