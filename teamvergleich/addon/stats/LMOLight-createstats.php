<?php
/** LMOLight 5.0
  *
  * http://lmo.sourceforge.net/
  *
  * Dieses Programm ist freie Software. Sie können es unter den Bedingungen
  * der GNU General Public License, wie von der Free Software Foundation
  * veröffentlicht, weitergeben und/oder modifizieren, entweder gemäß Version 2
  * der Lizenz oder (nach Ihrer Option) jeder späteren Version.
  *
  * Die Veröffentlichung dieses Programms erfolgt in der Hoffnung,
  * daß es Ihnen von Nutzen sein wird, aber OHNE IRGENDEINE GARANTIE,
  * sogar ohne die implizite Garantie der MARKTREIFE oder der
  * VERWENDBARKEIT FÜR EINEN BESTIMMTEN ZWECK. Details finden Sie in
  * der GNU General Public License.
  *
  * Sie sollten ein Exemplar der GNU General Public License zusammen mit
  * diesem Programm erhalten haben. Falls nicht, schreiben Sie an die
  * Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA.
  *
  * @author Torsten Hofmann, Dirk Babig
  * @package LMOLight
  * @access public
  * @version 5
  *
  */


require_once(dirname(__FILE__).'/../../init.php');
isset($_POST['createstats']) ? $createstats=true : $createstats=false;
require(_LMOLIGHT_CLASSAPI_DIR.'/external/pear.net/PHP/autoloader/Autoloader.php');
$autoloader = new Autoloader(_LMOLIGHT_CLASSAPI_DIR.'/classes/');
$autoloader->register();

$t=new LMOLIGHT_Language;
$t->load('addon-stats');

