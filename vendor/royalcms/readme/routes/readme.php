<?php

if ( RC_Config::get('readme::readme.route') ) {
    RC_Route::get(RC_Config::get('readme::readme.route.prefix'), RC_Config::get('readme::readme.route.action'))
        ->name(RC_Config::get('readme::readme.route.name'));
}
