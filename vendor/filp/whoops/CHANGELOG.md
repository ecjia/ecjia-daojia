# 2.9.2

* Fix copy button styles

# 2.9.1

* Fix xdebug function crash on PHP 8

# 2.9.0

* JsonResponseHandler includes the exception code

# 2.8.0

* Support PHP 8

# 2.7.3

* PrettyPageHandler functionality to hide superglobal keys has a clearer name hideSuperglobalKey

# 2.7.2

* PrettyPageHandler now accepts custom js files
* PrettyPageHandler templateHelper is now accessible through inheritance

# 2.7.1

* Fix a PHP warning in some cases with anonymous classes.

# 2.7.0

* removeFirstHandler and removeLastHandler.

# 2.6.0

* Fix 2.4.0 pushHandler changing the order of handlers.

# 2.5.1

* Fix error messaging in a rare case.

# 2.5.0

* Automatically configure xdebug if available.

# 2.4.1

* Try harder to close all output buffers

# 2.4.0

* Allow to prepend and append handlers.

# 2.3.2

* Various fixes from the community.

# 2.3.1

* Prevent exception in Whoops when caught exception frame is not related to real file

# 2.3.0

* Show previous exception messages.

# 2.2.0

* Support PHP 7.2

# 2.1.0

* Add a `SystemFacade` to allow clients to override Whoops behavior.
* Show frame arguments in `PrettyPageHandler`.
* Highlight the line with the error.
* Add icons to search on Google and Stack Overflow.

# 2.0.0

Backwards compatibility breaking changes:

* `Run` class is now `final`. If you inherited from `Run`, please now instead use a custom `SystemFacade` injected into the `Run` constructor, or contribute your changes to our core.
* PHP < 5.5 support dropped.
