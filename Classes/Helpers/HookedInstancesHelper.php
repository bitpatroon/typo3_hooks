<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2018 Sjoerd Zonneveld <typo3@bitpatroon.nl>
 *  Date: 7-2-2018 11:29
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

class HookedInstancesHelper
{
    /**
     * HookedInstancesHelper constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        throw new \Exception('Class cannot be instantiated.', 1517999376);
    }

    /**
     * Method executes a method on a series of $instances all with similar arguments
     * @param object[] $instances  the collection of instances to execute upon.
     * @param string   $methodName the name of the method
     * @param mixed    $parameters the parameters array. optional.
     * @return array results
     * @throws \ReflectionException
     */
    public static function executeMethod($instances, $methodName, $parameters)
    {
        $result = [];

        if (empty($instances)) {
            return $result;
        }

        foreach ($instances as $instance) {
            if (empty($instance)) {
                continue;
            }
            if (!empty($parameters)) {
                if (!is_array($parameters)) {
                    continue;
                }
            }

            if (method_exists($instance, $methodName)) {
                /** @var \ReflectionMethod $reflectionMethod */
                $reflectionMethod = new \ReflectionMethod(get_class($instances), $methodName);
                $result[] = $reflectionMethod->invokeArgs($instance, $parameters);
            }
        }

        return $result;
    }


    /**
     * Method executes a method on a series of $instances all with similar arguments
     * @param string $class         the name of the class a/o the instance that tries to retrieve all hooked instances
     * @param string $hookID        the name of the hook containing the collection of names to be hooked.
     * @param string $interfaceName optionally the name of the interface the hooked class must implement.
     * @return object[] A collection of instances
     */
    public static function getHookedInstances($class, $hookID, $interfaceName = '')
    {
        $result = [];

        if (empty($class)) {
            throw new \InvalidArgumentException('Invalid value for $class', 1518000484);
        }

        $className = \SPL\SplHooks\Helpers\HooksHelper::getHookClassName($class);
        if (empty($className)) {
            return $result;
        }

        /** @var string[] $hookedInstanceNames */
        $hookedInstanceNames = $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][$className][$hookID];
        if (empty($hookedInstanceNames)) {
            return $result;
        }

        foreach ($hookedInstanceNames as $hookedInstanceName) {
            if (!is_string($hookedInstanceName)) {
                continue;
            }
            $hookedInstance = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance($hookedInstanceName);
            if (empty($hookedInstance)) {
                continue;
            }

            if (self::instanceImplements($hookedInstance, $interfaceName) === false) {
                continue;
            }

            $result[] = $hookedInstance;
        }

        return $result;
    }

    /**
     * Method checks if the instance implements interface $interfaceName
     * @param object $instance      the instance to check
     * @param string $interfaceName the name of the instance to check for
     * @return bool|null true, false if it does or not implement. Null if interfaceName is empty.
     */
    public static function instanceImplements($instance, $interfaceName)
    {
        if (empty($instance)) {
            return false;
        }
        if (empty($interfaceName)) {
            return null;
        }

        $interfaces = class_implements($instance);
        return in_array($interfaceName, $interfaces);
    }

}