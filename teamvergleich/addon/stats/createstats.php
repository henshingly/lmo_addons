<?php

require(dirname(__FILE__).'/../../init.php');

isset($_POST['createstats']) ? $createstats=true : $createstats=false; 

if($createstats == false) {
   ?>
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
<table>
<tr><td colspan="2"><h1><?php echo $text['stats'][200];?></h1></td></tr>
<tr><td colspan="2"><h3><?php echo $text['stats'][201]?></h3></td></tr>
<tr><td><?php echo $text['stats'][202]?>:</td><td><input type="text" name="liganame"></td></tr>
<tr><td><?php echo $text['stats'][203]?>:</td><td><input type="text" name="archiv" value="archiv"></td></tr>
<tr><td><?php echo $text['stats'][204]?>:</td><td><input type="radio" name="sortdirection" value="asc"> <?php echo $text['stats'][205]?> <input type="radio" name="sortdirection" value="desc" checked> <?php echo $text['stats'][206]?></td></tr>
<tr><td coslpan="2">&nbsp;</td><tr>
<tr><td coslpan="2"><h3><?php echo $text['stats'][207]?>:</h3></td></tr>
<tr><td><?php echo $text['stats'][208]?>:</td><td><input type="radio" name="modus" value="1" checked> <?php echo $text['stats'][209]?> <input type="radio" name="modus" value="2"> <?php echo $text['stats'][210]?></td></tr>
<tr><td><?php echo $text['stats'][211]?>:</td><td><input type="text" name="template" value="standard"></td></tr>
<tr><td><?php echo $text['stats'][212]?>:</td><td><input type="text" name="tordummy" value="_"></td></tr>
<tr><td><?php echo $text['stats'][213]?>:</td><td><input type="text" name="www"></td></tr>
<tr><td><?php echo $text['stats'][214]?>:</td><td><input type="text" name="bild"></td></tr>
<tr><td><?php echo $text['stats'][215]?>:</td><td><input type="text" name="spieltageminus"></td></tr>
<tr><td><?php echo $text['stats'][216]?>:</td><td><input type="text" name="spieltageplus"></td></tr>
<tr><td><?php echo $text['stats'][217]?>:</td><td><input type="radio" name="pdf_verlinken" value="1" checked> <?php echo $text['stats'][223]?> <input type="radio" name="pdf_verlinken" value="0"> <?php echo $text['stats'][224]?></td></tr>
<tr><td><?php echo $text['stats'][218]?>:</td><td><input type="radio" name="notizen_verlinken" value="1" checked> <?php echo $text['stats'][223]?> <input type="radio" name="notizen_verlinken" value="0"> <?php echo $text['stats'][224]?></td></tr>
<tr><td><?php echo $text['stats'][219]?>:</td><td><input type="radio" name="spielberichte_verlinken" value="1" checked> <?php echo $text['stats'][223]?> <input type="radio" name="spielberichte_verlinken" value="0"> <?php echo $text['stats'][224]?></td></tr>
<tr><td><?php echo $text['stats'][220]?>:</td><td><input type="text" name="pdfsymbol" value="pdf.gif"></td></tr>
<tr><td><?php echo $text['stats'][221]?>:</td><td><input type="text" name="notizsymbol" value="notiz.gif"></td></tr>
<tr><td><?php echo $text['stats'][222]?>:</td><td><input type="text" name="spielberichtesymbol" value="spielbericht.gif"></td></tr>
</table>
<input type="hidden" name="createstats" value="1">
<input type="submit" value="<?php echo $text['stats'][227]?>">
</form>
<?php
}
if($createstats == true) {
   $archiv = htmlspecialchars($_POST['archiv']);
   $liganame = htmlspecialchars($_POST['liganame']);
   $i = 1;
   $stats = fopen(PATH_TO_CONFIGDIR.'/stats/'.$liganame.'.stats',"wb");
   fputs($stats,"[config]\r\n");
   fputs($stats,"modus=".htmlspecialchars($_POST['modus'])."\r\n");
   fputs($stats,"template=".htmlspecialchars($_POST['template'])."\r\n");
   fputs($stats,"tordummy=".htmlspecialchars($_POST['tordummy'])."\r\n");
   fputs($stats,"www=".htmlspecialchars($_POST['www'])."\r\n");
   fputs($stats,"bild=".htmlspecialchars($_POST['bild'])."\r\n");
   fputs($stats,"spieltageminus=".htmlspecialchars($_POST['spieltageminus'])."\r\n");
   fputs($stats,"spieltageplus=".htmlspecialchars($_POST['spieltageplus'])."\r\n");
   fputs($stats,"pdf_verlinken=".htmlspecialchars($_POST['pdf_verlinken'])."\r\n");
   fputs($stats,"notizen_verlinken=".htmlspecialchars($_POST['notizen_verlinken'])."\r\n");
   fputs($stats,"spielberichte_verlinken=".htmlspecialchars($_POST['spielberichte_verlinken'])."\r\n");
   fputs($stats,"pdfsymbol=".htmlspecialchars($_POST['pdfsymbol'])."\r\n");
   fputs($stats,"notizsymbol=".htmlspecialchars($_POST['notizsymbol'])."\r\n");
   fputs($stats,"spielberichtesymbol=".htmlspecialchars($_POST['spielberichtesymbol'])."\r\n");
   fputs($stats,"\r\n");
   fputs($stats,"[Viewer Ligen]\r\n");
   fputs($stats,"liga".$i."=".$liganame.".l98\r\n");

   $ligendir = scan(PATH_TO_LMO.'/'.$dirliga.$archiv);

   if($_POST['sortdirection'] == 'asc') {
      sort($ligendir);
   } else {
      rsort($ligendir);
   }

   foreach($ligendir as $ligadir) {
      $pathinfo = pathinfo(substr($ligadir,strrpos($ligadir,'/')+1,strlen($ligadir)));
      if(isset($pathinfo["extension"])) {
         $extension = $pathinfo["extension"];
         if($extension == "l98") {
            $i++;
            fputs($stats,"liga".$i."=".$archiv.$ligadir."\r\n");
         }
      }
   }
   $createstats = false;
   echo $text['stats'][225]." <a href=".$_SERVER['PHP_SELF'].">".$text['stats'][226]."</a>";
}

function scan($folder) {
   /* eigene Funktion, get_dir() aus lmo-functions.php ruft sich nicht selbst auf */
   global $out,$archiv;

   if($content = opendir($folder)){  
      while(false !== ($file = readdir($content))){  
         if(is_dir("$folder/$file") && $file != "." && $file != ".."){ 
            scan("$folder/$file");  
         } elseif($file != "." && $file != ".."){
	    $verz = substr($folder,strrpos($folder,$archiv)+strlen($archiv),strlen($folder));
            $out[] = "$verz/$file";
         }  
      }  
    closedir($content);  
   }  
   return $out;
}  
 
?>
