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
  * $Id: createvereinsplan.php,v 1.3.0 2009/08/06 $
  */
/** Vereinsplan 1.3.0
  *
  * Credits:
  * Vereinsplan based on and uses following
  * - LMO-Addon Viewer 4.0 Beta 3
  * - LMO-Addon TP 1.0 Spielplan
  * - JoomlaWorks "Tabs & Slides" Module for Joomla! 1.5.x - Version 1.0
  *
  */
/** Changelog:
    06.08.2009  Happy Birthday
    29.08.2009  Variable für Versionsnummer hinzugefügt
                Versionsnummer von 1.0.0 auf 1.1.0 gesetzt
    30.08.2009  Erstellt nun Ausgabe-Datei für PDF-Funktionalität
                weitere Infos in vereinsplan_Sort.php
    08.09.2009  diverse Template-Anpassungen notwendig
    12.09.2009  HTML- u. CSS-Validierungstest des Outputs
    13.09.2009  An LMO-Forum übergeben
    23.11.2010  Version auf 1.3.0 gesetzt
                Diverse Fehlerabfragen und neue Template-Variablen eingepflegt
  */


function myown_sort($a, $b) {
    if ($a == $b) return 0;
    return ($a > $b) ? -1 : 1;
}
$MyAddonName='vereinsplan';

require(dirname(__FILE__).'/../../init.php');
require_once(PATH_TO_ADDONDIR."/".$MyAddonName."/ini.php");


// Dateien und Pfade festlegen
$Path_To_OutputDir   = PATH_TO_LMO.'/output';
$Url_To_OutputDir    = URL_TO_LMO.'/output';

$MyProgNameExt = basename(__FILE__);
$MyProgName = substr($MyProgNameExt,0,strlen($MyProgNameExt)-4);
$MyPath = basename(dirname(__FILE__));
if (isset($_REQUEST["cfg"])) {$cfg_name=$_REQUEST["cfg"];}
isset($cfg_name) ? $MyConfigFileName=$cfg_name : $MyConfigFileName=$MyAddonName;

//die("R".$cfg_name);

$MyOutputPath        = $Path_To_OutputDir;
$MyAddOnPath         = PATH_TO_ADDONDIR.'/'.$MyAddonName;
$MyConfigPath        = PATH_TO_CONFIGDIR.'/'.$MyAddonName;
$MyTemplatePath      = PATH_TO_TEMPLATEDIR.'/'.$MyAddonName;
$MyImgPath           = $MyTemplatePath.'/img';
$MyHostUrl           = dirname(URL_TO_LMO);
$MyTemplateUrl       = URL_TO_TEMPLATEDIR.'/'.$MyAddonName;
$MyImgUrl            = $MyTemplateUrl.'/img';
$MyPathUrl           = URL_TO_ADDONDIR.'/'.$MyAddonName;
$MyJsUrl             = URL_TO_JSDIR.'/'.$MyAddonName;
$MyOutputUrl         = URL_TO_LMO.'/output';

$MyPreString         = $MyConfigFileName;
$MyPreString2        = $MyPreString.'_res';
$MyOutputFileName    = $MyPreString.'.txt';
$MyOutputFileNameH   = $MyPreString.'H.txt';
$MyOutputFileNameA   = $MyPreString.'A.txt';
$MyOutputFileNameErg = $MyPreString2.'.txt';

$MyCountFileName     = $MyPreString.'_count.txt';
$MyCountFileNameErg  = $MyPreString2.'_count.txt';

$MyCountFile         = $MyOutputPath.'/'.$MyCountFileName;
$MyCountFileErg      = $MyOutputPath.'/'.$MyCountFileNameErg;
$MyOutputFile        = $MyOutputPath.'/'.$MyOutputFileName;
$MyOutputFileH       = $MyOutputPath.'/'.$MyOutputFileNameH;
$MyOutputFileA       = $MyOutputPath.'/'.$MyOutputFileNameA;
$MyOutputFileErg     = $MyOutputPath.'/'.$MyOutputFileNameErg;
//vereinsplan-Ini-Datei: hier TVH-Teams
$MyConfigFile    = $MyConfigPath.'/'.$MyConfigFileName.'.cfg';
$MyClubNameLong  = 'TV Herbolzheim';
$MyClubNameShort = 'TVH';
$MyClubArena     = 'Breisgau';

$Slider=0;

// Load the cache-counter-file for viewers simple cache mechanism
$vereinsplan_cache_counter = 0; //counter for cache hits
if (!file_exists($MyCountFile)) {
  touch($MyCountFile);
}
$vereinsplan_cache_counter_file = fopen($MyCountFile, "rb");
$vereinsplan_cache_counter = intval(trim(fgets($vereinsplan_cache_counter_file)));
fclose($vereinsplan_cache_counter_file);

