<?
/** Liga Manager Online 4
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
  * History Table Addon for LigaManager Online
  * Copyright (C) 2005 by Marcus Schug
  * langer77@gmx.de
  *
  * @author <a href="mailto:langer77@gmx.de">Marcus Schug</a>
  * @version 0.9
  *
  * History:
  * 0.9: initial Release
  *
  * URL-Parameter:
  *
  *   his_liga:		Dateiname der aktuellen Liga
  *
  *   his_ligen: 	Ligen die zur Berechnung der ewigen Tabelle genutzt werden sollen,
  * 			 	außer die aktuelle Liga. //nur im Notfall nutzen
  *   his_folder: 	Ordner mit dem Ligenarchiv
  *   his_sort:     Sortiervorgabe der ewigen Tabelle
  * 				0 Standartsortierung nach Punkten
  * 				1 Sortierung nach Spielen
  * 				2 Sortierung nach Siegen
  * 				3 Sortierung nach Toren
  * 				4 Sortierung nach Punkte/Spiel
  *   his_template: Template, dass benutzt werden soll
  *
  * Beispiel 1: 1.Bundesliga Fussball 2004 / 2005 mit his_ligen
  * Sollte nur genutzt werden wenn Zugriff über FTP nicht möglich ist.
  *   his_liga = 1bundesliga2004.l98
  *   his_ligen =1bundesliga2003.l98,1bundesliga2002.l98,1bundesliga2001.l98,1bundesliga2000.l98
  *
  *   Einbindung über IFrame:
  *     <iframe src="<url_to_lmo>/addon/history/lmo-history.php?his_liga=1bundesliga2004.l98&his_ligen=1bundesliga2003.l98,1bundesliga2002.l98,1bundesliga2001.l98,1bundesliga2000.l98"><url_to_lmo>/addon/history/lmo-history.php?his_liga=1bundesliga2004.l98&his_ligen=1bundesliga2003.l98,1bundesliga2002.l98,1bundesliga2001.l98,1bundesliga2000.l98</iframe>
  *     (die Parameter his_sort und his_template bei Bedarf mit &amp;his_sort=<integer>&amp;his_template=<integer> anhängen
  *
  *   Einbindung über include:
  *     $his_liga = '1bundesliga2004.l98'
  *   	$his_ligen= '1bundesliga2003.l98,1bundesliga2002.l98,1bundesliga2001.l98,1bundesliga2000.l98'
  *     (auch hier bei Bedarf his_sort und/oder his_template angeben: $a = <integer>;$his_template = '<string>'; )
  *     include ("<pfad_zum_lmo>/addon/history/lmo-history.php.php");
  *
  * Beispiel 2: 1.Bundesliga Fussball 2004 / 2005 mit his_ligen
  * Sollte nur genutzt werden wenn Zugriff über FTP nicht möglich ist.
  *   his_liga = 1bundesliga2004.l98
  *   his_folder = archiv/bundesliga
  *
  *   Einbindung über IFrame:
  *     <iframe src="<url_to_lmo>/addon/history/lmo-history.php?his_liga=1bundesliga2004.l98&his_ligen=1bundesliga2003.l98,1bundesliga2002.l98,1bundesliga2001.l98,1bundesliga2000.l98"><url_to_lmo>/addon/history/lmo-history.php?his_liga=1bundesliga2004.l98&his_folder=archiv/bundesliga</iframe>
  *     (die Parameter his_sort und his_template bei Bedarf mit &amp;his_sort=<integer>&amp;his_template=<integer> anhängen
  *
  *   Einbindung über include:
  *     $his_liga = '1bundesliga2004.l98'
  *   	$his_folder = archiv/bundesliga
  *     (auch hier bei Bedarf his_sort und/oder his_template angeben: $a = <integer>;$his_template = '<string>'; )
  *     include ("<pfad_zum_lmo>/addon/history/lmo-history.php.php");
  *
  *	Installation:
  * lmo-history.php ins Verzeichnis <lmo_root>/addon/history/ kopieren.
  * history.tpl.php ins Verzeichnis <lmo_root>/template/history/ kopieren
  * history3.tpl.php ins Verzeichnis <lmo_root>/template/history/ kopieren
  * *lang.txt-dateien ins Verzeichnis <lmo_root>/lang/history/ kopieren
  * cfg.txt ins Verzeichnis <lmo_root>/lang/config/history/ kopieren
  *
  * install_history.php ausführen.
  *
  * Hinweis:
  * Es ist nicht gestattet den Hinweis auf den Autor zu entfernen!
  * Eigene Templates müssen den Hinweis auf Autor des Scripts enthalten.
  *
  */

