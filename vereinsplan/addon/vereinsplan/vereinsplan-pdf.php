<?php
/** Pdf Addon for LMO 4
  *
  * (c) by Tim Schumacher
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
  * $Id: vereinsplan-pdf.php,v 1.1.2 2009/08/27 $
  *
  * parms: cfg=<cfg:filename>            default: vereinsplan
  *        planart=gesamt | heim | gast  default: gesamt
  *        format=0 | 1                  default: 0 (Hochformat)
  *        page=0 | 1                    default: 1 (neue Seite pro Monat)
  */
/** Vereinsplan 1.1.2
  *
  * Credits:
  * Vereinsplan is based on and is used following
  * - LMO-Addon Viewer 4.0 Beta 3
  * - LMO-Addon TP 1.0 Spielplan
  * - JoomlaWorks "Tabs & Slides" Module for Joomla! 1.5.x - Version 1.0
  *
  */
/** Changelog:
    27.08.2009  Happy Birthday to myself
                erstellt PDF-Dokument für vereinsplan
    04.09.2009  DAS LMO-Logo fest eingepflegt
                2 Logos eingepflegt, die über Admin-Oberfläche angepasst werden können
    08.09.2009  Liga- und Notiz-Spalte über Admin-Oberfläche aus-/einblenden
    10.09.2009  PDF-Ausgabeformat wählbar
    13.09.2009  An LMO-Forum übergeben
    02.11.2010  Verwendet nun die LMO4-eigene PDF-Classlib
                Dadurch unabhängig von PDF-Addon
  */


require_once(dirname(__FILE__).'/../../init.php');

$MyAddonName ='vereinsplan';

$cfgoutput   = isset($_REQUEST["cfg"])?$_REQUEST["cfg"]:'vereinsplan';
$filename    = $cfgoutput.'.pdf.txt';
$file        = PATH_TO_LMO."/output/".$filename;

$cfgplanart=isset($_REQUEST["planart"])?$_REQUEST["planart"]:'gesamt';
switch ($cfgplanart) {
  case "heim":
    // Heimspielplan
    $showplan=0;$titel=$text[$MyAddonName][7105];
    break;
  case "gast":
    // Auswärtsspielplan
    $showplan=1;$titel=$text[$MyAddonName][7106];
    break;
  case "result":
    // Spielergebnisse
    $showplan=3;$titel=$text[$MyAddonName][7104];
    break;
  default:
    // Gesamtspielplan
    $showplan=3;$titel=$text[$MyAddonName][7104];
    break;
}

