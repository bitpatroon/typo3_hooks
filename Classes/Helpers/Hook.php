<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2020 Sjoerd Zonneveld  <typo3@bitpatroon.nl>
 *  Date: 6-4-2020 21:16
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

namespace Bitpatroon\Typo3Hooks\Helpers;

use TYPO3\CMS\Core\SingletonInterface;

/**
 * Instance of HooksHelper
 * @package Bitpatroon\Typo3Hooks\Helpers
 */
class Hook implements SingletonInterface
{
    public function processHook($class, $hookID, &$params = [])
    {
        HooksHelper::processHook($class, $hookID, $params);
    }

    /**
     * Converts a class, instance, object or name into a name
     * @param object|mixed|string $class
     * @return string
     */
    public function getHookClassName($class)
    {
        return HooksHelper::getHookClassName($class);
    }

    /**
     * checks if hookId has connected hooks
     * @param string|object|mixed $className
     * @param string              $hookID The ID of a hook
     * @return bool
     */
    public static function hasHooksConnected($className, $hookID)
    {
        return HooksHelper::hasHooksConnected($className, $hookID);
    }

    /**
     * Gets the amount of connected hooks
     * @param string|object|mixed $className
     * @param string              $hookID The ID of a hook
     * @return bool|int
     */
    public static function getConnectedHooks($className, $hookID)
    {
        return HooksHelper::getConnectedHooks($className, $hookID);
    }

    /**
     * Processes the hook and returns any result returned in the params array with the key result
     * @param object|string $class the instance of a class
     * @param string        $hookId
     * @param array         $parameters
     * @return bool the result of the hook
     */
    public static function processHookWithResult($class, $hookId, &$parameters)
    {
        return HooksHelper::processHookWithResult($class, $hookId, $parameters);
    }
}
