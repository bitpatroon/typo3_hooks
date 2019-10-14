# typo3_hooks
Hooks mechanism for TYPO3

Usage: 

## processHook
To call a hook, simple add the following code in any class of your code. 

    \Bitpatroon\Typo3Hooks\Helpers\HooksHelper::processHook(<class>, <hookname>, [<params>]);

* Class (I) can be the instance, the static reference or the classname i.e.
    * $this 
    * self
    * \VENDOR\CALLING_HOOK_CLASS::class
* Hookname (II) is the name of the hook is the hook, 
* Params (III) is a y reference passed array with values for the hook.   

## Register the hook

In your or any localconf.php, add the hook. 

     $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\VENDOR\CALLING_HOOK_CLASS::class] = [
            'className' => \VENDOR\CALLED_CLASS::class
     ];

* CALLING_HOOK_CLASS is the name of the class, as specified in (I).
* CALLED_CLASS is the name of the class, handling the hook

## The class with the hook
Add a TYPO3 class CALLED_CLASS with the following code.
    
    namespace VENDOR;
    
    class CALLED_CLASS
        
        /**
         * Hook
         * @param array $params The parameter Array
         * @param object $ref   The parent object
         */
        public function MyHook(&$params, $ref)
        {
        
        }
    }

Notice the $params is by reference. Changing the content affects the original array. 
$ref is the calling class. See (I). 

Notice: Don't forget to reset the cache! 