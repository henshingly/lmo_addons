<?php

/**
 * PDF Addon for LMO 4 für Team-Vergleich
 *
 * Copyright © 2004 by Torsten Hofmann
 *
 * PDF CLASS
 * https://github.com/rospdf/
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
 */

// error_reporting(E_ALL);
// set_time_limit(1800);
require_once (__DIR__ . '/../../init.php');
require_once (PATH_TO_ADDONDIR . '/stats/ini.php');

if (!isset($cfgarray))
    $cfgarray = array();
$multi1 = PATH_TO_CONFIGDIR . '/stats/' . $multi . '.stats';

if (file_exists($multi1)) {
    $multi_cfgarray = parse_ini_file($multi1);
    $multi_cfgarray += $main_cfgarray;
    extract($multi_cfgarray);
}
else {
    die($text['viewer'][55] . ': ' . $multi1 . ' ' . $text['viewer'][56]);
}

$error = FALSE;
$protectRows = 30;
$a = $_GET['a'];
$b = $_GET['b'];
$cols = 5;

$pdf = new Cezpdf();
$pdf->ezSetMargins(70, 70, 50, 50);
$pdf->selectFont(PATH_TO_ADDONDIR . '/classlib/classes/pdf/fonts/Helvetica.afm');
$all = $pdf->openObject();
$pdf->saveState();
$pdf->setStrokeColor(0, 0, 0, 1);
$pdf->setColor(0, 0, 0);
$pdf->addText(100, 824, 15, $text['stats'][20]);
$pdf->addText(390, 824, 10, date('d.m.Y - G:i:s') . $text['stats'][31]);
$pdata = array(200, 10, 400, 20, 300, 50, 150, 40);
$pdf->line(60, 820, 535, 820);
$pdf->addText(100, 800, 15, $text['stats'][7]);
$pdf->addText(100, 780, 15, $a . ' ' . $text['stats'][6] . ' ' . $b);
$pdf->line(60, 25, 535, 25);
$pdf->addText(80, 14, 6, TEAM_VERGLEICH);
$pdf->addText(450, 14, 6, VERSlON);
$pdf->restoreState();
$pdf->closeObject();
$pdf->addObject($all, 'all');
$spTagOptions = array('cols' => $cols, 'titleFontSize' => 10, 'showHeadings' => 0, 'showLines' => 0, 'fontSize' => 8, 'shaded' => 0, 'protectRows' => $protectRows);
$spTagOptionsTable = array('cols' => $cols, 'titleFontSize' => 10, 'showHeadings' => 1, 'showLines' => 0, 'fontSize' => 8, 'shaded' => 0, 'protectRows' => $protectRows);

$i = 1;
$output = '';
$fav_liga[] = array();
while (isset($multi_cfgarray['liga' . $i])) {
    $fav_liga[$i] = $multi_cfgarray['liga' . $i];
    $i++;
}
$anzahl_ligen = --$i;

