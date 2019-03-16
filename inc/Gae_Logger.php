<?php

class Gae_Logger
{
    private static $permissionsProblem = false;

// create log folder
// return true if folder has been created or exists else false
    function gae_createLogFolder()
    {
        $error = false;
        if (!@is_dir(gae_LOG_PATH)) {
            if (!@mkdir(gae_LOG_PATH, 0777)) {
                $gae_on_off = 0;
                update_option('gae_on_off', 0);
                $error = true;
            }
        }

        # check if log folder is writeable
        if (!@is_writable(gae_LOG_PATH)) {

            # trying to set permissions
            if (!@chmod(gae_LOG_PATH, 0777)) {
                $gae_on_off = 0;
                update_option('gae_on_off', 0);
                $error = true;
            }
        } else {
            # create empty index.html file to hide logs from browsing
            $emptyFile = gae_LOG_PATH . 'index.html';
            $fileWrite = fopen($emptyFile, 'a');
            fclose($fileWrite);
        }
        if ($error) return false; else return true;
    }

# delete log folder
    function gae_deleteLogFolder()
    {
        # delete log folder and logs
        if (@is_dir(gae_LOG_PATH)) {
            gae_deltree(gae_LOG_PATH);
        }
    }


    function gae_check_folder_error()
    {
        $error = false;
        # check if log folder is writeable
        if (!@is_writable(gae_LOG_PATH)) {
            # trying to set permissions
            if (!@chmod(gae_LOG_PATH, 0777)) {
                // can't write to or create log folder
                // maybe you should switch you lugin to off now
                // $gae_on_off=false;
                $error = true;
            }
        }
        return $error;
    }

# deletes all files and folders and subfolders in given folder
    function gae_deltree($f)
    {
        if (@is_dir($f)) {
            foreach (glob($f . '/*') as $sf) {
                if (@is_dir($sf) && !is_link($sf)) {
                    @gae_deltree($sf);
                } else {
                    @unlink($sf);
                }
            }
        }
        if (@is_dir($f)) rmdir($f);
        return true;
    }


    public static function isLogingEnabled(){
        return Gae_Admin::debug();
    }

    public static function write_log()
    {
        if (!self::isLogingEnabled()){
            return false;
        }
        if (self::$permissionsProblem){
            return false;
        }
        $numargs = func_num_args();
        $arg_list = func_get_args();
        if ($numargs > 2) $linenumber = func_get_arg(2); else $linenumber = "";
        if ($numargs > 1) $functionname = func_get_arg(1); else $functionname = "";
        if ($numargs >= 1) $string = func_get_arg(0);
        if (!isset($string) or $string == "") return;

        $logFile = gae_LOG_PATH . 'gae-' . date("Y-m") . ".log";
        $timeStamp = date("d/M/Y:H:i:s O");

        //dirrectory exists
        if (file_exists(dirname($logFile))){
            if (!is_writable(dirname($logFile))){
                Gae_Admin::add_message("Could not create log file! Please, check if directory " . dirname($logFile) . " or/and file " . $logFile . " is writable to the php process, web server!","error");
                self::$permissionsProblem=true;
                return false;
            } else {
                touch($logFile);
                chmod($logFile,0777);
            }
        } else {
            //no dirrectory....
            //try to create

            $fileCreated = @mkdir(dirname($logFile),0755,true);
            $fileCreated = $fileCreated && @touch($logFile);
            chmod($logFile,0777);
            if (!$fileCreated){
                Gae_Admin::add_message("Could not create log file! Please, check if directory " . dirname($logFile) . " or/and file " . $logFile . " is writable to the php process, web server!","error");
                self::$permissionsProblem=true;
                return false;
            }
        }

        // fixe exists but is not writable
        if (!file_exists($logFile) || !is_writable($logFile)){
            Gae_Admin::add_message("Could not create log file! Please, check if directory " . dirname($logFile) . " or/and file " . $logFile . " is writable to the php process, web server!","error");
            self::$permissionsProblem=true;
            return false;
        }

        $fileWrite = fopen($logFile, 'a');

        //flock($fileWrite, LOCK_SH);
        if (Gae_Admin::debug()) {
            $logline = "[$timeStamp] " . html_entity_decode($string) . " $functionname $linenumber\r\n";  # for debug purposesls
        } else {
            $logline = "[$timeStamp] " . html_entity_decode($string) . "\r\n";
        }
        fwrite($fileWrite, utf8_encode($logline));
//flock($fileWrite, LOCK_UN);
        fclose($fileWrite);
    }


}