// falls Array nicht existiert, definieren
if (!isset($cfgarray)){
    $cfgarray = array();
}

//Konfigurationdatei einlesen
if (!file_exists($MyConfigFile)) {
   $vpRC=1;
   echo getmessage($text['vereinsplan'][7000].': '.$text['vereinsplan'][7011].' '.$MyConfigFileName.' '.$text[$MyAddonName][7054],TRUE);
   // die("Konfigurationsdatei: $MyConfigFile nicht gefunden!");

} else {
  // Ini-Datei in Array lesen
  $multi_cfgarray = parse_ini_file($MyConfigFile);
  // in Array lesen & mit Hauptscript zusammenlegen
  $multi_cfgarray += $main_cfgarray;
  // Array in Variablen transformieren - bestehende werden überschrieben
  extract ($multi_cfgarray);

  $useBS='';$targetBlank = ' target="_blank" ';
  $use_XHTML = isset($multi_cfgarray['vereinsplan_xhtml'])?$multi_cfgarray['vereinsplan_xhtml']:0;
  if ($use_XHTML==1) {
    $useBS='/';
    $targetBlank = " onclick=\"window.open(this.href,'_blank'); return false;\" ";
  }

  $Slider = isset($multi_cfgarray['vereinsplan_slidemodus'])?$multi_cfgarray['vereinsplan_slidemodus']:1;
  // Falls cache_refresh noch nicht existiert, Defaultwert 0 setzen
  $multi_cfgarray['vereinsplan_cache_refresh'] = isset($multi_cfgarray['vereinsplan_cache_refresh'])?$multi_cfgarray['vereinsplan_cache_refresh']:0;

  if ($vereinsplan_cache_counter == 0 || $vereinsplan_cache_counter > $multi_cfgarray['vereinsplan_cache_refresh']) {
    //not cached or cache limit reached->generate new view
    $i = 1;
    $output = "";
    $fav_liga[] = array();
    $fav_team[][] = array();
    $tvh_Playlist[] = array();
    $tvh_nummer[] = array();
    $tvh_Erglist[] = array();
    $tvh_ErgNr[] = array();
    while (isset($multi_cfgarray['liga'.$i])) {
      //Namen der gewüschten Liga einlesen
      $fav_liga[$i] = $multi_cfgarray['liga'.$i];
      $ii = 1;
      while (isset($multi_cfgarray[$multi_cfgarray['liga'.$i].'_'.$ii])) {
        //Nummer des Favoriten-Teams einlesen
        $fav_team[$i][$ii] = $multi_cfgarray[$multi_cfgarray['liga'.$i].'_'.$ii];
        $ii++;
      }
      $i++;
    }
    // Templates laden
    $anzahl_ligen = --$i;
    $template_file = $multi_cfgarray['vereinsplan_template'];
    $template_erg_file = $multi_cfgarray['vereinsplan_template_erg'];
    if ($anzahl_ligen<=0) {
      $vpRC=2;  /* keine Ligen definiert */
      $myErrMsg = $text['vereinsplan'][7011].' '.$MyConfigFileName.': '.$text[$MyAddonName][7171];
    }
    if (!file_exists($MyTemplatePath.'/'.$template_file.'.tpl.php')) {
      /* Default-Template verwenden */
      if (!file_exists($MyTemplatePath.'/'.$MyAddonName.'.tpl.php')) {
        $vpRC=4;  /* Template-Datei fehlt */
        $myErrMsg = "Template-Datei fehlt: ".$template_file.'.tpl.php';
      } else {$template_file = $MyAddonName;}
    }
    if (!file_exists($MyTemplatePath.'/'.$template_erg_file.'.tpl.result.php')) {
      /* Default-Ergebnis-Template verwenden */
      if (!file_exists($MyTemplatePath.'/'.$MyAddonName.'.tpl.result.php')) {
        $vpRC=8;
        $myErrMsg = "Ergebnis-Template-Datei fehlt: ".$template_erg_file.'.tpl.result.php';
      } else {$template_erg_file = $MyAddonName;}
    }
    $css_file = $multi_cfgarray['vereinsplan_cssname'];
    $css_slider_file = $multi_cfgarray['vereinsplan_cssname_slider'];

    if ($vpRC<1) {
      $template = new HTML_Template_IT($MyTemplatePath);        // Template Object: alle Vereinsspiele
      $templateA = new HTML_Template_IT($MyTemplatePath);        // Template Object: nur Auswärtsspiele
      $templateH = new HTML_Template_IT($MyTemplatePath);        // Template Object: nur Heimspiele
      $templateErg = new HTML_Template_IT($MyTemplatePath);       // Template Object: aktuelle Ergebnissliste
      $template->loadTemplatefile($template_file.'.tpl.php',true,true);
      $templateA->loadTemplatefile($template_file.'.tpl.php',true,true);
      $templateH->loadTemplatefile($template_file.'.tpl.php',true,true);
      $templateErg->loadTemplatefile($template_erg_file.'.tpl.result.php',true,true);

      if (isset($multi_cfgarray['vereinsplan_vereinsnamelang'])) {
        $MyClubNameLong = $multi_cfgarray['vereinsplan_vereinsnamelang'];
      }
      if (isset($multi_cfgarray['vereinsplan_vereinsnamekurz'])) {
        $MyClubNameShort = $multi_cfgarray['vereinsplan_vereinsnamekurz'];
      }
      if (isset($multi_cfgarray['vereinsplan_vereinshalle'])) {
        $MyClubArena = $multi_cfgarray['vereinsplan_vereinshalle'];
      }

      $template->setVariable("BasisCssName", $css_file);
      $templateA->setVariable("BasisCssName", $css_file);
      $templateH->setVariable("BasisCssName", $css_file);
      $templateErg->setVariable("BasisCssName", $css_file);
      $template->setVariable("xmlTag", $useBS);
      $templateH->setVariable("xmlTag", $useBS);
      $templateA->setVariable("xmlTag", $useBS);
      $templateErg->setVariable("xmlTag", $useBS);
      $template->setVariable("urlHost", $MyHostUrl);
      $templateA->setVariable("urlHost", $MyHostUrl);
      $templateH->setVariable("urlHost", $MyHostUrl);
      $template->setVariable("urlVereinsTemplate", $MyTemplateUrl);
      $templateA->setVariable("urlVereinsTemplate", $MyTemplateUrl);
      $templateH->setVariable("urlVereinsTemplate", $MyTemplateUrl);
      $templateErg->setVariable("urlVereinsTemplate", $MyTemplateUrl);
      $template->setVariable("VereinsNameLang", $MyClubNameLong);
      $templateA->setVariable("VereinsNameLang", $MyClubNameLong);
      $templateH->setVariable("VereinsNameLang", $MyClubNameLong);
      $templateErg->setVariable("VereinsNameKurz", $MyClubNameShort);

      $template->setVariable("FensterTitel", $text[$MyAddonName][7104]." ".$MyClubNameLong);
      $templateH->setVariable("FensterTitel", $text[$MyAddonName][7105]." ".$MyClubNameLong);
      $templateA->setVariable("FensterTitel", $text[$MyAddonName][7106]." ".$MyClubNameLong);
      $templateErg->setVariable("FensterTitel", $text[$MyAddonName][7114]." ".$MyClubNameShort.$text[$MyAddonName][7115].$text[$MyAddonName][7034]);
      $template->setVariable("TPL-Info","<!--CFG: ".$MyConfigFileName.", Template: ".$template_file."-->");
      $templateH->setVariable("TPL-Info","<!--CFG: ".$MyConfigFileName.", Template: ".$template_file."-->");
      $templateA->setVariable("TPL-Info","<!--CFG: ".$MyConfigFileName.", Template: ".$template_file."-->");
      $templateErg->setVariable("TPL-Info","<!--CFG: ".$MyConfigFileName.", Template: ".$template_erg_file."-->");
      $templateErg->setVariable("KopfInfo1", $text[$MyAddonName][7165]);
      $templateErg->setVariable("KopfInfo2", $text[$MyAddonName][7034]);

      $template->setVariable("PlanArt", $text[$MyAddonName][7104]);
      $templateH->setVariable("PlanArt", $text[$MyAddonName][7105]);
      $templateA->setVariable("PlanArt", $text[$MyAddonName][7106]);
      $Startzeile="";

      //  URLs für die verschiedenen Planarten
      $url_phpaufruf='href="'.$MyPathUrl.'/showvereinsplan.php';
      $url_gesamt = $url_phpaufruf;
      $url_heim = $url_gesamt.'?planart=heim';
      $url_gast = $url_gesamt.'?planart=gast';
      if ($MyConfigFileName!=$MyAddonName) {
        $cfg_parm = '?cfg='.$MyConfigFileName;
        $url_gesamt = $url_phpaufruf.$cfg_parm;
        $url_heim = $url_gesamt.'&amp;planart=heim';
        $url_gast = $url_gesamt.'&amp;planart=gast';
      }

      $template->setVariable("topmenutext1", $text[$MyAddonName][7150].':');
      $template->setVariable("urlAuswahl1", $url_heim.'" title="'.$text[$MyAddonName][7103].' '.$text[$MyAddonName][7105].' '.$text[$MyAddonName][7107].'"');
      $template->setVariable("txtAuswahl1", $text[$MyAddonName][7105]);
      $template->setVariable("urlAuswahl2", $url_gast.'" title="'.$text[$MyAddonName][7103].' '.$text[$MyAddonName][7106].' '.$text[$MyAddonName][7107].'"');
      $template->setVariable("txtAuswahl2", $text[$MyAddonName][7106]);

      $templateH->setVariable("topmenutext1", $text[$MyAddonName][7150].':');
      $templateH->setVariable("urlAuswahl1", $url_gesamt.'" title="'.$text[$MyAddonName][7103].' '.$text[$MyAddonName][7104].' '.$text[$MyAddonName][7107].'"');
      $templateH->setVariable("txtAuswahl1", $text[$MyAddonName][7104]);
      $templateH->setVariable("urlAuswahl2", $url_gast.'" title="'.$text[$MyAddonName][7103].' '.$text[$MyAddonName][7106].' '.$text[$MyAddonName][7107].'"');
      $templateH->setVariable("txtAuswahl2", $text[$MyAddonName][7106]);

      $templateA->setVariable("topmenutext1", $text[$MyAddonName][7150].':');
      $templateA->setVariable("urlAuswahl1", $url_gesamt.'" title="'.$text[$MyAddonName][7103].' '.$text[$MyAddonName][7104].' '.$text[$MyAddonName][7107].'"');
      $templateA->setVariable("txtAuswahl1", $text[$MyAddonName][7104]);
      $templateA->setVariable("urlAuswahl2", $url_heim.'" title="'.$text[$MyAddonName][7103].' '.$text[$MyAddonName][7105].' '.$text[$MyAddonName][7107].'"');
      $templateA->setVariable("txtAuswahl2", $text[$MyAddonName][7105]);

      include($MyAddOnPath.'/'.$MyProgName.'_Sort.php');

      $vereinsplan_output = $template->get();
      $vereinsplan_outputA = $templateA->get();
      $vereinsplan_outputH = $templateH->get();
      $vereinsplan_outputErg = $templateErg->get();

      //save cache outputfiles
      if ($vereinsplan_cache_file = fopen($MyOutputFile, "wb")) {
        fwrite($vereinsplan_cache_file, $vereinsplan_output);
        fclose($vereinsplan_cache_file);
      }
      if ($vereinsplan_cache_file = fopen($MyOutputFileA, "wb")) {
        fwrite($vereinsplan_cache_file, $vereinsplan_outputA);
        fclose($vereinsplan_cache_file);
      }
      if ($vereinsplan_cache_file = fopen($MyOutputFileH, "wb")) {
        fwrite($vereinsplan_cache_file, $vereinsplan_outputH);
        fclose($vereinsplan_cache_file);
      }
      if ($vereinsplan_cache_file = fopen($MyOutputFileErg, "wb")) {
        fwrite($vereinsplan_cache_file, $vereinsplan_outputErg);
        fclose($vereinsplan_cache_file);
      }
      //reset cache counters
      $vereinsplan_cache_counter_file = fopen($MyCountFile, "wb");
      fwrite($vereinsplan_cache_counter_file, "1");
      fclose($vereinsplan_cache_counter_file);
      $vereinsplan_cache_counter_file = fopen($MyCountFileErg, "wb");
      fwrite($vereinsplan_cache_counter_file, "1");
      fclose($vereinsplan_cache_counter_file);

      // reiner HTML-Code
      //echo $vereinsplan_output;
    }
    else {
      echo getmessage($text['vereinsplan'][7000].': '.$myErrMsg,TRUE);
    }
  } else {
    //get cache

    if ($vereinsplan_cache_file = fopen($MyOutputFile, "rb")) {
      fpassthru($vereinsplan_cache_file);
      fclose($vereinsplan_cache_file);
    }
    if ($vereinsplan_cache_file = fopen($MyOutputFileA, "rb")) {
      fpassthru($vereinsplan_cache_file);
      fclose($vereinsplan_cache_file);
    }
    if ($vereinsplan_cache_file = fopen($MyOutputFileH, "rb")) {
      fpassthru($vereinsplan_cache_file);
      fclose($vereinsplan_cache_file);
    }
    if ($vereinsplan_cache_file = fopen($MyOutputFileErg, "rb")) {
      fpassthru($vereinsplan_cache_file);
      fclose($vereinsplan_cache_file);
    }
    //increment cache counter

    $vereinsplan_cache_counter_file = fopen($MyCountFile, "wb");
    fwrite($vereinsplan_cache_counter_file, ++$vereinsplan_cache_counter);
    fclose($vereinsplan_cache_counter_file);
    $vereinsplan_cache_counter_file = fopen($MyCountFileErg, "wb");
    fwrite($vereinsplan_cache_counter_file, $vereinsplan_cache_counter);
    fclose($vereinsplan_cache_counter_file);
  }
}

?>