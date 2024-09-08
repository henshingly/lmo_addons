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
   * $Id: createvereinsplan_Sort.php,v 1.3.0 2009/08/06 SVN:598 $
  */
/** Vereinsplan 1.3.0
  *
  * Credits:
  * Vereinsplan is based on and is used following
  * - LMO-Addon Viewer 4.0 Beta 3
  * - LMO-Addon TP 1.0 Spielplan
  * - JoomlaWorks "Tabs & Slides" Module for Joomla! 1.5.x - Version 1.0
  *
  */
/** Changelog:
    06.08.2009  Happy Birthday
    13.09.2009  Version 1.1.0 an LMO-Forum übergeben
    08.10.2010  Version 1.1.1 wurde in LMO-SVN integriert und gepflegt
    05.11.2010  Version 1.1.2 bekannte Bugs aus LMO-Forum beseitigt
    05.11.2010  Version 1.2.0 gesetzt
    23.11.2010  Version 1.3.0 gesetzt
                Unterstützung weiterer Konfigurations-Parameter zur Formatsteuerung, z.B. Tabellen-Link
                Unterstützung vieler LMO-Ausgabe-Variablen für Template-Dateien
    30.11.2011  Version 1.3.0 an LMO-Forum übergeben
    12.12.2010  Forum-ID: 11281 backslash beseitigt, Verlinkungen überprüft
    29.01.2011  Forum-ID: 11322 Torfaktor bei Ergebnis berücksichtigt
  */

$MyAddonName = 'vereinsplan';
$MyAddonVersion = '1.3.0';
$jetzt = date("d.m.y H:i:s");
$planupdate = ' '.$text[$MyAddonName][7199].' '.$jetzt;
$MonatsNamen= Array($text[160],$text[161],$text[162],$text[163],$text[164],$text[165],$text[166],$text[167],$text[168],$text[169],$text[170],$text[171]);
$TagesNamen = Array($text[153],$text[147],$text[148],$text[149],$text[150],$text[151],$text[152]);

$Eventzeile = "";
$kopfende = str_repeat(' ', 16).'</table>'."\n";
$kopfende .= str_repeat(' ', 14).'</div>'."\n\n";

function getNameWoTag($tag,$lang) {
 switch ($lang) {
    case "Magyar": case "Portugues":
      return substr($tag,0,3);
      break;
    default:
      return substr($tag,0,2);
 }
}

if (!defined('VEREINSPLAN_VERSIONSNUMMER'))  define('VEREINSPLAN_VERSIONSNUMMER',$MyAddonVersion);
if (!defined('VEREINSPLAN_VERSION')) {
   define('VEREINSPLAN_VERSION','[<acronym title="VEREINSPLAN '.$MyAddonVersion.' &copy; LMO-Group">&copy;</acronym>]');
}

isset($multi_cfgarray['vereinsplan_datumshow'])      ? $cfgdatumshow  =$multi_cfgarray['vereinsplan_datumshow']          : $cfgdatumshow=0;

$cfghighlight=false;
if (isset($multi_cfgarray['vereinsplan_team_highlight']) && $multi_cfgarray['vereinsplan_team_highlight']==1) {
  $cfghighlight=true;
}
isset($multi_cfgarray['vereinsplan_teamlogo'])       ? $cfgteamlogo    =$multi_cfgarray['vereinsplan_teamlogo']          : $cfgteamlogo=1;
isset($multi_cfgarray['vereinsplan_teamname'])       ? $cfgteamname    =$multi_cfgarray['vereinsplan_teamname']          : $cfgteamname=0;
isset($multi_cfgarray['vereinsplan_teamplan'])       ? $cfgteamplan    =$multi_cfgarray['vereinsplan_teamplan']          : $cfgteamplan=1;
isset($multi_cfgarray['vereinsplan_teamhplink'])     ? $cfgteamhplink  =$multi_cfgarray['vereinsplan_teamhplink']        : $cfgteamhplink=1;
isset($multi_cfgarray['vereinsplan_teamhpsymbol'])   ? $cfgteamhpsymbol=$multi_cfgarray['vereinsplan_teamhpsymbol']      : $cfgteamhpsymbol='url.png';
isset($multi_cfgarray['vereinsplan_teamplantarget']) ? $cfgteamplantarget =$multi_cfgarray['vereinsplan_teamplantarget'] : $cfgteamplantarget=1;
isset($multi_cfgarray['vereinsplan_teamhptarget'])   ? $cfgteamhptarget   =$multi_cfgarray['vereinsplan_teamhptarget']   : $cfgteamhptarget=1;

isset($multi_cfgarray['vereinsplan_ligaicon'])     ? $cfgligaicon=$multi_cfgarray['vereinsplan_ligaicon']         : $cfgligaicon=1;
isset($multi_cfgarray['vereinsplan_ligasymbol'])   ? $cfgligasymbol=$multi_cfgarray['vereinsplan_ligasymbol']     : $cfgligasymbol='tabelle.gif';
isset($multi_cfgarray['vereinsplan_ligakopftext']) ? $cfgligakopftext=$multi_cfgarray['vereinsplan_ligakopftext'] : $cfgligakopftext=$text[$MyAddonName][7088];
isset($multi_cfgarray['vereinsplan_ligalink'])     ? $cfgligalink=$multi_cfgarray['vereinsplan_ligalink']         : $cfgligalink=1;
isset($multi_cfgarray['vereinsplan_ligatarget'])   ? $cfgligatarget=$multi_cfgarray['vereinsplan_ligatarget']     : $cfgligatarget=1;

isset($multi_cfgarray['vereinsplan_notiz'])         ? $cfgnotiz=$multi_cfgarray['vereinsplan_notiz']                 : $cfgnotiz=1;
isset($multi_cfgarray['vereinsplan_notizsymbol'])   ? $cfgnotizsymbol=$multi_cfgarray['vereinsplan_notizsymbol']     : $cfgnotizsymbol='lmo-st2.gif';
isset($multi_cfgarray['vereinsplan_notizkopftext']) ? $cfgnotizkopftext=$multi_cfgarray['vereinsplan_notizkopftext'] : $cfgnotizkopftext=$text[$MyAddonName][7047];

isset($multi_cfgarray['vereinsplan_bericht'])         ? $cfgbericht=$multi_cfgarray['vereinsplan_bericht']                 : $cfgbericht=1;
isset($multi_cfgarray['vereinsplan_berichtsymbol'])   ? $cfgberichtsymbol=$multi_cfgarray['vereinsplan_berichtsymbol']     : $cfgberichtsymbol='lmo-st1.gif';
isset($multi_cfgarray['vereinsplan_berichtkopftext']) ? $cfgberichtkopftext=$multi_cfgarray['vereinsplan_berichtkopftext'] : $cfgberichtkopftext=$text[$MyAddonName][7048];
isset($multi_cfgarray['vereinsplan_berichttarget'])   ? $cfgberichttarget=$multi_cfgarray['vereinsplan_berichttarget']     : $cfgberichttarget=1;

isset($multi_cfgarray['vereinsplan_usemootools']) ? $cfgUseMooTools=$multi_cfgarray['vereinsplan_usemootools'] : $cfgUseMooTools=1;

$cfgsliderstart=isset($multi_cfgarray['vereinsplan_sliderstart'])?$multi_cfgarray['vereinsplan_sliderstart']:2;

$vp_dirliga=isset($multi_cfgarray['vereinsplan_ligapfad'])?$multi_cfgarray['vereinsplan_ligapfad']:'ligen';
if (substr($vp_dirliga,-1)!=='/') {$vp_dirliga = $vp_dirliga.'/';}

