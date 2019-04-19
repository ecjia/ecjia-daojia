/**
 * ecjia hook form RC_Hook
 */
;(function(ecjia) {

    var EcjiaHooks = function() {
        // Ensure this function is used like a constructor.
        if ( ! ( this instanceof EcjiaHooks ) ) {
            return new EcjiaHooks();
        }

        // Object for data storage.
        this._hooks = {
            actions: {},
            filters: {}
        };

        // Add action/filter functions.
        this.add_action = createAddHook( this._hooks.actions );
        this.add_filter = createAddHook( this._hooks.filters );

        // Remove action/filter functions.
        this.remove_action = createRemoveHook( this._hooks.actions );
        this.remove_filter = createRemoveHook( this._hooks.filters );

        // Has action/filter functions.
        this.has_action = createHasHook( this._hooks.actions );
        this.has_filter = createHasHook( this._hooks.filters );

        // Remove all actions/filters functions.
        this.remove_all_actions = createRemoveHook( this._hooks.actions, true );
        this.remove_all_filters = createRemoveHook( this._hooks.filters, true );

        // Do action/apply filters functions.
        this.do_action     = createRunHook( this._hooks.actions );
        this.apply_filters = createRunHook( this._hooks.filters, true );

        // Current action/filter functions.
        this.current_action = createCurrentHook( this._hooks.actions );
        this.current_filter = createCurrentHook( this._hooks.filters );

        // Doing action/filter: true while a hook is being run.
        this.doing_action = createDoingHook( this._hooks.actions );
        this.doing_filter = createDoingHook( this._hooks.filters );

        // Did action/filter functions.
        this.did_action = createDidHook( this._hooks.actions );
        this.did_filter = createDidHook( this._hooks.filters );
    };

    ecjia.hook = new EcjiaHooks();

    /**
     * Returns a function which, when invoked, will add a hook.
     *
     * @param  {Object}   hooks Stored hooks, keyed by hook name.
     *
     * @return {Function}       Function that adds a new hook.
     */
    function createAddHook( hooks ) {
        /**
         * Adds the hook to the appropriate hooks container.
         *
         * @param {string}   hookName Name of hook to add
         * @param {Function} callback Function to call when the hook is run
         * @param {?number}  priority Priority of this hook (default=10)
         */
        return function addHook( hookName, callback, priority ) {

            priority = ecjia._default(priority, 10);

            if ( typeof hookName !== 'string' ) {
                console.error( 'The hook name must be a string.' );
                return;
            }

            if ( /^__/.test( hookName ) ) {
                console.error( 'The hook name cannot begin with `__`.' );
                return;
            }

            if ( typeof callback !== 'function' ) {
                console.error( 'The hook callback must be a function.' );
                return;
            }

            // Validate numeric priority
            if ( typeof priority !== 'number' ) {
                console.error( 'If specified, the hook priority must be a number.' );
                return;
            }

            var handler = {callback: callback, priority: priority };

            if ( hooks.hasOwnProperty( hookName ) ) {
                // Find the correct insert index of the new hook.
                var handlers = hooks[ hookName ].handlers;
                var i = 0;
                while ( i < handlers.length ) {
                    if ( handlers[ i ].priority > priority ) {
                        break;
                    }
                    i++;
                }
                // Insert (or append) the new hook.
                handlers.splice( i, 0, handler );
                // We may also be currently executing this hook.  If the callback
                // we're adding would come after the current callback, there's no
                // problem; otherwise we need to increase the execution index of
                // any other runs by 1 to account for the added element.
                ( hooks.__current || [] ).forEach( function (hookInfo)  {
                    if ( hookInfo.name === hookName && hookInfo.currentIndex >= i ) {
                        hookInfo.currentIndex++;
                    }
                } );
            } else {
                // This is the first hook of its type.
                hooks[ hookName ] = {
                    handlers: [ handler ],
                    runs: 0
                };
            }
        };
    }


    /**
     * Returns a function which, when invoked, will return the name of the
     * currently running hook, or `null` if no hook of the given type is currently
     * running.
     *
     * @param  {Object}   hooks          Stored hooks, keyed by hook name.
     *
     * @return {Function}                Function that returns the current hook.
     */
    function createCurrentHook( hooks, returnFirstArg ) {
        /**
         * Returns the name of the currently running hook, or `null` if no hook of
         * the given type is currently running.
         *
         * @return {?string}             The name of the currently running hook, or
         *                               `null` if no hook is currently running.
         */
        return function currentHook() {
            if ( ! hooks.__current || ! hooks.__current.length ) {
                return null;
            }

            return hooks.__current[ hooks.__current.length - 1 ].name;
        };
    }

    /**
     * Returns a function which, when invoked, will return the number of times a
     * hook has been called.
     *
     * @param  {Object}   hooks Stored hooks, keyed by hook name.
     *
     * @return {Function}       Function that returns a hook's call count.
     */
    function createDidHook( hooks ) {
        /**
         * Returns the number of times an action has been fired.
         *
         * @param  {string} hookName The hook name to check.
         *
         * @return {number}          The number of times the hook has run.
         */
        return function didHook( hookName ) {
            return hooks.hasOwnProperty( hookName ) && hooks[ hookName ].runs
                ? hooks[ hookName ].runs
                : 0;
        };
    }

    /**
     * Returns a function which, when invoked, will return whether a hook is
     * currently being executed.
     *
     * @param  {Object}   hooks Stored hooks, keyed by hook name.
     *
     * @return {Function}       Function that returns whether a hook is currently
     *                          being executed.
     */
    function createDoingHook( hooks ) {
        /**
         * Returns whether a hook is currently being executed.
         *
         * @param  {?string} hookName The name of the hook to check for.  If
         *                            omitted, will check for any hook being executed.
         *
         * @return {bool}             Whether the hook is being executed.
         */
        return function doingHook( hookName ) {
            // If the hookName was not passed, check for any current hook.
            if ( 'undefined' === typeof hookName ) {
                return 'undefined' !== typeof hooks.__current[0];
            }

            // Return the __current hook.
            return hooks.__current[0]
                ? hookName === hooks.__current[0].name
                : false;
        };
    }

    /**
     * Returns a function which, when invoked, will return whether any handlers are
     * attached to a particular hook.
     *
     * @param  {Object}   hooks Stored hooks, keyed by hook name.
     *
     * @return {Function}       Function that returns whether any handlers are
     *                          attached to a particular hook.
     */
    function createHasHook( hooks ) {
        /**
         * Returns how many handlers are attached for the given hook.
         *
         * @param  {string}  hookName The name of the hook to check for.
         *
         * @return {number}           The number of handlers that are attached to
         *                            the given hook.
         */
        return function hasHook( hookName ) {
            return hooks.hasOwnProperty( hookName )
                ? hooks[ hookName ].handlers.length
                : 0;
        };
    }

    /**
     * Returns a function which, when invoked, will remove a specified hook or all
     * hooks by the given name.
     *
     * @param  {Object}   hooks      Stored hooks, keyed by hook name.
     * @param  {bool}     removeAll  Whether to remove all hooked callbacks.
     *
     * @return {Function}            Function that removes hooks.
     */
    function createRemoveHook( hooks, removeAll ) {
        /**
         * Removes the specified callback (or all callbacks) from the hook with a
         * given name.
         *
         * @param {string}    hookName The name of the hook to modify.
         * @param {?Function} callback The specific callback to be removed.  If
         *                             omitted (and `removeAll` is truthy), clears
         *                             all callbacks.
         *
         * @return {number}            The number of callbacks removed.
         */
        return function removeHook( hookName, callback ) {
            if ( ! removeAll && typeof callback !== 'function' ) {
                console.error( 'The hook callback to remove must be a function.' );
                return;
            }

            // Bail if no hooks exist by this name
            if ( ! hooks.hasOwnProperty( hookName ) ) {
                return 0;
            }

            var handlersRemoved = 0;

            if ( removeAll ) {
                handlersRemoved = hooks[ hookName ].handlers.length;
                hooks[ hookName ] = {
                    runs: hooks[ hookName ].runs,
                    handlers: []
                };
            } else {
                // Try to find the specified callback to remove.
                var handlers = hooks[ hookName ].handlers;
                for ( var i = handlers.length - 1; i >= 0; i-- ) {
                    if ( handlers[ i ].callback === callback ) {
                        handlers.splice( i, 1 );
                        handlersRemoved++;
                        // This callback may also be part of a hook that is
                        // currently executing.  If the callback we're removing
                        // comes after the current callback, there's no problem;
                        // otherwise we need to decrease the execution index of any
                        // other runs by 1 to account for the removed element.
                        ( hooks.__current || [] ).forEach( function (hookInfo) {
                            if ( hookInfo.name === hookName && hookInfo.currentIndex >= i ) {
                                hookInfo.currentIndex--;
                            }
                        } );
                    }
                }
            }

            return handlersRemoved;
        };
    }


    /**
     * Returns a function which, when invoked, will execute all callbacks
     * registered to a hook of the specified type, optionally returning the final
     * value of the call chain.
     *
     * @param  {Object}   hooks          Stored hooks, keyed by hook name.
     * @param  {?bool}    returnFirstArg Whether each hook callback is expected to
     *                                   return its first argument.
     *
     * @return {Function}                Function that runs hook callbacks.
     */
    function createRunHook( hooks, returnFirstArg ) {
        /**
         * Runs all callbacks for the specified hook.
         *
         * @param  {string} hookName The name of the hook to run.
         * @param  {...*}   args     Arguments to pass to the hook callbacks.
         *
         * @return {*}               Return value of runner, if applicable.
         */
        return function runHooks() {

            var args = Array.prototype.slice.call(arguments);
            var hookName = args.shift();

            if ( typeof hookName !== 'string' ) {
                console.error( 'The hook name must be a string.' );
                return;
            }

            if ( /^__/.test( hookName ) ) {
                console.error( 'The hook name cannot begin with `__`.' );
                return;
            }

            if ( ! hooks.hasOwnProperty( hookName ) ) {
                hooks[ hookName ] = {
                    runs: 0,
                    handlers: []
                };
            }

            var handlers = hooks[ hookName ].handlers;

            if ( ! handlers.length ) {
                return returnFirstArg
                    ? args[ 0 ]
                    : undefined;
            }

            var hookInfo = {
                name: hookName,
                currentIndex: 0
            };

            hooks.__current = hooks.__current || [];
            hooks.__current.push( hookInfo );
            hooks[ hookName ].runs++;

            var maybeReturnValue = args[ 0 ];

            while ( hookInfo.currentIndex < handlers.length ) {
                var handler = handlers[ hookInfo.currentIndex ];
                maybeReturnValue = handler.callback.apply( null, args );
                if ( returnFirstArg ) {
                    args[ 0 ] = maybeReturnValue;
                }
                hookInfo.currentIndex++;
            }

            hooks.__current.pop();

            if ( returnFirstArg ) {
                return maybeReturnValue;
            }
        };
    }

})(ecjia);

