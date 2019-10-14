<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2015 Sjoerd Zonneveld <typo3@bitpatroon.nl>
 *  Date: 14-7-2015 14:59
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

class HooksHelper
{
    /**
     * HooksHelper constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        throw new \Exception('Class cannot be instantiated.', 15195151923);
    }

    /**
     * Method handles a hook
     * @param object|string $class  the instance of a class
     * @param string        $hookID The ID of a hook
     * @param array         $params the params to pass to the hooked function
     */
    public static function processHook($class, $hookID, &$params = [])
    {

        $className = self::getHookClassName($class);

        if (!self::hasHooksConnected($className, $hookID)) {
            return;
        }

        // Hook before revert
        ksort($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][$className][$hookID], SORT_STRING);
        foreach ($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][$className][$hookID] as $_funcRef) {
            if ($_funcRef) {
                \TYPO3\CMS\Core\Utility\GeneralUtility::callUserFunction($_funcRef, $params, $class);
            }
        }
    }

    /**
     * Converts a class, instance, object or name into a name
     * @param object|mixed|string $class
     * @return string
     */
    public static function getHookClassName($class)
    {
        if (empty($class)) {
            throw new \InvalidArgumentException('Invalid value for $class', 15195150025);
        }

        $className = '';
        if (is_array($class)) {
            throw new \InvalidArgumentException('Invalid value for $class. Expected object instance.', 1511185358);
        }

        if (is_object($class)) {
            $className = get_class($class);
        } else {
            if (is_string($class)) {
                $className = $class;
            }
        }
        if (empty($className)) {
            throw new \InvalidArgumentException('Invalid value for $class. Expected object instance.', 15195151637);
        }

        return $className;
    }

    /**
     * checks if hookId has connnected hooks
     * @param string|object|mixed $className
     * @param string              $hookID The ID of a hook
     * @return bool
     */
    public static function hasHooksConnected($className, $hookID)
    {
        if (empty($className)) {
            throw new \InvalidArgumentException('Invalid value for $className', 1516360138);
        }
        if (!is_string($className)) {
            $className = self::getHookClassName($className);
        }

        if (empty($hookID)) {
            throw new \InvalidArgumentException('Invalid value for $hookID', 15195150018);
        }


        // Hook before revert
        if (is_array($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][$className][$hookID])) {
            if (!empty($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][$className][$hookID])) {
                return true;
            }
        }
        return false;
    }

    /**
     * Gets the amount of connected hooks
     * @param string|object|mixed $className
     * @param string              $hookID The ID of a hook
     * @return bool|int
     */
    public static function getConnectedHooks($className, $hookID)
    {
        if (empty($className)) {
            throw new \InvalidArgumentException('Invalid value for $className', 1516360138);
        }
        if (!is_string($className)) {
            $className = self::getHookClassName($className);
        }

        if (empty($hookID)) {
            throw new \InvalidArgumentException('Invalid value for $hookID', 15195150018);
        }


        // Hook before revert
        if (is_array($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][$className][$hookID])) {
            if (!empty($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][$className][$hookID])) {
                return count($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][$className][$hookID]);
            }
        }
        return 0;
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
        self::processHook($class, $hookId, $parameters);
        if (!isset($parameters['result'])) {
            return null;
        }
        $result = !empty($parameters['result']);
        return $result;
    }
}