// Durchläufe sooft Ligen vorhanden sind
for($i=1; $i<=$anzahl_ligen ; $i++) {
  $akt_liga=new liga();
  // Ligadatei vorhanden?
  if ($akt_liga->loadFile(PATH_TO_LMO.'/'.$vp_dirliga.$fav_liga[$i]) == TRUE) {

    //etwas unglücklich nochmals einzulesen, um den Abbruchstatus zu erhalten
    // aber was soll's ...
    unset($absage);$absage = array();
    $datei = fopen(PATH_TO_LMO."/".$vp_dirliga.$files.$fav_liga[$i],"rb");
    if ($datei) {
      $sekt="";$propnr=0; $rr=0;
      while (!feof($datei)) {
        $zeile = fgets($datei,1000);
        $zeile=trim($zeile);
        if((substr($zeile,0,1)=="[") && (substr($zeile,-1)=="]")){  //Sektion
          $runde=strpos($zeile, 'Round');
          $sekt=substr($zeile,1,-2);
          if ($runde==1) {
            $sekt=substr($zeile,1,5);
            ++$rr;
          }
        }
        else {
          if ((strpos($zeile,"=")!==false) && (substr($zeile,0,1)!=";") && ($sekt=="Round")){  //Wert
            $prop=explode("=",$zeile,2);
            $prop_name=$prop[0];
            $prop_wert=isset($prop[1])?$prop[1]:'0';
            //echo substr($prop_name,0,-1).'<br>';
            if (substr($prop_name,0,-1)=="TA" && $prop_wert>0) {++$propnr;$absage[$propnr]= 0;}

            if (substr($prop_name,0,-1)=="BR"){
              $absage[$propnr]= $prop_wert;
            }
          }
        }
      }
      fclose($datei);
    }
    //print_r($absage);
    $rounds=$akt_liga->options->keyValues['Rounds'];
    $aktueller_spieltag=$akt_liga->options->keyValues['Actual'];
    $ende=$rounds;
    $start=1;$liga_game=0;
    $goalfaktor = $akt_liga->options->keyValues['goalfaktor'];

    $tmp_liganame=trim($akt_liga->name);$LigaTitel=$tmp_liganame;
    unset($tmparray);$tmparray=split('[ ]', $tmp_liganame);
    unset($zeichen);unset($tmp_liganame);
    unset($game_used);$game_used = array();

    //falls vorhanden: kurzer Vereinsname und Jahreszahl aus dem Liganame entfernen
    // TVH spezial :))
    if ($MyClubNameLong == 'TV Herbolzheim' && $MyClubNameShort == 'TVH') {
      foreach ($tmparray as $element) {
        if (strpos($element,$MyClubNameShort)!==FALSE || strpos($element,"/")!==FALSE){}
        else { $tmp_liganame .= " $element";}
      }
    } else {  $tmp_liganame=trim($akt_liga->name);}

    $tmp_liganame=trim($tmp_liganame);$Liganamepdf=$tmp_liganame;
    $bturnier=FALSE;$bturnier=strpos($tmp_liganame,"Turnier");
    $bfinal=FALSE;$bfinal=strpos($tmp_liganame,"Final");

    $tmpligafile = $vp_dirliga.$files.$fav_liga[$i];
    if (strpos(strtolower($tmpligafile),"ligen/")===0) {$tmpligafile = substr($tmpligafile, 6);}
    $LigaDatum= $akt_liga->ligaDatumAsString();

    //alle Spieltage durchgehen
    for ($spieltag=$start; $spieltag<=$ende; $spieltag++) {
      $akt_spieltag=$akt_liga->spieltagForNumber($spieltag);
      $template->setCurrentBlock("Inhalt");                      //Ausgabe Inhalt Beginn
      $templateA->setCurrentBlock("Inhalt");
      $templateH->setCurrentBlock("Inhalt");
      // alle Spiele des Spieltags
      //print_r($akt_spieltag);
      foreach ($akt_spieltag->partien as $myPartie) {
        ++$liga_game;
        foreach ($fav_team[$i] as $akt_team) {
/*
          if (isset($multi_cfgarray['modus']) && $multi_cfgarray['modus'] == 1) {
            $spieltag = $mySpieltag->nr;
          }
*/
          $tmp_liganame=$Liganamepdf;
          $mhp_hl_s=$mgp_hl_s=$mhp_hl_e=$mgp_hl_e="";
          $heimspiel=0;$gastspiel=0;
          $heimnr= $myPartie->heim->nr;$gastnr = $myPartie->gast->nr;

          if ($akt_team == $myPartie->heim->nr) {$heimspiel=1;}
          if ($akt_team == $myPartie->gast->nr) {$gastspiel=1;}
          if ($heimspiel==1 || $gastspiel==1) {
            //Heim- bzw. Gastteam ist gesuchtes Team aus Konfiguration
            $game_not_used=true;
            for ($lg=0;$lg<=count($game_used);$lg++) {
              //falls mehrere Teams des Vereins in der gleichen Liga spielen
              if ($liga_game==$game_used[$xx_tmpNr+$lg]) {$game_not_used=false;}
            }
            if ($game_not_used) {
              //Begegnung noch nicht verwendet
              $xx_tmpNr++;
              $game_used[$xx_tmpNr]=$liga_game;
              //Anfang Relevante Daten der Begegnung : Falls kein Datum bzw. Zeit vorhanden, dann Anwender ein bißchen stubsen  ...
              // denn er sollte seine Spielpläne dann schon besser pflegen....
              $tmp_datum = $myPartie->datumString(date("11.11.1111"),$multi_cfgarray['vereinsplan_datumsformat']);
              //$tmp_datum = $myPartie->datumString(date("d.m.y"),$multi_cfgarray['vereinsplan_datumsformat']);
              $tmp_sort = substr($tmp_datum,6).substr($tmp_datum,3,2).substr($tmp_datum,0,2);
              //$tmp_zeit =  $myPartie->zeitString(date("H:i"),$multi_cfgarray['vereinsplan_uhrzeitformat']);
              $tmp_zeit =  $myPartie->zeitString(date("11:11"),$multi_cfgarray['vereinsplan_uhrzeitformat']);
              $tmp_sort = $tmp_sort.substr($tmp_zeit,0,2).substr($tmp_zeit,3);

              $HeimTore = applyFactor($myPartie->hToreString($multi_cfgarray['vereinsplan_tordummy']),$goalfaktor);
              $GastTore = applyFactor($myPartie->gToreString($multi_cfgarray['vereinsplan_tordummy']),$goalfaktor);

              //if ($xx_tmpNr==1) {print_r($myPartie);}
              switch ($absage[$liga_game]) {
                case 1:
                  $tmp_tore = $text[6577]; // Absg. - Absage;
                  break;
                case 2:
                  $tmp_tore = $text[6578]; // Abbr. - Abbruch;
                  break;
                case 3:
                  $tmp_tore = $text[6579]; // Verl. - Verlegung;
                  break;
                default:
                  $tmp_tore = $HeimTore.":".$GastTore.' '.$myPartie->spielEndeString($text);
                  break;
              }
              if ($absage[$xx_tmpNr]==1 || $absage[$xx_tmpNr]==2 || $absage[$xx_tmpNr]==3) {
              }
              else{
              }

              $tmp_target= "";
              if ($tmp_liganame=="" || $cfgligaicon==0 ) {$tmp_liganame="&nbsp;";}
              $tmp_text = $text[$MyAddonName][7093].' '.$tmp_liganame;
              if ($cfgligatarget=='1') {
                $tmp_target= $targetBlank;
                $tmp_text .= ' '.$text[$MyAddonName][7126];
              }
              $tmp_text .= ' '.$text[$MyAddonName][7107];
              if ($cfgligaicon==1) { /* Liga-Icon */
                 if ($cfgligalink==1) {
                    $liga_link=URL_TO_LMO.'/lmo.php?file='.$fav_liga[$i]."&amp;action=results&amp;st=".$spieltag;
                    $xtmp_liganame ='&nbsp; <a name="L'.$xx_tmpNr.'" id="L'.$xx_tmpNr.'" href="'.$liga_link.'" ';
                    $xtmp_liganame.=$tmp_target.' title="'.$tmp_text.'">';
                    $xtmp_liganame.='<img src="'.URL_TO_IMGDIR.'/'.$cfgligasymbol.'" alt="'.$tmp_text.'" '.$useBS.'></a>';
                    $tmp_liganame=$xtmp_liganame;
                 }
                 else {
                    $xtmp_liganame ='&nbsp; <a name="L'.$xx_tmpNr.'" id="L'.$xx_tmpNr.'" href="#L'.$xx_tmpNr.'" onclick="alert(';
                    $xtmp_liganame.="'".$text[$MyAddonName][7120].": ".$tmp_liganame;
                    $xtmp_liganame.="');window.focus();return false;";
                    $xtmp_liganame.='"><span class="popup"><strong>'.$text[$MyAddonName][7120].':&nbsp;</strong>'.$tmp_liganame;
                    $xtmp_liganame.='</span><img src="'.URL_TO_IMGDIR.'/'.$cfgligasymbol.'" width="10" height="12" alt="" '.$useBS.'></a>';
                    $tmp_liganame=$xtmp_liganame;
                 }
              }
              if ($cfgligaicon==2) { /* Liga-Text */
                 if ($cfgligalink==1) {
                    $liga_link=URL_TO_LMO.'/lmo.php?file='.$fav_liga[$i]."&amp;action=results&amp;st=".$spieltag;
                    $xtmp_liganame ='&nbsp; <a name="L'.$xx_tmpNr.'" id="L'.$xx_tmpNr.'" href="'.$liga_link.'" ';
                    $xtmp_liganame.=$tmp_target.' title="'.$tmp_text.'">';
                    $xtmp_liganame.=$tmp_liganame.'</a>';
                    $tmp_liganame=$xtmp_liganame;
                 }
              }

              $tmp_notiz = trim($myPartie->notiz);$Notizpdf=$tmp_notiz;
              //Feststellen, ob in der eigenen Halle gespielt wird
              // u.U. wichtig bei Turnierspiele, z.B. E-Jugend)
              $bhalledaheim=FALSE; if ($tmp_notiz<>"" && trim($MyClubArena)<>"") {$bhalledaheim = strpos($tmp_notiz,$MyClubArena);}

              if ($tmp_notiz=="" || $cfgnotiz==0) {$tmp_notiz="&nbsp;";}
              else {
                 if ($cfgnotiz==1) {
                    $xtmp_notiz='&nbsp; <a name="N'.$xx_tmpNr.'" id="N'.$xx_tmpNr.'" href="#N'.$xx_tmpNr.'" title="'.$text[$MyAddonName][7047].': '.$tmp_notiz.'" onclick="alert(';
                    $xtmp_notiz.="'".$text[$MyAddonName][7047].": ".$tmp_notiz;
                    $xtmp_notiz.="');window.focus();return false;";
                    $xtmp_notiz.='"><img src="'.URL_TO_IMGDIR.'/'.$cfgnotizsymbol.'" width="10" height="12" alt="'.$text[$MyAddonName][7047].': '.$tmp_notiz.'" '.$useBS.'></a>';
                    $tmp_notiz=$xtmp_notiz;
                 }
              }

              $tmp_target= "";
              $tmp_text = $text[$MyAddonName][7092];
              if ($cfgberichttarget=='1') {
                $tmp_target= $targetBlank;
                $tmp_text .= ' '.$text[$MyAddonName][7126];
              }
              $tmp_text .= ' '.$text[$MyAddonName][7107];
              $tmp_bericht = trim($myPartie->reportUrl);$Berichtpdf=$tmp_bericht;
              if ($tmp_bericht=="" || $cfgbericht==0) {$tmp_bericht="&nbsp;";}
              else {
                  $tmp_bericht="&nbsp; <a href='".$tmp_bericht."' ".$tmp_target." title='".$tmp_text."'><img src='".URL_TO_IMGDIR.'/'.$cfgberichtsymbol."' alt='".$tmp_text."' ".$useBS."></a>";
              }

              /* Mannschaftsnamen */
              $HeimKurz=$myPartie->heim->kurz; $Heimkurzpdf=$Heimkurz;
              $GastKurz=$myPartie->gast->kurz; $Gastkurzpdf=$Gastkurz;
              $HeimMittel=$myPartie->heim->mittel; $Heimmittelpdf=$HeimMittel;
              $GastMittel=$myPartie->gast->mittel; $Gastmittelpdf=$GastMittel;
              $HeimLang=$myPartie->heim->name; $Heimmittelpdf=$HeimLang;
              $GastLang=$myPartie->gast->name; $Gastmittelpdf=$GastLang;

              $Heim=$HeimLang; $Heimpdf=$HeimLang;
              $Gast=$GastLang; $Gastpdf=$GastLang;
              if ($cfgteamname==1) {
                 $Heim=$HeimMittel; $Heimpdf=$HeimMittel;
                 $Gast=$GastMittel; $Gastpdf=$GastMittel;
              }
              if ($cfgteamname==2) {
                 $Heim=$HeimKurz; $Heimpdf=$HeimKurz;
                 $Gast=$GastKurz; $Gastpdf=$GastKurz;
              }

              $Heimlogo = $Gastlogo = "";
              $Heimlogobig = $Gastlogobig = "";
              $Heimlogobigalt = $Gastlogobigalt = "";
              if ($cfgteamlogo>0) {
                 $Heimlogo = HTML_smallTeamIcon($file,$HeimLang," alt=''" );
                 $Gastlogo = HTML_smallTeamIcon($file,$GastLang," alt=''");
                 $Heimlogoalt = HTML_smallTeamIcon($file,$HeimLang," alt='TeamIcon $Heim'");
                 $Gastlogoalt = HTML_smallTeamIcon($file,$GastLang," alt='TeamIcon $Heim'");
                 $Heimlogobig = HTML_bigTeamIcon($file,$HeimLang," alt=''");
                 $Gastlogobig = HTML_bigTeamIcon($file,$GastLang," alt=''");
                 $Heimlogobigalt = HTML_bigTeamIcon($file,$HeimLang," alt='TeamIcon $Heim'");
                 $Gastlogobigalt = HTML_bigTeamIcon($file,$GastLang," alt='TeamIcon $Gast'");
                 if ($use_XHTML==0) {
                   $Heimlogo = str_replace('/>', '>', $Heimlogo);
                   $Gastlogo = str_replace('/>', '>', $Gastlogo);
                   $Heimlogoalt = str_replace('/>', '>', $Heimlogoalt);
                   $Gastlogoalt = str_replace('/>', '>', $Gastlogoalt);
                   $Heimlogobig = str_replace('/>', '>', $Heimlogobig);
                   $Gastlogobig = str_replace('/>', '>', $Gastlogobig);
                   $Heimlogobigalt = str_replace('/>', '>', $Heimlogoalt);
                   $Gastlogobigalt = str_replace('/>', '>', $Gastlogoalt);
                 }
              }
              if ($cfgteamlogo==0) {$tmp_heimlogo="";$tmp_gastlogo="";}
              if ($cfgteamlogo==1) {$tmp_heimlogo=$Heimlogo;$tmp_gastlogo=$Gastlogo;}
              if ($cfgteamlogo==2) {$tmp_heimlogo=$Heimlogobig;$tmp_gastlogo=$Gastlogobig;}
              if ($cfgteamlogo==3) {$tmp_heimlogo=$Heimlogobigalt;$tmp_gastlogo=$Gastlogobigalt;}
              if ($cfgteamlogo==4) {$tmp_heimlogo=$Heimlogoalt;$tmp_gastlogo=$Gastlogoalt;}

              $heimurl  = $myPartie->heim->keyValues["URL"];$tmp_heimurl  = $heimurl;
              $gasturl  = $myPartie->gast->keyValues["URL"];$tmp_gasturl  = $gasturl;

              if ($cfgteamhplink==0) {$tmp_heimurl="";$tmp_gasturl="";}
              else {
                 $tmp_target= "";
                 $tmp_textH = $text[$MyAddonName][7090].' '.$Heim;
                 $tmp_textG = $text[$MyAddonName][7090].' '.$Gast;
                 if ($cfgteamhptarget=='1') {
                   $tmp_target= $targetBlank;
                   $tmp_textH .= ' '.$text[$MyAddonName][7126];
                   $tmp_textG .= ' '.$text[$MyAddonName][7126];
                 }
                 $tmp_textH .= ' '.$text[$MyAddonName][7107];
                 $tmp_textG .= ' '.$text[$MyAddonName][7107];
                 if (trim($tmp_heimurl)<>"") {
                    $tmp_heimurl="<a ".$tmp_target." href='".$heimurl."' title='".$tmp_textH."'><img src='".URL_TO_IMGDIR.'/'.$cfgteamhpsymbol."' alt='".$tmp_textH."' ".$useBS."></a>";
                 }
                 if (trim($tmp_gasturl)<>"") {
                    $tmp_gasturl="<a ".$tmp_target." href='".$tmp_gasturl."' title='".$tmp_textG."'><img src='".URL_TO_IMGDIR.'/'.$cfgteamhpsymbol."' alt='".$tmp_textG."' ".$useBS."></a>";
                 }
              }

              if ($cfgteamhplink == 0 && $cfgteamlogo==0 ) {$heimlogourl="";$gastlogourl="";}
              if ($cfgteamhplink <> 0 && $cfgteamlogo==0 ) {$heimlogourl=$tmp_heimurl;$gastlogourl=$tmp_gasturl;}
              if ($cfgteamhplink == 0 && $cfgteamlogo<>0 ) {$heimlogourl=$tmp_heimlogo;$gastlogourl=$tmp_gastlogo;}
              if ($cfgteamhplink <> 0 && $cfgteamlogo<>0 ) {
                 $heimlogourl="<a ".$tmp_target." href='".$heimurl."' title='".$tmp_textH."'>".$tmp_heimlogo."</a>";
                 $gastlogourl="<a ".$tmp_target." href='".$gasturl."' title='".$tmp_textG."'>".$tmp_gastlogo."</a>";
                 if ($tmp_heimurl=="") {$heimlogourl= $tmp_heimlogo;}
                 if ($tmp_gasturl=="") {$gastlogourl= $tmp_gastlogo;}
                 if ($tmp_heimlogo=="") {$heimlogourl= $tmp_heimurl;}
                 if ($tmp_gastlogo=="") {$gastlogourl= $tmp_gasturl;}
              }

              $mhp_hl_s="";
              $mhp_hl_e="";
              $mgp_hl_s="";
              $mgp_hl_e="";
              $HeimHL=0;$GastHL=0;
              //gewünschte Teams hervorheben?
              if ($heimspiel==1 & $cfghighlight) {
                $mhp_hl_s='<strong>';
                $mhp_hl_e.='</strong>';
                $HeimHL=1;
              }
              if ($gastspiel==1 & $cfghighlight) {
                $mgp_hl_s='<strong>';
                $mgp_hl_e.='</strong>';
                $GastHL=1;
              }
              if ($bturnier!==FALSE) {
                 if ($bhalledaheim!==FALSE) {
                   //Turnierform z.B. bei E-Jugend, wenn "Auswärtsspiel" in eigener Halle stattfindet-> Heimspiel
                   if ($heimspiel==0) {
                      $heimspiel=1;
                      if ($gastspiel==1) {$gastspiel=0;}
                   }
                 }
                 else {
                   //Turnierform z.B. bei E-Jugend, wenn "Heimspiel" in auswärtiger Halle stattfindet-> Gastspiel
                   if ($heimspiel==1) {
                      $heimspiel=0;
                      if ($gastspiel==0) {$gastspiel=1;}
                   }
                 }
              }
              $tmp_heim = $Heim;
              $tmp_gast = $Gast;

              $addp = URL_TO_LMO."/lmo.php?action=program&amp;file=".$tmpligafile."&amp;selteam=";
              $addr = URL_TO_LMO."/lmo.php?action=results&amp;file=".$tmpligafile."&amp;st=";

              if ($cfgberichttarget=='1') {
                $tmp_target= $targetBlank;
              }

              $tmp_textH = $text[$MyAddonName][7091].' '.$Heim;
              $tmp_textG = $text[$MyAddonName][7091].' '.$Gast;
              if ($cfgteamplan==1) {
                 $tmp_target='';
                 if ($cfgteamplantarget==1) {
                   $tmp_target= $targetBlank;
                   $tmp_textH .= ' '.$text[$MyAddonName][7126];
                   $tmp_textG .= ' '.$text[$MyAddonName][7126];
                 }
                 $tmp_textH .= ' '.$text[$MyAddonName][7107];
                 $tmp_textG .= ' '.$text[$MyAddonName][7107];
                 $tmp_heim= '<a'.$tmp_target.' href="'.$addp.$heimnr.'" title="'.$tmp_textH.'">'.$Heim.'</a>';
                 $tmp_gast= '<a'.$tmp_target.' href="'.$addp.$gastnr.'" title="'.$tmp_textG.'">'.$Gast.'</a>';
              }
              $tmp_heim = $mhp_hl_s.$tmp_heim.$mhp_hl_e;
              $tmp_gast = $mgp_hl_s.$tmp_gast.$mgp_hl_e;

              $tvh_Playlist[$xx_tmpNr] = array($tmp_datum, $tmp_zeit, $tmp_heim, $tmp_gast, $tmp_tore, $tmp_liganame, $heimspiel, $gastspiel, $tmp_notiz, $Heimpdf, $HeimHL, $Gastpdf, $GastHL, $Notizpdf, $ShowNotizpdf, $Liganamepdf, $ShowLiganamepdf, $tmp_bericht, $tmp_heimlogo, $tmp_gastlogo, $Heimlogo, $Gastlogo, $Heimlogobig, $Gastlogobig, $Heimlogobigalt, $Gastlogobigalt, $tmp_heimurl, $tmp_gasturl, $HeimLang, $GastLang, $HeimMittel, $GastMittel, $HeimKurz, $GastKurz, $spieltag, $HeimTore, $GastTore, $LigaDatum, $heimlogourl, $gastlogourl, $LigaTitel);
              $tvh_nummer[$xx_tmpNr]= $tmp_sort;

              if ($aktueller_spieltag==$spieltag) {
                if ($bfinal == 0) {
                  // aktuelle Ergebnisliste
                 $templateErg->setCurrentBlock("Inhalt");
                 $xx_tmpNrErg++;
                 $tvh_Erglist[$xx_tmpNrErg] = array($tmp_datum, $tmp_zeit, $Heim, $Gast, $tmp_tore, $tmp_liganame, $heimspiel, $gastspiel, $tmp_notiz, $tmp_bericht, $tmp_heimlogo, $tmp_gastlogo, $Heimlogo, $Gastlogo, $Heimlogobig, $Gastlogobig, $Heimlogobigalt, $Gastlogobigalt, $tmp_heimurl, $tmp_gasturl, $HeimLang, $GastLang, $HeimMittel, $GastMittel, $HeimKurz, $GastKurz, $spieltag, $HeimTore, $GastTore, $LigaDatum, $heimlogourl, $gastlogourl, $LigaTitel);
                 $tvh_ErgNr[$xx_tmpNrErg]= $tmp_sort;
                 if ($heim_len < strlen($Heim)) {$heim_len=strlen($Heim);}
                 if ($gast_len < strlen($Gast)) {$gast_len=strlen($Gast);}
                }
              }
            } //ende game_used
            else {
              //gewünschte Teams spielen gegeneinander
              if ($cfghighlight) {
                $tvh_Playlist[$xx_tmpNr][2]= '<strong>'.$Heim.'</strong>';
                $tvh_Playlist[$xx_tmpNr][3]= '<strong>'.$Gast.'</strong>';
              }
            }
          }    // Ende gewünschtes Team gefunden
        }      // Ende Durchlauf alle Teams
      }        // Ende Durchlauf alle Spiele des Spieltags
    }          // Ende Durchlauf alle Spieltage der Liga
  }
  else  {
    echo getMessage($text['vereinsplan'][7000].": ".$text['vereinsplan'][7120]." ".$fav_liga[$i]." ".$text['vereinsplan'][7054],TRUE); // Ligenfile vorhanden? Frage beantwortet
  }            // Ende Liga-Datei existiert
}              // Ende Durchlauf alle Ligen