$error = FALSE;
if ($filename <> '') {
  if (!file_exists($file)) {
     $message = $text[$MyAddonName][7011].': '.$filename.' '.$text[$MyAddonName][7054];
     // die("Konfigurationsdatei: $MyConfigFile nicht gefunden!");
     $error=TRUE;
     $spielplanName= $message;
  }
  else {
    // Ini-Datei in Array lesen
    $spielplan = parse_ini_file($file,true);
    $spiele = count($spielplan);
    if ($spiele>1) {
      $spielplanName   = $titel.' '.$spielplan['basics']['titel'];
      $cfghl           = $spielplan['basics']['pdfhl'];
      $cfgdate         = $spielplan['basics']['erstellt'];
      $version         = $spielplan['basics']['version'];
      $cfgkopf         = $spielplan['basics']['kopf'];
      $cfgformat       = isset($spielplan['basics']['pdfformat']) ? $spielplan['basics']['pdfformat'] : 0;
      $cfgformat       = isset($_REQUEST["format"]) ? $_REQUEST["format"] : $cfgformat;
      if ($cfgformat< 0 || $cfgformat > 1) {$cfgformat=0;}
      $cfgseitejemonat = isset($spielplan['basics']['seitejemonat']) ? $spielplan['basics']['seitejemonat'] : 1;
      $cfgseitejemonat = isset($_REQUEST["page"]) ? $_REQUEST["page"] : $cfgseitejemonat;
      if ($cfgseitejemonat< 0 || $cfgseitejemonat > 1) {$cfgseitejemonat=0;}
      //$cfgseitejemonat = 0; //noch intensiver austesten
      $cfgnotiz        = isset($spielplan['basics']['pdfshownotiz']) ? $spielplan['basics']['pdfshownotiz'] : 0;
      $cfgliga         = isset($spielplan['basics']['pdfshowliga'])  ? $spielplan['basics']['pdfshowliga']  : 1;
      $kopfarray       = explode(',',$cfgkopf);   //Nr. Tag Datum Zeit Heim * Gast Tore Klasse Notiz
      $cfglogo1        = $spielplan['basics']['pdflogo1'].'.png';
      $cfglogo1show    = $spielplan['basics']['pdflogo1show'];
      $cfglogo1size    = array($spielplan['basics']['pdflogo1w'],$spielplan['basics']['pdflogo1h']);
      $cfglogo1posh    = array($spielplan['basics']['pdflogo1xh'],$spielplan['basics']['pdflogo1yh']);
      $cfglogo1posq    = array($spielplan['basics']['pdflogo1xq'],$spielplan['basics']['pdflogo1yq']);

      $cfglogo2        = $spielplan['basics']['pdflogo2'].'.png';
      $cfglogo2show    = $spielplan['basics']['pdflogo2show'];
      $cfglogo2size    = array($spielplan['basics']['pdflogo2w'],$spielplan['basics']['pdflogo2h']);
      $cfglogo2posh    = array($spielplan['basics']['pdflogo2xh'],$spielplan['basics']['pdflogo2yh']);
      $cfglogo2posq    = array($spielplan['basics']['pdflogo2xq'],$spielplan['basics']['pdflogo2yq']);

      //**************************************************************************************
      // diverse Variable mit Werten für ausgesuchte Ausgabeobjekte
      //**************************************************************************************
      $pdf_blatt= 'a4';
      $pdf_format = $cfgformat;           // 0: Hochformat, 1: Querformat
      $pdf_rand0  = array(50,70,50,50);   //oben, unten, links, rechts
      $pdf_rand1  = array(80,70,40,40);
      //****************************************
      //allgemeine Schrift- bzw. Linienfarbe
      // r, g, b : je zwischen 0 und 255
      // f(orce) : nur bei Linien
      //****************************************
      $line_black = array(0,0,0,1);
      $text_black = array(0,0,0);
      $line_blue  = array(0,0,255,1);
      $text_blue  = array(0,0,255);
      $line_green = array(0,255,0,1);
      $text_green = array(0,255,0);
      $line_red   = array(255,0,0,1);
      $text_red   = array(255,0,0);

      //****************************************
      //alternative Zeilen-Farben
      //0=nein, 1=ja, 2=beide
      $zfarbewechseln=2;
      // r, g, b : je zwischen 0.0 (schwarz) und 1.0 (weiss)
      $zfarbe1 = array(1.0,1.0,1.0);
      $zfarbe2 = array(0.9,0.9,0.9);

      //****************************************
      //Bilder
      //  pos : x, y
      //  size: Breite, Höhe, Qualität (max. 75)
      //****************************************
      //Bilder im PDF-Header
      //$img_name1 = "tvh_logo.png";
      //$img_size1 = array(30,22,75);
      //$img_name2 = "tvh_logoname.png";
      //$img_size2 = array(55,18,75);
      $img_name1 = $cfglogo1;
      $img_size1 = array($cfglogo1size[0],$cfglogo1size[1],75);
      $img_name2 = $cfglogo2;
      $img_size2 = array($cfglogo2size[0],$cfglogo2size[1],75);
      $img_name3  = "LMO401-logo-gross.png";
      $img_size3 = array(60,20,75);
      //Position Bilder

      if ($pdf_format==1) {
        //$img_pos1  = array(50,530);
        //$img_pos2  = array(100,531);
        $img_pos1  = array($cfglogo1posq[0],$cfglogo1posq[1]);
        $img_pos2  = array($cfglogo2posq[0],$cfglogo2posq[1]);
        $img_pos3  = array(600,531);
      } else {
        //$img_pos1  = array(50,795);
        //$img_pos2  = array(100,796);
        $img_pos1  = array($cfglogo1posh[0],$cfglogo1posh[1]);
        $img_pos2  = array($cfglogo2posh[0],$cfglogo2posh[1]);
        $img_pos3  = array(490,797);
      }
      //****************************************
      //Texte
      // x, y, Schriftgrösse
      //****************************************
      //Kopf-Überschrift
      $header1_farbe = $text_red;
      $header1_text  = $spielplanName;

      //Homepage
      $hp_farbe = $text_blue;
      $hp_text  = isset($cfgarray['pdf']['homepage'])?$cfgarray['pdf']['homepage']:'';

      //Aktualisierungsstand
      $akt_farbe = $text_blue;
      $akt_text  = $cfgdate.' (by Addon '.$version.')';

      //PDF-Version
      $pdfversion_farbe = $text_black;
      $pdfversion_text  = "Addon for Liga Manager Online 4 <c:alink:http://lmo.sourceforge.net/>http://lmo.sourceforge.net</c:alink>";

      //PDF-Erstellung
      $pdfcreate_farbe = $text_black;
      $pdfcreate_text  = $text[$MyAddonName][7033].' '.$text[$MyAddonName][7118].' '.$text[$MyAddonName][7102].': '.strftime ("%d.%m.%y %H:%M");

      //Position Text-Objekte
      if ($pdf_format==1) {
        $hp_pos         = array(50,560,8);
        $akt_pos        = array(600,560,6); // x, y, Schriftgrösse
        $header1_pos    = array(330,535,12);
        $pdfversion_pos = array(50,34,6);
        $pdfcreate_pos  = array(600,34,6);
      } else {
        $hp_pos         = array(50,824,8);
        $akt_pos        = array(360,824,6); // x, y, Schriftgrösse
        $header1_pos    = array(200,800,12);
        $pdfversion_pos = array(50,34,6);
        $pdfcreate_pos  = array(380,34,6);
      }

      //****************************************
      //Linien
      //   pos: x1, y1, x2, y2
      //     x: links->rechts
      //     y: unten->oben (!)
      // style: w, c, j, d[], p
      //     w: width: 1->n
      //     c: cap  : 'butt','round','square'
      //     j: join : 'miter', 'round', 'bevel'
      //     d: dash : (2) represents 2 on, 2 off, 2 on , 2 off ...
      //               (2,1) is 2 on, 1 off, 2 on, 1 off.. etc
      //     p: phase: 0->n used by dash
      //****************************************
      $line_style_normal=array(1,'round','',array(1,0),0);

      $firstline_farbe  = $line_red;
      $secondline_farbe = $line_red;
      $kopflinie1_style = array(1,'round','round',array(3,1),0);
      $kopflinie1_farbe = $line_black;
      $kopflinie2_farbe = $line_blue;
      $lastline_farbe   = $line_black;
      //Position Linien
      if ($pdf_format==1) {
        $firstline_pos  = array(30,555,800,555);
        $secondline_pos = array(30,528,800,528);
        $kopflinie1_pos = array(370,500,470,500);
        $kopflinie2_pos = array(30,484,800,484);
        $lastline_pos   = array(30,40,800,40);
      } else {
        $firstline_pos  = array(20,822,578,822);
        $secondline_pos = array(20,794,578,794);
        $kopflinie1_pos = array(250,776,350,776);
        $kopflinie2_pos = array(20,760,578,760);
        $lastline_pos   = array(20,40,578,40);
      }

     //****************************************************************************************************

      $img1=PATH_TO_TEMPLATEDIR."/".$MyAddonName."/img/".$img_name1;
      $img2=PATH_TO_TEMPLATEDIR."/".$MyAddonName."/img/".$img_name2;
      $img3=PATH_TO_TEMPLATEDIR."/".$MyAddonName."/img/".$img_name3;
      $img1_ok = $img2_ok = $img3_ok = false;
      if ($img_name1!='.png') {if (file_exists($img1)) {$img1_ok=true;}}
      if ($img_name2!='.png') {if (file_exists($img2)) {$img2_ok=true;}}
      if (file_exists($img3)) {$img3_ok=true;}
      //echo  $img_pos1[0].' '.$img_pos1[1].' '.$img_size1[0].' '.$img_size1[1].' '.$img1;

      // jetzt wird gerechnet....
      $sp=1; // Test Nur Spielplan anzeigen

      //***************************************************************************
      // PDF-Basisumgebung einrichten
      //***************************************************************************
      if (!isset($pdf_blatt) || trim($pdf_blatt)=='') {$pdf_blatt='a4';}
      if (!isset($pdf_format) || $pdf_format<0 || $pdf_format>1) {$pdf_format=1;}

      $pdf_formate = array('portrait','landscape');
      $pdf = new Cezpdf($paper=$pdf_blatt,$orientation=$pdf_formate[$pdf_format]);
      //$pdf = new Cezpdf();
      if ($pdf_format==1) {
        $pdf -> ezSetMargins($pdf_rand1[0],$pdf_rand1[1],$pdf_rand1[2],$pdf_rand1[3]);
      } else {
        $pdf -> ezSetMargins($pdf_rand0[0],$pdf_rand0[1],$pdf_rand0[2],$pdf_rand0[3]);
      }
      //$pdf->setPreferences('FitWindow',true);
      //Schriftart
      $pdf->selectFont(PATH_TO_ADDONDIR.'/classlib/classes/pdf/fonts/Helvetica.afm');
      $all = $pdf->openObject();
      $pdf->saveState();
      $pdf->setLineStyle($line_style_normal[0],$line_style_normal[1],$line_style_normal[2],array($line_style_normal[3][0],$line_style_normal[3][1]),$line_style_normal[4]);

      //HP-Info
      $pdf->setColor($hp_farbe[0],$hp_farbe[1],$hp_farbe[2]);
      $pdf->addText($hp_pos[0],$hp_pos[1],$hp_pos[2],$hp_text);
      //Aktualisierung
      $pdf->setColor($akt_farbe[0],$akt_farbe[1],$akt_farbe[2]);
      $pdf->addText($akt_pos[0],$akt_pos[1],$akt_pos[2],$akt_text);
      //Linien oben
      $pdf->setStrokeColor($firstline_farbe[0],$firstline_farbe[1],$firstline_farbe[2],$firstline_farbe[3]);
      $pdf->line($firstline_pos[0],$firstline_pos[1],$firstline_pos[2],$firstline_pos[3]);
      $pdf->setStrokeColor($secondline_farbe[0],$secondline_farbe[1],$secondline_farbe[2],$secondline_farbe[3]);
      $pdf->line($secondline_pos[0],$secondline_pos[1],$secondline_pos[2],$secondline_pos[3]);
      // Bilder einfügen
      if ($img1_ok && $cfglogo1show==1) {
        $img= ImageCreatefrompng($img1);
        $pdf->addImage($img,$img_pos1[0],$img_pos1[1],$img_size1[0],$img_size1[1],$img_size1[2]);
      }
      if ($img2_ok && $cfglogo2show==1) {
        $img= ImageCreatefrompng($img2);
        $pdf->addImage($img,$img_pos2[0],$img_pos2[1],$img_size2[0],$img_size2[1],$img_size2[2]);
      }
      if ($img3_ok) {
        $img= ImageCreatefrompng($img3);
        $pdf->addImage($img,$img_pos3[0],$img_pos3[1],$img_size3[0],$img_size3[1],$img_size3[2]);
      }
      //Kopf-Überschrift
      $pdf->setColor($header1_farbe[0],$header1_farbe[1],$header1_farbe[2]);
      $pdf->addText($header1_pos[0],$header1_pos[1],$header1_pos[2],$header1_text);
      //Linien Tabellenkopf
      $pdf->setStrokeColor($kopflinie1_farbe[0],$kopflinie1_farbe[1],$kopflinie1_farbe[2],$kopflinie1_farbe[3]);
      $pdf->setLineStyle($kopflinie1_style[0],$kopflinie1_style[1],$kopflinie1_style[2],array($kopflinie1_style[3][0],$kopflinie1_style[3][0]),$kopflinie1_style[4]);
      $pdf->line($kopflinie1_pos[0],$kopflinie1_pos[1],$kopflinie1_pos[2],$kopflinie1_pos[3],$kopflinie1_pos[4]);
      $pdf->setLineStyle($line_style_normal[0],$line_style_normal[1],$line_style_normal[2],array($line_style_normal[3][0],$line_style_normal[3][1]),$line_style_normal[4]);
      $pdf->setStrokeColor($kopflinie2_farbe[0],$kopflinie2_farbe[1],$kopflinie2_farbe[2],$kopflinie2_farbe[3]);
      $pdf->line($kopflinie2_pos[0],$kopflinie2_pos[1],$kopflinie2_pos[2],$kopflinie2_pos[3]);
      //Linie unten
      $pdf->setStrokeColor($lastline_farbe[0],$lastline_farbe[1],$lastline_farbe[2],$lastline_farbe[3]);
      $pdf->line($lastline_pos[0],$lastline_pos[1],$lastline_pos[2],$lastline_pos[3]);
      //PDF-Version
      $pdf->setColor($pdfversion_farbe[0],$pdfversion_farbe[1],$pdfversion_farbe[2]);
      $pdf->addText($pdfversion_pos[0],$pdfversion_pos[1],$pdfversion_pos[2],$pdfversion_text);
      //PDF-Erstellung
      $pdf->setColor($pdfcreate_farbe[0],$pdfcreate_farbe[1],$pdfcreate_farbe[2]);
      $pdf->addText($pdfcreate_pos[0],$pdfcreate_pos[1],$pdfcreate_pos[2],$pdfcreate_text);

      //Spalten ausrichten
      $SpielOptionen = array(
          $kopfarray[0]=>array('justification'=>'center'),
          $kopfarray[4]=>array('justification'=>'center'),
          $kopfarray[6]=>array('justification'=>'center'),
          $kopfarray[8]=>array('justification'=>'center'),
          $kopfarray[9]=>array('justification'=>'center')
      );

      $pdf->restoreState();
      $pdf->closeObject();
      $pdf->addObject($all,'all');

      //allg. PDF-Eigenschaften
      if ($pdf_format==1) {$ZeilenproSeite =30;}
      else {$ZeilenproSeite =51;}

      $SpielplanOptionen = array(
        'cols' => $SpielOptionen,
        'titleFontSize'=>10,
        'fontSize'=>8,
        'shaded' => $zfarbewechseln,'shadeCol'=>$zfarbe1,'shadeCol2'=>$zfarbe2,
        'showLines' => 0,
        'showHeadings'=>1,
        'protectRows'=> $ZeilenproSeite
      );

      // jetzt Daten v. Spielplan übernehmen
      $spnr=0;$zeilengesamt=0;$zeilenspiele=0;$monatneu="";$monatalt="";$monatanzahl=0;
      for ($z=1;$z<count($spielplan);$z++) {
        if (isset($spielplan['spiel'.$z])) {
          if ($spielplan['spiel'.$z]['monat']!=='') {
             $monatneu=$spielplan['spiel'.$z]['monat'];
             if ($monatalt == "" && $cfgseitejemonat!=1) {$monatalt=$monatneu;}
          }
          if ($spielplan['spiel'.$z]['datum']!=='') {
             $datumtmp=$spielplan['spiel'.$z]['datum'];
          }
          if ($spielplan['spiel'.$z]['wotag']!=='') {
             $wotagtmp=$spielplan['spiel'.$z]['wotag'];
          }
          $useme=false;
          if ($spielplan['spiel'.$z]['heimspiel']==1 && $showplan==0) {$useme=true;}
          if ($spielplan['spiel'.$z]['gastspiel']==1 && $showplan==1) {$useme=true;}
          if ($showplan==3) {$useme=true;}
          if ($useme) {
            if ($monatneu !== $monatalt) {
              $SpielplanOptionen['protectRows'] = $zeilenspiele;
              $pdf->ezTable($pdfSpieltag,"",$monatalt,$SpielplanOptionen);
              ++$monatanzahl;
              if ($monatanzahl>1 && $cfgseitejemonat==1) {
                 $pdf->eznewpage();
              }
              $pdfSpieltag = array();
              $monatalt=$monatneu;
              $zeilenspiele=0;
            }
            if ($zeilenspiele>$ZeilenproSeite) {
              $SpielplanOptionen['protectRows'] = $zeilenspiele;
              $pdf->ezTable($pdfSpieltag,"",$monatalt,$SpielplanOptionen);
              $pdfSpieltag = array();
              $zeilenspiele=0;
            }
            ++$zeilengesamt;
            ++$zeilenspiele;
            ++$spnr;

            $heim = $spielplan['spiel'.$z]['heim'];
            $gast = $spielplan['spiel'.$z]['gast'];
            $heimhl = $spielplan['spiel'.$z]['heimhl'];
            $gasthl = $spielplan['spiel'.$z]['gasthl'];
            if ($cfghl==1) {
              if ($heimhl==1) { $heim = '<b>'.$heim.'</b>';}
              if ($gasthl==1) { $gast = '<b>'.$gast.'</b>';}
            }
            $datumout = $zeilenspiele==1 ? $datumtmp : $spielplan['spiel'.$z]['datum'];
            $wotagout = $zeilenspiele==1 ? $wotagtmp : $spielplan['spiel'.$z]['wotag'];
            $pdfSpiel=array(
              $kopfarray[0]=>$spnr,
              $kopfarray[10]=>$wotagout,
              $kopfarray[2]=>$datumout,
              $kopfarray[3]=>$spielplan['spiel'.$z]['zeit'],
              $kopfarray[4]=>$heim,
              $kopfarray[5]=>$kopfarray[5],
              $kopfarray[6]=>$gast,
              $kopfarray[7]=>$spielplan['spiel'.$z]['tore']
              );
            if ($cfgliga==1) {$pdfSpiel[$kopfarray[8]] = $spielplan['spiel'.$z]['liga'];}
            if ($cfgnotiz==1) {$pdfSpiel[$kopfarray[9]] = $spielplan['spiel'.$z]['notiz'];}

            $pdfSpieltag[]=$pdfSpiel;
          } //useme
        } //isset
      } //for
      $pdf->ezTable($pdfSpieltag,"",$monatalt,$SpielplanOptionen);
    } //spiele>0
  } //file exists
} //filename empty
else {
  $error=TRUE;
  $message = $text[$MyAddonName][7118].'-'.$text[$MyAddonName][7011].' '.$text[$MyAddonName][7072].' '.$text[$MyAddonName][7073].': '.$filename.chr(10);
  $spielplanName= $message;
}

if (!$error) {
  $pdf->ezStream();
}
else {
?>
  <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
          "http://www.w3.org/TR/html4/loose.dtd">
  <html lang="de">
  <head>
  <title><?php echo "Pdf Addon ($spielplanName)"?></title>
  </head>
  <body>
  <?php echo getMessage($message,TRUE);?>
  </body>
  </html>
<?php }?>