require_once(dirname(__FILE__).'/../../init.php');
require_once(PATH_TO_ADDONDIR."/classlib/ini.php");
require_once(PATH_TO_ADDONDIR."/history/lmo-history_func.php");

// Durch Get bestimmter Parameter (für IFRAME)
$m_liga=       isset($_GET['his_liga'])?             urldecode($_GET['his_liga']):       '';
$m_ligen=       isset($_GET['his_ligen'])?             urldecode($_GET['his_ligen']):       '';
$m_template=   isset($_GET['his_template'])?         urldecode($_GET['his_template']):   "history";
$m_sort=      !empty($_GET['his_sort'])?           urldecode($_GET['his_sort']):      '0';

// Direkt bestimmte Parameter (für include/require)
$m_liga		=   isset($his_liga)	?	$his_liga:      $m_liga;
$m_ligen	=   isset($his_ligen)	?   $his_ligen:     $m_ligen;
$m_template	=   isset($his_template)?   $his_template:  $m_template;
$m_sort		=   isset($his_sort)	?   $his_sort:      $m_sort;
$archivFolder = isset($_GET['his_folder'])?$_GET['his_folder']:isset($his_folder)?$his_folder:basename($ArchivDir);// Default



if (basename($_SERVER['PHP_SELF'])=="lmo-history.php") {?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
					"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Minitab</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" >
<style type="text/css">
  html,body {margin:0;padding:0;background:transparent;}
</style>
</head>
<body><?
}
/**Format of CSV-File:
*       0     |      1            |   2   |   3   |  4   |  5   |  6  | 7 | 8  |  9 |    10    |     11
* TeamLongName|TeamnameAbbrevation|Points+|Points-|Goals+|Goals-|Games|Win|Draw|Loss|Marking   |TeamShortName
*  Teamname   |  Kurzname         |Pkt.+  | Pkt.- |Tore+ | Tore-|Sp.  | + | o  | -  |Markierung| Mittelname
*/
if($cfgarray['history'][lmo_autocreate]==1){
  scan($archivFolder);
}

