<?php

define('DEBUG', true);

define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'ruah');
define('DB_USER', 'root');
define('DB_PASSWORD', '');

define('DEFAULT_CONTROLLER', 'Home');	// default controller if there isn't one defined in the url
define('DEFAULT_LAYOUT', 'default');	// if no layout is set in the controller, use this layout

define('PROOT', '/ruah/');		// set this to '/' for a live server

define('SITE_TITLE', 'Ruah MVC Framework');		// this wiil be used if no site title is set