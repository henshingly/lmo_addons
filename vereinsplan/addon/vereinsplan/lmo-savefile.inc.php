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
  * $Id: vereinsplan_insert1_lmo-savefile.php,v 1.3.0 2009/08/06 $
  */
/** Vereinsplan 1.3.0
  *
  * Credits:
  * Vereinsplan based on and uses following
  * - LMO-Addon Viewer 4.0 Beta 3
  * - JoomlaWorks "Tabs & Slides" Module for Joomla! 1.5.x - Version 1.0
  *
  */
        /* addon vereinsplan start */
        $vereinsplansave=PATH_TO_ADDONDIR."/vereinsplan/createvereinsplan.php";
        if ($lmtype==0 && file_exists($vereinsplansave) && isset($vereinsplan_plan_erstellen) && $vereinsplan_cfg_auswahl!="") {
          /*aktueller Vereinsplan generieren*/
          $cfg_name=$vereinsplan_cfg_auswahl;
          include($vereinsplansave);
          if ($vpRC==0) {
            echo getMessage($text['vereinsplan'][7000].': '.$text['vereinsplan'][7142]);
          }
        }
        /* addon vereinsplan end */
?>