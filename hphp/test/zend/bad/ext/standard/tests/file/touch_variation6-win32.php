<?php
/* Prototype  : bool touch(string filename [, int time [, int atime]])
 * Description: Set modification time of file 
 * Source code: ext/standard/filestat.c
 * Alias to functions: 
 */

$workDir = "touchVar5.tmp";
$subDirOrFile = "aSubDirOrFile";
chdir(__DIR__);
mkdir($workDir);
$cwd = getcwd();

$unixifiedDirOrFile = '/'.substr(str_replace('\\','/',$cwd).'/'.$workDir.'/'.$subDirOrFile, 3);

$paths = array(
			 // relative
             $workDir.'\\'.$subDirOrFile,
             '.\\'.$workDir.'\\'.$subDirOrFile,
             $workDir.'\\..\\'.$workDir.'\\'.$subDirOrFile,
             
             // relative bad path (note p8 msgs differ)
             $workDir.'\\..\\BADDIR\\'.$subDirOrFile,
             'BADDIR\\'.$subDirOrFile,
             
             //absolute
             $cwd.'\\'.$workDir.'\\'.$subDirOrFile,
             $cwd.'\\.\\'.$workDir.'\\'.$subDirOrFile,
             $cwd.'\\'.$workDir.'\\..\\'.$workDir.'\\'.$subDirOrFile,

             //absolute bad path (note p8 msgs differ)             
             $cwd.'\\BADDIR\\'.$subDirOrFile,
             
             //trailing separators
             $workDir.'\\'.$subDirOrFile.'\\',
             $cwd.'\\'.$workDir.'\\'.$subDirOrFile.'\\',
             
             // multiple separators
             $workDir.'\\\\'.$subDirOrFile,
             $cwd.'\\\\'.$workDir.'\\\\'.$subDirOrFile,
             
             // Unixified Dir Or File
             $unixifiedDirOrFile,                         
             
             );
             
echo "*** Testing touch() : variation ***\n";

echo "\n*** testing nonexisting paths ***\n";      
test_nonexisting($paths);

echo "\n*** testing existing files ***\n";      
test_existing($paths, false);

echo "\n*** testing existing directories ***\n";      
test_existing($paths, true);


rmdir($workDir);



function test_nonexisting($paths) {
	foreach($paths as $path) {
	   echo "--- testing $path ---\n";
	   
	   if (is_dir($path) || is_file($path)) {
	      echo "FAILED: $path - exists\n";
	   }
	   else {
	      $res = touch($path);
	      if ($res === true) {
	         // something was created
	         if (file_exists($path)) {
	              // something found
			      if (is_dir($path)) {
			         echo "FAILED: $path - unexpected directory\n";
			      }
			      else {
			         echo "PASSED: $path - created\n";
			         unlink($path);
			      }
	         }
	         else {
	            // nothing found
	            echo "FAILED: $path - touch returned true, nothing there\n";
	         }
	      }
	      else {
	         // nothing created
	         if (file_exists($path)) {
	              //something found
	              echo "FAILED: $path - touch returned false, something there\n";
    		      if (is_dir($path)) {
    		         rmdir($path);
			      }
			      else {
			         unlink($path);
			      }
	         }
	      }
	   }
	}
}

function test_existing($paths, $are_dirs) {
	foreach($paths as $path) {
	   if ($are_dirs) {
	      $res = @mkdir($path);
	      if ($res == true) {
             test_path($path);
             rmdir($path);
          }	   
	   }
	   else {
	      $h = @fopen($path,"w");
	      if ($h !== false) {
	         fclose($h);
             test_path($path);
             unlink($path);
          }	   
	   }
	}
}
	   
	
function test_path($path) {
   echo "--- testing $path ---\n";
   $org_atime = get_atime($path);
   clearstatcache();
   $res = touch($path,0,0);
   $next_atime = get_atime($path);
   if ($next_atime == $org_atime) {
      echo "FAILED: $path - access time not changed\n";
   }
   else {
      echo "PASSED: $path - touched\n";
   }
}

function get_atime($path) {
   $temp = stat($path);
   return $temp['atime'];
}


?>
===DONE===