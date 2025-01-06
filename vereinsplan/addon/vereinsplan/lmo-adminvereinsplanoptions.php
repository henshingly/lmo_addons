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
  * $Id: lmo-adminvereinsplanoptions.php,v 1.3.0 2009/08/26 $
  *  - includes now sortable leagues (extract from lmo-dirlist.php)
  */
/** Vereinsplan 1.3.0
  *
  * Credits:
  * Vereinsplan based on and uses following
  * - LMO-Addon Viewer 4.0 Beta 3
  * - LMO-Addon TP 1.0 Spielplan
  * - JoomlaWorks "Tabs & Slides" Module for Joomla! 1.5.x - Version 1.0
  */
/** Changelog:
    06.08.2009  Happy Birthday
    13.09.2009  Version 1.1.0 an LMO-Forum übergeben
    08.10.2010  Version 1.1.1 wurde in LMO-SVN integriert und gepflegt
    05.11.2010  Version 1.1.2 bekannte Bugs aus LMO-Forum beseitigt
    05.11.2010  Version 1.2.0 gesetzt
                Anzeigen/Ausblenden im Ergebnisformular in Konfiguration steuerbar
                Plan-Erstellen bei Speichern in Konfiguration steuerbar
                Aktive Konfiguration steuerbar
    23.11.2011  Version 1.3.0 gesetzt
                Unterstützung weiterer Konfigurations-Parameter zur Formatsteuerung, z.B. Tabellen-Link
                Unterstützung vieler LMO-Ausgabe-Variablen für Template-Dateien
  */

require(dirname(__FILE__).'/../../init.php');
require_once(PATH_TO_LMO."/ini.fct");
require_once(PATH_TO_ADDONDIR."/classlib/ini.php");

$MyAddonName     = 'vereinsplan';
$ThisAddonDir      = PATH_TO_ADDONDIR.'/'.$MyAddonName;
$ThisConfigDir     = PATH_TO_CONFIGDIR.'/'.$MyAddonName;
$ThisImgDir        = PATH_TO_IMGDIR.'/'.$MyAddonName;
$ThisJsDir         = PATH_TO_JSDIR.'/'.$MyAddonName;
$ThisLangDir       = PATH_TO_IMGDIR.'/'.$MyAddonName;
$ThisTemplateDir   = PATH_TO_TEMPLATEDIR.'/'.$MyAddonName;
$ThisCssDir        = $ThisTemplateDir.'/css';
$Path_To_OutputDir = PATH_TO_LMO.'/output';

$ThisAddonUrl      = URL_TO_ADDONDIR.'/'.$MyAddonName;
$ThisConfigUrl     = URL_TO_CONFIGDIR.'/'.$MyAddonName;
$ThisImgUrl        = URL_TO_IMGDIR.'/'.$MyAddonName;
$ThisJsUrl         = URL_TO_JSDIR.'/'.$MyAddonName;
$ThisLangUrl       = URL_TO_IMGDIR.'/'.$MyAddonName;
$ThisTemplateUrl   = URL_TO_TEMPLATEDIR.'/'.$MyAddonName;
$Url_To_OutputDir  = URL_TO_LMO.'/output';

?>
<link rel="StyleSheet" href="<?php echo $ThisTemplateUrl;?>/css/dtree.css" type="text/css" />
<script src="<?php echo $ThisJsUrl;?>/<?php echo $MyAddonName;?>.js" type="text/javascript"></script>
<script src="<?php echo $ThisJsUrl;?>/dhtml81.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo $ThisJsUrl;?>/dtree.js"></script>
<?php

