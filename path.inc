<?php
$path = '/usr/local/lib/system_libs';
    if (file_exists('local.ini'))
    {
        $parse = parse_ini_file('local.ini',true);
        if (isset($parse['paths']))
        {
            $path = $parse['paths']['libraries'];
        }
        else
        {
<<<<<<< HEAD
           trigger_error("local.ini missing paths field\n",E_USER_NOTICE);
=======
           trigger_error("local.ini missing paths field\n",E_USER_NOTICE); 
>>>>>>> 317f86f6b05959445308342d255c84d84fe2cbdf
        }
    }
    set_include_path(get_include_path().PATH_SEPARATOR.$path);
?>
