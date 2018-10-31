<?php

/** @deprecated use WPSID::OPTION_KEY */
define('OPENSID_OPTION_KEY', WPSID::OPTION_KEY);

/** @deprecated */
define('OPENSID_ABSPATH', WPSID_DIR);

/** @deprecated */
define('OPENSID_APPPATH', WPSID_DIR);

define('BASEPATH', WPSID::config('ci_sys_path'));
define('APPPATH', WPSID_DIR);
define('FCPATH', '/');
define('VIEWPATH', WPSID_DIR .'views/');
define('ENVIRONMENT', WP_DEBUG ? 'development' : 'production');

define('MB_ENABLED', extension_loaded('mbstring'));
define('ICONV_ENABLED', extension_loaded('iconv'));
