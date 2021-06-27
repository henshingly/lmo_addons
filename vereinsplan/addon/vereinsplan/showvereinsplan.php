<?php
/** Liga Manager Online 4
  *
  * http://lmo.sourceforge.net/
  *
  * This program is free software; you can redistribute it and/or
  * modify it under the terms of the GNU General Public License as
  * published by the Free Software Foundation; either version 2 of
  * the License, or (at your option) any later version.
  *
  * This program is distributed in the hope that it will be useful,
  * but WITHOUT ANY WARRANTY; without even the implied warranty of
  * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
  * General Public License for more details.
  *
  * REMOVING OR CHANGING THE COPYRIGHT NOTICES IS NOT ALLOWED!
  *
  * $Id: showvereinsplan.php,v 1.0 2009/08/06 $
  */
/** Vereinsplan 1.0
  *
  * Credits:
  * Vereinsplan based on and uses following
  * - LMO-Addon Viewer 4.0 Beta 3
  * - JoomlaWorks "Tabs & Slides" Module for Joomla! 1.5.x - Version 1.0
  *
  */
if (!function_exists("getmicrotime")) {
  function getmicrotime(){
    list($usec, $sec) = explode(" ",microtime());
    return ((float)$usec + (float)$sec);
  }
}

$startzeit = getmicrotime();

require(dirname(__FILE__).'/../../init.php');

$cfgoutput=isset($_REQUEST["cfg"])?$_REQUEST["cfg"]:'vereinsplan';
$showplan=isset($_REQUEST["planart"])?$_REQUEST["planart"]:'gesamt';

switch ($showplan) {
    case "heim":
        // Heimspielplan
        $outext='H.txt';
        break;
    case "gast":
        // Auswärtsspielplan
        $outext='A.txt';
        break;
    case "result":
        // Spielergebnisse
        $outext='_res.txt';
        break;
    default:
         // Gesamtspielplan
        $outext='.txt';
}

$ShowMe=PATH_TO_LMO.'/output/'.$cfgoutput.$outext;
if (file_exists($ShowMe)) {
  if ($vereinsplan_cache_file = fopen($ShowMe, "rb")) {
    fpassthru($vereinsplan_cache_file);
    fclose($vereinsplan_cache_file);
  }
} else {
    echo getMessage($text['vereinsplan'][7130].' '.$showplan.': '.$cfgoutput.$outext,true);
  }

?>