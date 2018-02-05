# Description

This package gives you the possibily to add gearman as native queue back-end service

#Installation

first you need to add it to your composer.json

second, in `config/provider.php`, you need to comment out the native queue service provider

    //'Royalcms\Component\Queue\QueueServiceProvider',

and to put this instead:

    'Royalcms\Component\Gearman\GearmanServiceProvider',

Then in your config/queue.php file you can add:

    'default' => 'gearman',
    'connections' => array(
        'gearman' => array(
            'driver' => 'gearman',
            'host'   => 'localserver.6min.local',
            'queue'  => 'default',
            'port'   => 4730,
            'timeout' => 1000 //milliseconds
        )
    )

or, if you have multiple gearman servers:

    'default' => 'gearman',
    'connections' => array(
        'gearman' => array(
            'driver' => 'gearman',
            'hosts'  => array(
                array('host' => 'localserver.6min.local', 'port' => 4730),
                array('host' => 'localserver2.6min.local', 'port' => 4730),
            ),
            'queue'  => 'default',
            'timeout' => 1000 //milliseconds
        )
    )

Then in your code you can add code as (this is the native way to add jobs to the queue):

    Queue::push('SomeClass', array('message' => 'The data that should be available in the SomeClass@fire method'));

Small hint, you can call Namespaced classes and everything that is written in the docs of laravel for calling custom methods is valid here, too.


# Example:

I add a "service" folder to my app folder and inside I create a file "SendMail.php"
The code of the class is here:

    <?php

    namespace TaskProcess\Services;

    class SendMail {

        public function fire($job, $data)
        {
            //I send an email to my email address with subject "gearman test" and message whatever comes from gearman
            mail('pavel@taskprocess.com', 'gearman test', $data['message']);
        }

    }

In my routes file I add a new Route


    RC_Route::get('/gearman', function() {
        //in a loop I add 3 jobs to gearman with different content. The purpose is to see 3 different emails with 3 different contents
        foreach (array(1,2,3) as $row) {
            RC_Queue::push('TaskProcess\Services\SendMail', array('message' => 'Message №' . $row));
        }
    });

Finally I just run on my console:

    php royalcms queue:listen

And I go to check what's on my email

#Bugs

Please if you notice a bug open an issue or submit request. 

Hope this package will help you