for ($i = 1; $i <= 1; $i++) {
    $akt_liga = new liga();
    if ($akt_liga->loadFile(PATH_TO_LMO . '/' . $dirliga . $fav_liga[$i]) == TRUE) {
        $ligaName = $akt_liga->name;
        $spTag = '';
        $table = $akt_liga->calcTable($spTag);
        $keys = array_keys($table[0]);
        $pos = 1;
        foreach ($table as $tableRow) {
            $tabTableRow = array();
            foreach ($keys as $key) {
                $tabTableRow[$key] = $key == 'team' ? $tableRow[$key]->name : $tableRow[$key];
            }
            $tabTableRow['pos'] = $pos++;
            $tabTable[] = $tabTableRow;
            if (($tabTableRow['team'] == $a)) {
                $pdftabTabl = array('Pos' => $tabTableRow['pos'], 'Team' => $tabTableRow['team'], 'Spiele' => $tabTableRow['spiele'], 'S' => $tabTableRow['s'], 'U' => $tabTableRow['u'], 'N' => $tabTableRow['n'], 'Tore' => $tabTableRow['pTor'] . ' : ' . $tabTableRow['mTor'], 'pPkt' => $tabTableRow['pPkt']);
                $tabTabl[] = $pdftabTabl;
            }
            if (($tabTableRow['team'] == $b)) {
                $pdftabTabl = array('Pos' => $tabTableRow['pos'], 'Team' => $tabTableRow['team'], 'Spiele' => $tabTableRow['spiele'], 'S' => $tabTableRow['s'], 'U' => $tabTableRow['u'], 'N' => $tabTableRow['n'], 'Tore' => $tabTableRow['pTor'] . ' : ' . $tabTableRow['mTor'], 'pPkt' => $tabTableRow['pPkt']);
                $tabTabl[] = $pdftabTabl;
            }
        }
        $cols = array('Pos' => $text[577], 'Team' => $text[281], 'Spiele' => $text[63], 'S' => $text['stats'][23], 'U' => $text['stats'][24], 'N' => $text['stats'][25], 'Tore' => $text[38], 'pPkt' => $text['stats'][34]);
        $coloptions = array('Pos' => array('justification' => 'center'), 'Team' => array('justification' => 'left'), 'Spiele' => array('justification' => 'center'), 'S' => array('justification' => 'center'), 'U' => array('justification' => 'center'), 'N' => array('justification' => 'center'), 'Tore' => array('justification' => 'center'), 'pPkt' => array('justification' => 'center'));

        // Zeige den Tabellenstand der Mannschaften $a und $b in der aktuellen Ligadatei
        // Show the standings of teams $a and $b in the current league file
        $pdf->ezTable($tabTabl, $cols, $text['stats'][30].' '.$ligaName, array('cols' =>  $coloptions));

    } else {
        $error = TRUE;
        $message = $text['stats'][15] . ': ' . $file;
        $ligaName = $message;
    }
}

$aspiele = 0;
$asieg = 0;
$aunentschieden = 0;
$aniederlage = 0;
$aspieleh = 0;
$asiegh = 0;
$aunentschiedenh = 0;
$aniederlageh = 0;
$aspielea = 0;
$asiega = 0;
$aunentschiedena = 0;
$aniederlagea = 0;
$aptoreh = '';
$amtoreh = '';
$aptorea = '';
$amtoreh = '';
$amtorea = '';
for ($i = 1; $i <= $anzahl_ligen; $i++) {
    $akt_liga = new liga();
    if ($akt_liga->loadFile(PATH_TO_LMO . '/' . $dirliga . $fav_liga[$i]) == TRUE) {
        $ligaName = $akt_liga->name;
        foreach ($akt_liga->partien as $partie) {
            $pdfSpieltag = array();
            if ((@$partie->heim->name == $a) and (@$partie->gast->name == $b)) {
                $pdfPartie = array($text['stats'][35] => $partie->datumString($leer = '__.__.____'), $text['stats'][31] => $partie->zeitString($leer = '__:__ '), $text['stats'][32] => $partie->heim->name, $text['stats'][33] => $partie->gast->name, $text['stats'][36] => $partie->hToreString() . ' : ' . $partie->gToreString() . ' ' . $partie->spielEndeString($text));
                //
                $pdfSpieltag[] = $pdfPartie;
                if ($partie->hToreString() > $partie->gToreString()) {
                    $asiegh = $asiegh + 1;
                }
                if ($partie->hToreString() == $partie->gToreString()) {
                    if ($partie->hToreString() != $tordummy) {
                        $aunentschiedenh = $aunentschiedenh + 1;
                    }
                }
                if ($partie->hToreString() < $partie->gToreString()) {
                    $aniederlageh = $aniederlageh + 1;
                }
                $aptoreh = intval($aptoreh) + intval($partie->hToreString());
                $amtoreh = intval($amtoreh) + intval($partie->gToreString());
            }
            if ((@$partie->heim->name == $b) and (@$partie->gast->name == $a)) {
                $pdfPartie = array($text['stats'][35] => $partie->datumString($leer = '__.__.____'), $text['stats'][31] => $partie->zeitString($leer = '__:__ '), $text['stats'][32] => $partie->heim->name, $text['stats'][33] => $partie->gast->name, $text['stats'][36] => $partie->hToreString() . ' : ' . $partie->gToreString() . ' ' . $partie->spielEndeString($text));
                $pdfSpieltag[] = $pdfPartie;
                if ($partie->hToreString() > $partie->gToreString()) {
                    $aniederlagea = $aniederlagea + 1;
                }
                if ($partie->hToreString() == $partie->gToreString()) {
                    if ($partie->hToreString() != $tordummy) {
                        $aunentschiedena = $aunentschiedena + 1;
                    }
                }
                if ($partie->hToreString() < $partie->gToreString()) {
                    $asiega = $asiega + 1;
                }
                $aptorea = intval($aptorea) + intval($partie->gToreString());
                $amtorea = intval($amtorea) + intval($partie->hToreString());
            }
            // funktioniert momentan noch nicht
            // not working at the moment
            //$pdf->ezTable($pdfSpieltag, '', '', $spTagOptions);
        }
    } else {
        $error = TRUE;
        $message = $text['stats'][15] . ': ' . $file;
        $ligaName = $message;
    }
}

