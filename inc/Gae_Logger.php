<?php

class Gae_Logger
{


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


# write a message to the logfile
  public static function write_log()
  {
    $numargs = func_num_args();
    $arg_list = func_get_args();
    if ($numargs > 2) $linenumber = func_get_arg(2); else $linenumber = "";
    if ($numargs > 1) $functionname = func_get_arg(1); else $functionname = "";
    if ($numargs >= 1) $string = func_get_arg(0);
    if (!isset($string) or $string == "") return;

    $logFile = gae_LOG_PATH . '/ops-' . date("Y-m") . ".log";
    $timeStamp = date("d/M/Y:H:i:s O");

    $fileWrite = fopen($logFile, 'a');

    //flock($fileWrite, LOCK_SH);
    if (Gae_Admin::debug()) {
      $logline = "[$timeStamp] " . html_entity_decode($string) . " $functionname $linenumber\r\n";  # for debug purposes
    } else {
      $logline = "[$timeStamp] " . html_entity_decode($string) . "\r\n";
    }
    fwrite($fileWrite, utf8_encode($logline));
//flock($fileWrite, LOCK_UN);
    fclose($fileWrite);
  }


}