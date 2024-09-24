<?php
require_once(PATH_TO_ADDONDIR.'/export/class.lmo.iCal.inc.php');
$addAllGames = $export_iCal_allGames==1?TRUE:FALSE;
$silentExport = isset($silentExport) ? $silentExport : FALSE; // No Messages for silent export
$ligaLoaded = isset($ligaLoaded) ? $ligaLoaded : FALSE;
$createIcal = FALSE;
if ($ligaLoaded == TRUE) {
	$dirName = PATH_TO_LMO.'/'.$export_iCal_outputFile;
	$fileName = strBeforChar(basename($liga->fileName),'.');
	$favTeam = isset ($liga->options->keyValues['favTeam'])?$liga->teamForNumber($liga->options->keyValues['favTeam']):null;
	$addAllGames = !isset($favTeam)?TRUE:$addAllGames;// if no favTeam found in the options Section add all Games as Events
	$organizer = (array) array('','');
	$categories = $liga->options->keyValues['Type']==0 ? array($text['export'][3]):array($text['export'][4]);
	$attendees = array();
	$url = $export_iCal_eventUrlPrefix != '' ? $export_iCal_eventUrlPrefix : URL_TO_LMO."/lmo.php";
	$iCal = (object) new lmo_iCal('', 0, $dirName); // (ProgrammID, Method (1 = Publish | 0 = Request), Download Directory)

// Kalenderdateinamen Anfang
  $configFile = PATH_TO_CONFIGDIR.'/export/'.$export_iCal_configFile.'.expo';
  $config = file($configFile);
  for($x=0;$x<count($config);$x++){
    $name =  strBeforChar($config[$x],',');                           //Dateiname LMO und Dateiname iCal und Versatz Anstosszeit
    $name_ical =  strBeforChar($name,',');                            //Dateiname LMO und Dateiname iCal
    $name_lmo =  strBeforChar($name_ical,',');                        //Dateiname LMO
    If ($name_lmo == $fileName) {
//      $iCalFileName = strBeforChar($config[$x],',');                  //Dateiname LMO und Dateiname iCal
      $iCalFileName = strAfterChar($name_ical,',');                   //Dateiname iCal
      $iCalFileName = $iCalFileName.'.ics';
      $export_iCal_startTime = strAfterChar($name,',');               //Versatz Anstosszeit
      $export_iCal_eventDuration = strAfterChar($config[$x],',');     //Spieldauer
      $export_iCal_eventDuration = $export_iCal_eventDuration * '60';
    }
  }
//  $iCalFileName = $fileName.'.ics';
// Kalenderdateinamen Ende

	if ($export_iCal_create == 1 && ( $export_iCal_calendars == '' || in_Array($fileName,explode(',',$export_iCal_calendars)) ) )
		$createIcal =	TRUE;

	foreach ($liga->spieltage as $spieltag) {
		foreach ($spieltag->partien as $partie) {
			$title = $partie->heim->name.' '.$text['export'][7].' '.$partie->gast->name;
			if ($partie->valuateGame() > -1) {
				$title .= " ".$text['export'][11]." ".$partie->hToreString().":".$partie->gToreString();
			}
//		  $description = $liga->name.' '.$spieltag->nr.$text['export'][8].$partie->zeitString().$text['export'][9]; // Description
			$description = $liga->name.' '.$spieltag->nr.$text['export'][8]; // Description
//			if ($partie->valuateGame() > -1) {
//				$description .= " ".$text['export'][11]." ".$partie->hToreString().":".$partie->gToreString();
//			}
			if ($addAllGames == True || $partie->heim == $favTeam || $partie->gast == $favTeam) {

				// iCalendar Event
				if ($createIcal == TRUE) {
					$iCal->addEvent(
						(array) $organizer, // Organizer
//						(int) $partie->zeit,
						(int) ($partie->zeit+$export_iCal_startTime),     // Start Time (timestamp; for an allday event the startdate has to start at YYYY-mm-dd 00:00:00)
						(int) ($partie->zeit+$export_iCal_eventDuration), // End Time (write 'allday' for an allday event instead of a timestamp)
						(string) $partie->notiz, // Location
						(int) 1, // Transparancy (0 = OPAQUE | 1 = TRANSPARENT)
						(array) $categories, // Array with Strings
						(string) $description,
						(string) $title,
						(int) 1, // Class (0 = PRIVATE | 1 = PUBLIC | 2 = CONFIDENTIAL)
						(array) $attendees, // Array (key = attendee name, value = e-mail, second value = role of the attendee [0 = CHAIR | 1 = REQ | 2 = OPT | 3 =NON])
						(int) 5, // Priority = 0-9
						(int) 0, // frequency: 0 = once, secoundly - yearly = 1-7
						(int) 0, // recurrency end: ('' = forever | integer = number of times | timestring = explicit date)
						(int) 0, // Interval for frequency (every 2,3,4 weeks...)
						'', // Array with the number of the days the event accures (example: array(0,1,5) = Sunday, Monday, Friday
						(int) 1, // Startday of the Week ( 0 = Sunday - 6 = Saturday)
						'', // exeption dates: Array with timestamps of dates that should not be includes in the recurring event
						(int) 0,  // Sets the time in minutes an alarm appears before the event in the programm. no alarm if empty string or 0
						(int) 1, // Status of the event (0 = TENTATIVE, 1 = CONFIRMED, 2 = CANCELLED)
						(string) $url."?file=".$fileName.".l98&action=table&st=".$spieltag->nr, // optional URL for that event
						(string) $text['export'][10], // Language of the Strings example "de" for Germany
						'' // Optional UID for this event
					   );
				}
			}
		}
	}
	if ($createIcal == TRUE) {
		$iCal->generateOutput('ics'); // output file as ics (xcs and rdf possible)
		$iCal->events_filename=$iCalFileName;//
		$iCal->writeFile(); //'ics'
	}

	if ( !$silentExport && $createIcal) echo getMessage($text['export'][6].", Name: ".$iCalFileName,FALSE);
} else echo getMessage('lmo-export.php '.$text['export'][5],TRUE);
?>