if (!$error) {
    $asieg = $asiega + $asiegh;
    $aunentschieden = $aunentschiedena + $aunentschiedenh;
    $aniederlage = $aniederlagea + $aniederlageh;
    $aptore = $aptorea + $aptoreh;
    $amtore = $amtorea + $amtoreh;
    $aspiele = $asieg + $aunentschieden + $aniederlage;
    $aspieleh = $asiegh + $aunentschiedenh + $aniederlageh;
    $aspielea = $asiega + $aunentschiedena + $aniederlagea;
    $teamstata = array($text[281] => $a, $text['stats'][22] => $aspiele, $text['stats'][23] => $asieg, $text['stats'][24] => $aunentschieden, $text['stats'][25] => $aniederlage, $text['stats'][26] => $aptore . ' : ' . $amtore);
    $teamstat[] = $teamstata;
    $teamstata = array($text[281] => $text['stats'][27], $text['stats'][22] => $aspieleh, $text['stats'][23] => $asiegh, $text['stats'][24] => $aunentschiedenh, $text['stats'][25] => $aniederlageh, $text['stats'][26] => $aptoreh . ' : ' . $amtoreh);
    $teamstat[] = $teamstata;
    $teamstata = array($text[281] => $text['stats'][28], $text['stats'][22] => $aspielea, $text['stats'][23] => $asiega, $text['stats'][24] => $aunentschiedena, $text['stats'][25] => $aniederlagea, $text['stats'][26] => $aptorea . ' : ' . $amtorea);
    $teamstat[] = $teamstata;

    $teamstatb = array($text[281] => $b, $text['stats'][22] => $aspiele, $text['stats'][23] => $aniederlage, $text['stats'][24] => $aunentschieden, $text['stats'][25] => $asieg, $text['stats'][26] => $amtore . ' : ' . $aptore);
    $teamstat[] = $teamstatb;
    $teamstatb = array($text[281] => $text['stats'][27], $text['stats'][22] => $aspielea, $text['stats'][23] => $asiega, $text['stats'][24] => $aunentschiedena, $text['stats'][25] => $aniederlagea, $text['stats'][26] => $amtorea . ' : ' . $aptorea);
    $teamstat[] = $teamstatb;
    $teamstatb = array($text[281] => $text['stats'][28], $text['stats'][22] => $aspieleh, $text['stats'][23] => $asiegh, $text['stats'][24] => $aunentschiedenh, $text['stats'][25] => $aniederlageh, $text['stats'][26] => $amtoreh . ' : ' . $aptoreh);
    $teamstat[] = $teamstatb;

    $statsoption = array($text[281] => array('justification' => 'right'), $text['stats'][22] => array('justification' => 'center'), $text['stats'][23] => array('justification' => 'center'), $text['stats'][24] => array('justification' => 'center'), $text['stats'][25] => array('justification' => 'center'), $text['stats'][26] => array('justification' => 'center'));
    $pdf->ezText(' ', 10);
    $pdf->ezTable($teamstat, '', $text['stats'][8], array('cols' =>  $statsoption));

    for ($i = 1; $i <= 1; $i++) {
        $akt_liga = new liga();
        if ($akt_liga->loadFile(PATH_TO_LMO . '/' . $dirliga . $fav_liga[$i]) == TRUE) {
            $ligaName = $akt_liga->name;
            $Spielm = $multi_cfgarray['spieltageminus'];
            $Spielp = $multi_cfgarray['spieltageplus'];
            $sptest = $akt_liga->aktuellerSpieltag();
            $aktueller_spieltag = $sptest->nr;
            $start = $aktueller_spieltag - $Spielm;
            $ende = $aktueller_spieltag + $Spielp - 1;
            if ($ende > $akt_liga->spieltageCount()) {
                $ende = $akt_liga->spieltageCount();
            }
            if ($start < 1)
                $start = 1;
            for ($spieltag = $start; $spieltag <= $ende; $spieltag++) {
                $akt_spieltag = $akt_liga->spieltagForNumber($spieltag);
                foreach ($akt_spieltag->partien as $yPartie) {
                    if (($yPartie->heim->name == $a) or ($yPartie->gast->name == $a)) {
                        if ($yPartie->heim->name == $a) {
                            $spielstata = array($text['stats'][35] => $yPartie->datumString($leer = '__.__.____'), $text[281] => $yPartie->gast->name, '' => $text[73], $text['stats'][36] => ($yPartie->hToreString() . ' : ' . $yPartie->gToreString() . ' ' . $yPartie->spielEndeString($text)));
                            $spielstat[] = $spielstata;
                        }
                        if ($yPartie->gast->name == $a) {
                            $spielstata = array($text['stats'][35] => $yPartie->datumString($leer = '__.__.____'), $text[281] => $yPartie->heim->name, '' => $text[74], $text['stats'][36] => ($yPartie->hToreString() . ' : ' . $yPartie->gToreString() . ' ' . $yPartie->spielEndeString($text)));
                            $spielstat[] = $spielstata;
                        }
                    }
                    if (($yPartie->heim->name == $b) or ($yPartie->gast->name == $b)) {
                        if ($yPartie->heim->name == $b) {
                            $spielstatb = array($text['stats'][35] => $yPartie->datumString($leer = '__.__.____'), $text[281] => $yPartie->gast->name, '' => $text[73], $text['stats'][36] => ($yPartie->hToreString() . ' : ' . $yPartie->gToreString() . ' ' . $yPartie->spielEndeString($text)));
                            $spielstats[] = $spielstatb;
                        }
                        if ($yPartie->gast->name == $b) {
                            $spielstatb = array($text['stats'][35] => $yPartie->datumString($leer = '__.__.____'), $text[281] => $yPartie->heim->name, '' => $text[74], $text['stats'][36] => ($yPartie->hToreString() . ' : ' . $yPartie->gToreString() . ' ' . $yPartie->spielEndeString($text)));
                            $spielstats[] = $spielstatb;
                        }
                    }
                }
            }
            $pdf->ezText('', 15);  //Distance to the next block by empty text line
            $pdf->ezTable($spielstat, '', $text['stats'][29].' '.$a, '');  //zeige Spiele von Mannschaft $a - show games from team $a
            $pdf->ezText('', 15);  //Distance to the next block by empty text line
            $pdf->ezTable($spielstats, '', $text['stats'][29].' '.$b, '');  //zeige Spiele von Mannschaft $b - show games from team $b
        } else {
            $error = TRUE;
            $message = $text['stats'][15] . ': ' . $file;
            $ligaName = $message;
        }
    }
    $pdf->ezStream(['Content-Disposition' => str_replace(' ', '_', $text['stats'][29]) . '_' . str_replace(' ', '_', $a) . '_' . str_replace(' ', '_', $text['stats'][17]) . '_' . str_replace(' ', '_', $b) . '.pdf']);
} else {
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
          "http://www.w3.org/TR/html4/loose.dtd">
<html lang="de">
<head>
<title><?php echo 'Pdf Addon (' . $ligaName . ')';?></title>
</head>
<body>
<?php echo $message;?>
</body>
</html>
<?php
}