if($createstats == false) { ?>
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
  <table>
    <tr><td colspan="2"><h1><?php echo $t->line('addon-stats_200');?></h1></td></tr>
    <tr><td colspan="2"><h3><?php echo $t->line('addon-stats_201');?></h3></td></tr>
    <tr><td><?php echo $t->line('addon-stats_202');?>:</td><td><input type="text" name="liganame"></td></tr>
    <tr><td><?php echo $t->line('addon-stats_203');?>:</td><td><input type="text" name="archiv" value="archiv"></td></tr>
    <tr><td><?php echo $t->line('addon-stats_204');?>:</td><td><input type="radio" name="sortdirection" value="asc"> <?php echo $t->line('addon-stats_205');?> <input type="radio" name="sortdirection" value="desc" checked> <?php echo $t->line('addon-stats_206');?></td></tr>
    <tr><td coslpan="2">&nbsp;</td><tr>
    <tr><td coslpan="2"><h3><?php echo $t->line('addon-stats_207');?>:</h3></td></tr>
    <tr><td><?php echo $t->line('addon-stats_208');?>:</td><td><input type="radio" name="modus" value="1" checked> <?php echo $t->line('addon-stats_209');?> <input type="radio" name="modus" value="2"> <?php echo $t->line('addon-stats_210');?></td></tr>
    <tr><td><?php echo $t->line('addon-stats_211');?>:</td><td><input type="text" name="template" value="standard"></td></tr>
    <tr><td><?php echo $t->line('addon-stats_212');?>:</td><td><input type="text" name="tordummy" value="_"></td></tr>
    <tr><td><?php echo $t->line('addon-stats_213');?>:</td><td><input type="text" name="www"></td></tr>
    <tr><td><?php echo $t->line('addon-stats_214');?>:</td><td><input type="text" name="bild"></td></tr>
    <tr><td><?php echo $t->line('addon-stats_215');?>:</td><td><input type="text" name="spieltageminus"></td></tr>
    <tr><td><?php echo $t->line('addon-stats_216');?>:</td><td><input type="text" name="spieltageplus"></td></tr>
    <tr><td><?php echo $t->line('addon-stats_217');?>:</td><td><input type="radio" name="pdf_verlinken" value="1" checked> <?php echo $t->line('addon-stats_223');?> <input type="radio" name="pdf_verlinken" value="0"> <?php echo $t->line('addon-stats_224');?></td></tr>
    <tr><td><?php echo $t->line('addon-stats_218');?>:</td><td><input type="radio" name="notizen_verlinken" value="1" checked> <?php echo $t->line('addon-stats_223');?> <input type="radio" name="notizen_verlinken" value="0"> <?php echo $t->line('addon-stats_224');?></td></tr>
    <tr><td><?php echo $t->line('addon-stats_219');?>:</td><td><input type="radio" name="spielberichte_verlinken" value="1" checked> <?php echo $t->line('addon-stats_223');?> <input type="radio" name="spielberichte_verlinken" value="0"> <?php echo $t->line('addon-stats_224');?></td></tr>
    <tr><td><?php echo $t->line('addon-stats_220');?>:</td><td><input type="text" name="pdfsymbol" value="pdf.gif"></td></tr>
    <tr><td><?php echo $t->line('addon-stats_221');?>:</td><td><input type="text" name="notizsymbol" value="notiz.gif"></td></tr>
    <tr><td><?php echo $t->line('addon-stats_222');?>:</td><td><input type="text" name="spielberichtesymbol" value="spielbericht.gif"></td></tr>
  </table>

  <input type="hidden" name="createstats" value="1">
  <input type="submit" value="<?php echo $t->line('addon-stats_227');?>">
</form>
<?php
}
if($createstats == true) {
  $archiv = htmlspecialchars($_POST['archiv']);
  $liganame = htmlspecialchars($_POST['liganame']);
  $i = 1;

  include 'Config/Lite.php';
  $config = new Config_Lite();
  $config->read(_LMOLIGHT_CONFIG_DIR.'/stats/'.$liganame.'.stats');
  //$config->setFilename(_LMOLIGHT_CONFIG_DIR.'/stats/'.$liganame.'.stats');
  //$config->setSection('config');
  $config->set('config','modus', htmlspecialchars($_POST['modus']));
  $config->set('config','template', htmlspecialchars($_POST['template']));
  $config->set('config','tordummy', htmlspecialchars($_POST['tordummy']));
  $config->set('config','www', htmlspecialchars($_POST['www']));
  $config->set('config','bild', htmlspecialchars($_POST['bild']));
  $config->set('config','spieltageminus', htmlspecialchars($_POST['spieltageminus']));
  $config->set('config','spieltageplus', htmlspecialchars($_POST['spieltageplus']));
  $config->set('config','pdf_verlinken', htmlspecialchars($_POST['pdf_verlinken']));
  $config->set('config','notizen_verlinken', htmlspecialchars($_POST['notizen_verlinken']));
  $config->set('config','spielberichte_verlinken', htmlspecialchars($_POST['spielberichte_verlinken']));
  $config->set('config','pdfsymbol', htmlspecialchars($_POST['pdfsymbol']));
  $config->set('config','notizsymbol', htmlspecialchars($_POST['notizsymbol']));
  $config->set('config','spielberichtesymbol', htmlspecialchars($_POST['spielberichtesymbol']));
  //$config->setSection('Stats Ligen');
  $config->set('Stats Ligen','liga'.$i, $liganame.'.l98');
  $config->save();

  $ligendir = scan(PATH_TO_LMO.'/'.$dirliga.$archiv);

  if($_POST['sortdirection'] == 'asc') {
    sort($ligendir);
  }
  else {
    rsort($ligendir);
  }

  foreach($ligendir as $ligadir) {
    $pathinfo = pathinfo(substr($ligadir,strrpos($ligadir,'/') + 1, strlen($ligadir)));
    if(isset($pathinfo["extension"])) {
      $extension = $pathinfo["extension"];
      if($extension == "l98") {
        $i++;
        //fputs($stats,"liga".$i."=".$archiv.$ligadir."\r\n");
        $config->set('Stats Ligen', 'liga'.$i, $archiv.$ligadir);
      }
    }
  }
  $createstats = false;
  echo $t->line('addon-stats_225')." <a href=".$_SERVER['PHP_SELF'].">".$t->line('addon-stats_226')."</a>";
}

function scan($folder) {
  /* eigene Funktion, get_dir() aus lmo-functions.php ruft sich nicht selbst auf */
  global $out, $archiv;

  if($content = opendir($folder)) {
    while(false !== ($file = readdir($content))) {
      if(is_dir("$folder/$file") && $file != "." && $file != "..") {
        scan("$folder/$file");
      }
      elseif($file != "." && $file != "..") {
        $verz = substr($folder, strrpos($folder,$archiv) + strlen($archiv), strlen($folder));
        $out[] = "$verz/$file";
      }
    }
    closedir($content);
  }
  return $out;
}
?>