<?PHP
require(dirname(__FILE__) . '/../../init.php');
require_once(PATH_TO_LMO . "/lmo-cfgload.php");
require_once(PATH_TO_LMO . "/lmo-langload.php");
$output_gotoTippspiel = "";
$output_gotoLMO = "";
$output_letzteauswertung="";
if (!isset($cfgarray))$cfgarray = array();
if (!isset($endtab))$endtab = 0;
if (!isset($_SESSION['lmotippername'])){
  $_SESSION['lmotippername'] = "";
}
$multi1 = PATH_TO_CONFIGDIR.'/tipp/' . $multi . '.tipp';
if (file_exists($multi1)){
  $multi_cfgarray = parse_ini_file($multi1);
  $multi_cfgarray += $main_cfgarray;
  extract ($multi_cfgarray);
  $stand = date($defdateformat, filemtime(PATH_TO_LMO . '/' . $dirliga . $multi_cfgarray['file']));
} else {
  die($text['viewer'][55] . ": " . $multi1 . " " . $text['viewer'][56]);
}

$template_file = $multi_cfgarray['template'];
$template = new HTML_Template_IT(PATH_TO_TEMPLATEDIR . '/tipp');
$template -> loadTemplatefile($template_file . ".tpl.php");
$array = array("");

if ($endtab == 0) {
  if (isset($anzst)) {
    $endtab = $anzst;
  }
  $tabdat = "";
} else {
  $tabdat = $endtab.". " . $text[2];
}

if ($all == 1){
  $endtab = 0;
  $tabdat = "";
  $anzst = 0;
} else {
  $st = $endtab;
}

if (!isset($wertung)){
  $wertung = "einzel";

}
if (!isset($gewicht)){
  $gewicht = "absolut";
}

if (!isset($stwertmodus)){
  $stwertmodus = "nur";
}

if (!isset($anzseite)){
  $anzseite = $multi_cfgarray['anzahl_tipper'];
}

if (!isset($von)){
  $von = 1;
}

if (!isset($start)){
  $start = 1;
}

if ($wertung == "intern"){
  $start = 1;
  $anzseite = $multi_cfgarray['anzahl_tipper'];
}

if ($anzseite < 1){
  $anzseite = $multi_cfgarray['anzahl_tipper'];
}

if (($endtab > 1) && ($tabdat != "")){
  $endtab--;
  if ($wertung == "einzel" || $wertung == "intern"){
    require("lmo-tippcalcwert.php");
  } else {
    require("lmo-tippcalcwertteam.php");
  }
  if ($wertung == "team"){
    $multi_cfgarray['anzahl_tipper'] = $teamsanzahl;
  }
  $platz1 = array("");
  $platz1 = array_pad($array,$multi_cfgarray['anzahl_tipper'] + 1, "");
  for ($x = 0; $x < $multi_cfgarray['anzahl_tipper']; $x ++){
    $x3 = intval(substr($tab0[$x], 25));
    $platz1[$x3] = $x+1;
  }
  $endtab ++;
}

if ($wertung == "einzel" || $wertung == "intern"){
  require("lmo-tippcalcwert.php");
} else {
  require("lmo-tippcalcwertteam.php");
}

if ($wertung == "team" && isset($teamsanzahl)) {
  $anztipper = $teamsanzahl;
}
$platz0 = array("");
if (!isset($anztipper)) {
  $anztipper = 0;
}
$platz0 = array_pad($array, $multi_cfgarray['anzahl_tipper'] + 1, "");
for ($x = 0; $x < $multi_cfgarray['anzahl_tipper']; $x ++){
  $x3 = intval(substr($tab0[$x], -7));
  $platz0[$x3] = $x + 1;
}
$j = 1;
$spv = -1;
$ppv = -1;
$ende = (int)$start + (int)$anzseite - (int)1;
if ($ende > $anzseite){
  $ende = $anzseite;
}
for ($x = $start; $x <= $ende; $x ++){
  $i = intval(substr($tab0[$x - 1], -7));
  if ($wertung != "intern" || $teamintern == $tipp_tipperimteam[$i]){
    if ($spielegetippt[$i] != $spv || $tipppunktegesamt[$i] != $ppv){
      $template -> setVariable(array("Platz" => $x . "."));
      $lax = $x;
    } elseif ($wertung == "intern" && $lax != $lx)
    $y = 0;
    if (($endtab > 1) && ($tabdat != "")){
      if ($platz0[$i] < $platz1[$i]){
        $y = 1;
      } elseif ($platz0[$i] > $platz1[$i]){
        $y=2;
      }
    }/*
    if ($shownick==1 || ($showemail==0 && $showname==0)){
    }*/
    if ( $tipp_tipperimteam>=0){
      if ( $wertung=="einzel" || $wertung=="intern"){
        if ($tipp_tipperimteam[$i]==""){
          $tipp_tipperimteam[$i]="&nbsp;";
        }
      }
    }
    if ($spielegetippt[$i]!=$spv || $tipppunktegesamt[$i]!=$ppv){
      $lx=$x;
    }
    $spv=$spielegetippt[$i];
    $ppv=$tipppunktegesamt[$i];
    $template->setCurrentBlock("Inhalt");
    $template->setVariable(array("Name"=>$tippernick[$i]));
    $template->setVariable(array("Punkte"=>$tipppunktegesamt[$i]));
  }
  $template->parseCurrentBlock();
}
$output_letzteauswertung.="<acronym title='".$text[406]."'>".$stand."</acronym>";
//$output_letzteauswertung.=$text[406].':&nbsp;'.$stand;
$output_gotoTippspiel.=$text['tipp'][94];
$output_gotoLMO.=$text[176] . " " .$text[80];
$template->setVariable("LetzteAuswertung", $output_letzteauswertung);
$template->setVariable("gotoTippspiel", $output_gotoTippspiel);
$template->setVariable("gotoLMO", $output_gotoLMO);

if ($multi_cfgarray['all']!=1){
  $template->setVariable("Link", URL_TO_LMO.'/lmo.php?action=tipp&amp;&todo=wert&amp;file='.$multi_cfgarray['file']);
  $template->setVariable("Lmo", URL_TO_LMO.'/lmo.php?todo=&file='.$multi_cfgarray['file']);
} else {
  $template->setVariable("Link", URL_TO_LMO.'/lmo.php?action=tipp');
  $template->setVariable("Lmo", URL_TO_LMO.'/lmo.php');
}
//$template->parse();
$template->show();
?>
