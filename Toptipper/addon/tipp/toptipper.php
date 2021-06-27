<?PHP
require(dirname(__FILE__).'/../../init.php');
require_once(PATH_TO_LMO."/lmo-cfgload.php");
require_once(PATH_TO_LMO."/lmo-langload.php");
if (!isset($cfgarray))$cfgarray=array();
$multi1=PATH_TO_CONFIGDIR.'/tipp/'.$multi.'.tipp';                    
if (file_exists($multi1)) {                         
  $multi_cfgarray=parse_ini_file($multi1);         
  $multi_cfgarray+=$main_cfgarray;                                     
extract ($multi_cfgarray);                                                                    
}else{                                                                 
  die("Konfigurationsdatei: $multi1 nicht gefunden!");                 
}                  

$template_file=$multi_cfgarray['template'];
 $template = new HTML_Template_IT( PATH_TO_TEMPLATEDIR.'/tipp' );
  $template->loadTemplatefile($template_file.".tpl.php"); 
  $array = array("");
  if(!isset($endtab) || $endtab==0){
    $endtab=$anzst;
    $tabdat="";
    }
  else{
    $tabdat=$endtab.". ".$text[2];
    }
  if($all==1){
    $endtab=0;
    $tabdat="";
    $anzst=0;
    }
  else{
    $st=$endtab;
    }
  if(!isset($wertung)){$wertung="einzel";}
  if(!isset($gewicht)){$gewicht="absolut";}
  if(!isset($stwertmodus)){$stwertmodus="nur";}
  if(!isset($anzseite)){$anzseite=$multi_cfgarray['anzahl_tipper'];}
  if(!isset($von)){$von=1;}
  if(!isset($start)){$start=1;}
  if($wertung=="intern"){$start=1;$anzseite=$multi_cfgarray['anzahl_tipper'];}
  if($anzseite<1){$anzseite=$multi_cfgarray['anzahl_tipper'];}
  if(($endtab>1) && ($tabdat!="")){
    $endtab--;
    if($wertung=="einzel" || $wertung=="intern"){require("lmo-tippcalcwert.php");}else{require("lmo-tippcalcwertteam.php");}
    if($wertung=="team"){$multi_cfgarray['anzahl_tipper']=$teamsanzahl;}
    $platz1 = array("");
    $platz1 = array_pad($array,$multi_cfgarray['anzahl_tipper']+1,"");
    for($x=0;$x<$multi_cfgarray['anzahl_tipper'];$x++){$x3=intval(substr($tab0[$x],25));$platz1[$x3]=$x+1;}
    $endtab++;
  }
  if($wertung=="einzel" || $wertung=="intern"){require("lmo-tippcalcwert.php");}else{require("lmo-tippcalcwertteam.php");}
  if($wertung=="team"){$multi_cfgarray['anzahl_tipper']=$teamsanzahl;}
  $platz0 = array("");
  $platz0 = array_pad($array,$multi_cfgarray['anzahl_tipper']+1,"");
  for($x=0;$x<$multi_cfgarray['anzahl_tipper'];$x++){
    $x3=intval(substr($tab0[$x],25));
    $platz0[$x3]=$x+1;
    }
  if($tipperimteam>=0){
 } 
  $j=1;
  $spv=-1;
  $ppv=-1;
  $ende=$start+$anzseite-1;
  if($ende>$$multi_cfgarray['anzahl_tipper']){$ende=$multi_cfgarray['anzahl_tipper'];}
  for($x=$start;$x<=$ende;$x++){
    $i=intval(substr($tab0[$x-1],-7));
    if($wertung!=intern || $teamintern==$tipperteam[$i]){        
if($spielegetippt[$i]!=$spv || $tipppunktegesamt[$i]!=$ppv){
	$template->setVariable(array("Platz"=>$x."."));
  $lax=$x;
  }
elseif($wertung=="intern" && $lax!=$lx)
  $y=0;
  if(($endtab>1) && ($tabdat!="")){
    if($platz0[$i]<$platz1[$i]){$y=1;}
    elseif($platz0[$i]>$platz1[$i]){$y=2;}
    }
	if($shownick==1 || ($showemail==0 && $showname==0)){
}   
 if( $tipperimteam>=0){
  if( $wertung=="einzel" || $wertung=="intern"){
    if($tipperteam[$i]==""){$tipperteam[$i]="&nbsp;";}
 }  
}
if($spielegetippt[$i]!=$spv || $tipppunktegesamt[$i]!=$ppv){$lx=$x;} 
$spv=$spielegetippt[$i]; 
$ppv=$tipppunktegesamt[$i];
   $template->setCurrentBlock("Inhalt");
    
     $template->setVariable(array("Name"=>$tippernick[$i]));
    $template->setVariable(array("Punkte"=>$tipppunktegesamt[$i]));
    }
    $template->parseCurrentBlock();
  } 
if ($multi_cfgarray['all']!=1) {
      $template->setVariable("Link", BASEDIR.'/lmo.php?action=tipp&amp;&todo=wert&amp;file='.$multi_cfgarray['file']);
                 $template->setVariable("Lmo", BASEDIR.'/lmo.php?todo=&file='.$multi_cfgarray['file']);
              } else {
              	$template->setVariable("Link", URL_TO_LMO.'/?action=tipp');
               $template->setVariable("Lmo", URL_TO_LMO.'/lmo.php'); 
              }
  //$template->parse();
  $template->show();
?>