//Falls entsprechende Spiele gefunden wurden
if ($xx_tmpNr>=0) {
   //Die Begegnungen zeitlich sortieren
   asort($tvh_nummer,SORT_NUMERIC);
   $tvh_tmp=array_values($tvh_nummer); //Datum MinMax

   //Skript für Slider Eventzeilen
   $EventzeileG  = "var isMin=0;"."\n";
   $EventzeileG .= "var Diffx;"."\n";
   $EventzeileG .= "var jetzt = new Date();"."\n";
   $EventzeileG .= "var Jahreszahl = jetzt.getFullYear();"."\n";
   $EventzeileG .= "var Jahreszahl = String(Jahreszahl).substr(2);"."\n";
   $EventzeileG .= "var Jahresmonat = jetzt.getMonth()+1;"."\n";
   $EventzeileG .= "if (String(Jahresmonat).length==1) {Jahresmonat=0+String(Jahresmonat);}"."\n";
   $EventzeileG .= "var aktuell=Jahreszahl+Jahresmonat;"."\n";
   $EventzeileG .= "var DiffMin=Math.abs(eventids[0]-aktuell);"."\n\n";
   $EventzeileG .= "for (var i=1;i<eventids.length;i++) {"."\n";
   $EventzeileG .= "   Diffx =Math.abs(eventids[i]-aktuell);"."\n";
   $EventzeileG .= "   if (DiffMin>=Diffx) {DiffMin=Diffx;isMin=i;}"."\n\n";
   $EventzeileG .= "}"."\n";

   $EventzeileG .= "var sliderstart=".$cfgsliderstart.";"."\n";
   $EventzeileG .= "switch (sliderstart) {"."\n";
   $EventzeileG .= "  case 0: //alles geschlossen"."\n";
   $EventzeileG .= "    var show = 0000;"."\n";
   $EventzeileG .= "    break;"."\n";
   $EventzeileG .= "  case 1: //alles offen"."\n";
   $EventzeileG .= "    var show = 9999;"."\n";
   $EventzeileG .= "    break;"."\n";
   $EventzeileG .= "  default:"."\n";
   $EventzeileG .= "    var show = eventids[isMin];"."\n";
   $EventzeileG .= "    break"."\n";
   $EventzeileG .= "}"."\n\n";
   $EventzeileH=$EventzeileG;$EventzeileA=$EventzeileG;

   $OpenCloseFunktion  = "\n\nfunction OpenClose(todo) {\n";
   $OpenCloseFunktion .= "  for (var i=0;i<eventids.length;i++) {\n";
   $OpenCloseFunktion .= "    var aufruf = 'fplan_'+eventids[i]+'.'+todo+'()';\n";
   $OpenCloseFunktion .= "    eval(aufruf);\n";
   $OpenCloseFunktion .= "  }\n";
   $OpenCloseFunktion .= "}\n";



   $EventHide="";$EventHideG="";$EventHideH="";$EventHideA="";
   $SpNr=0;$DatumAlt=0;$JahrAlt=0;$MonatAlt=0;$TagAlt=0;$WoTagAlt=0;$KWAlt=0;
   $SpNrG=0;$DatumAltG=0;$JahrAltG=0;$MonatAltG=0;$TagAltG=0;$WoTagAltG=0;$KWAltG=0;$DatumMinG=$tvh_tmp[1];$DatumMaxG=$tvh_tmp[$xx_tmpNr];$MG_count=0;
   $SpNrH=0;$DatumAltH=0;$JahrAltH=0;$MonatAltH=0;$TagAltH=0;$WoTagAltH=0;$KWAltH=0;$DatumMinH="";$DatumMaxH="";$MH_count=0;
   $SpNrA=0;$DatumAltA=0;$JahrAltA=0;$MonatAltA=0;$TagAltA=0;$WoTagAltA=0;$KWAltA=0;$DatumMinA="";$DatumMaxA="";$MA_count=0;

   $zout  = "var DatumMin = new Date(20".substr($DatumMinG,0,2).",".sprintf("%d",substr($DatumMinG,2,2))."-1,".sprintf("%d",substr($DatumMinG,4,2)).");"."\n";
   $zout .= "var DatumMax = new Date(20".substr($DatumMaxG,0,2).",".sprintf("%d",substr($DatumMaxG,2,2))."-1,".sprintf("%d",substr($DatumMaxG,4,2)).");"."\n";
   $zout .= "//DatumMin: ".$DatumMinH." DatumMax: ".$DatumMaxH."\n";
   $EventzeileG = $zout.$EventzeileG;

   //Jedes Spiel durchackern...
   foreach ($tvh_nummer as $key => $val) {
      $DatumNeu=$tvh_Playlist[$key][0];
      $Uhrzeit=$tvh_Playlist[$key][1];
      $Heim=$tvh_Playlist[$key][2];
      $Gast=$tvh_Playlist[$key][3];
      $Tore=$tvh_Playlist[$key][4];
      $Liganame=$tvh_Playlist[$key][5];
      $heimspiel=$tvh_Playlist[$key][6];
      $gastspiel=$tvh_Playlist[$key][7];
      $Notiz=$tvh_Playlist[$key][8];
      $Heimpdf=$tvh_Playlist[$key][9];
      $HeimHL=$tvh_Playlist[$key][10];
      $Gastpdf=$tvh_Playlist[$key][11];
      $GastHL=$tvh_Playlist[$key][12];
      $Notizpdf=$tvh_Playlist[$key][13];
      $ShowNotizpdf=$tvh_Playlist[$key][14];
      $Liganamepdf=$tvh_Playlist[$key][15];
      $ShowLiganamepdf=$tvh_Playlist[$key][16];
      $Bericht=$tvh_Playlist[$key][17];
      $HLogo=$tvh_Playlist[$key][18];
      $GLogo=$tvh_Playlist[$key][19];
      $HeimLogo=$tvh_Playlist[$key][20];
      $GastLogo=$tvh_Playlist[$key][21];
      $HeimLogoBig=$tvh_Playlist[$key][22];
      $GastLogoBig=$tvh_Playlist[$key][23];
      $HeimLogoBigAlt=$tvh_Playlist[$key][24];
      $GastLogoBigAlt=$tvh_Playlist[$key][25];
      $HeimUrl=$tvh_Playlist[$key][26];
      $GastUrl=$tvh_Playlist[$key][27];
      $HeimLang=$tvh_Playlist[$key][28];
      $GastLang=$tvh_Playlist[$key][29];
      $HeimMittel=$tvh_Playlist[$key][30];
      $GastMittel=$tvh_Playlist[$key][31];
      $HeimKurz=$tvh_Playlist[$key][32];
      $GastKurz=$tvh_Playlist[$key][33];
      $Spieltag=$tvh_Playlist[$key][34];
      $ToreHeim=$tvh_Playlist[$key][35];
      $ToreGast=$tvh_Playlist[$key][36];
      $LigaDatum=$tvh_Playlist[$key][37];
      $HeimLogoUrl=$tvh_Playlist[$key][38];
      $GastLogoUrl=$tvh_Playlist[$key][39];
      $LigaTitel=$tvh_Playlist[$key][40];

      if ($DatumNeu!="") {
	//Datumsangabe ist nicht leer, Neue Datumsangaben resetten und neu einlesen
         unset($tmparray);$tmparray=split('[.]', $DatumNeu);
         $JahrNeu=$tmparray[2]; $MonatNeu=$tmparray[1]; $TagNeu=$tmparray[0];
         $WoTagNeu=getNameWoTag($TagesNamen[date("w", mktime(0,0,0,$MonatNeu,$TagNeu,$JahrNeu))],$lmouserlang);
         $KWNeu=date("W", mktime(0,0,0,$MonatNeu,$TagNeu,$JahrNeu));
         $nanu= getdate(mktime(0,0,0,$MonatNeu,$TagNeu,$JahrNeu));
         $KWpdf="";
         $JahrNeuG=$JahrNeu; $MonatNeuG=$MonatNeu; $TagNeuG=$TagNeu;
         $WoTagNeuG=$WoTagNeu; $KWNeuG=$KWNeu; $DatumNeuG=$DatumNeu;
         $JahrNeuH=$JahrNeu; $MonatNeuH=$MonatNeu; $TagNeuH=$TagNeu;
         $WoTagNeuH=$WoTagNeu; $KWNeuH=$KWNeu; $DatumNeuH=$DatumNeu;
         $JahrNeuA=$JahrNeu; $MonatNeuA=$MonatNeu; $TagNeuA=$TagNeu;
         $WoTagNeuA=$WoTagNeu; $KWNeuA=$KWNeu;  $DatumNeuA=$DatumNeu;

         // Tabellenkopf einmalig für statisches Template setzen
         if ($SpNr==0 && $Slider==0) {
            $zout = "<!-- Kopfzeile f&uuml;r Tabelle -->\n";
            $template->setCurrentBlock("KopfMonat");
            $template->setVariable("InfoKopfMonat",$zout);
            $template->setVariable("KSpielNr",$text[$MyAddonName][7080]);
            $template->setVariable("KSpieltag",$text[$MyAddonName][7173]);
            $template->setVariable("KWoTag",$text[$MyAddonName][7081]);
            $template->setVariable("KDatum",$text[$MyAddonName][7082]);
            $template->setVariable("KUhrzeit",$text[$MyAddonName][7083]);
            $zout = $text[$MyAddonName][7084];
            $template->setVariable("KHeim",$zout);
            if ($cfgligaicon<2) {$zout='L">'.$zout;}
            $template->setVariable("KHeim-v112",$zout);
            $template->setVariable("KHeimTore",$text[$MyAddonName][7087]);
            $template->setVariable("KTrenn",$text[$MyAddonName][7085]);
            $template->setVariable("KGastTore",$text[$MyAddonName][7087]);
            if ($cfgteamhplink <> 0) {$template->setVariable("KHeimUrl",$text[$MyAddonName][7168]);}
            if ($cfgteamlogo   <> 0) {$template->setVariable("KHeimLogo",$text[$MyAddonName][7169]);}
            if ($cfgteamhplink <> 0) {$template->setVariable("KGastUrl",$text[$MyAddonName][7168]);}
            if ($cfgteamlogo   <> 0) {$template->setVariable("KGastLogo",$text[$MyAddonName][7169]);}
            $zout = $text[$MyAddonName][7086];
            $template->setVariable("KGast",$zout);
            if ($cfgligaicon<2) {$zout='L">'.$zout;}
            $template->setVariable("KGast-v112",$zout);
            $template->setVariable("KTore",$text[$MyAddonName][7170]);
            $zout = "&nbsp;".$cfgligakopftext;
            $template->setVariable("KLiganame",$zout);
            if ($cfgligaicon==0) {$zout='I">'."&nbsp;";}
            if ($cfgligaicon==1) {$zout='I">'.$zout;}
            $template->setVariable("KLiganame-v112",$zout);
            $template->setVariable("KLigaDatum",$text[$MyAddonName][7175]);
            $zout = "&nbsp;".$cfgnotizkopftext;
            if ($cfgnotiz==0) {$zout="&nbsp;";}
            $template->setVariable("KNotiz",$zout);
            $zout = "&nbsp;".$cfgberichtkopftext;
            if ($cfgbericht==0) {$zout="&nbsp;";}
            $template->setVariable("KBericht",$zout);
            $template->parseCurrentBlock();
            $template->setCurrentBlock("Inhalt");
          }

         // GESAMTSPIELPAN
         //Anhand vom Datum bestimmen, ob Datumsanzeige notwendig ist
         if ($DatumNeuG!=$DatumAltG) {
           $DatumAltG=$DatumNeuG;$WoTagAltG=$WoTagNeuG;
           $Datumpdf=$DatumNeuG;$WoTagpdf=$WoTagNeuG;
         }
         else {
           if ($cfgdatumshow==0) {
             $DatumNeuG="&nbsp;";$WoTagNeuG="&nbsp;";
             $Datumpdf="";$WoTagpdf="";
           }
         }
         $MonatName = $MonatsNamen[$MonatNeuG-1];
         $MonatKlein = strtolower($MonatName);
         $Monatpdf="";
         //wenn neues Datum ungleich dem alten: Datum in Ausgabe anzeigen
         if ($MonatNeuG!=$MonatAltG) {
            ++$MG_count;
            //wenn neuer Monat ungleich altem: Monatszeile ausgeben
            $Monatpdf=$MonatName." '".$JahrNeu;
            $MonatsText=$Monatpdf;
            if ($JahrNeu=='1111') {$MonatsText=$text[$MyAddonName][7074];}
            $MonatAltG=$MonatNeuG;
            $zout = "";
            //Eventzeile für Slider-Template erstellen
            $EventId=$JahrNeu.$MonatAltG;
            $EventHide=sprintf("%04d",$JahrNeu.$MonatAltG);
            $EventHideG .= ',"'.$EventHide.'"';
            $EventzeileG .= "window.addEvent('domready', function(){ fplan_".$EventId." = new Fx.Slide('plan_".$EventId."' ); if (show=='".$EventHide."' || show=='9999') {fplan_".$EventId.".show();} else {fplan_".$EventId.".hide();}  $('toggleplan_".$EventId."').addEvent('mousedown', function(e){ e = new Event(e); fplan_".$EventId.".toggle(); e.stop(); }); });"."\n";

            if ($Slider==1) { //Slider-Ausgabe
              if ($SpNr>0 ) {$zout=$kopfende;}
              $zout .= '<!-- Toggle-Bereich f&uuml;r Monat '.$MonatsText.' -->'."\n";
              $template->setCurrentBlock("SliderDev");
              $template->setVariable("MonatsInfoSlider",$zout);
              $template->setVariable("MonatNameKlein",$EventId);
              $template->setVariable("MonatName",$MonatsText);
              $template->parseCurrentBlock();
              $zout = '<!-- Kopfzeile f&uuml;r Monat '.$MonatsText.' -->'."\n";
              $template->setCurrentBlock("KopfMonat");
              $template->setVariable("InfoKopfMonat",$zout);
              $template->setVariable("KSpielNr",$text[$MyAddonName][7080]);
              $template->setVariable("KSpieltag",$text[$MyAddonName][7173]);
              $template->setVariable("KWoTag",$text[$MyAddonName][7081]);
              $template->setVariable("KDatum",$text[$MyAddonName][7082]);
              $template->setVariable("KUhrzeit",$text[$MyAddonName][7083]);
              $zout = $text[$MyAddonName][7084];
              $template->setVariable("KHeim",$zout);
              if ($cfgligaicon<2) {$zout='L">'.$zout;}
              $template->setVariable("KHeim-v112",$zout);
              $template->setVariable("KHeimTore",$text[$MyAddonName][7087]);
              $template->setVariable("KTrenn",$text[$MyAddonName][7085]);
              $zout = $text[$MyAddonName][7086];
              $template->setVariable("KGastTore",$text[$MyAddonName][7087]);
              if ($cfgteamhplink <> 0) {$template->setVariable("KHeimUrl",$text[$MyAddonName][7168]);}
              if ($cfgteamlogo   <> 0) {$template->setVariable("KHeimLogo",$text[$MyAddonName][7169]);}
              if ($cfgteamhplink <> 0) {$template->setVariable("KGastUrl",$text[$MyAddonName][7168]);}
              if ($cfgteamlogo   <> 0) {$template->setVariable("KGastLogo",$text[$MyAddonName][7169]);}
              $template->setVariable("KGast",$zout);
              if ($cfgligaicon<2) {$zout='L">'.$zout;}
              $template->setVariable("KGast-v112",$zout);
              $template->setVariable("KTore",$text[$MyAddonName][7170]);
              $zout = "&nbsp;".$cfgligakopftext;
              $template->setVariable("KLiganame",$zout);
              if ($cfgligaicon==0) {$zout='I">'."&nbsp;";}
              if ($cfgligaicon==1) {$zout='I">'.$zout;}
              $template->setVariable("KLiganame-v112",$zout);
              $template->setVariable("KLigaDatum",$text[$MyAddonName][7175]);
              $zout = "&nbsp;".$cfgnotizkopftext;
              if ($cfgnotiz==0) {$zout="&nbsp;";}
              $template->setVariable("KNotiz",$zout);
              $zout = "&nbsp;".$cfgberichtkopftext;
              if ($cfgbericht==0) {$zout="&nbsp;";}
              $template->setVariable("KBericht",$zout);
              $template->parseCurrentBlock();
            }
            else {  //statische Ausgabe
               $zout = '<!-- Kopfzeile f&uuml;r Monat '.$MonatsText.' -->'."\n";
               $template->setCurrentBlock("MonatszeileStat");
               $template->setVariable("MonatsInfoStat",$zout);
               $template->setVariable("MonatColSpan","11");
               $template->setVariable("MonatNrStat",$JahrNeuG.$MonatNeuG);
               $template->setVariable("MonatNameStat",$MonatsText);
               $template->parseCurrentBlock();
            }
            $template->setCurrentBlock("Inhalt");
            $KWAltG=$KWNeuG;
         }
         else {
            //Monat ist identisch
            $zout="";
            if ($KWNeuG!=$KWAltG) {
               //wenn neue Kalenderwoche, dann KW-Trennzeile ausgeben
               $KWAltG=$KWNeuG;$KWpdf=$KWNeuG;
               $template->setCurrentBlock("WochenNr");
               $template->setVariable("KWColSpan","11");
               $template->setVariable("KWNr",$JahrNeu.$KWNeuG);
               $template->parseCurrentBlock();
               $template->setCurrentBlock("Inhalt");
            }
         }

         //Zeilenfarbe der Ligadaten toggeln
         if ($SpNr%2==1) {
            $template->setCurrentBlock("BackColor1");
            $template->setVariable("Setme1","");
          }
         else {
            $template->setCurrentBlock("BackColor2");
            $template->setVariable("Setme2","");
         }
         $template->parseCurrentBlock();

         // Ergebnis in Gesamtspielplan übernehmen
         $template->setCurrentBlock("Inhalt");
         $template->setVariable("Spieltag",$Spieltag);
         $template->setVariable("LigaDatum",$LigaDatum);
         $template->setVariable("SpielNr",++$SpNr);
         $template->setVariable("WoTag",$WoTagNeuG);
         $template->setVariable("Datum",$DatumNeuG);
         $template->setVariable("Uhrzeit",$Uhrzeit);
         $zout = $Heim;
         if ($cfgligaicon<2) {$zout='L">'.$zout;}
         $template->setVariable("Heim-v112",$zout);
         $template->setVariable("Heim",$Heim);
         $template->setVariable("HeimKurz",$HeimKurz);
         $template->setVariable("HeimMittel",$HeimMittel);
         $template->setVariable("HeimLang",$HeimLang);
         $template->setVariable("HeimLogoUrl",$HeimLogoUrl);
         $template->setVariable("HeimUrl",$HeimUrl);
         $template->setVariable("HeimLogo",$HeimLogo);
         $template->setVariable("HeimLogoAlt",$HeimLogoAlt);
         $template->setVariable("HeimLogoBig",$HeimLogoBig);
         $template->setVariable("HeimLogoBigAlt",$HeimLogoBigAlt);
         $template->setVariable("HeimTore",$ToreHeim);
         $template->setVariable("Trenn",$text[$MyAddonName][7085]);
         $zout = $Gast;
         if ($cfgligaicon<2) {$zout='L">'.$zout;}
         $template->setVariable("Gast-v112",$zout);
         $template->setVariable("Gast",$Gast);
         $template->setVariable("GastKurz",$GastKurz);
         $template->setVariable("GastMittel",$GastMittel);
         $template->setVariable("GastLang",$GastLang);
         $template->setVariable("GastLogoUrl",$GastLogoUrl);
         $template->setVariable("GastUrl",$GastUrl);
         $template->setVariable("GastLogo",$GastLogo);
         $template->setVariable("GastLogoAlt",$GastLogoAlt);
         $template->setVariable("GastLogoBig",$GastLogoBig);
         $template->setVariable("GastLogoBigAlt",$GastLogoBigAlt);
         $template->setVariable("GastTore",$ToreGast);
         $template->setVariable("Tore",$Tore);
         $zout = $Liganame;
         if ($cfgligaicon==0) {$zout='I">'."&nbsp;";}
         if ($cfgligaicon==1) {$zout='I">'.$zout;}
         $template->setVariable("Liganame-v112",$zout);
         $template->setVariable("Liganame",$Liganame);
         $template->setVariable("LigaTitel",$LigaTitel);
         $template->setVariable("Notiz",$Notiz);
         $template->setVariable("Bericht",$Bericht);
         $template->parseCurrentBlock();

         $pdfZeile[$SpNr]=array(
                          "nr" => $SpNr, "heimspiel" => $heimspiel, "gastspiel" => $gastspiel, "monat" => $Monatpdf, "kw" => $KWpdf,
                          "wotag" => $WoTagpdf, "datum" => $Datumpdf, "zeit" => $Uhrzeit, "heim" => $Heimpdf, "gast" => $Gastpdf, "tore" => $Tore,
                          "liga" => $Liganamepdf, "notiz" => $Notizpdf, "heimhl" => $HeimHL, "gasthl" => $GastHL
                         );
         //Das gleiche nochmals für Heim- bzw. Auswärtsplan erledigen
         if ($heimspiel==1) {
            // Heimspielplan erstellen
            if ($SpNrH==0) {$DatumMinH = $DatumNeuH;}
            $DatumMaxH = $DatumNeuH;

	   if ($DatumNeuH!=$DatumAltH) {$DatumAltH=$DatumNeuH;$WoTagAltH=$WoTagNeuH;}
	   else { if ($cfgdatumshow==0) {$DatumNeuH="&nbsp;";$WoTagNeuH="&nbsp;";} }

            // Tabellenkopf einmalig für statisches Template setzen
            if ($SpNrH==0 && $Slider==0) {
               $zout = "<!-- Kopfzeile f&uuml;r Tabelle -->\n";
               $templateH->setCurrentBlock("KopfMonat");
               $templateH->setVariable("InfoKopfMonat",$zout);
               $templateH->setVariable("KSpielNr",$text[$MyAddonName][7080]);
               $templateH->setVariable("KSpieltag",$text[$MyAddonName][7173]);
               $templateH->setVariable("KWoTag",$text[$MyAddonName][7081]);
               $templateH->setVariable("KDatum",$text[$MyAddonName][7082]);
               $templateH->setVariable("KUhrzeit",$text[$MyAddonName][7083]);
               $zout = $text[$MyAddonName][7084];
               $templateH->setVariable("KHeim",$zout);
               if ($cfgligaicon<2) {$zout='L">'.$zout;}
               $templateH->setVariable("KHeim-v112",$zout);
               $templateH->setVariable("KHeimTore",$text[$MyAddonName][7087]);
               $templateH->setVariable("KTrenn",$text[$MyAddonName][7085]);
               if ($cfgteamhplink <> 0) {$templateH->setVariable("KHeimUrl",$text[$MyAddonName][7168]);}
               if ($cfgteamlogo   <> 0) {$templateH->setVariable("KHeimLogo",$text[$MyAddonName][7169]);}
               if ($cfgteamhplink <> 0) {$templateH->setVariable("KGastUrl",$text[$MyAddonName][7168]);}
               if ($cfgteamlogo   <> 0) {$templateH->setVariable("KGastLogo",$text[$MyAddonName][7169]);}
               $zout = $text[$MyAddonName][7086];
               $templateH->setVariable("KGastTore",$text[$MyAddonName][7087]);
               $templateH->setVariable("KGast",$zout);
               if ($cfgligaicon<2) {$zout='L">'.$zout;}
               $templateH->setVariable("KGast-v112",$zout);
               $templateH->setVariable("KTore",$text[$MyAddonName][7170]);
               $zout = "&nbsp;".$cfgligakopftext;
               $templateH->setVariable("KLiganame",$zout);
               $templateH->setVariable("KLigaDatum",$text[$MyAddonName][7175]);
               if ($cfgligaicon==0) {$zout='I">'."&nbsp;";}
               if ($cfgligaicon==1) {$zout='I">'.$zout;}
               $templateH->setVariable("KLiganame-v112",$zout);
               $zout = "&nbsp;".$cfgnotizkopftext;
               if ($cfgnotiz==0) {$zout="&nbsp;";}
               $templateH->setVariable("KNotiz",$zout);
               $zout = "&nbsp;".$vereinsplan_berichtkopftext;
               if ($cfgbericht==0) {$zout="&nbsp;";}
               $templateH->setVariable("KBericht",$zout);
               $templateH->parseCurrentBlock();
            }
            $templateH->setCurrentBlock("Inhalt");

            if ($MonatNeuH!=$MonatAltH) {            //wenn neuer Monat ungleich altem: Monatszeile ausgeben
               $MonatAltH=$MonatNeuH;
               $MonatName = $MonatsNamen[$MonatNeuH-1];
               $MonatKlein = strtolower($MonatName);
               $zout = "";
               //Eventzeile für Slider-Template erstellen
               $EventId=$JahrNeu.$MonatAltH;
               $EventHide=sprintf("%04d",$JahrNeu.$MonatAltH);
               $EventHideH .= ',"'.$EventHide.'"';
               $EventzeileH .= "window.addEvent('domready', function(){ fplan_".$EventId." = new Fx.Slide('plan_".$EventId."' ); if (show=='".$EventHide."' || show=='9999') {fplan_".$EventId.".show();} else {fplan_".$EventId.".hide();}  $('toggleplan_".$EventId."').addEvent('mousedown', function(e){ e = new Event(e); fplan_".$EventId.".toggle(); e.stop(); }); });"."\n";

               if ($Slider==1) { //Slider-Ausgabe
                 if ($SpNrH>0 ) {$zout=$kopfende;}
                 $zout .= '<!-- Toggle-Bereich f&uuml;r Monat '.$MonatsText.' -->'."\n";
                 $templateH->setCurrentBlock("SliderDev");
                 $templateH->setVariable("MonatsInfoSlider",$zout);
                 $templateH->setVariable("MonatNameKlein",$EventId);
                 $templateH->setVariable("MonatName",$MonatsText);
                 $templateH->parseCurrentBlock();
                 $zout = '<!-- Kopfzeile f&uuml;r Monat '.$MonatsText.' -->'."\n";
                 $templateH->setCurrentBlock("KopfMonat");
                 $templateH->setVariable("InfoKopfMonat",$zout);
                 $templateH->setVariable("KSpielNr",$text[$MyAddonName][7080]);
                 $templateH->setVariable("KSpieltag",$text[$MyAddonName][7173]);
                 $templateH->setVariable("KWoTag",$text[$MyAddonName][7081]);
                 $templateH->setVariable("KDatum",$text[$MyAddonName][7082]);
                 $templateH->setVariable("KUhrzeit",$text[$MyAddonName][7083]);
                 $zout = $text[$MyAddonName][7084];
                 $templateH->setVariable("KHeim",$zout);
                 if ($cfgligaicon<2) {$zout='L">'.$zout;}
                 $templateH->setVariable("KHeim-v112",$zout);
                 $templateH->setVariable("KHeimTore",$text[$MyAddonName][7087]);
                 $templateH->setVariable("KTrenn",$text[$MyAddonName][7085]);
                 if ($cfgteamhplink <> 0) {$templateH->setVariable("KHeimUrl",$text[$MyAddonName][7168]);}
                 if ($cfgteamlogo   <> 0) {$templateH->setVariable("KHeimLogo",$text[$MyAddonName][7169]);}
                 if ($cfgteamhplink <> 0) {$templateH->setVariable("KGastUrl",$text[$MyAddonName][7168]);}
                 if ($cfgteamlogo   <> 0) {$templateH->setVariable("KGastLogo",$text[$MyAddonName][7169]);}
                 $templateH->setVariable("KGastTore",$text[$MyAddonName][7087]);
                 $zout = $text[$MyAddonName][7086];
                 $templateH->setVariable("KGast",$zout);
                 if ($cfgligaicon<2) {$zout='L">'.$zout;}
                 $templateH->setVariable("KGast-v112",$zout);
                 $templateH->setVariable("KTore",$text[$MyAddonName][7170]);
                 $zout = "&nbsp;".$cfgligakopftext;
                 $templateH->setVariable("KLiganame",$zout);
                 $templateH->setVariable("KLigaDatum",$text[$MyAddonName][7175]);
                 if ($cfgligaicon==0) {$zout='I">'."&nbsp;";}
                 if ($cfgligaicon==1) {$zout='I">'.$zout;}
                 $templateH->setVariable("KLiganame-v112",$zout);
                 $zout = "&nbsp;".$cfgnotizkopftext;
                 if ($cfgnotiz==0) {$zout="&nbsp;";}
                 $templateH->setVariable("KNotiz",$zout);
                 $zout = "&nbsp;".$vereinsplan_berichtkopftext;
                 if ($cfgbericht==0) {$zout="&nbsp;";}
                 $templateH->setVariable("KBericht",$zout);
                 $templateH->parseCurrentBlock();
               }
               else {  //statische Ausgabe
                  $zout = '<!-- Kopfzeile f&uuml;r Monat '.$MonatName." '".$JahrNeu.' -->'."\n";
                  $templateH->setCurrentBlock("MonatszeileStat");
                  $templateH->setVariable("MonatsInfoStat",$zout);
                  $templateH->setVariable("MonatColSpan","11");
                  $templateH->setVariable("MonatNrStat",$JahrNeuH.$MonatNeuH);
                  $templateH->setVariable("MonatNameStat",$MonatsText);
                  $templateH->parseCurrentBlock();
               }
               $templateH->setCurrentBlock("Inhalt");
               $KWAltH=$KWNeuH;
            }
            else {
               //Monat ist identisch
               $zout="";
               if ($KWNeuH!=$KWAltH) {
                  //wenn neue Kalenderwoche, dann KW-Trennzeile ausgeben
                  $KWAltH=$KWNeuH;
                  $templateH->setCurrentBlock("WochenNr");
                  $templateH->setVariable("KWColSpan","11");
                  $templateH->setVariable("KWNr",$JahrNeu.$KWNeuH);
                  $templateH->parseCurrentBlock();
                  $templateH->setCurrentBlock("Inhalt");
               }
            }

            //Zeilenfarbe der Ligadaten toggeln
            if ($SpNrH%2==1) {
               $templateH->setCurrentBlock("BackColor1");
               $templateH->setVariable("Setme1","");
             }
            else {
               $templateH->setCurrentBlock("BackColor2");
               $templateH->setVariable("Setme2","");
            }
            $templateH->parseCurrentBlock();

            // Ergebnis in Heimspielplan übernehmen
           $templateH->setCurrentBlock("Inhalt");
           $templateH->setVariable("Spieltag",$Spieltag);
           $templateH->setVariable("LigaDatum",$LigaDatum);
           $templateH->setVariable("SpielNr",++$SpNrH);
           $templateH->setVariable("WoTag",$WoTagNeuH);
           $templateH->setVariable("Datum",$DatumNeuH);
           $templateH->setVariable("Uhrzeit",$Uhrzeit);
           $zout = $Heim;
           if ($cfgligaicon<2) {$zout='L">'.$zout;}
           $templateH->setVariable("Heim-v112",$zout);
           $templateH->setVariable("Heim",$Heim);
           $templateH->setVariable("HeimKurz",$HeimKurz);
           $templateH->setVariable("HeimMittel",$HeimMittel);
           $templateH->setVariable("HeimLang",$HeimLang);
           $templateH->setVariable("HeimLogoUrl",$HeimLogoUrl);
           $templateH->setVariable("HeimUrl",$HeimUrl);
           $templateH->setVariable("HeimLogo",$HeimLogo);
           $templateH->setVariable("HeimLogoAlt",$HeimLogoAlt);
           $templateH->setVariable("HeimLogoBig",$HeimLogoBig);
           $templateH->setVariable("HeimLogoBigAlt",$HeimLogoBigAlt);
           $templateH->setVariable("HeimTore",$ToreHeim);
           $templateH->setVariable("Trenn",$text[$MyAddonName][7085]);
           $zout = $Gast;
           if ($cfgligaicon<2) {$zout='L">'.$zout;}
           $templateH->setVariable("Gast-v112",$zout);
           $templateH->setVariable("Gast",$Gast);
           $templateH->setVariable("GastKurz",$GastKurz);
           $templateH->setVariable("GastMittel",$GastMittel);
           $templateH->setVariable("GastLang",$GastLang);
           $templateH->setVariable("GastLogoUrl",$GastLogoUrl);
           $templateH->setVariable("GastUrl",$GastUrl);
           $templateH->setVariable("GastLogo",$GastLogo);
           $templateH->setVariable("GastLogoAlt",$GastLogoAlt);
           $templateH->setVariable("GastLogoBig",$GastLogoBig);
           $templateH->setVariable("GastLogoBigAlt",$GastLogoBigAlt);
           $templateH->setVariable("GastTore",$ToreGast);
           $templateH->setVariable("Tore",$Tore);
           $zout = $Liganame;
           if ($cfgligaicon==0) {$zout='I">'."&nbsp;";}
           if ($cfgligaicon==1) {$zout='I">'.$zout;}
           $templateH->setVariable("Liganame-v112",$zout);
           $templateH->setVariable("LigaTitel",$LigaTitel);
           $templateH->setVariable("Liganame",$Liganame);
           $templateH->setVariable("Notiz",$Notiz);
           $templateH->setVariable("Bericht",$Bericht);
           $templateH->parseCurrentBlock();
         }
         if ($gastspiel==1) {
            // Auswärtsspielplan erstellen
            if ($SpNrA==0) {$DatumMinA = $DatumNeu;}
            $DatumMaxA = $DatumNeu;

       	   if ($DatumNeuA!=$DatumAltA) {$DatumAltA=$DatumNeuA;$WoTagAltA=$WoTagNeuA;}
	   else { if ($cfgdatumshow==0) {$DatumNeuA="&nbsp;";$WoTagNeuA="&nbsp;";} }

            // Tabellenkopf einmalig für statisches Template setzen
            if ($SpNrA==0 && $Slider==0) {
               $zout = "<!-- Kopfzeile f&uuml;r Tabelle -->\n";
               $templateA->setCurrentBlock("KopfMonat");
               $templateA->setVariable("InfoKopfMonat",$zout);
               $templateA->setVariable("KSpieltag",$text[$MyAddonName][7173]);
               $templateA->setVariable("KSpielNr",$text[$MyAddonName][7080]);
               $templateA->setVariable("KWoTag",$text[$MyAddonName][7081]);
               $templateA->setVariable("KDatum",$text[$MyAddonName][7082]);
               $templateA->setVariable("KUhrzeit",$text[$MyAddonName][7083]);
               $zout = $text[$MyAddonName][7084];
               $templateA->setVariable("KHeim",$zout);
               if ($cfgligaicon<2) {$zout='L">'.$zout;}
               $templateA->setVariable("KHeim-v112",$zout);
               $templateA->setVariable("KHeimTore",$text[$MyAddonName][7087]);
               $templateA->setVariable("KTrenn",$text[$MyAddonName][7085]);
               if ($cfgteamhplink <> 0) {$templateA->setVariable("KHeimUrl",$text[$MyAddonName][7168]);}
               if ($cfgteamlogo   <> 0) {$templateA->setVariable("KHeimLogo",$text[$MyAddonName][7169]);}
               if ($cfgteamhplink <> 0) {$templateA->setVariable("KGastUrl",$text[$MyAddonName][7168]);}
               if ($cfgteamlogo   <> 0) {$templateA->setVariable("KGastLogo",$text[$MyAddonName][7169]);}
               $templateA->setVariable("KGastTore",$text[$MyAddonName][7087]);
               $zout = $text[$MyAddonName][7086];
               $templateA->setVariable("KGast",$zout);
               if ($cfgligaicon<2) {$zout='L">'.$zout;}
               $templateA->setVariable("KGast-v112",$zout);
               $templateA->setVariable("KTore",$text[$MyAddonName][7170]);
               $zout = "&nbsp;".$cfgligakopftext;
               $templateA->setVariable("KLiganame",$zout);
               $templateA->setVariable("KLigaDatum",$text[$MyAddonName][7175]);
               if ($cfgligaicon==0) {$zout='I">'."&nbsp;";}
               if ($cfgligaicon==1) {$zout='I">'.$zout;}
               $templateA->setVariable("KLiganame-v112",$zout);
               $zout = "&nbsp;".$cfgnotizkopftext;
               if ($cfgnotiz==0) {$zout="&nbsp;";}
               $templateA->setVariable("KNotiz",$zout);
               $zout = "&nbsp;".$vereinsplan_berichtkopftext;
               if ($cfgbericht==0) {$zout="&nbsp;";}
               $templateA->setVariable("KBericht",$zout);
               $templateA->parseCurrentBlock();
            }
            $templateA->setCurrentBlock("Inhalt");

            if ($MonatNeuA!=$MonatAltA) {            //wenn neuer Monat ungleich altem: Monatszeile ausgeben
               $MonatAltA=$MonatNeuA;
               $MonatName = $MonatsNamen[$MonatNeuA-1];
               $MonatKlein = strtolower($MonatName);
               $zout = "";
               //Eventzeile für Slider-Template erstellen
               $EventId=$JahrNeu.$MonatAltA;
               $EventHide=sprintf("%04d",$JahrNeu.$MonatAltA);
               $EventHideA .= ',"'.$EventHide.'"';
               $EventzeileA .= "window.addEvent('domready', function(){ fplan_".$EventId." = new Fx.Slide('plan_".$EventId."' ); if (show=='".$EventHide."' || show=='9999') {fplan_".$EventId.".show();} else {fplan_".$EventId.".hide();}  $('toggleplan_".$EventId."').addEvent('mousedown', function(e){ e = new Event(e); fplan_".$EventId.".toggle(); e.stop(); }); });"."\n";

               if ($Slider==1) { //Slider-Ausgabe
                 if ($SpNrA>0 ) {$zout=$kopfende;}
                 $zout .= '<!-- Toggle-Bereich f&uuml;r Monat '.$MonatsText.' -->'."\n";
                 $templateA->setCurrentBlock("SliderDev");
                 $templateA->setVariable("MonatsInfoSlider",$zout);
                 $templateA->setVariable("MonatNameKlein",$EventId);
                 $templateA->setVariable("MonatName",$MonatsText);
                 $templateA->parseCurrentBlock();
                 $zout = '<!-- Kopfzeile f&uuml;r Monat '.$MonatsText.' -->'."\n";
                 $templateA->setCurrentBlock("KopfMonat");
                 $templateA->setVariable("InfoKopfMonat",$zout);
                 $templateA->setVariable("KSpielNr",$text[$MyAddonName][7080]);
                 $templateA->setVariable("KSpieltag",$text[$MyAddonName][7173]);
                 $templateA->setVariable("KWoTag",$text[$MyAddonName][7081]);
                 $templateA->setVariable("KDatum",$text[$MyAddonName][7082]);
                 $templateA->setVariable("KUhrzeit",$text[$MyAddonName][7083]);
                 $zout = $text[$MyAddonName][7084];
                 $templateA->setVariable("KHeim",$zout);
                 if ($cfgligaicon<2) {$zout='L">'.$zout;}
                 $templateA->setVariable("KHeim-v112",$zout);
                 $templateA->setVariable("KHeimTore",$text[$MyAddonName][7087]);
                 $templateA->setVariable("KTrenn",$text[$MyAddonName][7085]);
                 $templateA->setVariable("KGastTore",$text[$MyAddonName][7087]);
                 if ($cfgteamhplink <> 0) {$templateA->setVariable("KHeimUrl",$text[$MyAddonName][7168]);}
                 if ($cfgteamlogo   <> 0) {$templateA->setVariable("KHeimLogo",$text[$MyAddonName][7169]);}
                 if ($cfgteamhplink <> 0) {$templateA->setVariable("KGastUrl",$text[$MyAddonName][7168]);}
                 if ($cfgteamlogo   <> 0) {$templateA->setVariable("KGastLogo",$text[$MyAddonName][7169]);}
                 $zout = $text[$MyAddonName][7086];
                 $templateA->setVariable("KGast",$zout);
                 if ($cfgligaicon<2) {$zout='L">'.$zout;}
                 $templateA->setVariable("KGast-v112",$zout);
                 $templateA->setVariable("KTore",$text[$MyAddonName][7170]);
                 $zout = "&nbsp;".$cfgligakopftext;
                 $templateA->setVariable("KLiganame",$zout);
                 if ($cfgligaicon==0) {$zout='I">'."&nbsp;";}
                 if ($cfgligaicon==1) {$zout='I">'.$zout;}
                 $templateA->setVariable("KLiganame-v112",$zout);
                 $templateA->setVariable("KLigaDatum",$text[$MyAddonName][7175]);
                 $zout = "&nbsp;".$cfgnotizkopftext;
                 if ($cfgnotiz==0) {$zout="&nbsp;";}
                 $templateA->setVariable("KNotiz",$zout);
                 $zout = "&nbsp;".$vereinsplan_berichtkopftext;
                 if ($cfgbericht==0) {$zout="&nbsp;";}
                 $templateA->setVariable("KBericht",$zout);
                 $templateA->parseCurrentBlock();
               }
               else {  //statische Ausgabe
                  $zout = '<!-- Kopfzeile f&uuml;r Monat '.$MonatsText.' -->'."\n";
                  $templateA->setCurrentBlock("MonatszeileStat");
                  $templateA->setVariable("MonatsInfoStat",$zout);
                  $templateA->setVariable("MonatColSpan","11");
                  $templateA->setVariable("MonatNrStat",$JahrNeuA.$MonatNeuA);
                  $templateA->setVariable("MonatNameStat",$MonatsText);
                  $templateA->parseCurrentBlock();
               }
               $templateA->setCurrentBlock("Inhalt");
               $KWAltA=$KWNeuA;
            }
            else {
               //Monat ist identisch
               $zout="";
               if ($KWNeuA!=$KWAltA) {
                  //wenn neue Kalenderwoche, dann KW-Trennzeile ausgeben
                  $KWAltA=$KWNeuA;
                  $templateA->setCurrentBlock("WochenNr");
                  $templateA->setVariable("KWColSpan","11");
                  $templateA->setVariable("KWNr",$JahrNeu.$KWNeuA);
                  $templateA->parseCurrentBlock();
                  $templateA->setCurrentBlock("Inhalt");
               }
            }

            //Zeilenfarbe der Ligadaten toggeln
            if ($SpNrA%2==1) {
               $templateA->setCurrentBlock("BackColor1");
               $templateA->setVariable("Setme1","");
             }
            else {
               $templateA->setCurrentBlock("BackColor2");
               $templateA->setVariable("Setme2","");
            }
            $templateA->parseCurrentBlock();

            // Ergebnis in Auswärtsspielplan übernehmen
            $templateA->setCurrentBlock("Inhalt");
            $templateA->setVariable("Spieltag",$Spieltag);
            $templateA->setVariable("LigaDatum",$LigaDatum);
            $templateA->setVariable("SpielNr",++$SpNrA);
            $templateA->setVariable("WoTag",$WoTagNeuA);
            $templateA->setVariable("Datum",$DatumNeuA);
            $templateA->setVariable("Uhrzeit",$Uhrzeit);
            $zout = $Heim;
            if ($cfgligaicon<2) {$zout='L">'.$zout;}
            $templateA->setVariable("Heim-v112",$zout);
            $templateA->setVariable("Heim",$Heim);
            $templateA->setVariable("HeimKurz",$HeimKurz);
            $templateA->setVariable("HeimMittel",$HeimMittel);
            $templateA->setVariable("HeimLang",$HeimLang);
            $templateA->setVariable("HeimLogoUrl",$HeimLogoUrl);
            $templateA->setVariable("HeimUrl",$HeimUrl);
            $templateA->setVariable("HeimLogo",$HeimLogo);
            $templateA->setVariable("HeimLogoAlt",$HeimLogoAlt);
            $templateA->setVariable("HeimLogoBig",$HeimLogoBig);
            $templateA->setVariable("HeimLogoBigAlt",$HeimLogoBigAlt);
            $templateA->setVariable("HeimTore",$ToreHeim);
            $templateA->setVariable("Trenn",$text[$MyAddonName][7085]);
            $zout = $Gast;
            if ($cfgligaicon<2) {$zout='L">'.$zout;}
            $templateA->setVariable("Gast-v112",$zout);
            $templateA->setVariable("Gast",$Gast);
            $templateA->setVariable("GastKurz",$GastKurz);
            $templateA->setVariable("GastMittel",$GastMittel);
            $templateA->setVariable("GastLang",$GastLang);
            $templateA->setVariable("GastLogoUrl",$GastLogoUrl);
            $templateA->setVariable("GastUrl",$GastUrl);
            $templateA->setVariable("GastLogo",$GastLogo);
            $templateA->setVariable("GastLogoAlt",$GastLogoAlt);
            $templateA->setVariable("GastLogoBig",$GastLogoBig);
            $templateA->setVariable("GastLogoBigAlt",$GastLogoBigAlt);
            $templateA->setVariable("GastTore",$ToreGast);
            $templateA->setVariable("Tore",$Tore);
            $zout = $Liganame;
            if ($cfgligaicon==0) {$zout='I">'."&nbsp;";}
            if ($cfgligaicon==1) {$zout='I">'.$zout;}
            $templateA->setVariable("Liganame-v112",$zout);
            $templateA->setVariable("Liganame",$Liganame);
            $templateA->setVariable("LigaTitel",$LigaTitel);
            $templateA->setVariable("Notiz",$Notiz);
            $templateA->setVariable("Bericht",$Bericht);
            $templateA->parseCurrentBlock();
         }  //Ende Auswärtsspiel erstellen
      }     //Ende Datumsangabe NICHT leer
   }	   //Ende foreach, jedes Spiel


   //allg. Nacharbeiten und dann den Spielplan-Templates zuordnen
   if ($Slider==1) {
      //Slider-Angaben vervollständigen
      $zout = "var eventids = new Array(".substr($EventHideG,1).");"."\n";
      $EventzeileG = $zout.$EventzeileG.$OpenCloseFunktion;

      $zout  = "var eventids = new Array(".substr($EventHideH,1).");"."\n";
      $zout .= "var DatumMin = new Date(20".substr($DatumMinH,6,2).",".sprintf("%d",substr($DatumMinH,3,2))."-1,".sprintf("%d",substr($DatumMinH,0,2)).");"."\n";
      $zout .= "var DatumMax = new Date(20".substr($DatumMaxH,6,2).",".sprintf("%d",substr($DatumMaxH,3,2))."-1,".sprintf("%d",substr($DatumMaxH,0,2)).");"."\n";
      $zout .= "//DatumMin: ".$DatumMinH." DatumMax: ".$DatumMaxH."\n";
      $EventzeileH = $zout.$EventzeileH.$OpenCloseFunktion;

      $zout  = "var eventids = new Array(".substr($EventHideA,1).");"."\n";
      $zout .= "var DatumMin = new Date(20".substr($DatumMinA,6,2).",".sprintf("%d",substr($DatumMinA,3,2))."-1,".sprintf("%d",substr($DatumMinA,0,2)).");"."\n";
      $zout .= "var DatumMax = new Date(20".substr($DatumMaxA,6,2).",".sprintf("%d",substr($DatumMaxA,3,2))."-1,".sprintf("%d",substr($DatumMaxA,0,2)).");"."\n";
      $zout .= "//DatumMin: ".$DatumMinA." DatumMax: ".$DatumMaxA."\n";
      $EventzeileA = $zout.$EventzeileA.$OpenCloseFunktion;

      if ($SpNr>0) {
        $template->setCurrentBlock("SliderDevEnd");
        $template->setVariable("SliderDevEndDummy","");
        $template->parseCurrentBlock();
        $template->setCurrentBlock("SliderMenu");
        $template->setVariable("slidermenutxt1",$text[$MyAddonName][7156].':');
        $template->setVariable("urlImg",$MyImgUrl);
        $template->setVariable("imgTitel1",$text[$MyAddonName][7033].' '.$text[$MyAddonName][7151]);
        $template->setVariable("imgText1",$text[$MyAddonName][7155].' '.$text[$MyAddonName][7153]);
        $template->setVariable("imgTitel2",$text[$MyAddonName][7033].' '.$text[$MyAddonName][7152]);
        $template->setVariable("imgText2",$text[$MyAddonName][7155].' '.$text[$MyAddonName][7154]);
        $template->parseCurrentBlock();
        $template->setCurrentBlock("BasicsSlider");
        $template->setVariable("urlVereinsTemplate1",$MyTemplateUrl);
        $template->setVariable("BasisCssNameSlider", $css_slider_file);
        if ($cfgUseMooTools==1) {$template->setVariable("urlVereinsJs",$MyJsUrl);}
        if ($use_XHTML==1) {
          //Skript auslagern
          $MyScriptFileName = $MyConfigFileName.'G.js';
          $MyScriptOutputFile = $MyOutputPath.'/'.$MyScriptFileName;
          if(!$fp=fopen($MyScriptOutputFile,"w")) {
            $error_dateiopen=true; echo $MyAddonName.': '.$text[$MyAddonName][7067].': '.$MyScriptFileName;
            $template->setVariable("EventZeile",$EventzeileG); /* dann das versuchen ... */
          }
          else  {
            fwrite($fp,$EventzeileG.chr(10));
            fclose ($fp);
            $EventJsG='src="'.$MyOutputUrl.'/'.$MyScriptFileName.'"';
            $template->setVariable("EventJs",$EventJsG);
          }
        } else { $template->setVariable("EventZeile",$EventzeileG);}
        $template->parseCurrentBlock();
        $template->setCurrentBlock("Inhalt");
      }

      if ($SpNrH>0) {
        $templateH->setCurrentBlock("SliderDevEnd");
        $templateH->setVariable("SliderDevEndDummy","");
        $templateH->parseCurrentBlock();
        $templateH->setCurrentBlock("SliderMenu");
        $templateH->setVariable("slidermenutxt1",$text[$MyAddonName][7156].':');
        $templateH->setVariable("urlImg",$MyImgUrl);
        $templateH->setVariable("imgTitel1",$text[$MyAddonName][7033].' '.$text[$MyAddonName][7151]);
        $templateH->setVariable("imgText1",$text[$MyAddonName][7155].' '.$text[$MyAddonName][7153]);
        $templateH->setVariable("imgTitel2",$text[$MyAddonName][7033].' '.$text[$MyAddonName][7152]);
        $templateH->setVariable("imgText2",$text[$MyAddonName][7155].' '.$text[$MyAddonName][7154]);
        $templateH->parseCurrentBlock();
        $templateH->setCurrentBlock("BasicsSlider");
        $templateH->setVariable("urlVereinsTemplate1",$MyTemplateUrl);
        $templateH->setVariable("BasisCssNameSlider", $css_slider_file);
        if ($cfgUseMooTools==1) {$templateH->setVariable("urlVereinsJs",$MyJsUrl);}
        if ($use_XHTML==1) {
          //Skript auslagern
          $MyScriptFileName = $MyConfigFileName.'H.js';
          $MyScriptOutputFile = $MyOutputPath.'/'.$MyScriptFileName;
          if(!$fp=fopen($MyScriptOutputFile,"w")) {
            $error_dateiopen=true; echo $MyAddonName.': '.$text[$MyAddonName][7067].': '.$MyScriptFileName;
            $templateH->setVariable("EventZeile",$EventzeileH); /* dann das versuchen ... */
          }
          else  {
            fwrite($fp,$EventzeileH.chr(10));
            fclose ($fp);
            $EventJsH='src="'.$MyOutputUrl.'/'.$MyScriptFileName.'"';
            $templateH->setVariable("EventJs",$EventJsH);
          }
        } else { $templateH->setVariable("EventZeile",$EventzeileH);}
        $templateH->parseCurrentBlock();
        $templateH->setCurrentBlock("Inhalt");
      }
      if ($SpNrA>0) {
        $templateA->setCurrentBlock("SliderDevEnd");
        $templateA->setVariable("SliderDevEndDummy","");
        $templateA->parseCurrentBlock();
        $templateA->setCurrentBlock("SliderMenu");
        $templateA->setVariable("slidermenutxt1",$text[$MyAddonName][7156].':');
        $templateA->setVariable("urlImg",$MyImgUrl);
        $templateA->setVariable("imgTitel1",$text[$MyAddonName][7033].' '.$text[$MyAddonName][7151]);
        $templateA->setVariable("imgText1",$text[$MyAddonName][7155].' '.$text[$MyAddonName][7153]);
        $templateA->setVariable("imgTitel2",$text[$MyAddonName][7033].' '.$text[$MyAddonName][7152]);
        $templateA->setVariable("imgText2",$text[$MyAddonName][7155].' '.$text[$MyAddonName][7154]);
        $templateA->parseCurrentBlock();
        $templateA->setCurrentBlock("BasicsSlider");
        $templateA->setVariable("urlVereinsTemplate1",$MyTemplateUrl);
        $templateA->setVariable("BasisCssNameSlider", $css_slider_file);
        if ($cfgUseMooTools==1) {$templateA->setVariable("urlVereinsJs",$MyJsUrl);}
        if ($use_XHTML==1) {
          //Skript auslagern
          $MyScriptFileName = $MyConfigFileName.'A.js';
          $MyScriptOutputFile = $MyOutputPath.'/'.$MyScriptFileName;
          if(!$fp=fopen($MyScriptOutputFile,"w")) {
            $error_dateiopen=true; echo $MyAddonName.': '.$text[$MyAddonName][7067].': '.$MyScriptFileName;
            $templateA->setVariable("EventZeile",$EventzeileA); /* dann das versuchen ... */
          }
          else  {
            fwrite($fp,$EventzeileA.chr(10));
            fclose ($fp);
            $EventJsA='src="'.$MyOutputUrl.'/'.$MyScriptFileName.'"';
            $templateA->setVariable("EventJs",$EventJsA);
          }
        } else { $templateA->setVariable("EventZeile",$EventzeileA);}
        $templateA->parseCurrentBlock();
        $templateA->setCurrentBlock("Inhalt");
      }
   }
   else {
      if ($SpNr>0) {
        $template->setCurrentBlock("StaticDevEnd");
        $template->setVariable("StaticEndDummy","");
        $template->parseCurrentBlock();
      }
      if ($SpNrH>0) {
        $templateH->setCurrentBlock("StaticDevEnd");
        $templateH->setVariable("StaticEndDummy","");
        $templateH->parseCurrentBlock();
      }
      if ($SpNrA>0) {
        $templateA->setCurrentBlock("StaticDevEnd");
        $templateA->setVariable("StaticEndDummy","");
        $templateA->parseCurrentBlock();
      }
   }
   $template->parse("Liga");
   $template->setVariable("VERSION",VEREINSPLAN_VERSION);
   $template->parse("Liga");
   $template->setVariable("ZEITSTEMPEL",$planupdate);
   $template->parse("Liga");

   $templateH->parse("Liga");
   $templateH->setVariable("VERSION",VEREINSPLAN_VERSION);
   $templateH->parse("Liga");
   $templateH->setVariable("ZEITSTEMPEL",$planupdate);
   $templateH->parse("Liga");

   $templateA->parse("Liga");
   $templateA->setVariable("VERSION",VEREINSPLAN_VERSION);
   $templateA->parse("Liga");
   $templateA->setVariable("ZEITSTEMPEL",$planupdate);
   $templateA->parse("Liga");
   //print_r($tvh_Playlist);
}  // Ende Spiele gefunden

