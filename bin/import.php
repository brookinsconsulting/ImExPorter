<?php

set_time_limit( 0 );

require 'autoload.php';

$cli          = eZCLI::instance();

$script = eZScript::instance(array(
    'use-session'    => false,
    'use-modules'    => true,
    'use-extensions' => true
));

$imExPorter = new ImExPorter();

$imExPorter->import();

//-- final shutdown
$cli->output( "Done." );
$script->shutdown();