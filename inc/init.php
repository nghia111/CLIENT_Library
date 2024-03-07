<?php
if (session_id() === '') {
  session_start();
}
/**
 * Use for autoload 
 */
spl_autoload_register(
  function ($className) {
    $fileName = strtolower($className) . ".php";
    $dirRoot = dirname(__DIR__);
    require $dirRoot . "/classes/" . $fileName;
  }
);

require dirname(__DIR__) . "/config.php";
if (session_id() === '') session_start();

if (!function_exists('errorHandler')) {
  function errorHandler($level, $message, $file, $line)
  {
    throw new ErrorException($message, 0, $level, $file, $line);
  }
}

if (!function_exists('exceptionHandler')) {
  function exceptionHandler($ex)
  {
    if (DEBUG) {
      echo "<h2>Error</h2>";
      echo "<p>Exception: " . get_class($ex) . "</p>";
      echo "<p>Content: " . $ex->getMessage() . "</p>";
      echo "<p>File: " . $ex->getFile() . ", line: " . $ex->getLine() . "</p>";
    } else {
      echo "<h2>Error. Please try again</h2>";
    }
    exit();
  }
}

// set_error_handler('errorHandler');
// set_exception_handler('exceptionHandler');