//aktuelle Ergebnis-Liste erstellen
if ($xx_tmpNrErg>=0) {
   arsort($tvh_ErgNr,SORT_NUMERIC);
   foreach ($tvh_ErgNr as $key => $val) {
       $tmp_heim = $tvh_Erglist[$key][2];
       $tmp_gast = $tvh_Erglist[$key][3];
       $templateErg->setVariable("Datum",$tvh_Erglist[$key][0]);
       $templateErg->setVariable("Heim",$tmp_heim);
       $templateErg->setVariable("Gast",$tmp_gast);
       $templateErg->setVariable("Tore",$tvh_Erglist[$key][4]);
       $templateErg->parseCurrentBlock();
   }
   $templateErg->setVariable("VERSION",VEREINSPLAN_VERSION);
   $templateErg->parse("Liga");
}

//PDF-Erstellung
//Wert aus Konfiguration ermitteln
$cfgpdf=0;
if (isset($multi_cfgarray['vereinsplan_pdf']) && $multi_cfgarray['vereinsplan_pdf']==1) {
  $cfgpdf=1;
}

//feststellen, ob PDF-Erstellung ab LMO4 möglich ist
$pdf_ok=0;$pdf_needed2=0;
if (file_exists(PATH_TO_ADDONDIR."/classlib/classes/pdf/class.ezpdf.php")) {$pdf_needed2=1;}
if (($pdf_needed2+$cfgpdf==2) && $SpNr>0) {
  $pdf_ok=1;

  $MyPdfDataFileName = $MyConfigFileName.'.pdf.txt';
  $MyPdfOutputFile = $MyOutputPath.'/'.$MyPdfDataFileName;

  //  URLs für die verschiedenen PDFs
  $url_pdfaufruf='href="'.$MyPathUrl.'/vereinsplan-pdf.php';
  $url_pdfgesamt = $url_pdfaufruf;
  $url_pdfheim = $url_pdfgesamt.'?planart=heim';
  $url_pdfgast = $url_pdfgesamt.'?planart=gast';
  if ($MyConfigFileName!=$MyAddonName) {
    $cfg_parm = '?cfg='.$MyConfigFileName;
    $url_pdfgesamt = $url_pdfaufruf.$cfg_parm;
    $url_pdfheim = $url_pdfgesamt.'&amp;planart=heim';
    $url_pdfgast = $url_pdfgesamt.'&amp;planart=gast';
  }

  $error_dateiopen=false;
  $pdf_count=0;
  if(!$fp=fopen($MyPdfOutputFile,"w")) {
    $error_dateiopen=true; echo $MyAddonName.': '.$text[$MyAddonName][7067].': '.$MyPdfDataFileName;
  }
  else  {
   $cfgpdfliga=0;
   if (isset($multi_cfgarray['vereinsplan_pdfliga']) && $multi_cfgarray['vereinsplan_pdfliga']==1) {
     $cfgpdfliga=1;
   }
   $cfgpdfnotiz=0;
   if (isset($multi_cfgarray['vereinsplan_pdfnotiz']) && $multi_cfgarray['vereinsplan_pdfnotiz']==1) {
     $cfgpdfnotiz=1;
   }
   $cfgpdfhighlight=0;
   if ($cfghighlight) { $cfgpdfhighlight=1; }

   $cfgseitejemonat=0;
   if (isset($multi_cfgarray['vereinsplan_pdfseitejemonat']) && $multi_cfgarray['vereinsplan_pdfseitejemonat']==1) {
     $cfgseitejemonat=1;
   }
   $cfgpdfformat=0;
   if (isset($multi_cfgarray['vereinsplan_pdfformat']) && $multi_cfgarray['vereinsplan_pdfformat']==1) {
     $cfgpdfformat=1;
     $url_pdfgesamt .= '&amp;format=1';
     $url_pdfheim   .= '&amp;format=1';
     $url_pdfgast   .= '&amp;format=1';

   }
   $cfgpdflogo1=$multi_cfgarray['vereinsplan_pdflogo1'];
   $cfgpdflogo2=$multi_cfgarray['vereinsplan_pdflogo2'];

   $tmp_text = $text[$MyAddonName][7094];
   $cfgpdftarget=0;$pdftarget ="";
   if (isset($multi_cfgarray['vereinsplan_pdftarget']) && $multi_cfgarray['vereinsplan_pdftarget']==1) {
      $cfgpdftarget=1;
      $pdftarget = $targetBlank;
      $tmp_text .= ' '.$text[$MyAddonName][7126];
   }
   $tmp_text .= ' '.$text[$MyAddonName][7107];
    fwrite($fp,'[basics]'.chr(10));
    fwrite($fp,'titel='.$MyClubNameLong.chr(10));

    $pdfkopf  =$text[$MyAddonName][7080].', ';
    $pdfkopf .=$text[$MyAddonName][7081].', ';
    $pdfkopf .=$text[$MyAddonName][7082].', ';
    $pdfkopf .=$text[$MyAddonName][7083].', ';
    $pdfkopf .=$text[$MyAddonName][7084].', ';
    $pdfkopf .=$text[$MyAddonName][7085].', ';
    $pdfkopf .=$text[$MyAddonName][7086].', ';
    $pdfkopf .=$text[$MyAddonName][7087].', ';
    $pdfkopf .=$text[$MyAddonName][7088].', ';
    $pdfkopf .=$text[$MyAddonName][7047].chr(10);
    fwrite($fp,'kopf='.$pdfkopf);

    fwrite($fp,'erstellt='.$planupdate.chr(10));
    fwrite($fp,'version='.$MyAddonName.' '.$MyAddonVersion.chr(10));
    fwrite($fp,'pdfhl='.$cfgpdfhighlight.chr(10));
    fwrite($fp,'pdfshownotiz='.$cfgpdfnotiz.chr(10));
    fwrite($fp,'pdfshowliga='.$cfgpdfliga.chr(10));
    fwrite($fp,'pdfformat='.$cfgpdfformat.chr(10));
    fwrite($fp,'seitejemonat='.$cfgseitejemonat.chr(10));
    fwrite($fp,'pdflogo1='.$cfgpdflogo1.chr(10));
    fwrite($fp,'pdflogo1show='.$multi_cfgarray['vereinsplan_pdfshowlogo1'].chr(10));
    fwrite($fp,'pdflogo1w='.$multi_cfgarray['vereinsplan_pdflogo1w'].chr(10));
    fwrite($fp,'pdflogo1h='.$multi_cfgarray['vereinsplan_pdflogo1h'].chr(10));
    fwrite($fp,'pdflogo1xh='.$multi_cfgarray['vereinsplan_pdflogo1xh'].chr(10));
    fwrite($fp,'pdflogo1yh='.$multi_cfgarray['vereinsplan_pdflogo1yh'].chr(10));
    fwrite($fp,'pdflogo1xq='.$multi_cfgarray['vereinsplan_pdflogo1xq'].chr(10));
    fwrite($fp,'pdflogo1yq='.$multi_cfgarray['vereinsplan_pdflogo1yq'].chr(10));
    fwrite($fp,'pdflogo2='.$cfgpdflogo2.chr(10));
    fwrite($fp,'pdflogo2show='.$multi_cfgarray['vereinsplan_pdfshowlogo2'].chr(10));
    fwrite($fp,'pdflogo2w='.$multi_cfgarray['vereinsplan_pdflogo2w'].chr(10));
    fwrite($fp,'pdflogo2h='.$multi_cfgarray['vereinsplan_pdflogo2h'].chr(10));
    fwrite($fp,'pdflogo2xh='.$multi_cfgarray['vereinsplan_pdflogo2xh'].chr(10));
    fwrite($fp,'pdflogo2yh='.$multi_cfgarray['vereinsplan_pdflogo2yh'].chr(10));
    fwrite($fp,'pdflogo2xq='.$multi_cfgarray['vereinsplan_pdflogo2xq'].chr(10));
    fwrite($fp,'pdflogo2yq='.$multi_cfgarray['vereinsplan_pdflogo2yq'].chr(10));

    foreach ($pdfZeile as $key => $val) {
      $pdf_count++;
        fwrite($fp,'[spiel'.$pdf_count.']'.chr(10));
        foreach ($pdfZeile[$pdf_count] as $key => $val) {
          //echo "<br>Feld $key hat den Wert: $val";
          if (!$ok=fwrite($fp,$key.'="'.$val.'"'.chr(10))) {
            $error_dateiopen=true;
          }
        }
    }
    fclose ($fp);

    $template->setCurrentBlock("CREATEPDF");
    $template->setVariable("targetPDF", $pdftarget);
    $template->setVariable("urlPDF", $url_pdfgesamt.'" title="'.$tmp_text.'"');
    $template->setVariable("txtPDF",$text[$MyAddonName][7116].': '.$text[$MyAddonName][7104]);
    $template->parseCurrentBlock();
    $template->setCurrentBlock("Inhalt");
    $template->parse("Liga");

    $templateH->setCurrentBlock("CREATEPDF");
    $templateH->setVariable("targetPDF", $pdftarget);
    $templateH->setVariable("urlPDF", $url_pdfheim.'" title="'.$tmp_text.'"');
    $templateH->setVariable("txtPDF",$text[$MyAddonName][7116].': '.$text[$MyAddonName][7105]);
    $templateH->parseCurrentBlock();
    $templateH->setCurrentBlock("Inhalt");
    $templateH->parse("Liga");

    $templateA->setCurrentBlock("CREATEPDF");
    $templateA->setVariable("targetPDF", $pdftarget);
    $templateA->setVariable("urlPDF", $url_pdfgast.'" title="'.$tmp_text.'"');
    $templateA->setVariable("txtPDF",$text[$MyAddonName][7116].': '.$text[$MyAddonName][7106]);
    $templateA->parseCurrentBlock();
    $templateA->setCurrentBlock("Inhalt");
    $templateA->parse("Liga");

  }
}

?>