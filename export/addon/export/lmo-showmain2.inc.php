<?php
// Kalenderdateinamen Anfang
require_once(PATH_TO_ADDONDIR.'/classlib/functions.php');
$configFile = PATH_TO_CONFIGDIR.'/export/'.$export_iCal_configFile.'.expo';
$config = file($configFile);
for($x=0;$x<count($config);$x++){
  $name =  strBeforChar($config[$x],',');
  $name =  strBeforChar($name,',');
  $fileName =  strBeforChar($file,'.');
  if ($name == $fileName) {
    $iCalFileName = strBeforChar($config[$x],',');
    $iCalFileName = strAfterChar($iCalFileName,',');
    $iCalFileName = $iCalFileName.'.ics';
  }
}
// Kalenderdateinamen Ende
$iCalPath = PATH_TO_LMO.'/'.$export_iCal_outputFile.'/'.$iCalFileName;
$iCalURL  = URL_TO_LMO.'/'.$export_iCal_outputFile.'/'.$iCalFileName;
if(file_exists($iCalPath)){
	echo "<br/><a href='$iCalURL' title='".$text['export'][1]."'>";
	echo "<img src='".URL_TO_LMO."/img/export/iconical.gif' alt='ical' border='0'/>&nbsp;".$text['export'][0]."</a>&nbsp;";
	echo "(<a href='".$text['export'][12]."' title='".$text['export'][14]."'>".$text['export'][13]."</a>)";
}
?>