if (file_exists(PATH_TO_LMO.'/'.$diroutput.$m_liga.'-tab.csv')) {
  $template = new HTML_Template_IT( PATH_TO_TEMPLATEDIR.'/history' );
  $template->loadTemplatefile($m_template.".tpl.php");

  $m_tabelle=array();
  $handle = fopen (PATH_TO_LMO.'/'.$diroutput.$m_liga.'-tab.csv',"rb");
  while ( ($data = fgetcsv ($handle, 1000, "|")) !== FALSE ) {
    $m_tabelle[$data[0]]=$data;
    $m_tabelle[$data[0]][10] = "";
    //Mannschaft in Liga
    $m_tabelle[$data[0]][11] = 1;
    //Meisterschaften
    $m_tabelle[$data[0]][12] = 0;
    //Abstiege
    $m_tabelle[$data[0]][13] = 0;
    //Saisons
    $m_tabelle[$data[0]][14] = 1;
  }
  fclose($handle);
  //Umwandeln der Übergebenen Ligen in ein Array
  if($m_ligen != ''){
    $m_ligen = explode(',',$m_ligen);
    for($i=0;$i<count($m_ligen);$i++){
      add_saison($m_tabelle,PATH_TO_LMO.'/'.$diroutput,$m_ligen[$i]);
    }
  }
  else{
    addLeague($archivFolder,$m_tabelle);
  }
  //Umschlüssel der Tabelle
  $r_tabelle = array();
  $keys =array_keys($m_tabelle);
  for($i=0;$i<count($keys);$i++){
    $r_tabelle[] = $m_tabelle[$keys[$i]];
  }
  $m_tabelle = $r_tabelle;
  switch($m_sort){
    case(0): usort($m_tabelle,'cmp');	 break; //Sortiert nach Punkten
    case(1): usort($m_tabelle,'cmp1');	 break; //Sortiert nach Siegen
    case(2): usort($m_tabelle,'cmp2');	 break; //Sortiert nach Spielen
    case(3): usort($m_tabelle,'cmp3');	 break; //Sortiert nach Toren
    case(4): usort($m_tabelle,'cmp4');	 break; //Sortiert nach Punkte/Spiel
  }
  $m_anzteams=count($m_tabelle);
  for ($j=0;$j<$m_anzteams;$j++) {
    $template->setCurrentBlock("Inhalt");
    $template->setVariable("copy",$text['history'][0]);
    $template->setVariable("D",$text['history'][6]);
    $template->setVariable("M",$text['history'][7]);
    $template->setVariable("A",$text['history'][8]);
    $template->setVariable("S",$text['history'][9]);
    $template->setVariable(array("Platz"=>"<strong>".($j+1)."</strong>"));
    $template->setVariable(array("TeamBild"=>getSmallImage($m_tabelle[$j][0])));
    $template->setVariable(array("TeamLang"=>$m_tabelle[$j][0]));
    $template->setVariable(array("TeamMittel"=>(isset($m_tabelle[$j][11])?$m_tabelle[$j][11]:'')));
    $template->setVariable(array("Team"=>$m_tabelle[$j][1]));
    $m_3punkte = ($m_tabelle[$j][7] * 3) + $m_tabelle[$j][8];
    $template->setVariable(array("3Punkte"=>$m_3punkte));
    if ($m_tabelle[$j][3]=='') {
      $template->setVariable(array("Punkte"=>$m_tabelle[$j][2]));
    } else {
      $template->setVariable(array("Punkte"=>$m_tabelle[$j][2].':'.$m_tabelle[$j][3]));
    }
    $template->setVariable(array("PlusTore"=>$m_tabelle[$j][4]));
    $template->setVariable(array("MinusTore"=>$m_tabelle[$j][5]));
    if (($m_diff=$m_tabelle[$j][4]-$m_tabelle[$j][5])>0) $m_diff='+'.$m_diff;
    $template->setVariable(array("Tordifferenz"=>$m_diff));
    $template->setVariable(array("Spiele"=>$m_tabelle[$j][6]));
    $template->setVariable(array("Siege"=>$m_tabelle[$j][7]));
    $template->setVariable(array("Unentschieden"=>$m_tabelle[$j][8]));
    $template->setVariable(array("Niederlagen"=>$m_tabelle[$j][9]));
    $style='';
    if($m_tabelle[$j][6]>0){
      $m_durch = round($m_tabelle[$j][2]/$m_tabelle[$j][6],2);
    }
    else{
      $m_durch = 0;
    }
    $template->setVariable(array("Durchschnitt"=>$m_durch));
    $template->setVariable(array("Meisterschaften"=>$m_tabelle[$j][12]));
    $template->setVariable(array("Abstiege"=>$m_tabelle[$j][13]));
    $template->setVariable(array("Saisons"=>$m_tabelle[$j][14]));
    $style='';
    if ($m_tabelle[$j][10]!='') {
      if (strpos($m_tabelle[$j][10],'M')!==FALSE){  //Meister
        $style="background: $lmo_tabelle_background1 repeat;";
        $style.=empty($lmo_tabelle_color1)?'':"color: $lmo_tabelle_color1;";
        $template->setVariable(array("Style"=>$style));
      } elseif (strpos($m_tabelle[$j][10],'A')!==FALSE){  //Absteiger
        $style="background: $lmo_tabelle_background6 repeat;";
        $style.=empty($lmo_tabelle_color6)?'':"color: $lmo_tabelle_color6;";
        $template->setVariable(array("Style"=>$style));
      }
    }
    if (strpos($m_tabelle[$j][10],'F')!==FALSE){  //FavTeam
      $style.="font-weight:bolder;";
      $template->setVariable(array("Style"=>$style));
    }
    //Legende
    $template->setVariable(array("Meister"=>$text['history'][2]));
    $template->setVariable(array("Abstieg"=>$text['history'][3]));
    $style="background: $lmo_tabelle_background1 repeat;";
    $style.=empty($lmo_tabelle_color1)?'':"color: $lmo_tabelle_color1;";
    $template->setVariable(array("Style_M"=>$style));
    $style="background: $lmo_tabelle_background6 repeat;";
    $style.=empty($lmo_tabelle_color6)?'':"color: $lmo_tabelle_color6;";
    $template->setVariable(array("Style_A"=>$style));
    $template->parseCurrentBlock();
  }
  $template->show();
} else {
  echo getMessage($text['history'][5]." ".$his_liga,TRUE);
}

//Falls IFRAME - komplettes HTML-Dokument
if (basename($_SERVER['PHP_SELF'])=="lmo-history.php") {?>
</body>
</html><?
}?>