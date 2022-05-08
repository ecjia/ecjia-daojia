Using Swift Mailer for Japanese Emails
======================================

To send emails in Japanese, you need to tweak the default configuration.

<<<<<<< HEAD
After requiring the Swift Mailer autoloader (by including the
``swift_required.php`` file), call the ``Swift::init()`` method with the
following code::

    require_once '/path/to/swift-mailer/lib/swift_required.php';
=======
Call the ``Swift::init()`` method with the following code as early as possible
in your code::
>>>>>>> v2-test

    Swift::init(function () {
        Swift_DependencyContainer::getInstance()
            ->register('mime.qpheaderencoder')
            ->asAliasOf('mime.base64headerencoder');

        Swift_Preferences::getInstance()->setCharset('iso-2022-jp');
    });

    /* rest of code goes here */

That's all!