if($_SESSION['lmouserok']==2){

isset($_POST['vereinsplanform0']) ? $vereinsplan_form0=true : $vereinsplan_form0=false;  // formular 0 ausgefüllt?
isset($_POST['vereinsplanform01']) ? $vereinsplan_form01=true : $vereinsplan_form01=false;  // formular 01 ausgefüllt?
isset($_POST['vereinsplanform1']) ? $vereinsplan_form1=true : $vereinsplan_form1=false;  // formular 1 ausgefüllt?
isset($_POST['vereinsplanform2']) ? $vereinsplan_form2=true : $vereinsplan_form2=false;  // formular 2 ausgefüllt?
isset($_POST['vereinsplanform3']) ? $vereinsplan_form3=true : $vereinsplan_form3=false;  // formular 3 ausgefüllt?

$MyProgPathName = basename(dirname(__FILE__));

// Dateien und Pfade festlegen
$MyProgNameExt = basename(__FILE__);
$MyProgName = substr($MyProgNameExt,0,strlen($MyProgNameExt)-4);
//Default-cfg-File
$DefaultCfgFileName = $MyAddonName;
$DefaultCfgFileNameAktiv = $MyAddonName;
$DefaultCfgFileNameExt = $MyAddonName.'.cfg';
$ConfigLastFileName= $MyAddonName.'.lastcfg';
$GeneralCfgFileName= $MyAddonName.'.generalcfg';
/*  Default-Werte */
$DefaultCfg_array[] = array();
$DefaultCfg_array['vereinsplan_vereinsnamelang']    = 'TV Herbolzheim';
$DefaultCfg_array['vereinsplan_vereinsnamekurz']    = 'TVH';
$DefaultCfg_array['vereinsplan_vereinshalle']       = 'Breisgau';
$DefaultCfg_array['vereinsplan_template']           = $MyAddonName;
$DefaultCfg_array['vereinsplan_template_erg']       = $DefaultCfg_array['vereinsplan_template'];
$DefaultCfg_array['vereinsplan_cssname']            = $DefaultCfg_array['vereinsplan_template'];
$DefaultCfg_array['vereinsplan_cssname_slider']     = $DefaultCfg_array['vereinsplan_template'];
$DefaultCfg_array['vereinsplan_datumsformat']       ='d.m.y' ;
$DefaultCfg_array['vereinsplan_datumshow']          ='0';
$DefaultCfg_array['vereinsplan_uhrzeitformat']      = 'H:i';
$DefaultCfg_array['vereinsplan_tordummy']           = '-';
$DefaultCfg_array['vereinsplan_team_highlight']     = '1';
$DefaultCfg_array['vereinsplan_teamlogo']           = '1';
$DefaultCfg_array['vereinsplan_teamname']           = '0';
$DefaultCfg_array['vereinsplan_teamhplink']         = '1';
$DefaultCfg_array['vereinsplan_teamhptarget']       = '1';
$DefaultCfg_array['vereinsplan_teamhpsymbol']       = 'url.png';
$DefaultCfg_array['vereinsplan_teamplan']           = '1';
$DefaultCfg_array['vereinsplan_teamplantarget']     = '1';
$DefaultCfg_array['vereinsplan_notiz']              = '1';
$DefaultCfg_array['vereinsplan_notizsymbol']        = 'lmo-st2.gif';
$DefaultCfg_array['vereinsplan_notizkopftext']      = 'Notiz';
$DefaultCfg_array['vereinsplan_cache_refresh']      = '0';
$DefaultCfg_array['vereinsplan_cfg_ueberschreiben'] = '0';
$DefaultCfg_array['vereinsplan_planoutputname']     = $MyAddonName;
$DefaultCfg_array['vereinsplan_plan_erstellen']     = '1';
$DefaultCfg_array['vereinsplan_pdf']                = '1';
$DefaultCfg_array['vereinsplan_slidemodus']         = '1';
$DefaultCfg_array['vereinsplan_usemootools']        = '1';
$DefaultCfg_array['vereinsplan_ligapfad']           = 'ligen';
$DefaultCfg_array['vereinsplan_ligaicon']           = '1';
$DefaultCfg_array['vereinsplan_ligasymbol']         = 'tabelle.gif';
$DefaultCfg_array['vereinsplan_ligakopftext']       = 'Klasse';
$DefaultCfg_array['vereinsplan_ligalink']           = '1';
$DefaultCfg_array['vereinsplan_ligatarget']         = '1';
$DefaultCfg_array['vereinsplan_bericht']         = '1';
$DefaultCfg_array['vereinsplan_berichttarget']      = '1';
$DefaultCfg_array['vereinsplan_berichtsymbol']      = 'lmo-st1.gif';
$DefaultCfg_array['vereinsplan_berichtkopftext']    = 'Bericht';
$DefaultCfg_array['vereinsplan_xhtml']              = '0';
$DefaultCfg_array['vereinsplan_pdfliga']            = '1';
$DefaultCfg_array['vereinsplan_pdftarget']          = '1';
$DefaultCfg_array['vereinsplan_pdfnotiz']           = '0';
$DefaultCfg_array['vereinsplan_pdfformat']          = '0';
$DefaultCfg_array['vereinsplan_pdfseitejemonat']    = '1';
$DefaultCfg_array['vereinsplan_pdfshowlogo1']       = '1';
$DefaultCfg_array['vereinsplan_pdflogo1']           = 'vereinsplan-logo1';
$DefaultCfg_array['vereinsplan_pdflogo1w']          = '33';
$DefaultCfg_array['vereinsplan_pdflogo1h']          = '22';
$DefaultCfg_array['vereinsplan_pdflogo1x']          = '50';
$DefaultCfg_array['vereinsplan_pdflogo1y']          = '797';
$DefaultCfg_array['vereinsplan_pdflogo1xh']         = $DefaultCfg_array['vereinsplan_pdflogo1x'];
$DefaultCfg_array['vereinsplan_pdflogo1yh']         = $DefaultCfg_array['vereinsplan_pdflogo1y'];
$DefaultCfg_array['vereinsplan_pdflogo1xq']         = '50';
$DefaultCfg_array['vereinsplan_pdflogo1yq']         = '530';
$DefaultCfg_array['vereinsplan_pdfshowlogo2']       = '1';
$DefaultCfg_array['vereinsplan_pdflogo2']           = 'vereinsplan-logo2';
$DefaultCfg_array['vereinsplan_pdflogo2w']          = '80';
$DefaultCfg_array['vereinsplan_pdflogo2h']          = '23';
$DefaultCfg_array['vereinsplan_pdflogo2x']          = '100';
$DefaultCfg_array['vereinsplan_pdflogo2y']          = '796';
$DefaultCfg_array['vereinsplan_pdflogo2xh']         = $DefaultCfg_array['vereinsplan_pdflogo2x'];
$DefaultCfg_array['vereinsplan_pdflogo2yh']         = $DefaultCfg_array['vereinsplan_pdflogo2y'];
$DefaultCfg_array['vereinsplan_pdflogo2xq']         = '100';
$DefaultCfg_array['vereinsplan_pdflogo2yq']         = '529';
$DefaultCfg_array['vereinsplan_sliderstart']        = '2';

if (!$vereinsplan_form0 && !$vereinsplan_form1 && !$vereinsplan_form2 && !$vereinsplan_form3) {
   $MyCfgNameEdit=$DefaultCfgFileName;
   $MyCfgFileNameAktiv=$DefaultCfgFileNameAktiv;
   // try to load active/latest configfile-name
   $cfgAktiv_name = '';$cfgAktiv_exists = -2;   /* -2: nicht definiert, -1: Datei fehlt, n:Dateinummer  */
   $cfgLast_name  = '';$cfgLast_exists  = -2;
   if (file_exists($ThisConfigDir.'/'.$GeneralCfgFileName)) {
      $cfgAktiv_name = ReadIniValue($ThisConfigDir.'/'.$GeneralCfgFileName, 'general','vereinsplan_activecfg');
      $cfgLast_name = ReadIniValue($ThisConfigDir.'/'.$GeneralCfgFileName, 'general','vereinsplan_lastcfg');
      $cfg_hidesection  = ReadIniValue($ThisConfigDir.'/'.$GeneralCfgFileName, 'general','vereinsplan_hidesection');
      $cfg_createonedit = ReadIniValue($ThisConfigDir.'/'.$GeneralCfgFileName, 'general','vereinsplan_createplan');
   }
   if ($cfgLast_name == '' && file_exists($ThisConfigDir.'/'.$ConfigLastFileName)) {
       $cfgLast_name_file = fopen($ThisConfigDir.'/'.$ConfigLastFileName, "rb");
       $cfgLast_name = trim(fgets($cfgLast_name_file));
       fclose($cfgLast_name_file);
   }
   if ($cfgLast_name  !== '') { $cfgLast_exists = -1; $MyCfgNameEdit = $cfgLast_name;}
   if ($cfgAktiv_name !== '') { $cfgAktiv_exists = -1;$DefaultCfgFileNameAktiv = $cfgAktiv_name;}
   if ($cfg_hidesection  == '') {$cfg_hidesection  = 0;}
   if ($cfg_createonedit == '') {$cfg_createonedit = 1;}
}

isset($_POST['vereinsplandateiname']) ? $save_file_name=$_POST['vereinsplandateiname'] : $save_file_name=$MyCfgNameEdit;
isset($_POST['vereinsplancfg_auswahl']) ? $MyCfgNameEdit=$_POST['vereinsplancfg_auswahl'] : $MyCfgNameEdit=$DefaultCfgFileName;
isset($_POST['vereinsplancfg_exists']) ? $cfg_exists=$_POST['vereinsplancfg_exists'] : $cfg_exists=-1;
isset($_POST['vereinsplanligapfad']) ? $ligapfad=$_POST['vereinsplanligapfad'] : $ligapfad=$DefaultCfg_array['vereinsplan_ligapfad'];
isset($_POST['vereinsplancfgAktiv_auswahl']) ? $MyCfgFileNameAktiv=$_POST['vereinsplancfgAktiv_auswahl'] : $MyCfgFileNameAktiv=$DefaultCfgFileNameAktiv;
isset($_POST['vereinsplancfgAktiv_def']) ? $MyCfgFileNameDef=$_POST['vereinsplancfgAktiv_def'] : $MyCfgFileNameDef=$cfgAktiv_name;
isset($_POST['vereinsplancfgAktiv_exists']) ? $cfgAktiv_exists=$_POST['vereinsplancfgAktiv_exists'] : $cfgAktiv_exists=-1;
isset($_POST['vereinsplanhidesection']) ? $hidesection=$_POST['vereinsplanhidesection'] : $hidesection=$cfg_hidesection;
isset($_POST['vereinsplancreateonedit']) ? $createonedit=1 : $createonedit=$cfg_createonedit;

//Vereinsplan-cfg-Datei
$MyCfgFileExt = $MyCfgNameEdit.'.cfg';
$MyCfgFile = $ThisConfigDir.'/'.$MyCfgFileExt;
$MyCfgFileAktiv = $ThisConfigDir.'/'.$MyCfgFileNameAktiv.'.cfg';

if (is_dir($ThisConfigDir)) {
  //alle cfg-Dateien einlesen
  $cfg_verz=substr($ThisConfigDir,-1)=='/'?opendir(substr($ThisConfigDir.'/',0,-1)):opendir($ThisConfigDir.'/');
  $cfg_counter = 0;//$cfg_exists = -1;
  $cfg_exists = -1;$cfg_default_exists = -1;
  while($t_files=readdir($cfg_verz)) {
    if (strtolower(substr($t_files,-4))==".cfg"){
      $cfg_files[$cfg_counter++]=substr($t_files,0,-4);
      if (strtolower($MyCfgNameEdit)==strtolower($cfg_files[$cfg_counter-1])) {$cfg_exists=$cfg_counter-1;}
      if (strtolower($MyCfgFileNameAktiv)==strtolower($cfg_files[$cfg_counter-1])) {$cfgAktiv_exists=$cfg_counter-1;}
      if (strtolower($cfgAktiv_name)==strtolower($cfg_files[$cfg_counter-1])) {$cfgAktiv_exists=($cfg_counter-1);}
      if (strtolower($cfgLast_name)==strtolower($cfg_files[$cfg_counter-1])) {$cfgLast_exists=($cfg_counter-1);}
      if (strtolower($DefaultCfgFileName)==strtolower($cfg_files[$cfg_counter-1])) {$cfg_default_exists=($cfg_counter-1);}
    }
  }
  closedir($cfg_verz);
}

if ($cfg_exists==-1 && $cfg_counter>0) {
   if ($cfgAktiv_exists>-1) {$cfg_exists=$cfgAktiv_exists;}
   else {
      if ($cfgLast_exists>-1) {$cfg_exists=$cfgLast_exists;}
      else {
         if ($cfg_default_exists>-1) {$cfg_exists=$cfg_default_exists;}
         else {$cfg_exists=0;}
      }
   }
}

  $anzahl_ligen=0;
  //****************************************************************************
  //Konfigurationdatei einlesen
  //****************************************************************************
  if (!file_exists($MyCfgFile)) {
    $cfgfile_msg = $text[$MyAddonName][7011].' '.$MyCfgFileExt.' '.$text[$MyAddonName][7021];
    // die("Konfigurationsdatei: $MyCfgFile nicht gefunden!");
    $MyCfg_array = array_merge($DefaultCfg_array);

  }
  else {
    // Ini-Datei in Array lesen
    $cfgfile_msg = $text[$MyAddonName][7022].' '.$MyCfgFileExt;
    $MyCfg_array = parse_ini_file($MyCfgFile);
    $i = 1;
    $output = "";
    $fav_liga[] = array();
    $fav_liga_ok[] = array();
    $fav_team[][] = array();
    $fav_team_ok[][] = array();
    $tvh_Playlist[] = array();
    $tvh_nummer[] = array();
    $tvh_Erglist[] = array();
    $tvh_ErgNr[] = array();
    while (isset($MyCfg_array['liga'.$i])) {
      //Namen der gewüschte Liga einlesen
      $fav_liga[$i] = $MyCfg_array['liga'.$i];
      $fav_liga_ok[$i] = -1;
      $ii = 1;
      while (isset($MyCfg_array[$MyCfg_array['liga'.$i].'_'.$ii])) {
        //Nummer des gewünschten Teams einlesen
        $fav_team[$i][$ii] = $MyCfg_array[$MyCfg_array['liga'.$i].'_'.$ii];
        $fav_team_ok[$i][$ii] = -1;
        $ii++;
      }
      $i++;
    }
    $anzahl_ligen = --$i;

    // Prüfen, ob alle notwendigen Werte gesetzt sind
    foreach ($DefaultCfg_array as $key => $val) {
      if (!isset($MyCfg_array[$key])) {$MyCfg_array[$key]=$DefaultCfg_array[$key];}
    }
  }

  $fav_liga_ok[0] = $anzahl_ligen;
  $slider= $MyCfg_array['vereinsplan_slidemodus'];
  if ($MyCfg_array['vereinsplan_planoutputname']=="") {$MyCfg_array['vereinsplan_planoutputname']=$DefaultCfg_array['vereinsplan_planoutputname'];$output_exists=0;}
  $planoutput_file = $MyCfg_array['vereinsplan_planoutputname'];

  $tpl_exists = -2;$template_file = $MyCfg_array['vereinsplan_template'];
  $tpl_erg_exists = -2;$template_erg_file = $MyCfg_array['vereinsplan_template_erg'];
  if ($template_file  !== '') {$tpl_exists = -1;}
  if ($template_erg_file !== '') {$tpl_erg_exists = -1;}

  //template-Dateien einlesen
  $tmpl_counter = 0;;
  $tmpl_erg_counter = 0;
  if (is_dir($ThisTemplateDir)) {
    $tmpl_verz=substr($MyProgPathName,-1)=='/'?opendir(substr(PATH_TO_TEMPLATEDIR.'/'.$MyProgPathName.'/',0,-1)):opendir(PATH_TO_TEMPLATEDIR.'/'.$MyProgPathName.'/');

    while($t_files=readdir($tmpl_verz)) {
      if(strtolower(substr($t_files,-15))==".tpl.result.php"){
        $tpl_erg_files[$tmpl_erg_counter++]=substr($t_files,0,-15);
        if (strtolower($template_erg_file)==strtolower($tpl_erg_files[$tmpl_erg_counter-1])) {$tpl_erg_exists=$tmpl_erg_counter-1;}
      }
      else {
        if (strtolower(substr($t_files,-8))==".tpl.php"){
           $tpl_files[$tmpl_counter++]=substr($t_files,0,-8);
           if (strtolower($template_file)==strtolower($tpl_files[$tmpl_counter-1])) {$tpl_exists=$tmpl_counter-1;}
        }
      }
    }
    closedir($tmpl_verz);
 }

  $css_exists = -2;$css_file = $MyCfg_array['vereinsplan_cssname'];
  $css_slider_exists = -2;$css_slider_file = $MyCfg_array['vereinsplan_cssname_slider'];
  if ($css_file  !== '') {$css_exists = -1;}
  if ($css_slider_file !== '') {$css_slider_exists = -1;}

 //css-Dateien einlesen
  $css_counter = 0;
  $css_slider_counter = 0; ;
  if (is_dir($ThisCssDir)) {
    $css_verz=substr($MyProgPathName,-1)=='/'?opendir(substr(PATH_TO_TEMPLATEDIR.'/'.$MyProgPathName.'/css/',0,-1)):opendir(PATH_TO_TEMPLATEDIR.'/'.$MyProgPathName.'/css/');

    while($t_files=readdir($css_verz)) {
      if(strtolower(substr($t_files,-11))=="_slides.css"){
        $css_slider_files[$css_slider_counter++]=substr($t_files,0,-11);
        if (strtolower($css_slider_file)==strtolower($css_slider_files[$css_slider_counter-1])) {$css_slider_exists=$css_slider_counter-1;}
      }
      else {
        if (strtolower(substr($t_files,-4))==".css"){
           $css_files[$css_counter++]=substr($t_files,0,-4);
           if (strtolower($css_file)==strtolower($css_files[$css_counter-1])) {$css_exists=$css_counter-1;}
        }
      }
    }
    closedir($css_verz);
  }
  $liga_counter=0;
  $unbenannte_liga_counter=0;
  $ligadatei=array();

  $vp_dirliga=$ligapfad;
  if (substr($ligapfad,-1)!=='/') {$vp_dirliga=$ligapfad.'/';}

  $pfad_exists=true;
  if (!is_dir(PATH_TO_LMO."/".$vp_dirliga)) {$pfad_exists=false; echo $text[$MyAddonName][7058].$vp_dirliga.$text[$MyAddonName][7054];}
if ($pfad_exists) {
  $verz=substr($vp_dirliga,-1)=='/'?opendir(substr(PATH_TO_LMO."/".$vp_dirliga,0,-1)):opendir(PATH_TO_LMO."/".$vp_dirliga);

  while(false !== ($files=readdir($verz))){
    if(strtolower(substr($files,-4))==".l98") {
      $sekt="";
      $datei = fopen(PATH_TO_LMO."/".$vp_dirliga.$files,"rb");
      if ($datei) {
        $ligadatei[$liga_counter]['file_date']=filemtime(PATH_TO_LMO."/".$vp_dirliga.$files); //Datum
        $ligadatei[$liga_counter]['file_name']=$files;

        $ligadatei[$liga_counter]['liga_name']="";  //Liganame
        $ligadatei[$liga_counter]['anz_teams']="";  //Anzahl der Mannschaften
        $ligadatei[$liga_counter]['rundenbezeichnung']=$text[2];  //Spieltag oder Pokalrunde
        $ligadatei[$liga_counter]['aktueller_spieltag']="";  //Aktueller Spieltag
        while (!feof($datei)) {
          $zeile = fgets($datei,1000);
          $zeile=trim($zeile);
          if((substr($zeile,0,1)=="[") && (substr($zeile,-1)=="]")){  //Sektion
            $sekt=substr($zeile,1,-1);
          }elseif((strpos($zeile,"=")!==false) && (substr($zeile,0,1)!=";") && ($sekt=="Options")){  //Wert
            $option=explode("=",$zeile,2);
            $option_name=$option[0];
            $option_wert=isset($option[1])?$option[1]:'';

            if($option_name=="favTeam"){$ligadatei[$liga_counter]['favorit']=$option_wert;}
            if($option_name=="Name"){$ligadatei[$liga_counter]['liga_name']=$option_wert;}
            if($option_name=="Teams"){$ligadatei[$liga_counter]['anz_teams']=$option_wert;}
            if($option_name=="Actual"){$ligadatei[$liga_counter]['aktueller_spieltag']=$option_wert;}
            if($option_name=="Type"){
              if($option_wert=="1"){$ligadatei[$liga_counter]['rundenbezeichnung']=$text[370];}
            }          //Alle benötigten Werte gefunden -> Abbruch
            if($ligadatei[$liga_counter]['liga_name']!="" &&
               $ligadatei[$liga_counter]['favorit']!="" &&
               $ligadatei[$liga_counter]['aktueller_spieltag']!="" &&
               $ligadatei[$liga_counter]['anz_teams']!='')break;
         }
        }
        fclose($datei);
        if($ligadatei[$liga_counter]['liga_name']==""){
          $unbenannte_liga_counter++;
          $ligadatei[$liga_counter]['liga_name']=$text[507]." ".$unbenannte_liga_counter;
        }
        $liga_counter++;
      }
    }
  }
  closedir($verz);

  $_SESSION['liga_sort']=isset($_REQUEST['liga_sort'])?$_REQUEST['liga_sort']:$liga_sort;
  $_SESSION['liga_sort_direction']=isset($_REQUEST['liga_sort_direction'])?$_REQUEST['liga_sort_direction']:$liga_sort_direction;
  $subdir=str_replace(array('../','./'),array('',''),$subdir);
  usort($ligadatei,'cmp');
  if (isset($_SESSION['liga_sort_direction']) && $_SESSION['liga_sort_direction']=='desc') $ligadatei=array_reverse($ligadatei);

  $ligadatei_ok=array();
  $ligadatei_ok[0]=0;
  $z=1;
  foreach($ligadatei as $liga){
    $ligennamen[$z]=$liga['liga_name'];
    $ligenfile[$z]=$liga['file_name'];
    $ligenteams[$z]=$liga['anz_teams'];
    $ligenfavorit[$z]=$liga['favorit'];
    $ligena_spieltag[$z]=$liga['aktueller_spieltag'];

    //bestimmen, ob Liga in cfg-Datei definiert ist
    $ligadatei_ok[$z-1] =-1;
    for ($i=1; $i<=$anzahl_ligen; $i++) {
      if (strtolower($liga['file_name'])==strtolower($fav_liga[$i])) {
        $fav_liga_ok[$i] = $z-1;
        $ligadatei_ok[$z-1] = $i;
        --$fav_liga_ok[0];
      }
    }
    $z++;
  }
}
//feststellen, ob PDF-Erstellung ab LMO 4.0.0 möglich ist
$pdf_ok=0;
if (file_exists(PATH_TO_ADDONDIR."/classlib/classes/pdf/class.ezpdf.php") ) {$pdf_ok=1;}

  if (isset($_POST['vereinsplanE10'])) {
     $istfehler=0;
     isset($vereinsplancreateonedit) ? $creatonedit=1 : $createonedit=0;
     if (!WriteIniValue($ThisConfigDir.'/'.$GeneralCfgFileName, 'general','vereinsplan_activecfg', $MyCfgFileNameAktiv)) {$istfehler=1;}
     if (!WriteIniValue($ThisConfigDir.'/'.$GeneralCfgFileName, 'general','vereinsplan_hidesection', $hidesection)) {$istfehler=1;}
     if (!WriteIniValue($ThisConfigDir.'/'.$GeneralCfgFileName, 'general','vereinsplan_createplan', $createonedit)) {$istfehler=1;}
     if ($istfehler==0) {
        echo getMessage($text[$MyAddonName][7192].' '.$text[$MyAddonName][7193].': '.$text[$MyAddonName][7015]);
     } else {echo getMessage($text[$MyAddonName][7192].' '.$text[$MyAddonName][7193].': '.$text[$MyAddonName][7072].' '.$text[$MyAddonName][7015],TRUE);}
  }
  if (isset($_POST['vereinsplanB0'])) {
      $save_file_name=$_POST['vereinsplandateiname'];
  }
  if (isset($_POST['vereinsplanB1'])) {
      $save_file_name=$_POST['vereinsplandateiname'];
  }

if ($vereinsplan_form1) {
  isset($_POST['vereinsplanvereinsnamelang'])    ? $config_array[3]  ='vereinsplan_vereinsnamelang='.$_POST['vereinsplanvereinsnamelang']        : $config_array[3] ='vereinsplan_vereinsnamelang='.$MyCfg_array['vereinsplan_vereinsnamelang'];
  isset($_POST['vereinsplanvereinsnamekurz'])    ? $config_array[4]  ='vereinsplan_vereinsnamekurz='.$_POST['vereinsplanvereinsnamekurz']        : $config_array[4] ='vereinsplan_vereinsnamekurz='.$MyCfg_array['vereinsplan_vereinsnamekurz'];
  isset($_POST['vereinsplanvereinshalle'])       ? $config_array[5]  ='vereinsplan_vereinshalle='.$_POST['vereinsplanvereinshalle']              : $config_array[5] ='vereinsplan_vereinshalle='.$MyCfg_array['vereinsplan_vereinshalle'];
  isset($_POST['vereinsplantemplate'])           ? $config_array[8]  ='vereinsplan_template='.$_POST['vereinsplantemplate']                      : $config_array[8] ='vereinsplan_template='.$MyCfg_array['vereinsplan_template'];
  isset($_POST['vereinsplantemplate_erg'])       ? $config_array[9]  ='vereinsplan_template_erg='.$_POST['vereinsplantemplate_erg']              : $config_array[9] ='vereinsplan_template_erg='.$MyCfg_array['vereinsplan_template_erg'];
  isset($_POST['vereinsplandatumsformat'])       ? $config_array[10] ='vereinsplan_datumsformat='.$_POST['vereinsplandatumsformat']              : $config_array[10]='vereinsplan_datumsformat='.$MyCfg_array['vereinsplan_datumsformat'];
  isset($_POST['vereinsplanuhrzeitformat'])      ? $config_array[11] ='vereinsplan_uhrzeitformat='.$_POST['vereinsplanuhrzeitformat']            : $config_array[11]='vereinsplan_uhrzeitformat='.$MyCfg_array['vereinsplan_uhrzeitformat'];
  isset($_POST['vereinsplantordummy'])           ? $config_array[12] ='vereinsplan_tordummy='.$_POST['vereinsplantordummy']                      : $config_array[12]='vereinsplan_tordummy='.$MyCfg_array['vereinsplan_tordummy'];
  isset($_POST['vereinsplancache_refresh'])      ? $config_array[13] ='vereinsplan_cache_refresh='.$_POST['vereinsplancache_refresh']            : $config_array[13]='vereinsplan_cache_refresh='.$MyCfg_array['vereinsplan_cache_refresh'];
  $_POST['vereinsplancfg_ueberschreiben']==1     ? $config_array[14] ='vereinsplan_cfg_ueberschreiben=1'                                         : $config_array[14]='vereinsplan_cfg_ueberschreiben=0';
  isset($_POST['vereinsplanteam_highlight'])     ? $config_array[15] ='vereinsplan_team_highlight=1'                                             : $config_array[15]='vereinsplan_team_highlight=0';
  isset($_POST['vereinsplanplan_erstellen'])     ? $config_array[16] ='vereinsplan_plan_erstellen=1'                                             : $config_array[16]='vereinsplan_plan_erstellen=0';
  isset($_POST['vereinsplanslidemodus'])         ? $config_array[17] ='vereinsplan_slidemodus=1'                                                 : $config_array[17]='vereinsplan_slidemodus=0';
  isset($_POST['vereinsplanplanoutputname'])     ? $config_array[18] ='vereinsplan_planoutputname='.$_POST['vereinsplanplanoutputname']          : $config_array[18]='vereinsplan_planoutputname='.$MyCfg_array['vereinsplan_planoutputname'];
  isset($_POST['vereinsplannotiz'])              ? $config_array[19] ='vereinsplan_notiz='.$_POST['vereinsplannotiz']                            : $config_array[19]='vereinsplan_notiz=1';
  isset($_POST['vereinsplanpdf'])                ? $config_array[20] ='vereinsplan_pdf=1'                                                        : $config_array[20]='vereinsplan_pdf=0';
  isset($_POST['vereinsplanligapfad'])           ? $config_array[21] ='vereinsplan_ligapfad='.$_POST['vereinsplanligapfad']                      : $config_array[21]='vereinsplan_ligapfad='.$MyCfg_array['vereinsplan_ligapfad'];
  isset($_POST['vereinsplanligaicon'])           ? $config_array[22] ='vereinsplan_ligaicon='.$_POST['vereinsplanligaicon']                      : $config_array[22]='vereinsplan_ligaicon=1';
  isset($_POST['vereinsplanpdfliga'])            ? $config_array[23] ='vereinsplan_pdfliga=1'                                                    : $config_array[23]='vereinsplan_pdfliga=0';
  isset($_POST['vereinsplanpdfnotiz'])           ? $config_array[24] ='vereinsplan_pdfnotiz=1'                                                   : $config_array[24]='vereinsplan_pdfnotiz=0';
  isset($_POST['vereinsplanpdfformat'])          ? $config_array[25] ='vereinsplan_pdfformat=1'                                                  : $config_array[25]='vereinsplan_pdfformat=0';
  isset($_POST['vereinsplanpdfseitejemonat'])    ? $config_array[26] ='vereinsplan_pdfseitejemonat=1'                                            : $config_array[26]='vereinsplan_pdfseitejemonat=0';
  isset($_POST['vereinsplanpdfshowlogo1'])       ? $config_array[27] ='vereinsplan_pdfshowlogo1=1'                                               : $config_array[27]='vereinsplan_pdfshowlogo1=0';
  isset($_POST['vereinsplanpdflogo1'])           ? $config_array[28] ='vereinsplan_pdflogo1='.$_POST['vereinsplanpdflogo1']                      : $config_array[28]='vereinsplan_pdflogo1='.$MyCfg_array['vereinsplan_pdflogo1'];
  isset($_POST['vereinsplanpdflogo1w'])          ? $config_array[29] ='vereinsplan_pdflogo1w='.$_POST['vereinsplanpdflogo1w']                    : $config_array[29]='vereinsplan_pdflogo1w='.$MyCfg_array['vereinsplan_pdflogo1w'];
  isset($_POST['vereinsplanpdflogo1h'])          ? $config_array[30] ='vereinsplan_pdflogo1h='.$_POST['vereinsplanpdflogo1h']                    : $config_array[30]='vereinsplan_pdflogo1h='.$MyCfg_array['vereinsplan_pdflogo1h'];
  isset($_POST['vereinsplanpdflogo1x'])          ? $config_array[31] ='vereinsplan_pdflogo1x='.$_POST['vereinsplanpdflogo1x']                    : $config_array[31]='vereinsplan_pdflogo1x='.$MyCfg_array['vereinsplan_pdflogo1x'];
  isset($_POST['vereinsplanpdflogo1y'])          ? $config_array[32] ='vereinsplan_pdflogo1y='.$_POST['vereinsplanpdflogo1y']                    : $config_array[32]='vereinsplan_pdflogo1y='.$MyCfg_array['vereinsplan_pdflogo1y'];
  isset($_POST['vereinsplanpdflogo1xh'])         ? $config_array[33] ='vereinsplan_pdflogo1xh='.$_POST['vereinsplanpdflogo1xh']                  : $config_array[33]='vereinsplan_pdflogo1xh='.$MyCfg_array['vereinsplan_pdflogo1xh'];
  isset($_POST['vereinsplanpdflogo1yh'])         ? $config_array[34] ='vereinsplan_pdflogo1yh='.$_POST['vereinsplanpdflogo1yh']                  : $config_array[34]='vereinsplan_pdflogo1yh='.$MyCfg_array['vereinsplan_pdflogo1yh'];
  isset($_POST['vereinsplanpdflogo1xq'])         ? $config_array[35] ='vereinsplan_pdflogo1xq='.$_POST['vereinsplanpdflogo1xq']                  : $config_array[35]='vereinsplan_pdflogo1xq='.$MyCfg_array['vereinsplan_pdflogo1xq'];
  isset($_POST['vereinsplanpdflogo1yq'])         ? $config_array[36] ='vereinsplan_pdflogo1yq='.$_POST['vereinsplanpdflogo1yq']                  : $config_array[36]='vereinsplan_pdflogo1yq='.$MyCfg_array['vereinsplan_pdflogo1yq'];
  isset($_POST['vereinsplanpdfshowlogo2'])       ? $config_array[37] ='vereinsplan_pdfshowlogo2=1'                                               : $config_array[37]='vereinsplan_pdfshowlogo2=0';
  isset($_POST['vereinsplanpdflogo2'])           ? $config_array[38] ='vereinsplan_pdflogo2='.$_POST['vereinsplanpdflogo2']                      : $config_array[38]='vereinsplan_pdflogo2='.$MyCfg_array['vereinsplan_pdflogo2'];
  isset($_POST['vereinsplanpdflogo2w'])          ? $config_array[39] ='vereinsplan_pdflogo2w='.$_POST['vereinsplanpdflogo2w']                    : $config_array[39]='vereinsplan_pdflogo2w='.$MyCfg_array['vereinsplan_pdflogo2w'];
  isset($_POST['vereinsplanpdflogo2h'])          ? $config_array[40] ='vereinsplan_pdflogo2h='.$_POST['vereinsplanpdflogo2h']                    : $config_array[40]='vereinsplan_pdflogo2h='.$MyCfg_array['vereinsplan_pdflogo2h'];
  isset($_POST['vereinsplanpdflogo2x'])          ? $config_array[41] ='vereinsplan_pdflogo2x='.$_POST['vereinsplanpdflogo2x']                    : $config_array[41]='vereinsplan_pdflogo2x='.$MyCfg_array['vereinsplan_pdflogo2x'];
  isset($_POST['vereinsplanpdflogo2y'])          ? $config_array[42] ='vereinsplan_pdflogo2y='.$_POST['vereinsplanpdflogo2y']                    : $config_array[42]='vereinsplan_pdflogo2y='.$MyCfg_array['vereinsplan_pdflogo2y'];
  isset($_POST['vereinsplanpdflogo2xh'])         ? $config_array[43] ='vereinsplan_pdflogo2xh='.$_POST['vereinsplanpdflogo2xh']                  : $config_array[43]='vereinsplan_pdflogo2xh='.$MyCfg_array['vereinsplan_pdflogo2xh'];
  isset($_POST['vereinsplanpdflogo2yh'])         ? $config_array[44] ='vereinsplan_pdflogo2yh='.$_POST['vereinsplanpdflogo2yh']                  : $config_array[44]='vereinsplan_pdflogo2yh='.$MyCfg_array['vereinsplan_pdflogo2yh'];
  isset($_POST['vereinsplanpdflogo2xq'])         ? $config_array[45] ='vereinsplan_pdflogo2xq='.$_POST['vereinsplanpdflogo2xq']                  : $config_array[45]='vereinsplan_pdflogo2xq='.$MyCfg_array['vereinsplan_pdflogo2xq'];
  isset($_POST['vereinsplanpdflogo2yq'])         ? $config_array[46] ='vereinsplan_pdflogo2yq='.$_POST['vereinsplanpdflogo2yq']                  : $config_array[46]='vereinsplan_pdflogo2yq='.$MyCfg_array['vereinsplan_pdflogo2yq'];
  isset($_POST['vereinsplansliderstart'])        ? $config_array[47] ='vereinsplan_sliderstart='.$_POST['vereinsplansliderstart']                : $config_array[47]='vereinsplan_sliderstart='.$MyCfg_array['vereinsplan_sliderstart'];
  isset($_POST['vereinsplannotizsymbol'])        ? $config_array[48] ='vereinsplan_notizsymbol='.$_POST['vereinsplannotizsymbol']                : $config_array[48]='vereinsplan_notiz=lmo-st2.gif';
  isset($_POST['vereinsplannotizkopftext'])      ? $config_array[49] ='vereinsplan_notizkopftext='.$_POST['vereinsplannotizkopftext']            : $config_array[49]='vereinsplan_notizkopftext=Notiz';
  isset($_POST['vereinsplanbericht'])            ? $config_array[50] ='vereinsplan_bericht='.$_POST['vereinsplanbericht']                        : $config_array[50]='vereinsplan_bericht=1';
  isset($_POST['vereinsplanberichtsymbol'])      ? $config_array[51] ='vereinsplan_berichtsymbol='.$_POST['vereinsplanberichtsymbol']            : $config_array[51]='vereinsplan_berichtsymbol=lmo-st1.gif';
  isset($_POST['vereinsplanberichtkopftext'])    ? $config_array[52] ='vereinsplan_berichtkopftext='.$_POST['vereinsplanberichtkopftext']        : $config_array[52]='vereinsplan_berichtkopftext=Bericht';
  isset($_POST['vereinsplanligasymbol'])         ? $config_array[53] ='vereinsplan_ligasymbol='.$_POST['vereinsplanligasymbol']                  : $config_array[53]='vereinsplan_ligasymbol=tabelle.gif';
  isset($_POST['vereinsplanligakopftext'])       ? $config_array[54] ='vereinsplan_ligakopftext='.$_POST['vereinsplanligakopftext']              : $config_array[54]='vereinsplan_ligakopftext=Klasse';
  isset($_POST['vereinsplanligalink'])           ? $config_array[55] ='vereinsplan_ligalink=1'                                                   : $config_array[55]='vereinsplan_ligalink=0';
  isset($_POST['vereinsplanteamhplink'])         ? $config_array[56] ='vereinsplan_teamhplink=1'                                                 : $config_array[56]='vereinsplan_teamhplink=0';
  isset($_POST['vereinsplanteamname'])           ? $config_array[57] ='vereinsplan_teamname='.$_POST['vereinsplanteamname']                      : $config_array[57]='vereinsplan_teamname=0';
  isset($_POST['vereinsplanteamlogo'])           ? $config_array[58] ='vereinsplan_teamlogo='.$_POST['vereinsplanteamlogo']                      : $config_array[58]='vereinsplan_teamlogo=1';
  isset($_POST['vereinsplanteamplan'])           ? $config_array[59] ='vereinsplan_teamplan=1'                                                   : $config_array[59]='vereinsplan_teamplan=0';
  isset($_POST['vereinsplanteamhpsymbol'])       ? $config_array[60] ='vereinsplan_teamhpsymbol='.$_POST['vereinsplanteamhpsymbol']              : $config_array[60]='vereinsplan_teamhpsymbol=url.png';
  isset($_POST['vereinsplanusemootools'])        ? $config_array[61] ='vereinsplan_usemootools=1'                                                : $config_array[61]='vereinsplan_usemootools=0';
  isset($_POST['vereinsplancssname'])            ? $config_array[62] ='vereinsplan_cssname='.$_POST['vereinsplancssname']                        : $config_array[62]='vereinsplan_cssname='.$MyCfg_array['vereinsplan_cssname'];
  isset($_POST['vereinsplancssname_slider'])     ? $config_array[63] ='vereinsplan_cssname_slider='.$_POST['vereinsplancssname_slider']          : $config_array[63]='vereinsplan_cssname_slider='.$MyCfg_array['vereinsplan_cssname_slider'];
  isset($_POST['vereinsplanxhtml'])              ? $config_array[64] ='vereinsplan_xhtml=1'                                                      : $config_array[64]='vereinsplan_xhtml=0';
  isset($_POST['vereinsplanteamhptarget'])       ? $config_array[65] ='vereinsplan_teamhptarget=1'                                               : $config_array[65]='vereinsplan_teamhptarget=0';
  isset($_POST['vereinsplanteamplantarget'])     ? $config_array[66] ='vereinsplan_teamplantarget=1'                                             : $config_array[66]='vereinsplan_teamplantarget=0';
  isset($_POST['vereinsplanligatarget'])         ? $config_array[67] ='vereinsplan_ligatarget=1'                                                 : $config_array[67]='vereinsplan_ligatarget=0';
  isset($_POST['vereinsplanberichttarget'])      ? $config_array[68] ='vereinsplan_berichttarget=1'                                              : $config_array[68]='vereinsplan_berichttarget=0';
  isset($_POST['vereinsplanpdftarget'])          ? $config_array[69] ='vereinsplan_pdftarget=1'                                                  : $config_array[69]='vereinsplan_pdftarget=0';
  isset($_POST['vereinsplandatumshow'])          ? $config_array[70] ='vereinsplan_datumshow=1'                                                  : $config_array[70]='vereinsplan_datumshow=0';

  $output_file = $_POST['vereinsplanplanoutputname'];
  $save_config_array=implode(';',$config_array);
}

if ($vereinsplan_form2) {
    $MyCfgNameEdit=$_POST['vereinsplancfg_auswahl'];
    $MyCfgFileNameAktiv=$_POST['vereinsplancfgAktiv_auswahl'];
    $output_file=$_POST['vereinsplanplanoutputname'];
    $save_file_name=$_POST['vereinsplandateiname'];
    $config_array=explode(';',$_POST['vereinsplanconfig_array']);
    $save_config_array=implode(';',$config_array);
    $zz=1;
    $z=$_POST['vereinsplanzaehler'];
    for ($i=1; $i<$z; $i++) {
      $h='vereinsplanc'.$i;
      if (isset ($_POST[$h])){
         $vereinsplanausgewaehlte_ligen[$zz++]=$i;
       }
    }
}

$z=1;
$error_dateiopen=false; $speicherflag=false;
if ($vereinsplan_form3) {
  $output_file=$_POST['vereinsplanplanoutputname'];
  $createplan=$_POST['vereinsplanplan_erstellen'];
  $createpdf=$_POST['vereinsplanpdf'];
  $pdfform=$_POST['vereinsplanpdfformat'];
  $save_file_name=$_POST['vereinsplandateiname'];
  $vp_dirliga = $_POST['vereinsplanvpdirliga'];
  $config_array=explode(';',$_POST['vereinsplanconfig_array']);

  $zz=1;
  $anz_ligen=0;
  $teamnr=0;
  $flag=TRUE;
  $save_array[1]='[Ligen]';
  $doppelt_check="";
  $z=$_POST['vereinsplanzaehler'];

  for ($i=0; $i<=$z; $i++) {
    $h='vereinsplant'.$i;
    if (isset ($_POST[$h])){
      $ldn=$_POST[$h];
      $ligen_datei=substr($ldn,0,strrpos($ldn,'['));
      $team=substr($ldn,strrpos($ldn,'[')+1);
      $team=substr($team,0,strrpos($team,']'));
      $liga1= new liga();
      if ($liga1->loadFile(PATH_TO_LMO.'/'.$vp_dirliga.$ligen_datei) == TRUE) { // Ligenfile vorhanden?
        $file_ligen_datei=file(chop(PATH_TO_LMO.'/'.$vp_dirliga.$ligen_datei));
        if ($ligen_datei!=$doppelt_check) {
          $doppelt_check=$ligen_datei;
          $zz++;  $anz_ligen++;
          $save_array[$zz]='liga'.$anz_ligen.'='.$ligen_datei;
          $teamnr=0;
        }
      } else {
        echo $MyAddonName." Formular SAVE_FILE: ".PATH_TO_LMO.'/'.$vp_dirliga.$ligen_datei." ".$text[$MyAddonName][7054]."<br>";
      }
      $zz++; $teamnr++;
      $save_array[$zz]=$ligen_datei.'_'.$teamnr.'='.$team;
    }
  }
  $savedateiname=PATH_TO_CONFIGDIR.'/'.$MyProgPathName.'/'.$save_file_name;
  $error_dateiopen=false;
  $createplan_msg="";
  if(!$fp=fopen($savedateiname,"w")) {
    $error_dateiopen=true; echo $MyAddonName.': '.$text[$MyAddonName][7067];
  } else  {
    $config_array=explode(';',$_POST['vereinsplanconfig_array']);
    $config_cnt=count($config_array);
    $config_array[$config_cnt]='vereinsplan_cfg_anwender='.$_SESSION["lmousername"];
    $config_array[++$config_cnt]='vereinsplan_cfg_gespeichert='.date("d.m.y H:i:s");

    fwrite($fp,"[config]\n");
    foreach ($config_array as $w) {
      if (!$ok=fwrite($fp,$w.chr(10))) {
        $error_dateiopen=true;
      }
    }
    foreach ($save_array as $w) {
      if (!$ok=fwrite($fp,$w.chr(10))) {
       $error_dateiopen=true;
      }
    }
    fclose ($fp);
    $cfg_arg = '?cfg='.substr($save_file_name,0,-4);
    if (strtolower(substr($save_file_name,-4))==".cfg" && $createplan) {
        $cfg_name=substr($save_file_name,0,-4);
        $vereinsplansave=$ThisAddonDir."/createvereinsplan.php";
        include($vereinsplansave);
        if (!WriteIniValue($ThisConfigDir.'/vereinsplan.generalcfg', 'general','vereinsplan_lastcfg', substr($save_file_name,0,-4))) {
           echo getMessage(substr($save_file_name,0,-4).' '.$text[$MyAddonName][7014].': '.$text[$MyAddonName][7072].' '.$text[$MyAddonName][7015],TRUE);
        }
        $createplan_msg = " ".$text[$MyAddonName][7066];
        if ($vereinsplansetactivecfg) {
           if (!WriteIniValue($ThisConfigDir.'/vereinsplan.generalcfg', 'general','vereinsplan_activecfg', substr($save_file_name,0,-4))) {
              echo getMessage(substr($save_file_name,0,-4).' '.$text[$MyAddonName][7014].': '.$text[$MyAddonName][7072].' '.$text[$MyAddonName][7015],TRUE);
           }
        }
    }
  }
}

// FORMULARE

if($vereinsplan_form3) {

echo getMessage($text[138].$createplan_msg);
?>
<!-- *** Start Endformular mit Anwender-Info*** -->

      <table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0" width="600">
        <tr>
         <?php if (strtolower(substr($save_file_name,-4))==".cfg") { ?>
          <th align="center"><h1><?php echo $text[$MyAddonName][7062]." ".$text[$MyAddonName][7063]." ".$text[$MyAddonName][7064]; ?></h1></th>
         <?php }else { ?>
          <th align="center"><h1><?php echo $text[$MyAddonName][7068]; ?></h1></th>
         <?php } ?>
        </tr>
        <tr>
          <td class="nobr">
            <form action="#">
              <table class="lmoInner" cellspacing="0" cellpadding="0" border="0" width="100%">
                <tr>
                  <td class="nobr" colspan="2">
                 <?php if (strtolower(substr($save_file_name,-4))==".cfg") { ?>
                    <textarea  rows="6"  cols="80"><?php echo trim("\n".$text[$MyAddonName][7062].":\n".$ThisAddonUrl."/showvereinsplan.php".$cfg_arg."\n\n".$text[$MyAddonName][7063].":\n".$ThisAddonUrl."/showvereinsplan.php".$cfg_arg."&planart=result");?></textarea>
                 <?php }else{ ?>
                    <textarea  rows="3"  cols="80"><?php echo trim("\n".$text[$MyAddonName][7069].": ".$save_file_name."\n".$text[$MyAddonName][7068].":\n".$text[$MyAddonName][7070]." '.cfg' ");?></textarea>
                 <?php } ?>
                  </td>
                </tr>
               <?php if (strtolower(substr($save_file_name,-4))==".cfg") { ?>
                <tr>
               <td class="nobr" colspan="2"><h1><?php echo $text[$MyAddonName][7065]; ?></h1></td>
                </tr>
                <tr>
                  <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                  <td><a target="_blank" href="<?php echo $ThisAddonUrl.'/showvereinsplan.php'.$cfg_arg ?>" title=" <?php echo $text[$MyAddonName][7104].' '.$text[$MyAddonName][7126].' '.$text[$MyAddonName][7107]?>"><?php echo $text[$MyAddonName][7104].' '.$text[$MyAddonName][7126].' '.$text[$MyAddonName][7107]?></a></td>
                  <?php if ($createpdf) { $pdfarg=""; if ($pdfform) {$pdfarg="&format=1";}
                  ?>
                  <td><a target="_blank" href="<?php echo $ThisAddonUrl.'/vereinsplan-pdf.php'.$cfg_arg.$pdfarg ?>" title=" <?php echo $text[$MyAddonName][7103].' '.$text[$MyAddonName][7117]?>"><?php echo $text[$MyAddonName][7116].': '.$text[$MyAddonName][7104]?></a></td>
                  <?php }else {?>
                  <td colspan="2">&nbsp;</td>
                  <?php }?>
                  </tr>
                <tr>
                  <td class="nobr" align="center" colspan="2">
                    <input type="submit" class="lmo-formular-button" value="<?php echo $text[$MyAddonName][7198];  ?> >>" name="vereinsplanB4">
                    <input type="hidden" name="action" value="admin">
                    <input type="hidden" name="todo" value="vereinsplanoptions">
                  </td>
                </tr>

               <?php } ?>
              </table>
            </form>
          </td>
        </tr>
        <tr>
          <td class="lmoFooter"><?php echo $text[$MyAddonName][7200]; ?></td>
        </tr>
      </table>
<!-- *** Ende Endformular mit Anwender-Info*** -->
<?php
}

if ((!$vereinsplan_form0 && !$vereinsplan_form1 && !$vereinsplan_form2 && !$vereinsplan_form3) || isset($_POST['vereinsplanE10'])) {
?>

<!-- *** Start Formular Konfigurationsauswahl *** -->
      <table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0" width="600">
        <tr>
          <th align="center"><h1><?php echo $text[$MyAddonName][7001];  ?></h1></td>
        </tr>
        <tr>
          <td class="nobr">
            <form name="vereinsplanB0" method="POST" action="<?php echo $_SERVER['PHP_SELF'].'?action=admin&todo=vereinsplanoptions'; ?>">
              <table class="lmoInner" cellspacing="0" cellpadding="0" border="0" width="100%">
                <tr>
                  <th colspan="2" align="center"><?php echo $text[$MyAddonName][7010]; ?></th>
                </tr>
                <!-- Start Konfigurationsdatei edit -->
                <tr>
                  <td class="nobr" align="right">
                    <table class="lmoInner" cellspacing="0" cellpadding="0" border="0" width="100%">
                      <tr>
                        <td class="nobr" align="right" id="vereinsplancfgLasttxt"<?php if ($cfgLast_exists==-1) {echo ' style="color:red"';}?>><?php echo $text[$MyAddonName][7011]; ?>&nbsp;</td>
                        <td class="nobr" align="left"><select class="lmo-formular-input" id="vereinsplancfg_auswahl" name="vereinsplancfg_auswahl" onChange="chkinput(this,this.options[this.selectedIndex].value,'0')"> size="1">
                        <?php if ($cfgLast_exists==-1) {
                                echo '<option selected="selected" disabled="disabled">'.$cfgLast_name.'</option>'.chr(13);
                             }
                        ?>
                        <?php if ($cfg_counter==0) { echo '<option selected="selected">'.$MyCfgNameEdit.'</option>'.chr(13);}
                           for($cfg=0; $cfg<$cfg_counter; $cfg++) {
                             if ($cfg==$cfgLast_exists) {
                                echo '<option selected="selected">'.$cfg_files[$cfg].'</option>'.chr(13);
                             }
                             else {
                                echo '<option>'.$cfg_files[$cfg].'</option>'.chr(13);
                             }
                           }
                           ?>
                          </select>
                        </td>
                        <td class="nobr" align="right">
                          <input type="submit" class="lmo-formular-button" <?php if ($cfgLast_exists==-1) {echo 'disabled="disabled" ';}?> value="<?php echo $text[$MyAddonName][7013];  ?> >>" name="vereinsplanB0">
                          <input type="hidden" name="vereinsplanaction" value="admin">
                          <input type="hidden" name="vereinsplanform0" value="1">
                          <input type="hidden" name="vereinsplancfg_exists" value=<?php echo $cfg_exists;?>>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <!-- Ende Konfigurationsdatei edit -->
                <!-- Start allgemeine Ansichtsoptionen Ergebnisspeicherung  -->
                <tr>
                  <td class="nobr" align="right">
                    <table class="lmoInner" cellspacing="0" cellpadding="0" border="0" width="100%">
                      <tr>
                        <td class="nobr"  align="center" colspan="4"><?php echo $text[$MyAddonName][7017];  ?>&nbsp;</td>
                      </tr>
                      <tr> <!-- Abschnitt anzeigen Admins und Dateien erstellen  -->
                        <td class="nobr" align="right">&nbsp;<?php echo $text[$MyAddonName][7194].' '.$text[$MyAddonName][7107].' '.$text[$MyAddonName][7196].' '.$text[$MyAddonName][7018]; ?>&nbsp;</td>
                        <td class="nobr" align="left" height="22"><input class="lmo-formular-input" type="radio" value="1" name="vereinsplanhidesection" <?php if ($hidesection==1) {echo 'checked="checked" ';} ?>  ></td>
                        <td class="nobr" align="left"><input class="lmo-formular-input" type="checkbox" name="vereinsplancreateonedit" <?php if ($createonedit==1) {echo 'checked="checked" ';} ?>>&nbsp;&nbsp;</td>
                        <td class="nobr" align="left"><?php echo $text[$MyAddonName][7019];  ?></td>
                      </tr>
                      <tr> <!-- Abschnitt anzeigen Alle -->
                        <td class="nobr" align="right" >&nbsp;<?php echo $text[$MyAddonName][7196].' '.$text[$MyAddonName][7197];  ?>&nbsp;</td>
                        <td class="nobr" align="left" height="22" colspan="3"><input class="lmo-formular-input" type="radio" value="0" name="vereinsplanhidesection" <?php if ($hidesection==0) {echo 'checked="checked" ';} ?>  ></td>
                      </tr>
                      <tr>
                      </tr>
                      <tr>
                        <td class="nobr"  align="center" colspan="4">&nbsp;</td>
                      </tr>
                      <tr> <!-- aktive Konfigurationsdatei verwenden -->
                        <td class="nobr" align="right" id="vereinsplancfgAktivtxt"<?php if ($cfgAktiv_exists==-1) {echo ' style="color:red"';}?>><?php echo $text[$MyAddonName][7011].' '.$text[$MyAddonName][7026]; ?>&nbsp;</td>
                        <td class="nobr" align="left"><select class="lmo-formular-input" id="vereinsplancfgAktiv_auswahl" name="vereinsplancfgAktiv_auswahl" onChange="chkinput(this,this.options[this.selectedIndex].value,'0')"> size="1">
                        <?php if ($cfgAktiv_exists==-1 && $cfgAktiv_name <>"") {
                                echo '<option selected="selected" disabled="disabled">'.$cfgAktiv_name.'</option>'.chr(13);
                             }
                        ?>
                        <?php if ($cfg_counter==0) { echo '<option selected="selected">'.$MyCfgFileNameAktiv.'</option>'.chr(13);}
                           for($cfg=0; $cfg<$cfg_counter; $cfg++) {
                             if ($cfg==$cfgAktiv_exists) {
                                echo '<option selected="selected">'.$cfg_files[$cfg].'</option>'.chr(13);
                             }
                             else {
                                echo '<option>'.$cfg_files[$cfg].'</option>'.chr(13);
                             }
                           }
                           ?>
                          </select>
                        </td>
                        <td class="nobr" align="right" colspan="2">
                          <input type="submit" class="lmo-formular-button" <?php if ($cfgAktiv_exists==-1) {echo 'disabled="disabled" ';}?> value="<?php echo '&nbsp;'.$text[$MyAddonName][7014];?> >>" name="vereinsplanE10">
                          <input type="hidden" name="vereinsplanactionAktiv" value="admin">
                          <input type="hidden" name="vereinsplanform0Aktiv" value="1">
                          <input type="hidden" id="vereinsplancfgAktiv_exists" name="vereinsplancfgAktiv_exists" value=<?php echo $cfgAktiv_exists;?>>
                        </td>
                      </tr>
                    </table>
                  </td>

                </tr>
                <!-- Ende allgemeine Ansichtsoptionen Ergebnisspeicherung  -->
              </table>
            </form>
          </td>
        </tr>
        <tr>
          <td class="lmoFooter"><?php echo $text[$MyAddonName][7200]; ?></td>
        </tr>
      </table>
<!-- *** Ende Formular Konfigurationsauswahl *** -->

<?php
}

if ($vereinsplan_form0 && !$vereinsplan_form1 && !$vereinsplan_form2 && !$vereinsplan_form3 && !isset($_POST['vereinsplanE10']))  {
?>
<!-- Start Formular Basiseinstellungen  -->
      <table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0" width="600">
        <tr>
          <th align="center"><h1><?php echo $text[$MyAddonName][7001];  ?></h1></td>
        </tr>
        <tr>
          <td class="nobr">
            <form  name="vereinsplanB1" method="POST" action="<?php echo $_SERVER['PHP_SELF'].'?action=admin&todo=vereinsplanoptions'; ?>">
              <table class="lmoInner" cellspacing="0" cellpadding="0" border="0" width="100%">
                <tr>
                  <th colspan="2" align="center"><?php echo $text[$MyAddonName][7020]; ?></th>
                </tr>
<!--Start Basiseinstellungen ---------------------------------->
                <tr>
                  <td class="nobr" align="right">
                    <!-- Konfigurationsdatei -->
                    <table class="lmoInner" cellspacing="0" cellpadding="0" border="0" width="100%">
                      <tr>
                        <td class="nobr"  align="left" colspan="2"><?php echo $cfgfile_msg;  ?>&nbsp;</td>
                        <td class="nobr" align="left">&nbsp;<?php echo $text[$MyAddonName][7023];  ?></td>
                        <td class="nobr" align="left" height="22"><input class="lmo-formular-input" type="radio" value="1" name="vereinsplancfg_ueberschreiben" <?php if ($MyCfg_array['vereinsplan_cfg_ueberschreiben']==1) {echo 'checked="checked" ';} ?>  onClick="useCfg(this,'1')"></td>
                      </tr>
                      <tr>
                        <td class="nobr"  align="right" id="vereinsplancfgnew"<?php if ($MyCfg_array['vereinsplan_cfg_ueberschreiben']==1) {echo ' style="color:gray"';}?>><?php echo $text[$MyAddonName][7024]; ?>&nbsp;</td>
                        <td class="nobr" align="left" height="22"><input class="lmo-formular-input" type="text" id="vereinsplandateiname" name="vereinsplandateiname" size="20" <?php if ($MyCfg_array['vereinsplan_cfg_ueberschreiben']==1) {echo 'disabled="disabled" '; echo 'style="color:gray"';} ?> onkeyup="chkinput(this,this.value,'0')" onblur="chkinput(this,this.value,'1')" value="<?php echo $MyCfgNameEdit;  ?>"></td>
                        <td class="nobr" align="left" id="vereinsplancfgnew2"<?php if ($MyCfg_array['vereinsplan_cfg_ueberschreiben']==1) {echo ' style="color:gray"';}?>><?php echo $text[$MyAddonName][7025]; ?> </td>
                        <td class="nobr" align="left" height="22"><input class="lmo-formular-input" type="radio" value="2" name="vereinsplancfg_ueberschreiben" <?php if ($MyCfg_array['vereinsplan_cfg_ueberschreiben']==0) {echo 'checked="checked" ';} ?>  onClick="useCfg(this,'0')"></td>
                      </tr>
                    </table>
                    <br>
                    <!-- einzulesendes Verzeichnis  -->
                    <table class="lmoInner" cellspacing="0" cellpadding="0" border="0" width="100%">
                      <tr>
                        <td class="nobr" align="right" width="23%"  id="vereinsplanligapfadtxt" <?php  if (!$pfad_exists) {echo ' style="color:red"';}?>><?php echo $text[$MyAddonName][7058]; ?>:&nbsp;lmo/&nbsp;</td>
                        <td class="nobr" align="left" colspan="3" height="22"><input class="lmo-formular-input"  type="text" name="vereinsplanligapfad" size="30" onkeyup="chkinput(this,this.value,'0')" onBlur="trimpfad(this,this.value)" value="<?php echo $MyCfg_array['vereinsplan_ligapfad']; ?>"></td>
                      </tr>
                    </table>
                    <br>
                    <!-- allgemeine Vereins-Angaben  -->
                    <table class="lmoInner"cellspacing="1" cellpadding="0" border="0" width="100%">
                      <tr>
                        <td class="nobr"  align="center" colspan="4" style="color:blue;" ><?php echo $text[$MyAddonName][7027].' '.$text[$MyAddonName][7028];  ?>&nbsp;</td>
                      </tr>
                      <tr>  <!-- Vereinsnamen -->
                        <td class="nobr" align="right"><?php echo $text[$MyAddonName][7030]; ?>&nbsp;</td>
                        <td class="nobr" align="left" height="22"><input class="lmo-formular-input"  type="text" name="vereinsplanvereinsnamelang" size="20" value="<?php echo $MyCfg_array['vereinsplan_vereinsnamelang']; ?>"></td>
                        <td class="nobr" align="right"><?php echo $text[$MyAddonName][7031]; ?>&nbsp;</td>
                        <td class="nobr" align="left"><input class="lmo-formular-input" type="text" name="vereinsplanvereinsnamekurz" size="5" value="<?php echo $MyCfg_array['vereinsplan_vereinsnamekurz']; ?>"> </td>
                      </tr>
                      <tr>
                        <td class="nobr" align="right"><?php echo $text[$MyAddonName][7032]; ?>&nbsp;</td>
                        <td class="nobr" align="left" colspan="3" height="22"><input class="lmo-formular-input"  type="text" name="vereinsplanvereinshalle" size="20" value="<?php echo $MyCfg_array['vereinsplan_vereinshalle']; ?>"></td>
                      </tr>
                    </table>
                    <br>
                    <table class="lmoInner" cellspacing="1" cellpadding="0" border="0" width="100%">
                      <tr> <!-- Auswahl Formatsteuerung -->
                        <td class="nobr"  align="center" colspan="6" style="color:blue;" ><?php echo $text[$MyAddonName][7029];  ?>&nbsp;</td>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="6"> <!-- Auswahl datum  tordummy zeit  cache-->
                          <table class="lmoInner"cellspacing="1" cellpadding="0" border="0" width="100%">
                            <tr> <!-- datum / immer anzeigen  -->
                              <td class="nobr" align="right"><?php echo $text[$MyAddonName][7036]; ?>&nbsp;</td>
                              <td class="nobr" align="left"><input class="lmo-formular-input" type="text" name="vereinsplandatumsformat" size="6" value="<?php echo $MyCfg_array['vereinsplan_datumsformat']; ?>"></td>
                              <td class="nobr" align="right"><?php echo $text[$MyAddonName][7075];  ?>&nbsp;</td>
                              <td class="nobr" align="left"><input class="lmo-formular-input" type="checkbox" name="vereinsplandatumshow" <?php if ($MyCfg_array['vereinsplan_datumshow']==1) {echo 'checked="checked" ';}?>></td>
                            </tr>
                            <tr> <!-- zeit  tordummy (cache) -->
                              <td class="nobr" align="right"><?php echo $text[$MyAddonName][7037];  ?>&nbsp;</td>
                              <td class="nobr" align="left"><input class="lmo-formular-input" type="text" name="vereinsplanuhrzeitformat" size="6" value="<?php echo $MyCfg_array['vereinsplan_uhrzeitformat']; ?>"></td>
                              <td class="nobr" align="right"><?php echo $text[$MyAddonName][7038];  ?>&nbsp;</td>
                              <td class="nobr" align="left"><input class="lmo-formular-input" type="text" name="vereinsplantordummy" size="1" value="<?php echo $MyCfg_array['vereinsplan_tordummy']; ?>"></td>
<!--
                              <td class="nobr" align="right"><acronym title="<?php echo $text[$MyAddonName][7040]; ?>"><?php echo $text[$MyAddonName][7039]; ?>&nbsp;</acronym></td>
                              <td class="nobr" align="left"><input class="lmo-formular-input" type="text" name="vereinsplancache_refresh" size="3" value="<?php echo $MyCfg_array['vereinsplan_cache_refresh']; ?>"></td>
-->
                            </tr>
                          </table>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="6"> <!-- Auswahl Templates und Stylesheets -->
                          <table class="lmoInner"cellspacing="1" cellpadding="0" border="0" width="100%">
                            <tr> <!-- Auswahl Template -->
                              <td class="nobr" align="right"<?php if ($tpl_exists==-1) {echo ' style="color:red"';}?>><?php echo $text[$MyAddonName][7033]; ?>&nbsp;<?php echo $text[$MyAddonName][7035]; ?>&nbsp;</td>
                              <td class="nobr" align="left">
                                <select class="lmo-formular-input"  name="vereinsplantemplate" size="1">
                                  <?php
                                  if ($tpl_exists==-1) {echo '<option disabled="disabled">'.$MyCfg_array['vereinsplan_template'].'</option>'.chr(13);}
                                  for($tpl=0; $tpl<$tmpl_counter; $tpl++) {
                                    if ($tpl==$tpl_exists) {
                                      echo '<option selected="selected">'.$tpl_files[$tpl].'</option>'.chr(13);
                                    }
                                    else {
                                      if ( $DefaultCfg_array['vereinsplan_template']==$tpl_files[$tpl] && $tpl_exists==-1) {echo '<option selected="selected">'.$tpl_files[$tpl].'</option>'.chr(13);}
                                      else { echo '<option>'.$tpl_files[$tpl].'</option>'.chr(13);}
                                    }
                                  } ?>
                                </select>
                              </td>
                              <td class="nobr" align="left" colspan="1">.tpl.php</td>
                              <!-- Auswahl CSS-Datei Basis -->
                              <td class="nobr" align="right"<?php if ($css_exists==-1) {echo ' style="color:red"';}?>><?php echo $text[$MyAddonName][7166]; ?>&nbsp;</td>
                              <td class="nobr" align="left">
                                <select class="lmo-formular-input"  name="vereinsplancssname" size="1">
                                  <?php
                                  if ($css_exists==-1) {echo '<option disabled="disabled">'.$MyCfg_array['vereinsplan_cssname'].'</option>'.chr(13);}
                                  for($tpl=0; $tpl<$css_counter; $tpl++) {
                                    if ($tpl==$css_exists) {
                                      echo '<option selected="selected">'.$css_files[$tpl].'</option>'.chr(13);
                                    }
                                    else {
                                      if ( $DefaultCfg_array['vereinsplan_cssname']==$css_files[$tpl]  && $css_exists==-1) {echo '<option selected="selected">'.$css_files[$tpl].'</option>'.chr(13);}
                                      else { echo '<option>'.$css_files[$tpl].'</option>'.chr(13);}
                                    }
                                  } ?>
                                </select>
                              </td>
                              <td class="nobr" align="left" colspan="1">.css&nbsp;</td>
                            </tr>
                            <tr> <!-- Auswahl Template Resultat -->
                              <td class="nobr" align="right"<?php if ($tpl_erg_exists==-1) {echo ' style="color:red"';}?>><?php echo $text[$MyAddonName][7034]; ?>&nbsp;<?php echo $text[$MyAddonName][7035]; ?>&nbsp;</td>
                              <td class="nobr" align="left">
                                <select class="lmo-formular-input"  name="vereinsplantemplate_erg" size="1">
                                  <?php
                                  if ($tpl_erg_exists==-1) {echo '<option disabled="disabled">'.$MyCfg_array['vereinsplan_template_erg'].'</option>'.chr(13);}
                                  for($tpl=0; $tpl<$tmpl_erg_counter; $tpl++) {
                                    if ($tpl==$tpl_erg_exists) {
                                      echo '<option selected="selected">'.$tpl_erg_files[$tpl].'</option>'.chr(13);
                                    }
                                    else {
                                      if ( $DefaultCfg_array['vereinsplan_template_erg']==$tpl_erg_files[$tpl] && $tpl_erg_exists==-1) {echo '<option selected="selected">'.$tpl_erg_files[$tpl].'</option>'.chr(13);}
                                      else { echo '<option>'.$tpl_erg_files[$tpl].'</option>'.chr(13);}
                                    }
                                  } ?>
                                </select>
                              </td>
                              <td class="nobr" align="left" colspan="1">.tpl.result.php&nbsp;</td>
                              <!-- Auswahl CSS-Datei Slider-->
                              <td class="nobr" align="right"<?php if ($css_slider_exists==-1) {echo ' style="color:red"';}?>><?php echo $text[$MyAddonName][7167]; ?>&nbsp;</td>
                              <td class="nobr" align="left">
                                <select class="lmo-formular-input"  name="vereinsplancssname_slider" size="1">
                                  <?php
                                  if ($css_slider_exists==-1) {echo '<option disabled="disabled">'.$MyCfg_array['vereinsplan_cssname_slider'].'</option>'.chr(13);}
                                  for($tpl=0; $tpl<$css_slider_counter; $tpl++) {
                                    if ($tpl==$css_slider_exists) {
                                      echo '<option selected="selected">'.$css_slider_files[$tpl].'</option>'.chr(13);
                                    }
                                    else {
                                      if ( $DefaultCfg_array['vereinsplan_cssname_slider']==$css_slider_files[$tpl] && $css_slider_exists==-1) {echo '<option selected="selected">'.$css_slider_files[$tpl].'</option>'.chr(13);}
                                      else { echo '<option>'.$css_slider_files[$tpl].'</option>'.chr(13);}
                                    }
                                  } ?>
                                </select>
                              </td>
                              <td class="nobr" align="left" colspan="1">_slides.css&nbsp;</td>
                            </tr>
                            <tr>  <!-- XHTML-Unterstützung -->
                              <td class="nobr" align="right"><?php echo $text[$MyAddonName][7049];  ?>&nbsp;</td>
                              <td class="nobr" align="left"><input class="lmo-formular-input" type="checkbox" name="vereinsplanxhtml" <?php if ($MyCfg_array['vereinsplan_xhtml']==1) {echo 'checked="checked" ';}?>></td>
                              <td colspan="4">&nbsp;</td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                      <tr> <!-- Team Infos -->
                        <td colspan="6">
                          <table class="lmoInner" cellspacing="1" cellpadding="0" border="0" width="100%">
                            <tr> <!-- Teamnamen lang, mittel, kurz / Namen highlight -->
                              <td class="nobr" align="right"><?php echo $text[$MyAddonName][7181]; ?>&nbsp;</td>
                              <td class="nobr" align="left">
                                <select class="lmo-formular-input"  name="vereinsplanteamname" size="1">
                                  <?php
                                    $xsel='>'; if ($MyCfg_array['vereinsplan_teamname']==0) {$xsel = ' selected="selected">';}
                                    echo '<option value="0"'.$xsel.$text[$MyAddonName][7182].'</option>'.chr(13);
                                    $xsel='>'; if ($MyCfg_array['vereinsplan_teamname']==1) {$xsel = ' selected="selected">';}
                                    echo '<option value="1"'.$xsel.$text[$MyAddonName][7183].'</option>'.chr(13);
                                    $xsel='>'; if ($MyCfg_array['vereinsplan_teamname']==2) {$xsel = ' selected="selected">';}
                                    echo '<option value="2"'.$xsel.$text[$MyAddonName][7184].'</option>'.chr(13);
                                  ?>
                                </select>
                              </td>
                              <td class="nobr" align="right"><input class="lmo-formular-input" type="checkbox" name="vereinsplanteam_highlight" <?php if ($MyCfg_array['vereinsplan_team_highlight']==1) {echo 'checked="checked" ';} ?>></td>
                              <td class="nobr" align="left" ><?php echo $text[$MyAddonName][7041];  ?>&nbsp;</td>
                              <td colspan="2">&nbsp;</td>
                            <tr>  <!-- Teamlogo klein, groß, mit Alttext / TeamHomepage verlinken  -->
                              <td class="nobr" align="right"><?php echo $text[$MyAddonName][7177]; ?>&nbsp;</td>
                              <td class="nobr" align="left">
                                <select class="lmo-formular-input"  name="vereinsplanteamlogo" size="1">
                                  <?php
                                    $xsel='>'; if ($MyCfg_array['vereinsplan_teamlogo']==1) {$xsel = ' selected="selected">';}
                                    echo '<option value="1"'.$xsel.$text[$MyAddonName][7178].'</option>'.chr(13);
                                    $xsel='>'; if ($MyCfg_array['vereinsplan_teamlogo']==2) {$xsel = ' selected="selected">';}
                                    echo '<option value="2"'.$xsel.$text[$MyAddonName][7179].'</option>'.chr(13);
                                    $xsel='>'; if ($MyCfg_array['vereinsplan_teamlogo']==3) {$xsel = ' selected="selected">';}
                                    echo '<option value="3"'.$xsel.$text[$MyAddonName][7180].'</option>'.chr(13);
                                    $xsel='>'; if ($MyCfg_array['vereinsplan_teamlogo']==0) {$xsel = ' selected="selected">';}
                                    echo '<option value="0"'.$xsel.$text[$MyAddonName][7195].'</option>'.chr(13);
                                  ?>
                                </select>
                              </td>
                              <td class="nobr" align="right"><input class="lmo-formular-input" type="checkbox" name="vereinsplanteamplan" <?php if ($MyCfg_array['vereinsplan_teamplan']==1) {echo 'checked="checked" ';} ?>></td>
                              <td class="nobr" align="left" ><?php echo $text[$MyAddonName][7033].' '.$text[$MyAddonName][7186];  ?>&nbsp;</td>
                              <td class="nobr" align="right"><input class="lmo-formular-input" type="checkbox" name="vereinsplanteamplantarget" <?php if ($MyCfg_array['vereinsplan_teamplantarget']==1) {echo 'checked="checked" ';} ?>></td>
                              <td class="nobr" align="left" ><?php echo $text[$MyAddonName][7144];  ?>&nbsp;</td>
                            </tr>
                            <tr>  <!-- Team-HP-Symbol klein, groß, mit Alttext / TeamHomepage verlinken  -->
                              <td class="nobr" align="right" id="vereinsplanteamhpsymboltxt"><?php echo $text[$MyAddonName][7176].' '.$text[$MyAddonName][7187]; ?>&nbsp;</td>
                              <td class="nobr" align="left"><input class="lmo-formular-input" type="text" name="vereinsplanteamhpsymbol" size="20" value="<?php echo $MyCfg_array['vereinsplan_teamhpsymbol']; ?>" onChange="document.getElementById('vereinsplanteamhpsymbol').src='<?=URL_TO_IMGDIR;?>/'+this.value;">&nbsp;<img id="vereinsplanteamhpsymbol" src="<?=URL_TO_IMGDIR;?>/<?php echo $MyCfg_array['vereinsplan_teamhpsymbol']; ?>" alt=""/></td>
                              <td class="nobr" align="right"><input class="lmo-formular-input" type="checkbox" name="vereinsplanteamhplink" <?php if ($MyCfg_array['vereinsplan_teamhplink']==1) {echo 'checked="checked" ';} ?>></td>
                              <td class="nobr" align="left" ><?php echo $text[$MyAddonName][7176].' '.$text[$MyAddonName][7186];  ?>&nbsp;</td>
                              <td class="nobr" align="right"><input class="lmo-formular-input" type="checkbox" name="vereinsplanteamhptarget" <?php if ($MyCfg_array['vereinsplan_teamhptarget']==1) {echo 'checked="checked" ';} ?>></td>
                              <td class="nobr" align="left" ><?php echo $text[$MyAddonName][7144];  ?>&nbsp;</td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                      <tr> <!-- Spalte Ligainfo -->
                        <td colspan="6">
                          <table class="lmoInner" cellspacing="1" cellpadding="0" border="0" width="100%">
                            <tr> <!-- Ligainfo als Icon, Text, ausblenden / Spaltentext Kopf -->
                              <td class="nobr" align="right"><?php echo $text[$MyAddonName][7079].' '.$text[$MyAddonName][7120]; ?>&nbsp;</td>
                              <td class="nobr" align="left">
                                <select class="lmo-formular-input"  name="vereinsplanligaicon" size="1">
                                  <?php
                                    $xsel='>'; if ($MyCfg_array['vereinsplan_ligaicon']==1) {$xsel = ' selected="selected">';}
                                    echo '<option value="1"'.$xsel.$text[$MyAddonName][7121].'</option>'.chr(13);
                                    $xsel='>'; if ($MyCfg_array['vereinsplan_ligaicon']==2) {$xsel = ' selected="selected">';}
                                    echo '<option value="2"'.$xsel.$text[$MyAddonName][7190].' '.$text[$MyAddonName][7107].'</option>'.chr(13);
                                    $xsel='>'; if ($MyCfg_array['vereinsplan_ligaicon']==0) {$xsel = ' selected="selected">';}
                                    echo '<option value="0"'.$xsel.$text[$MyAddonName][7195].'</option>'.chr(13);
                                  ?>
                                </select>
                              </td>
                              <td class="nobr" align="right" id="vereinsplanligakopftxt1"><?php echo $text[$MyAddonName][7190].' '.$text[$MyAddonName][7189]; ?>&nbsp;</td>
                              <td class="nobr" align="left" height="22"><input class="lmo-formular-input"  type="text" name="vereinsplanligakopftext" size="20" value="<?php echo $MyCfg_array['vereinsplan_ligakopftext']; ?>" onkeyup="chkinput(this,this.value,'0')" onblur="chkinput(this,this.value,'1')" ></td>
                            <tr>  <!-- Liga verlinken / Imagedatei  -->
                              <td class="nobr" align="right"><?php echo $text[$MyAddonName][7120].' '.$text[$MyAddonName][7186];  ?>&nbsp;</td>
                              <td class="nobr" align="left"><input class="lmo-formular-input" type="checkbox" name="vereinsplanligalink" <?php if ($MyCfg_array['vereinsplan_ligalink']==1) {echo 'checked="checked" ';}?>>&nbsp;<?php echo $text[$MyAddonName][7144];  ?>&nbsp;&nbsp;<input class="lmo-formular-input" type="checkbox" name="vereinsplanligatarget" <?php if ($MyCfg_array['vereinsplan_ligatarget']==1) {echo 'checked="checked" ';} ?>></td>
                              <td class="nobr" align="right" id="vereinsplanligasymboltxt"><?php echo $text[$MyAddonName][7187]; ?>&nbsp;</td>
                              <td class="nobr" align="left"><input class="lmo-formular-input" type="text" name="vereinsplanligasymbol" size="20" value="<?php echo $MyCfg_array['vereinsplan_ligasymbol']; ?>" onChange="document.getElementById('vereinsplanligasymbol').src='<?=URL_TO_IMGDIR;?>/'+this.value;">&nbsp;<img id="vereinsplanligasymbol" src="<?=URL_TO_IMGDIR;?>/<?php echo $MyCfg_array['vereinsplan_ligasymbol']; ?>" alt=""/></td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                      <tr> <!-- Spalte Notiz -->
                        <td colspan="6">
                          <table class="lmoInner" cellspacing="1" cellpadding="0" border="0" width="100%">
                            <tr> <!-- Notiz als Icon, Text, ausblenden / Spaltentext Kopf -->
                              <td class="nobr" align="right"><?php echo $text[$MyAddonName][7079].' '.$text[$MyAddonName][7047]; ?>&nbsp;</td>
                              <td class="nobr" align="left">
                                <select class="lmo-formular-input"  name="vereinsplannotiz" size="1">
                                  <?php
                                    $xsel='>'; if ($MyCfg_array['vereinsplan_notiz']==1) {$xsel = ' selected="selected">';}
                                    echo '<option value="1"'.$xsel.$text[$MyAddonName][7046].'</option>'.chr(13);
                                    $xsel='>'; if ($MyCfg_array['vereinsplan_notiz']==2) {$xsel = ' selected="selected">';}
                                    echo '<option value="2"'.$xsel.$text[$MyAddonName][7190].' '.$text[$MyAddonName][7107].'</option>'.chr(13);
                                    $xsel='>'; if ($MyCfg_array['vereinsplan_notiz']==0) {$xsel = ' selected="selected">';}
                                    echo '<option value="0"'.$xsel.$text[$MyAddonName][7195].'</option>'.chr(13);
                                  ?>
                                </select>
                              </td>
                              <td class="nobr" align="right" id="vereinsplannotizkopftxt"><?php echo $text[$MyAddonName][7190].' '.$text[$MyAddonName][7189]; ?>&nbsp;</td>
                              <td class="nobr" align="left" height="22"><input class="lmo-formular-input"  type="text" name="vereinsplannotizkopftext" size="20" value="<?php echo $MyCfg_array['vereinsplan_notizkopftext']; ?>" onkeyup="chkinput(this,this.value,'0')" onblur="chkinput(this,this.value,'1')" ></td>
                            </tr>
                            <tr>  <!-- dummy / Notiz Imagedatei  -->
                              <td class="nobr" align="right" colspan="2">&nbsp;</td>
                              <td class="nobr" align="right" id="vereinsplannotizsymboltxt"><?php echo $text[$MyAddonName][7187]; ?>&nbsp;</td>
                              <td class="nobr" align="left"><input class="lmo-formular-input" type="text" name="vereinsplannotizsymbol" size="20" value="<?php echo $MyCfg_array['vereinsplan_notizsymbol']; ?>" onChange="document.getElementById('vereinsplannotizsymbol').src='<?=URL_TO_IMGDIR;?>/'+this.value;">&nbsp;<img id="vereinsplannotizsymbol" src="<?=URL_TO_IMGDIR;?>/<?php echo $MyCfg_array['vereinsplan_notizsymbol']; ?>" alt=""/></td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                      <tr> <!-- Spalte Bericht -->
                        <td colspan="6">
                          <table class="lmoInner" cellspacing="1" cellpadding="0" border="0" width="100%">
                            <tr> <!-- Berichts-Icon anzeigen, ausblenden / Spaltentext Kopf -->
                              <td class="nobr"  align="center"><?php echo $text[$MyAddonName][7079].' '.$text[$MyAddonName][7048]; ?>&nbsp;</td>
                              <td class="nobr" align="left">
                                <select class="lmo-formular-input"  name="vereinsplanbericht" size="1">
                                  <?php
                                    $xsel='>'; if ($MyCfg_array['vereinsplan_bericht']==1) {$xsel = ' selected="selected">';}
                                    echo '<option value="1"'.$xsel.$text[$MyAddonName][7048].' '.$text[$MyAddonName][7186].'</option>'.chr(13);
                                    $xsel='>'; if ($MyCfg_array['vereinsplan_bericht']==0) {$xsel = ' selected="selected">';}
                                    echo '<option value="0"'.$xsel.$text[$MyAddonName][7195].'</option>'.chr(13);
                                  ?>
                                </select>
                              </td>
                              <td class="nobr" align="right" id="vereinsplanberichtkopftxt"><?php echo $text[$MyAddonName][7190].' '.$text[$MyAddonName][7189]; ?>&nbsp;</td>
                              <td class="nobr" align="left" height="22"><input class="lmo-formular-input"  type="text" name="vereinsplanberichtkopftext" size="20" value="<?php echo $MyCfg_array['vereinsplan_berichtkopftext']; ?>" onkeyup="chkinput(this,this.value,'0')" onblur="chkinput(this,this.value,'1')" ></td>
                            </tr>
                            <tr>  <!-- dummy / Imagedatei  -->
                              <td class="nobr" align="right" ><?php echo $text[$MyAddonName][7144];  ?>&nbsp;</td>
                              <td class="nobr" align="left"><input class="lmo-formular-input" type="checkbox" name="vereinsplanberichttarget" <?php if ($MyCfg_array['vereinsplan_berichttarget']==1) {echo 'checked="checked" ';} ?>></td>
                              <td class="nobr" align="right" id="vereinsplanberichtsymboltxt"><?php echo $text[$MyAddonName][7187]; ?>&nbsp;</td>
                              <td class="nobr" align="left"><input class="lmo-formular-input" type="text" name="vereinsplanberichtsymbol" size="20" value="<?php echo $MyCfg_array['vereinsplan_berichtsymbol']; ?>" onChange="document.getElementById('vereinsplanberichtsymbol').src='<?=URL_TO_IMGDIR;?>/'+this.value;">&nbsp;<img id="vereinsplanberichtsymbol" src="<?=URL_TO_IMGDIR;?>/<?php echo $MyCfg_array['vereinsplan_berichtsymbol']; ?>" alt=""/></td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>
                    <br>

                    <!-- Slider Angaben  -->
                    <table class="lmoInner" cellspacing="1" cellpadding="0" border="0" width="100%">
                      <tr>
                        <td class="nobr"  align="center" colspan="6" style="color:blue;" ><?php echo $text[$MyAddonName][7043];  ?>&nbsp;</td>
                      </tr>
                      <tr> <!-- Slider Dateien erstellen  -->
                        <td class="nobr" align="right"><input class="lmo-formular-input" type="checkbox" name="vereinsplanslidemodus" <?php if ($MyCfg_array['vereinsplan_slidemodus']==1) {echo 'checked="checked" ';} ?>></td>
                        <td class="nobr" align="left">&nbsp;<?php echo $text[$MyAddonName][7043].' '.$text[$MyAddonName][7059];  ?></td>
                        <td class="nobr" align="right"><input class="lmo-formular-input" type="checkbox" name="vereinsplanusemootools" <?php if ($MyCfg_array['vereinsplan_usemootools']==1) {echo 'checked="checked" ';} ?>></td>
                        <td class="nobr" align="left">&nbsp;<?php echo $text[$MyAddonName][7045];  ?></td>
                        <td class="nobr" align="right" colspan="2">&nbsp;</td>
                      </tr>
                      <tr>
                        <td class="nobr" align="right" height="22"><input class="lmo-formular-input" type="radio" value="2" name="vereinsplansliderstart" <?php if ($MyCfg_array['vereinsplan_sliderstart']==2) {echo 'checked="checked" ';} ?>  ></td>
                        <td class="nobr" align="left">&nbsp;<?php echo $text[$MyAddonName][7157].' '.$text[$MyAddonName][7151];;  ?></td>
                        <td class="nobr" align="right" height="22"><input class="lmo-formular-input" type="radio" value="0" name="vereinsplansliderstart" <?php if ($MyCfg_array['vereinsplan_sliderstart']==0) {echo 'checked="checked" ';} ?>  ></td>
                        <td class="nobr" align="left">&nbsp;<?php echo $text[$MyAddonName][7155].' '.$text[$MyAddonName][7152];;  ?></td>
                        <td class="nobr" align="right" height="22"><input class="lmo-formular-input" type="radio" value="1" name="vereinsplansliderstart" <?php if ($MyCfg_array['vereinsplan_sliderstart']==1) {echo 'checked="checked" ';} ?>  ></td>
                        <td class="nobr" align="left">&nbsp;<?php echo $text[$MyAddonName][7155].' '.$text[$MyAddonName][7151];;  ?></td>
                      </tr>
                    </table>

                    <br>
                    <!-- PDF Angaben  -->
                    <table class="lmoInner" cellspacing="1" cellpadding="0" border="0" width="100%">
                      <tr>
                        <td class="nobr"  align="center" colspan="4" style="color:blue;" ><?php echo $text[$MyAddonName][7116];  ?>&nbsp;</td>
                      </tr>
                      <tr> <!-- PDF-Link  neues Fenster  -->
                        <td class="nobr" align="right"><input class="lmo-formular-input" type="checkbox" name="vereinsplanpdf" <?php if ($MyCfg_array['vereinsplan_pdf']==1) {echo 'checked="checked" ';} if ($pdf_ok==0) {echo ' style="color:gray"';echo ' disabled="disabled"';} ?>onChange="chgProps(this,this.checked)">&nbsp;&nbsp;</td>
                        <td class="nobr" align="left" <?php if ($pdf_ok==0) {echo ' style="color:gray"';} ?>><?php echo $text[$MyAddonName][7118].' '.$text[$MyAddonName][7119];  ?>&nbsp;</td>
                        <td class="nobr" align="right"><input class="lmo-formular-input" type="checkbox" name="vereinsplanpdftarget" <?php if ($MyCfg_array['vereinsplan_pdftarget']==1) {echo 'checked="checked" ';} ?>>&nbsp;&nbsp;</td>
                        <td class="nobr" align="left"><?php echo $text[$MyAddonName][7144]; ?></td>
                      </tr>
                      <tr> <!-- PDF Format /  Liga-Spalte -->
                        <td class="nobr" align="right"><input class="lmo-formular-input" type="checkbox" name="vereinsplanpdfformat" <?php if ($MyCfg_array['vereinsplan_pdfformat']==1) {echo 'checked="checked" ';} ?> onChange="chgProps(this,this.checked)">&nbsp;&nbsp;</td>
                        <td class="nobr" align="left"><?php echo $text[$MyAddonName][7123]; ?></td>
                        <td class="nobr" align="right"><input class="lmo-formular-input" type="checkbox" name="vereinsplanpdfliga" <?php if ($MyCfg_array['vereinsplan_pdfliga']==1) {echo 'checked="checked" ';} ?>>&nbsp;&nbsp;</td>
                        <td class="nobr" align="left"><?php echo $text[$MyAddonName][7079].' '.$text[$MyAddonName][7120].' '.$text[$MyAddonName][7122]; ?></td>
                      </tr>
                      <tr> <!-- PDF SeitejeMonat / Notiz-Spalte  -->
                        <td class="nobr" align="right"><input class="lmo-formular-input" type="checkbox" name="vereinsplanpdfseitejemonat" <?php if ($MyCfg_array['vereinsplan_pdfseitejemonat']==1) {echo 'checked="checked" ';} ?>>&nbsp;&nbsp;</td>
                        <td class="nobr" align="left" ><?php echo $text[$MyAddonName][7143]; ?></td>
                        <td class="nobr" align="right"><input class="lmo-formular-input" type="checkbox" name="vereinsplanpdfnotiz" <?php if ($MyCfg_array['vereinsplan_pdfnotiz']==1) {echo 'checked="checked" ';} ?>>&nbsp;&nbsp;</td>
                        <td class="nobr" align="left"><?php echo $text[$MyAddonName][7079].' '.$text[$MyAddonName][7047].' '.$text[$MyAddonName][7122];  ?></td>
                      </tr>
                      <tr> <!-- Vereinslogo anzeigen -->
                        <td class="nobr" align="right"><input class="lmo-formular-input" type="checkbox" name="vereinsplanpdfshowlogo1" <?php if ($MyCfg_array['vereinsplan_pdfshowlogo1']==1) {echo 'checked="checked" ';} ?>onChange="chgProps(this,this.checked)">&nbsp;&nbsp;</td>
                        <td class="nobr" align="left"><?php echo '1. '.$text[$MyAddonName][7124].' '.$text[$MyAddonName][7122]; ?></td>
                        <td class="nobr" align="right"><input class="lmo-formular-input" type="checkbox" name="vereinsplanpdfshowlogo2" <?php if ($MyCfg_array['vereinsplan_pdfshowlogo2']==1) {echo 'checked="checked" ';} ?>onChange="chgProps(this,this.checked)">&nbsp;&nbsp;</td>
                        <td class="nobr" align="left"><?php echo '2. '.$text[$MyAddonName][7124].' '.$text[$MyAddonName][7122];  ?></td>
                      </tr>
                      <tr>  <!-- Vereinslogo Datei -->
                        <td class="nobr" align="right" id="vereinsplanpdflogo1txt"><?php echo '1. '.$text[$MyAddonName][7124]; ?>&nbsp;</td>
                        <td class="nobr" align="left" height="22"><input class="lmo-formular-input"  type="text" name="vereinsplanpdflogo1" size="20" value="<?php echo $MyCfg_array['vereinsplan_pdflogo1']; ?>" onkeyup="chkinput(this,this.value,'0')" onblur="chkinput(this,this.value,'1')" >&nbsp;.png</td>
                        <td class="nobr" align="right" id="vereinsplanpdflogo2txt"><?php echo '2. '.$text[$MyAddonName][7124]; ?>&nbsp;</td>
                        <td class="nobr" align="left"><input class="lmo-formular-input" type="text" name="vereinsplanpdflogo2" size="20" value="<?php echo $MyCfg_array['vereinsplan_pdflogo2']; ?>" onkeyup="chkinput(this,this.value,'0')" onblur="chkinput(this,this.value,'1')" >&nbsp;.png</td>
                      </tr>
                      <tr>  <!-- Vereinslogo Breite / Höhe -->
                        <td class="nobr" align="right" id="vereinsplanpdflogo1wtxt" ><img src="<?php echo $ThisTemplateUrl?>/img/breit.gif" width="32" height="32" style="vertical-align:middle">&nbsp;<?php echo $text[$MyAddonName][7110]; ?> &nbsp;</td>
                        <td class="nobr" align="left" height="22" id="vereinsplanpdflogo1htxt">
                            <input class="lmo-formular-input"  type="text" name="vereinsplanpdflogo1w" size="4" value="<?php echo $MyCfg_array['vereinsplan_pdflogo1w']; ?>" onkeyup="chkinput(this,this.value,'0')" onblur="chkinput(this,this.value,'1')" >
                            &nbsp;&nbsp;<img src="<?php echo $ThisTemplateUrl?>/img/hoch.gif" width="32" height="32" style="vertical-align:middle">&nbsp;<?php echo $text[$MyAddonName][7111]; ?>&nbsp;
                            <input class="lmo-formular-input"  type="text" name="vereinsplanpdflogo1h" size="4" value="<?php echo $MyCfg_array['vereinsplan_pdflogo1h']; ?>" onkeyup="chkinput(this,this.value,'0')" onblur="chkinput(this,this.value,'1')" >
                        </td>
                        <td class="nobr" align="right" id="vereinsplanpdflogo2wtxt"><?php echo $text[$MyAddonName][7110]; ?>&nbsp;</td>
                        <td class="nobr" align="left" height="22" id="vereinsplanpdflogo2htxt">
                            <input class="lmo-formular-input" type="text" name="vereinsplanpdflogo2w" size="4" value="<?php echo $MyCfg_array['vereinsplan_pdflogo2w']; ?>" onkeyup="chkinput(this,this.value,'0')" onblur="chkinput(this,this.value,'1')" >
                            &nbsp;&nbsp;<?php echo $text[$MyAddonName][7111]; ?>&nbsp;
                            <input class="lmo-formular-input" type="text" name="vereinsplanpdflogo2h" size="4" value="<?php echo $MyCfg_array['vereinsplan_pdflogo2h']; ?>" onkeyup="chkinput(this,this.value,'0')" onblur="chkinput(this,this.value,'1')" >
                        </td>
                      </tr>
                      <tr>  <!-- Vereinslogo x/y-Position -->
                        <td class="nobr" align="right" id="vereinsplanpdflogo1xtxt"><img src="<?php echo $ThisTemplateUrl?>/img/posx.gif" width="32" height="32" style="vertical-align:middle">&nbsp;<?php echo $text[$MyAddonName][7112]; ?>&nbsp;</td>
                        <td class="nobr" align="left" height="22" id="vereinsplanpdflogo1ytxt">
                            <input class="lmo-formular-input"  type="text" name="vereinsplanpdflogo1x" size="4" value="<?php echo $MyCfg_array['vereinsplan_pdflogo1x']; ?>" onkeyup="chkinput(this,this.value,'0')" onblur="chkinput(this,this.value,'1')" >
                            &nbsp;&nbsp;<img src="<?php echo $ThisTemplateUrl?>/img/posy.gif" width="32" height="32" style="vertical-align:middle">&nbsp;<?php echo $text[$MyAddonName][7113]; ?>&nbsp;
                            <input class="lmo-formular-input"  type="text" name="vereinsplanpdflogo1y" size="4" value="<?php echo $MyCfg_array['vereinsplan_pdflogo1y']; ?>" onkeyup="chkinput(this,this.value,'0')" onblur="chkinput(this,this.value,'1')" >
                        </td>
                        <td class="nobr" align="right" id="vereinsplanpdflogo2xtxt"><?php echo $text[$MyAddonName][7112]; ?>&nbsp;</td>
                        <td class="nobr" align="left" height="22" id="vereinsplanpdflogo2ytxt">
                            <input class="lmo-formular-input" type="text" name="vereinsplanpdflogo2x" size="4" value="<?php echo $MyCfg_array['vereinsplan_pdflogo2x']; ?>" onkeyup="chkinput(this,this.value,'0')" onblur="chkinput(this,this.value,'1')" >
                            &nbsp;&nbsp;<?php echo $text[$MyAddonName][7113]; ?>&nbsp;
                            <input class="lmo-formular-input" type="text" name="vereinsplanpdflogo2y" size="4" value="<?php echo $MyCfg_array['vereinsplan_pdflogo2y']; ?>" onkeyup="chkinput(this,this.value,'0')" onblur="chkinput(this,this.value,'1')" >
                        </td>
                      </tr>
                      <tr>  <!-- Vereinslogo x/y-Position hoch/quer -->
                        <td class="nobr" align="left">
                            <input type="hidden" name="vereinsplanpdflogo1xh" size="5" value="<?php echo $MyCfg_array['vereinsplan_pdflogo1xh']; ?>">
                            <input type="hidden" name="vereinsplanpdflogo1yh" size="5" value="<?php echo $MyCfg_array['vereinsplan_pdflogo1yh']; ?>">
                            <input type="hidden" name="vereinsplanpdflogo1xq" size="5" value="<?php echo $MyCfg_array['vereinsplan_pdflogo1xq']; ?>">
                            <input type="hidden" name="vereinsplanpdflogo1yq" size="5" value="<?php echo $MyCfg_array['vereinsplan_pdflogo1yq']; ?>">
                            <input type="hidden" name="vereinsplanpdflogo2xh" size="5" value="<?php echo $MyCfg_array['vereinsplan_pdflogo2xh']; ?>">
                            <input type="hidden" name="vereinsplanpdflogo2yh" size="5" value="<?php echo $MyCfg_array['vereinsplan_pdflogo2yh']; ?>">
                            <input type="hidden" name="vereinsplanpdflogo2xq" size="5" value="<?php echo $MyCfg_array['vereinsplan_pdflogo2xq']; ?>">
                            <input type="hidden" name="vereinsplanpdflogo2yq" size="5" value="<?php echo $MyCfg_array['vereinsplan_pdflogo2yq']; ?>">
                        </td>
                      </tr>
                    </table>
                    <br>
                    <!-- Output Angaben  -->
                    <table class="lmoInner" cellspacing="1" cellpadding="0" border="0" width="100%">
                      <tr>
                        <td class="nobr"  align="center" colspan="4" style="color:blue;" ><?php echo $text[$MyAddonName][7042];  ?>&nbsp;</td>
                      </tr>
                      <tr>
                        <td class="nobr" align="right"><?php echo $text[$MyAddonName][7033]; ?>:&nbsp;&nbsp;</td>
                        <td class="nobr" align="left" id="vereinsplantxtoutfile1"><?php echo $MyCfgNameEdit; ?>.txt</td>
                        <td class="nobr" align="right"><?php echo $text[$MyAddonName][7118]; ?>:&nbsp;&nbsp;</td>
                        <td class="nobr" align="left" id="vereinsplantxtpdffile"><?php echo $MyCfgNameEdit; ?>.pdf.txt</td>
                      </tr>
                      <tr>
                        <td class="nobr" align="right"><?php echo $text[$MyAddonName][7034]; ?>:&nbsp;&nbsp;</td>
                        <td class="nobr" align="left" colspan="3" id="vereinsplantxtoutfile2"><?php echo $MyCfgNameEdit; ?>_res.txt</td>
                       </tr>
                      <tr> <!-- Slider Dateien erstellen  -->
                        <td class="nobr" align="right"><input class="lmo-formular-input" type="hidden" name="vpdummy3"></td>
                        <td class="nobr" align="left" >&nbsp;</td>
                        <td class="nobr" align="right"><input class="lmo-formular-input" type="checkbox" name="vereinsplanplan_erstellen" <?php if ($MyCfg_array['vereinsplan_plan_erstellen']==1) {echo 'checked="checked" ';} ?><?php if ($MyCfg_array['vereinsplan_cfg_ueberschreiben']!=1) {echo ' disabled="disabled"';}?>>&nbsp;&nbsp;</td>
                        <td class="nobr" align="left" id="vereinsplantxtcreateplan"<?php if ($MyCfg_array['vereinsplan_cfg_ueberschreiben']!=1) {echo ' style="color:gray"';}?>><?php echo $text[$MyAddonName][7044];  ?></td>
                      </tr>
                    </table>
                  </td>
                </tr>
<!--Ende Basiseinstellungen ---------------------------------->
                <tr>
                  <td class="nobr" align="right">
                    <input type="submit" class="lmo-formular-button" value="<?php echo $text[$MyAddonName][7012];  ?> >>" name="vereinsplanB1">
                    <input type="hidden" name="vereinsplanaction" value="admin">
                    <input type="hidden" name="vereinsplanform1" value="1">
                    <input type="hidden" name="vereinsplancfg_auswahl" value="<?php echo $MyCfgNameEdit;?>">
                    <input type="hidden" name="vereinsplancfg_exists" value=<?php echo $cfg_exists;?>>
                  </td>
                </tr>
              </table>
            </form>
          </td>
        </tr>
        <tr>
          <td class="lmoFooter"><?php echo $text[$MyAddonName][7200]; ?></td>
        </tr>
      </table>
<!-- Ende Formular Basiseinstellungen  -->

<?php
}

if ($vereinsplan_form1 && !$vereinsplan_form2 && !$vereinsplan_form3) {
  if ($_POST['vereinsplancfg_ueberschreiben']==1) {$save_file_name=$MyCfgFileExt;}
  else {$save_file_name .= '.tvh';}
  $createplan = $_POST['vereinsplanplan_erstellen'];
  $createpdf = $_POST['vereinsplanpdf'];
  $pdfform = $_POST['vereinsplanpdfformat'];

?>
<!-- Start Formular Ligendateien anzeigen -->
      <table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0" width="600">
        <tr>
          <th align="center"><h1><?php echo $text[$MyAddonName][7001];  ?></h1></th>
        </tr>
        <tr>
          <td class="nobr">
            <form name="vereinsplanB2" method="POST" action="<?php echo $_SERVER['PHP_SELF'].'?action=admin&todo=vereinsplanoptions'; ?>">
              <table class="lmoInner" cellspacing="0" cellpadding="0" border="0" width="100%">
                <tr>
                  <th colspan="2" align="center"><?php echo $text[$MyAddonName][7050]; ?></th>
                </tr>
                <?php $max=count($ligadatei); ?>
                <tr><td align="center" colspan="2" ><?php echo $max>0?$max.' '.$text[$MyAddonName][7051].' ('.$vp_dirliga.')':$text[223];?></td></tr>
                <?php if ($max>0) {?>
<!-- Start sortierte Liga-Anzeige -->
                <tr>
                  <td align="center">
                    <script type="text/javascript" src="<?php echo URL_TO_LMO?>/js/sortable/sortabletable.js"></script>
                    <script type="text/javascript" src="<?php echo URL_TO_LMO?>/js/sortable/limSortFunctions.js"></script>

                    <table id="ligaliste" class="lmoInner" cellspacing="0" width="99%">
                      <thead>
                        <tr>
                          <th class="nobr" align="left" title="<?php echo $text[525].' '.$text[529].' '.$text[526]?>">
                            <noscript><a href="<?php echo $_SERVER['PHP_SELF']?>?liga_sort=liga_name&amp;liga_sort_direction=asc" title="<?php echo $text[527].' '.$text[525].' '.$text[529].' '.$text[526]?>"><img src="<?php echo URL_TO_IMGDIR?>/upsimple.png" width="8" height="7" border="0" alt="&and;"></a> <?php echo $text[529]?> <a href="<?php echo $_SERVER['PHP_SELF']?>?liga_sort=liga_name&amp;liga_sort_direction=desc" title="<?php echo $text[528].' '.$text[525].' '.$text[529].' '.$text[526]?>"><img src="<?php echo URL_TO_IMGDIR?>/downsimple.png" width="8" height="7" border="0" alt="&or;"></a></noscript>
                            <script type="text/javascript">document.write('<?php echo $text[529]?>');</script>
                          </th>
                          <?php if (isset($_SESSION['lmouserok']) && $_SESSION['lmouserok']>0) {?>
                          <th class="nobr" align="left" title="<?php echo $text[525]." ".$text[531]." ".$text[526]?>">
                            <noscript><a href="<?php echo $_SERVER['PHP_SELF']?>?liga_sort=file_name&amp;liga_sort_direction=asc" title="<?php echo $text[527].' '.$text[525].' '.$text[531].' '.$text[526]?>"><img src="<?php echo URL_TO_IMGDIR?>/upsimple.png" width="8" height="7" border="0" alt="&and;"></a> <?php echo $text[531]?> <a href="<?php echo $_SERVER['PHP_SELF']?>?liga_sort=file_name&amp;liga_sort_direction=desc" title="<?php echo $text[528].' '.$text[525].' '.$text[531].' '.$text[526]?>"><img src="<?php echo URL_TO_IMGDIR?>/downsimple.png" width="8" height="7" border="0" alt="&or;"></a></noscript>
                            <script type="text/javascript">document.write('<?php echo $text[531]?>');</script>
                          </th>
                          <?php } ?>
                          <th class="nobr" align="left" title="<?php echo $text[525]." ".$text[2]."/".$text[370]." ".$text[526]?>">
                            <noscript><a href="<?php echo $_SERVER['PHP_SELF']?>?liga_sort=aktueller_spieltag&amp;liga_sort_direction=asc" title="<?php echo $text[527].' '.$text[525].' '.$text[2]."/".$text[370].' '.$text[526]?>"><img src="<?php echo URL_TO_IMGDIR?>/upsimple.png" width="8" height="7" border="0" alt="&and;"></a> <?php echo $text[2]."/".$text[370]?> <a href="<?php echo $_SERVER['PHP_SELF']?>?liga_sort=aktueller_spieltag&amp;liga_sort_direction=desc" title="<?php echo $text[528].' '.$text[525].' '.$text[2]."/".$text[370].' '.$text[526]?>"><img src="<?php echo URL_TO_IMGDIR?>/downsimple.png" width="8" height="7" border="0" alt="&or;"></a></noscript>
                            <script type="text/javascript">document.write('<?php echo $text[2]."/".$text[370]?>');</script>
                          </th>
                          <th class="nobr" align="left" title="<?php echo $text[525]." ".$text[530]." ".$text[526]?>">
                            <noscript><a href="<?php echo $_SERVER['PHP_SELF']?>?liga_sort=file_date&amp;liga_sort_direction=asc" title="<?php echo $text[527].' '.$text[525].' '.$text[530].' '.$text[526]?>"><img src="<?php echo URL_TO_IMGDIR?>/upsimple.png" width="8" height="7" border="0" alt="&and;"></a> <?php echo $text[530]?> <a href="<?php echo $_SERVER['PHP_SELF']?>?liga_sort=file_date&amp;liga_sort_direction=desc" title="<?php echo $text[528].' '.$text[525].' '.$text[530].' '.$text[526]?>"><img src="<?php echo URL_TO_IMGDIR?>/downsimple.png" width="8" height="7" border="0" alt="&or;"></a></noscript>
                            <script type="text/javascript">document.write('<?php echo $text[530]?>');</script>
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php $liga_checked=0; $ii=0;
                        foreach($ligadatei as $liga){
                        $ii++;
                        if ($ii>$max) break;
                        $checked ='';
                        if ($ligadatei_ok[$z-1]<>-1) {$checked = 'checked="checked" ';++$liga_checked;}
                      ?>
                        <tr onMouseOver="this.className='lmoBackMarkierung';" onMouseOut="this.className=''">
                          <td class="nobr" align="left"><?php echo '<input  type="checkbox" name = "vereinsplanc'.$z.'" value = "vereinsplanc'.$z.'" '.$checked.' onclick="cntChkActiv(this)">'.$liga['liga_name'];?></td>
                          <?php  if (isset($_SESSION['lmouserok']) && $_SESSION['lmouserok']>0) {?>
                          <td class="nobr" align="left"><?php echo $liga['file_name']?> &nbsp;</td>
                          <?php } ?>
                          <td class="nobr" align="left"><?php echo $liga['rundenbezeichnung']." ".$liga['aktueller_spieltag'];?> &nbsp;</td>
                          <td class="nobr" align="left"><!--<?=filemtime(PATH_TO_LMO."/".$vp_dirliga.$subdir.$liga['file_name'])?>--><?php echo strftime($defdateformat,filemtime(PATH_TO_LMO."/".$vp_dirliga.$subdir.$liga['file_name']))?></td>
                        </tr>
                        <?php $z++; }?>
                        <?php  if($liga_counter==0){echo "<td colspan='4'>[".$text[223]."]</td>";}?>
                      </tbody>
                    </table>

                    <script type="text/javascript">
                      var ligaTable = new SortableTable(document.getElementById("ligaliste"),
                      <?php  if (isset($_SESSION['lmouserok']) && $_SESSION['lmouserok']>0) {$sortprojection=array('liga_name'=>0,'file_name'=>1,'file_date'=>3,'asc'=>0,'desc'=>1);?>
                            ["CaseInsensitiveString","CaseInsensitiveString","RoundSort", "timeStamp"]);
                      <?php }else {$sortprojection=array('liga_name'=>0,'file_name'=>-1,'file_date'=>2,'asc'=>0,'desc'=>1);?>
                            ["CaseInsensitiveString","RoundSort", "timeStamp"]);
                      <?php } ?>
                      <?php  if (isset($_SESSION['liga_sort']) && isset($_SESSION['liga_sort_direction'])) {
                            if ($sortprojection[$_SESSION['liga_sort']]>=0)echo "ligaTable.sort(".$sortprojection[$_SESSION['liga_sort']].",".$sortprojection[$_SESSION['liga_sort_direction']].");".chr(13);
                          } else {
                            if ($sortprojection[$lmo_liga_sort]>=0) echo "ligaTable.sort(".$sortprojection[$lmo_liga_sort].",".$sortprojection[$lmo_liga_sort_direction].");".chr(13);
                          }
                      ?>
                    </script>
                  </td>
                </tr>
<!-- Ende sortierte Liga-Anzeige -->
                <tr><td><?php echo getMessage($text[$MyAddonName][7052],TRUE);?></td></tr>
                <tr>
                  <td align="left">
                    <script type="text/javascript">
                      document.writeln ('<input type=button value="<?php echo $text[$MyAddonName][7055]; ?>" onClick="checkAll(this)"\>');
                   document.writeln ('<input type=button value="<?php echo $text[$MyAddonName][7056]; ?>" onClick="uncheckAll(this)"\>');
                      document.writeln ('<input type=button value="<?php echo $text[$MyAddonName][7057]; ?>" onClick="switchAll(this)"\>');
                    </script>
                  </td>
                </tr>
                <?php }?>
                <?php if ($fav_liga_ok[0]>0) {?>
<!-- Start fehlende Liga-Anzeige -->
                <tr>
                  <td class="nobr">
                  <?php $ii=0;
                    echo '<br><table class="lmoInner" width="99%">';
                      for ($i=1; $i<=$anzahl_ligen; $i++) {
                        if ($fav_liga_ok[$i]==-1) {
                          if ($ii==0) {
                            echo "<tr><td>".getMessage($text[$MyAddonName][7053],TRUE);
                            $ii=1;
                            echo '</td></tr>';
                          }
                          echo '<tr><td class="nobr" align="left" ><span style="color:red">'.$fav_liga[$i].'</span></td></tr>';
                        }
                      }
                    echo '</table>';?>
                  </td>
                </tr>
<!-- Ende fehlende Liga-Anzeige -->
                <?php } ?>
                <tr>
                  <td class="nobr" align="right">
                    <input type="hidden" name="vereinsplanaction" value="admin">
                    <input type="hidden" name="vereinsplanform2" value="1">
                    <input type="hidden" name="vereinsplandateinameok" value="1">
                    <input type="hidden" name="vereinsplandateiname" value="<?php echo $save_file_name; ?>">
                    <input type="hidden" name="vereinsplanplanoutputname" value="<?php echo $output_file; ?>">
                    <input type="hidden" name="vereinsplanplan_erstellen" value="<?php echo $createplan; ?>">
                    <input type="hidden" name="vereinsplanconfig_array" value="<?php echo $save_config_array; ?>">
                    <input type="hidden" name="vereinsplanzaehler" value="<?php echo $z; ?>">
                    <input type="hidden" name="vereinsplancfg_auswahl" value="<?php echo $MyCfgNameEdit;?>">
                    <input type="hidden" name="vereinsplancfgAktiv_auswahl" value="<?php echo $MyCfgFileNameAktiv;?>">
                    <input type="hidden" name="vereinsplancfg_exists" value=<?php echo $cfg_exists;?>>
                    <input type="hidden" name="vereinsplanligapfad" value=<?php echo $ligapfad;?>>
                    <input type="hidden" name="vereinsplanvpdirliga" value=<?php echo $vp_dirliga;?>>
                    <input type="hidden" name="vereinsplanpdf" value=<?php echo $createpdf;?>>
                    <input type="hidden" name="vereinsplanpdfformat" value=<?php echo $pdfform;?>>
                    <input type="submit" class="lmo-formular-button" <?php if ($liga_checked==0) { echo 'disabled="disabled" style="color:gray" ';} ?>value="<?php echo $text[$MyAddonName][7012]; ?> >>" name="vereinsplanB2">
                  </td>
                </tr>
              </table>
            </form>
          </td>
        </tr>
        <tr>
          <td class="lmoFooter"><?php echo $text[$MyAddonName][7200]; ?></td>
        </tr>
      </table>
<!-- Ende Formular Ligendateien anzeigen -->

<?php
}
if (!$vereinsplan_form3 && $vereinsplan_form2){
  $createpdf=$_POST['vereinsplanpdf'];
  $pdfform=$_POST['vereinsplanpdfformat'];
  $createplan = $_POST['vereinsplanplan_erstellen'];
  $vp_dirliga = $_POST['vereinsplanvpdirliga'];
?>
<!-- Start Formular Mannschaftsauswahl  -->
       <table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0" width="600">
         <tr>
           <th align="center"><h1><?php echo $text[$MyAddonName][7001]; ?> </h1></th>
         </tr>
         <tr>
           <td class="nobr">
             <form name="vereinsplanB3" method="POST" action="<?php echo $_SERVER['PHP_SELF'].'?action=admin&todo=vereinsplanoptions'; ?>">
               <table class="lmoInner" cellspacing="0" cellpadding="0" border="0" width="100%">
                 <tr>
                   <th colspan="2" align="center"><?php echo $text[$MyAddonName][7060]; ?></h1></th>
                 </tr>
<!-- Start Team-Anzeige -->
                 <tr>
                   <td class="nobr">
                     <?php

                     $ges_teams=0;$teams_checked=0;$liga_is_checked = array();
                     for ($i=1; $i<=count($vereinsplanausgewaehlte_ligen) ;$i++ ) {
                       $liga1=new liga(); $liga_is_checked[$i]=0;
                       if ($liga1->loadFile(PATH_TO_LMO.'/'.$vp_dirliga.$ligenfile[$vereinsplanausgewaehlte_ligen[$i]]) == TRUE) { // Ligenfile vorhanden?
                     ?>

                     <table class=lmoInner cellspacing="0" cellpadding="0" border="0" width="100%">
                       <tr>
                         <td class="nobr"  colspan="3" align="center"><h1><?php echo $ligennamen[$vereinsplanausgewaehlte_ligen[$i]]; ?></h1></td>
                       </tr>

                     <?php
                         $ii=0; $spalte=0; $max=count($liga1->teams);
                         foreach ($liga1->teams as $mannschaft) {
                           $ii++;
                           if ($ii>$max) break;
                           $spalte++;if ($spalte > 3) $spalte=1; $ges_teams++;
                           //bestimmen, ob Liga-Team in cfg-Datei definiert ist
                           $fav_prev = -1;
                           if ($ligadatei_ok[$vereinsplanausgewaehlte_ligen[$i]-1]<>-1) {
                             for ($ft=1;$ft<=count($fav_team[$ligadatei_ok[$vereinsplanausgewaehlte_ligen[$i]-1]]);$ft++) {
                               if ($ii==$fav_team[$ligadatei_ok[$vereinsplanausgewaehlte_ligen[$i]-1]][$ft]) {$fav_prev = $ii; }
                             }
                           }
                           $liga_checked=0;
                           $fav_checked =''; $fav_highlight='';
                           if ($ii==$fav_prev) {
                             $fav_checked = ' checked="checked" ';
                             $fav_highlight = ' style="font-weight:bold;" ';
                             ++$teams_checked;++$liga_is_checked[$i];
                           }
                           if ($ii==$ligenfavorit[$vereinsplanausgewaehlte_ligen[$i]]) {
                             $fav_highlight = ' style="color:blue;" ';
                           }
                           if ($spalte==1) echo '<tr>'.chr(13).'<td class="nobr" align="left"'.$fav_highlight.'>';
                           if ($spalte==2) echo '<td class="nobr" align="left"'.$fav_highlight.'>';
                           if ($spalte==3) echo '<td class="nobr" align="left"'.$fav_highlight.'>';
                           echo '<input type="checkbox" '.$fav_checked.' name="vereinsplant'.$ges_teams.'" value="'.$ligenfile[$vereinsplanausgewaehlte_ligen[$i]].'['.$ii.']"'.' onclick="cntChkActiv(this)">'.$mannschaft->name;
                           if ($spalte==1) echo '</td>'.chr(13);
                           if ($spalte==2) echo '</td>'.chr(13);
                           if ($spalte==3) echo '</td>'.chr(13)."</tr>".chr(13);
                         }
                         if ($spalte <3) {echo"</tr>";}
                     ?>
                     </table>
                     <?php
                         } else {
                           echo "[".PATH_TO_LMO.'/'.$vp_dirliga.$ligenfile[$vereinsplanausgewaehlte_ligen[$i]]."] ".$text[$MyAddonName][7054]."<br>";
                         }
                       }

                       for ($i=1; $i<=count($vereinsplanausgewaehlte_ligen);$i++) {
                         if ($liga_is_checked[$i]==0) {$teams_checked=0;}
                       }
                     ?>
                     </td>
                   </tr>
<!-- Ende Team-Anzeige -->
                   <tr>
                    <td align="left">
                      <script type="text/javascript">
                        document.writeln ('<input type=button value="<?php echo $text[$MyAddonName][7055]; ?>" onClick="checkAll(this)"\>');
                        document.writeln ('<input type=button value="<?php echo $text[$MyAddonName][7056]; ?>" onClick="uncheckAll(this)"\>');
                 document.writeln ('<input type=button value="<?php echo $text[$MyAddonName][7057]; ?>" onClick="switchAll(this)"\>');
               </script>
                    </td>
                  </tr>
              </table>
              <table class=lmoInner cellspacing="0" cellpadding="0" border="0" width="100%">
                <tr>
                  <td class="nobr" align="center"><?php echo $text[$MyAddonName][7071].' '.$text[$MyAddonName][7014];?>&nbsp;<input class="lmo-formular-input" type="checkbox" name="vereinsplansetactivecfg"></td>
                </tr>
                <tr>
                  <td align="center">
                    <input type="hidden" name="vereinsplanaction" value="admin">
                    <input type="hidden" name="vereinsplanform3" value="1">
                    <input type="hidden" name="vereinsplanausgewaehlte_ligen[]" value="<?php echo $vereinsplanausgewaehlte_ligen ?>">
                    <input type="hidden" name="vereinsplanzaehler" value="<?php echo $ges_teams; ?>">
                    <input type="hidden" name="vereinsplandateiname" value="<?php echo $save_file_name; ?>">
                    <input type="hidden" name="vereinsplancfgAktiv" value="<?php echo $MyCfgNameEdit;?>">
                    <input type="hidden" name="vereinsplanplanoutputname" value="<?php echo $output_file; ?>">
                    <input type="hidden" name="vereinsplanplan_erstellen" value="<?php echo $createplan; ?>">
                    <input type="hidden" name="vereinsplanconfig_array" value="<?php echo $save_config_array; ?>">
                    <input type="hidden" name="vereinsplanvpdirliga" value="<?php echo $vp_dirliga;?>">
                    <input type="hidden" name="vereinsplanpdf" value="<?php echo $createpdf;?>">
                    <input type="hidden" name="vereinsplanpdfformat" value="<?php echo $pdfform;?>">
                    <input type="submit" class="lmo-formular-button" <?php if ($teams_checked==0) { echo 'disabled="disabled" style="color:gray" ';} ?>value="<?php echo $text[$MyAddonName][7061]; ?> >>" name="vereinsplanB3"></p>
                  </td>
                </tr>
              </table>

            </form>
          </td>
        </tr>
        <tr>
          <td class="lmoFooter"><?php echo $text[$MyAddonName][7200]; ?></td>
        </tr>
      </table>
<!-- Start Formular Mannschaftsauswahl  -->

<?php
}
}
?>

<?php

function cmp ($a1, $a2) {
  $sort=(isset($_SESSION['liga_sort']) && isset($a1[$_SESSION['liga_sort']]) && isset($a1[$_SESSION['liga_sort']]))?$_SESSION['liga_sort']:'liga_name';
  if (is_numeric($a1[$sort]) && is_numeric($a2[$sort])) {  //Numerischer Vergleich
    if ($a2[$sort]==$a1[$sort]) return 0;
    return ($a1[$sort]>$a2[$sort]) ? 1 : -1;
  }else{ //Stringvergleich
    $a1[$sort]=strtr($a1[$sort],"¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿ","YuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy");
    $a2[$sort]=strtr($a2[$sort],"¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿ","YuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy");
    return  strnatcasecmp($a1[$sort],$a2[$sort]);
  }
}

?>