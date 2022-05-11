<?php

  echo 'DEL';

  function delete_directory($dirname){
    if (is_dir($dirname))
      $dir_handle = opendir($dirname);
    if (!$dir_handle)
      return false;
    while ($file = readdir($dir_handle)){
      echo $file;
      if ($file != "." && $file != ".."){
        if (!is_dir($dirname . "/" . $file))
          unlink($dirname . "/" . $file);
        else
          delete_directory($dirname . '/' . $file);
      }
    }
    closedir($dir_handle);
    rmdir($dirname);
    return true;
  }

  delete_directory(__DIR__ . '/temp/cache');