<?php
function getmicrotime(){
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

// Startwerte Höchste Siege
$highwina = 1;
$highwinagoal = 0;
$highwinb = 1;
$highwinbgoal = 0;
$highawina = 1;
$highawinagoal = 0;
$highawinb = 1;
$highawinbgoal = 0;
// Ende Startwerte Höchste Sieg

$time_start = getmicrotime();
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
$aptoreh = "";
$amtoreh = "";
$aptorea = "";
$amtoreh = "";
$amtorea = "";
$Spielm = $multi_cfgarray['spieltageminus'];
$Spielp = $multi_cfgarray['spieltageplus'];

$tabstat = "";
$tabstat .= "      <table width=\"95%\" align= \"center\">\n";
$tabstat .= "        <tr>\n";
$tabstat .= "          <td class=\"vTitle\" align=\"center\"colspan=10>" . $text['stats'][30] . "</td>\n";
$tabstat .= "        </tr>\n";
$tabstat .= "        <tr width=\"100%\" class=\"vZeilenklasse\">\n";
$tabstat .= "          <td align=\"left\"></td>\n";
$tabstat .= "          <td align=\"left\"><b>" . $text[281] . "</b></td>\n";
$tabstat .= "          <td align=\"center\"><b>" . $text['stats'][22] . "</b></td>\n";
$tabstat .= "          <td align=\"center\"><b>" . $text['stats'][23] . "</b></td>\n";
$tabstat .= "          <td align=\"center\"><b>" . $text['stats'][24] . "</b></td>\n";
$tabstat .= "          <td align=\"center\"><b>" . $text['stats'][25] . "</b></td>\n";
$tabstat .= "          <td align=\"center\"><b>" . $text['stats'][26] . "</b></td>\n";
$tabstat .= "          <td align=\"center\"><b>" . $text['stats'][34] . "</b></td>\n";
$tabstat .= "        </tr>\n";

$spielstat = "";
$spielstat .= "<table width=\"95%\" align= \"center\">\n";
$spielstat .= "        <tr>\n";
$spielstat .= "          <td class=\"vTitle\" align=\"center\"colspan=6>" . $text['stats'][29] . " " . $a . "</td>\n";
$spielstat .= "        </tr>\n";
$spielstat .= "        <tr width=\"100%\" class=\"vZeilenklasse\">\n";
$spielstat .= "          <td align=\"left\"><b>" . $text['stats'][35] . "</b></td>\n";
$spielstat .= "          <td align=\"center\"><b>" . $text[281] . "</b></td>\n";
$spielstat .= "          <td align=\"center\"></td>\n";
$spielstat .= "          <td align=\"center\"><b>" . $text['stats'][26] . "</b></td>\n";
$spielstat .= "        </tr>\n";
$spielbstat="";
$spielbstat .= "<table width=\"95%\" align= \"center\">\n";
$spielbstat .= "        <tr>\n";
$spielbstat .= "          <td class=\"vTitle\" align=\"center\"colspan=6>" . $text['stats'][29] . " " . $b . "</td>\n";
$spielbstat .= "        </tr>\n";
$spielbstat .= "        <tr width=\"100%\" class=\"vZeilenklasse\">\n";
$spielbstat .= "          <td align=\"left\"><b>" . $text['stats'][35] . "</b></td>\n";
$spielbstat .= "          <td align=\"center\"><b>" . $text[281] . "</b></td>\n";
$spielbstat .= "          <td align=\"center\"></td>\n";
$spielbstat .= "          <td align=\"center\"><b>" . $text['stats'][26] . "</b></td>\n";
$spielbstat .= "        </tr>\n";

for ($i = 1; $i <= 1; $i++) {
    $akt_liga = new liga();
    if ($akt_liga->loadFile(PATH_TO_LMO . '/' . $dirliga . $fav_liga[$i]) == FALSE) {
        echo "<font color=\"red\">" . $text['stats'][15] . " ($fav_liga[$i])</font>";
    }
    else {
        $spTag = "";
        $table = $akt_liga->calcTable($spTag); {
            $keys = array_keys($table[0]);
        }
        $pos = 1;
        foreach ($table as $tableRow) {
            $tabTableRow = array();
            foreach ($keys as $key) {
                $tabTableRow[$key] = $key == 'team' ? $tableRow[$key]->name : $tableRow[$key];
            }
            $tabTableRow['pos'] = $pos++;
            $tabTable[]  = $tabTableRow;
            if (($tabTableRow['team'] == $a)) {
                $tabstat .= "        <tr width=\"100%\" class=\"Zeilenklasse\">\n";
                $tabstat .= "          <td align=\"left\">$tabTableRow[pos]</td>\n";
                $tabstat .= "          <td align=\"left\">$tabTableRow[team]</td>\n";
                $tabstat .= "          <td align=\"center\">$tabTableRow[spiele]</td>\n";
                $tabstat .= "          <td align=\"center\">$tabTableRow[s]</td>\n";
                $tabstat .= "          <td align=\"center\">$tabTableRow[u]</td>\n";
                $tabstat .= "          <td align=\"center\">$tabTableRow[n]</td>\n";
                $tabstat .= "          <td align=\"center\">$tabTableRow[pTor]:$tabTableRow[mTor]</td>\n";
                $tabstat .= "          <td align=\"center\">$tabTableRow[pPkt]</td>\n";
                $tabstat .= "        </tr>\n";
            }
            elseif ($tabTableRow['team'] == $b) {
                $tabstat .= "        <tr width=\"100%\" class=\"Zeilenklasse\">\n";
                $tabstat .= "          <td align=\"left\">$tabTableRow[pos]</td>\n";
                $tabstat .= "          <td align=\"left\">$tabTableRow[team]</td>\n";
                $tabstat .= "          <td align=\"center\">$tabTableRow[spiele]</td>\n";
                $tabstat .= "          <td align=\"center\">$tabTableRow[s]</td>\n";
                $tabstat .= "          <td align=\"center\">$tabTableRow[u]</td>\n";
                $tabstat .= "          <td align=\"center\">$tabTableRow[n]</td>\n";
                $tabstat .= "          <td align=\"center\">$tabTableRow[pTor]:$tabTableRow[mTor]</td>\n";
                $tabstat .= "          <td align=\"center\">$tabTableRow[pPkt]</td>\n";
                $tabstat .= "        </tr>\n";
                $sptest = $akt_liga->aktuellerSpieltag();
                $aktueller_spieltag = $sptest->nr;
                $start = $aktueller_spieltag - intval($Spielm);
                $ende = $aktueller_spieltag + intval($Spielp) - 1;
                if ($ende > count($akt_liga->partien)) {
                    $ende = $akt_liga->partien;
                }
                if ($start < 1) $start = 1;
                for ($spieltag = $start; $spieltag <= $ende; $spieltag++) {
                    $akt_spieltag = $akt_liga->spieltagForNumber($spieltag);
                    foreach ($akt_spieltag->partien as $yPartie) {
                        if ((@$yPartie->heim->name == $a ) or (@$yPartie->gast->name == $a )){
                            $Datum = $yPartie->datumString($leer = '__.__.');
                            $Zeit = $yPartie->zeitString($leer = '__:__ ') . ' ' . $text['stats'][31];
                            $Heim = $yPartie->heim->name;
                            $Gast = $yPartie->gast->name;
                            $Tore = ($yPartie->hToreString() . " : " . $yPartie->gToreString());
                            if ($Heim == $a ) {
                                $spielstat .= "        <tr width=\"100%\" class=\"Zeilenklasse\">\n";
                                $spielstat .= "          <td align=\"center\">" . $Datum . " " . $Zeit . "</td>\n";
                                $spielstat .= "          <td align=\"center\">" . $Gast."</td>\n";
                                $spielstat .= "          <td align=\"center\"><strong>" . $text['stats'][27] . "</strong></td>\n";
                                $spielstat .= "          <td align=\"center\">" . $Tore . "</td>\n";
                                $spielstat .= "        </tr>\n";
                            }
                            elseif ($Gast == $a ) {
                                $spielstat .= "        <tr width=\"100%\" class=\"Zeilenklasse\">\n";
                                $spielstat .= "          <td align=\"center\">" . $Datum . " " . $Zeit . "</td>\n";
                                $spielstat .= "          <td align=\"center\">" . $Heim . "</td>\n";
                                $spielstat .= "          <td align=\"center\">" . $text['stats'][28] . "</td>\n";
                                $spielstat .= "          <td align=\"center\">" . $Tore . "</td>\n";
                                $spielstat .= "        </tr>\n";
                            }
                        }
                        if ((@$yPartie->heim->name == $b ) or (@$yPartie->gast->name == $b )){
                            $Datumb = $yPartie->datumString($leer = '__.__.');
                            $Zeitb = $yPartie->zeitString($leer = '__:__ ') . ' ' . $text['stats'][31];
                            $Heimb = $yPartie->heim->name;
                            $Gastb = $yPartie->gast->name;
                            $Toreb = ($yPartie->hToreString()." : " . $yPartie->gToreString());
                            if ($Heimb == $b ) {
                                $spielbstat .= "        <tr width=\"100%\" class=\"Zeilenklasse\">\n";
                                $spielbstat .= "          <td align=\"center\">" . $Datumb . " " . $Zeitb . "</td>\n";
                                $spielbstat .= "          <td align=\"center\">" . $Gastb . "</td>\n";
                                $spielbstat .= "          <td align=\"center\"><strong>" . $text['stats'][27] . "</strong></td>\n";
                                $spielbstat .= "          <td align=\"center\">" . $Toreb . "</td>\n";
                                $spielbstat .= "        </tr>\n";
                            }
                            elseif ($Gastb == $b ) {
                                $spielbstat .= "        <tr width=\"100%\" class=\"Zeilenklasse\">\n";
                                $spielbstat .= "          <td align=\"center\">" . $Datumb . " " . $Zeitb . "</td>\n";
                                $spielbstat .= "          <td align=\"center\">" . $Heimb . "</td>\n";
                                $spielbstat .= "          <td align=\"center\">" . $text['stats'][28] . "</td>\n";
                                $spielbstat .= "          <td align=\"center\">" . $Toreb . "</td>\n";
                                $spielbstat .= "        </tr>\n";
                            }
                        }
                    }
                }
            }
        }
        $spielstat .= "      </table>\n";
        $spielbstat .= "      </table>\n";
        $tabstat .= "      </table>";
    }
}

$template->setVariable("Spiela", $spielstat);
$template->setVariable("Spielb", $spielbstat);
$template->setVariable("Tabelle", $tabstat);

for ($i = 1; $i <= $anzahl_ligen; $i++) {
    $akt_liga = new liga();
    if ($akt_liga->loadFile(PATH_TO_LMO . '/' . $dirliga . $fav_liga[$i]) == FALSE) {
        echo "<font color=\"red\">" . $text['stats'][15] . " ($fav_liga[$i])</font>";
    }
    else {
        $template->setCurrentBlock("Liga");
        $template->setVariable("Teama", $a);
        $template->setVariable("Teamb", $b);
        $template->setVariable('IconHeim', HTML_smallTeamIcon('', $a, "width='24' alt='$a'"));
        $template->setVariable('IconHeimBig', HTML_bigTeamIcon('', $a, "width='48' alt='$a'"));
        $template->setVariable('IconGast', HTML_smallTeamIcon('', $b, "width='24' alt='$b'"));
        $template->setVariable('IconGastBig', HTML_bigTeamIcon('', $b, "width='48' alt='$a'"));
        $template->setCurrentBlock('Inhalt');
        foreach ($akt_liga->partien as $yPartie) {
            if ((@$yPartie->heim->name == $a) and (@$yPartie->gast->name == $b)) {
                //$heim = $yPartie->heim->name;
                $template->setVariable('Datum', $yPartie->datumString($leer = '__.__.____'));
                $template->setVariable('Uhr', $yPartie->zeitString($leer = '__:__ ') . ' ' . $text['stats'][31]);
                $template->setVariable('Liganame', $akt_liga->name);
                $template->setVariable('Heim', $yPartie->heim->name);
                $template->setVariable('HeimMittel', $yPartie->heim->mittel);
                $template->setVariable('HeimKurz', $yPartie->heim->kurz);
                $template->setVariable('Gast', $yPartie->gast->name);
                $template->setVariable('GastMittel', $yPartie->gast->mittel);
                $template->setVariable('GastKurz', $yPartie->gast->kurz);
                $template->setVariable('Tore', $yPartie->hToreString() . ' : ' . $yPartie->gToreString());
                $template->setVariable('SpielEnde', $yPartie->spielEndeString($text));
                $SpBer_link = $yPartie->reportUrl;
                // Höchste Siege Heimmannschaft Hinspiel (Team a)
                $windiffa = (intval($yPartie->hToreString()) - intval($yPartie->gToreString()));
                if ($windiffa > $highwina) {
                    $highwina = $windiffa;
                    $template->setVariable("HeimsiegA", $yPartie->hToreString() . ":" . $yPartie->gToreString());
                    $highwinagoal = $yPartie->hToreString();
                }
                elseif ($windiffa == $highwina) {
                    if ($highwinagoal < $yPartie->hToreString()) {
                        $template->setVariable("HeimsiegA", $yPartie->hToreString() . ":" . $yPartie->gToreString());
                        $highwinagoal = $yPartie->hToreString();
                    }
                }
                // Ende Höchste Siege Heimmannschaft Hinspiel
                // Höchste Siege Gastmannschaft Hinspiel (Team b)
                $winadiffb = (intval($yPartie->gToreString()) - intval($yPartie->hToreString()));
                if ($winadiffb > $highawinb) {
                    $highawinb = $winadiffb;
                    $template->setVariable("GastsiegB", $yPartie->gToreString() . ":" . $yPartie->hToreString());
                    $highawinbgoal = $yPartie->gToreString();
                }
                elseif ($winadiffb == $highawinb) {
                    if ($highawinbgoal < $yPartie->gToreString()) {
                        $template->setVariable("GastsiegB", $yPartie->gToreString() . ":" . $yPartie->hToreString());
                        $highawinbgoal = $yPartie->gToreString();
                    }
                }
                // Ende Höchste Siege Gastmannschaft Hinspiel
                if ($SpBer_link != "") {
                    if ($multi_cfgarray['spielberichte_verlinken'] == '1' ) {
                        $tlink = "<a href=" . $SpBer_link . " target='_blank' title='" . $text['stats'][10] . " (" . $text['stats'][12] . ")'><img src='" . URL_TO_IMGDIR . "/stats/" . $multi_cfgarray['gamereport_symbol'] . "' width='15' border='0' alt=''></a>";
                    }
                    elseif ($multi_cfgarray['spielberichte_verlinken'] == '0' ) {
                        $tlink = "&nbsp;";
                    }
                    $template->setVariable("Spielbericht", $tlink);
                }
                if (chop($yPartie->notiz) != "") {
                    if ($multi_cfgarray['notizen_verlinken'] == '1' ) {
                        $icon = URL_TO_IMGDIR . "/stats/" . $multi_cfgarray['note_symbol'];
                        $ntext = '<a href="#" onclick="alert(\'Notiz: ' . $yPartie->notiz . '\');window.focus();return FALSE;"><span class="popup">';
                        $ntext .= $yPartie->notiz . ' </span><img src="' . $icon . '" width="15" border="0" alt=""></a>';
                    }
                    elseif ($multi_cfgarray['notizen_verlinken'] == '0' ) {
                        $ntext = "&nbsp;";
                    }
                    $template->setVariable("Notiz", $ntext);
                }
                if ($yPartie->hToreString() > $yPartie->gToreString()) {
                    $asiegh = $asiegh + 1;
                }
                if ($yPartie->hToreString() == $yPartie->gToreString()) {
                    if ($yPartie->hToreString() !== $tordummy) {
                        $aunentschiedenh = $aunentschiedenh + 1;
                    }
                }
                if ($yPartie->hToreString() < $yPartie->gToreString()) {
                    $aniederlageh = $aniederlageh + 1;
                }
                $aptoreh = intval($aptoreh) + intval($yPartie->hToreString());
                $amtoreh = intval($amtoreh) + intval($yPartie->gToreString());
            }
            elseif ((@$yPartie->heim->name == $b ) and (@$yPartie->gast->name == $a)) {
                $gteam = $yPartie->heim->name;
                $template->setVariable("Datum", $yPartie->datumString($leer = '__.__.____'));
                $template->setVariable("Uhr", $yPartie->zeitString($leer = '__:__ ') . ' ' . $text['stats'][31]);
                $template->setVariable("Liganame", $akt_liga->name);
                $template->setVariable("Heim", $yPartie->heim->name);
                $template->setVariable('HeimMittel', $yPartie->heim->mittel);
                $template->setVariable('HeimKurz', $yPartie->heim->kurz);
                $template->setVariable("Gast", $yPartie->gast->name);
                $template->setVariable('GastMittel', $yPartie->gast->mittel);
                $template->setVariable('GastKurz', $yPartie->gast->kurz);
                $template->setVariable("Tore", $yPartie->hToreString() . " : " . $yPartie->gToreString());
                $template->setVariable('SpielEnde', $yPartie->spielEndeString($text));
                $SpBer_link=$yPartie->reportUrl;
                // Höchste Siege Gastmannschaft Rückspiel (Team a)
                $winadiffa = (intval($yPartie->gToreString()) - intval($yPartie->hToreString()));
                if ($winadiffa > $highawina) {
                    $highawina = $winadiffa;
                    $template->setVariable("GastsiegA", $yPartie->gToreString() . ":" . $yPartie->hToreString());
                    $highawinagoal = $yPartie->gToreString();
                }
                elseif ($winadiffa == $highawina) {
                    if ($highawinagoal < $yPartie->gToreString()) {
                        $template->setVariable("GastsiegA", $yPartie->gToreString() . ":" . $yPartie->hToreString());
                        $highawinagoal = $yPartie->gToreString();
                    }
                }
                // Ende Höchste Siege Gast Rück
                // Höchste Siege Heimmannschaft Rückspiel (Team b)
                $windiffb = (intval($yPartie->hToreString()) - intval($yPartie->gToreString()));
                if ($windiffb > $highwinb) {
                    $highwinb = $windiffb;
                    $template->setVariable("HeimsiegB", $yPartie->hToreString() . ":" . $yPartie->gToreString());
                    $highwinbgoal = $yPartie->hToreString();
                }
                elseif ($windiffb == $highwinb) {
                    if ($highwinbgoal < $yPartie->hToreString()) {
                        $template->setVariable("HeimsiegB", $yPartie->hToreString() . ":" . $yPartie->gToreString());
                        $highwinbgoal = $yPartie->hToreString();
                    }
                }
                // Ende Höchste Siege Heimrück
                if ($SpBer_link != "") {
                    if ($multi_cfgarray['spielberichte_verlinken'] == '1' ) {
                        $tlink = "<a href=" . $SpBer_link . " target='_blank' title='" . $text['stats'][10] . " (" . $text['stats'][12] . ")'><img src='" . URL_TO_IMGDIR . "/stats/" . $multi_cfgarray['gamereport_symbol'] . "' width='15' border='0' alt=''></a>";
                    }
                    elseif ($multi_cfgarray['spielberichte_verlinken'] == '0' ) {
                        $tlink = "&nbsp;";
                    }
                    $template->setVariable("Spielbericht", $tlink);
                }
                if (chop($yPartie->notiz) != "") {
                    if ($multi_cfgarray['notizen_verlinken'] == '1' ) {
                        $icon = URL_TO_IMGDIR . "/stats/" . $multi_cfgarray['note_symbol'];
                        $ntext = '<a href="#" onclick="alert(\'Notiz: ' . $yPartie->notiz . '\');window.focus();return FALSE;"><span class="popup">';
                        $ntext .= $yPartie->notiz . ' </span><img src="' . $icon . '" width="15" border="0" alt=""></a>';
                    }
                    elseif ($multi_cfgarray['notizen_verlinken']=='0' ) {
                        $ntext = "&nbsp;";
                    }
                    $template->setVariable("Notiz", $ntext);
                }
                if ($yPartie->hToreString() > $yPartie->gToreString()) {
                    $aniederlagea = $aniederlagea + 1;
                }
                if ($yPartie->hToreString() == $yPartie->gToreString()) {
                    if ($yPartie->hToreString() !== $tordummy ) {
                        $aunentschiedena = $aunentschiedena + 1;
                    }
                }
                if ($yPartie->hToreString() < $yPartie->gToreString()) {
                    $asiega = $asiega + 1;
                }
                $aptorea=intval($aptorea) + intval($yPartie->gToreString());
                $amtorea=intval($amtorea) + intval($yPartie->hToreString());
            }
            $template->parseCurrentBlock();
        }
        $hteam = @$yPartie->heim->name;
        $template->parse("Liga");
        $asieg = $asiega + $asiegh;
        $aunentschieden = $aunentschiedena + $aunentschiedenh;
        $aniederlage = $aniederlagea + $aniederlageh;
        $aptore = intval($aptorea) + $aptoreh;
        $amtore = intval($amtorea) + $amtoreh;
        $aspiele = $asieg + $aunentschieden + $aniederlage;
        $aspieleh = $asiegh + $aunentschiedenh + $aniederlageh;
        $aspielea = $asiega + $aunentschiedena + $aniederlagea;
        $teamstat = "\n";
        $teamstat .= "      <table width=\"95%\" align= \"center\">\n";
        $teamstat .= "        <tr>\n";
        $teamstat .= "          <td class=\"vTitle\" align=\"center\"colspan=6>" . $text['stats'][20] . "</td>\n";
        $teamstat .= "        </tr>\n";
        $teamstat .= "        <tr width=\"100%\" class=\"vZeilenklasse\">\n";
        $teamstat .= "          <td align=\"right\"><b>" . $text[281] . "</b></td>\n";
        $teamstat .= "          <td align=\"center\"><b>" . $text['stats'][22] . "</b></td>\n";
        $teamstat .= "          <td align=\"center\"><b>" . $text['stats'][23] . "</b></td>\n";
        $teamstat .= "          <td align=\"center\"><b>" . $text['stats'][24] . "</b></td>\n";
        $teamstat .= "          <td align=\"center\"><b>" . $text['stats'][25] . "</b></td>\n";
        $teamstat .= "          <td align=\"center\"><b>" . $text['stats'][26] . "</b></td>\n";
        $teamstat .= "        </tr>\n";
        $teamstat .= "        <tr width=\"100%\" class=\"Zeilenklasse\">\n";
        $teamstat .= "          <td align=\"right\">" . $a . "</td>\n";
        $teamstat .= "          <td align=\"center\">" . $aspiele . "</td>\n";
        $teamstat .= "          <td align=\"center\">" . $asieg . "</td>\n";
        $teamstat .= "          <td align=\"center\">" . $aunentschieden . "</td>\n";
        $teamstat .= "          <td align=\"center\">" . $aniederlage . "</td>\n";
        $teamstat .= "          <td align=\"center\">" . $aptore . " : " . $amtore . "</td>\n";
        $teamstat .= "        </tr>\n";
        $teamstat .= "        <tr width=\"100%\" class=\"Zeilenklasse\">\n";
        $teamstat .= "          <td align=\"right\">" . $text['stats'][27] . "</td>\n";
        $teamstat .= "          <td align=\"center\">" . $aspieleh . "</td>\n";
        $teamstat .= "          <td align=\"center\">" . $asiegh . "</td>\n";
        $teamstat .= "          <td align=\"center\">" . $aunentschiedenh . "</td>\n";
        $teamstat .= "          <td align=\"center\">" . $aniederlageh . "</td>\n";
        $teamstat .= "          <td align=\"center\">" . $aptoreh . " : " . $amtoreh . "</td>\n";
        $teamstat .= "        </tr>\n";
        $teamstat .= "        <tr width=\"100%\" class=\"Zeilenklasse\">\n";
        $teamstat .= "          <td align=\"right\">" . $text['stats'][28] . "</td>\n";
        $teamstat .= "          <td align=\"center\">" . $aspielea . "</td>\n";
        $teamstat .= "          <td align=\"center\">" . $asiega . "</td>\n";
        $teamstat .= "          <td align=\"center\">" . $aunentschiedena . "</td>\n";
        $teamstat .= "          <td align=\"center\">" . $aniederlagea . "</td>\n";
        $teamstat .= "          <td align=\"center\">" . $aptorea . " : " . $amtorea . "</td>\n";
        $teamstat .= "        </tr>\n";
        $teamstat .= "        <tr width=\"100%\" class=\"Zeilenklasse\">\n";
        $teamstat .= "          <td align=\"right\">" . $b . "</td>\n";
        $teamstat .= "          <td align=\"center\">" . $aspiele . "</td>\n";
        $teamstat .= "          <td align=\"center\">" . $aniederlage . "</td>\n";
        $teamstat .= "          <td align=\"center\">" . $aunentschieden . "</td>\n";
        $teamstat .= "          <td align=\"center\">" . $asieg . "</td>\n";
        $teamstat .= "          <td align=\"center\">" . $amtore . " : " . $aptore . "</td>\n";
        $teamstat .= "        </tr>\n";
        $teamstat .= "        <tr width=\"100%\" class=\"Zeilenklasse\">\n";
        $teamstat .= "          <td align=\"right\">" . $text['stats'][27] . "</td>\n";
        $teamstat .= "          <td align=\"center\">" . $aspielea . "</td>\n";
        $teamstat .= "          <td align=\"center\">" . $aniederlagea . "</td>\n";
        $teamstat .= "          <td align=\"center\">" . $aunentschiedena . "</td>\n";
        $teamstat .= "          <td align=\"center\">" . $asiega . "</td>\n";
        $teamstat .= "          <td align=\"center\">" . $amtorea . " : " . $aptorea . "</td>\n";
        $teamstat .= "        </tr>\n";
        $teamstat .= "        <tr width=\"100%\" class=\"Zeilenklasse\">\n";
        $teamstat .= "          <td align=\"right\">" . $text['stats'][28] . "</td>\n";
        $teamstat .= "          <td align=\"center\">" . $aspieleh . "</td>\n";
        $teamstat .= "          <td align=\"center\">" . $aniederlageh . "</td>\n";
        $teamstat .= "          <td align=\"center\">" . $aunentschiedenh . "</td>\n";
        $teamstat .= "          <td align=\"center\">" . $asiegh . "</td>\n";
        $teamstat .= "          <td align=\"center\">" . $amtoreh . " : " . $aptoreh . "</td>\n";
        $teamstat .= "        </tr>\n";
        $teamstat .= "      </table>";
        $template->setVariable("Statistik", $teamstat);
        if ($multi_cfgarray['pdf_verlinken'] == '1' ) {
            $tlink = "<a href='stats_viewp.php?multi=$c&a=$a&b=$b' target='_blank' title='" . $text['stats'][11] . " (" . $text['stats'][12] . ")'><img src='" . URL_TO_IMGDIR . "/stats/" . $multi_cfgarray['pdf_symbol'] . "' width='25' border='0' alt=''> " . $text['stats'][9] . "</a>";
        }
        elseif ($multi_cfgarray['pdf_verlinken'] == '0' ) {
            $tlink = "&nbsp;";
        }
        $template->setVariable("Pdf", $tlink);
        $template->setVariable("Text", $text['stats'][4]);
        $template->setVariable("Text1", $text['stats'][5]);
        $template->setVariable("Text2", $text['stats'][6]);
        $template->setVariable("VERSION", TEAM_VERGLEICH);
        $template->setVariable("VERSIONa", VERSIONA);
        $template->setVariable("SPRACHE", $text['stats'][60] . " " . $text['stats'][61]);
    }
}
$time_end = getmicrotime();
$time = round($time_end - $time_start, 4);
$template->setVariable("Dauer", $text['stats'][16] . ":" . $time);
?>
