<?php

require_once(PATH_TO_LMO."/lmo-admintest.php");

// alle Dateiordner im Ligenarchiv nach LMO_ROOT/config/archiv/ kopieren (keine Dateien)
function copyFolder($source, $dest, $recursive = FALSE) {
    if (!is_dir($dest)) {
        mkdir($dest, 0777);
    }
    $handle = @opendir($source);
    if(!$handle) return FALSE;
    while ($file = @readdir ($handle)) {
        if (preg_match("#^\.{1,2}$#", $file)) {
            continue;
        }
        if(!$recursive && $source != $source . $file . "/") {
            if(is_dir($source . $file))
                continue;
        }
        if(is_dir($source.$file)) {
            copyFolder($source . $file . "/", $dest . $file . "/", $recursive);
        }
    }
    @closedir($handle);
}
$source = PATH_TO_LMO . '/' . $dirliga;
$dest = PATH_TO_CONFIGDIR . '/stats/';
copyFolder($source, $dest, TRUE);

// Ligenarchiv
$dir = dir(PATH_TO_LMO . '/' . $dirliga . '/archiv');
showFolders(PATH_TO_LMO . '/' . $dirliga . '/archiv');

function showFolders($directory) {
    global $archivfolder, $dirliga;
    $dirHandle = dir($directory);
    while (($entry = $dirHandle->read()) != FALSE) {
        if ($entry != "." && $entry != ".."){
            $path = $directory.'/'.$entry;
            if (is_dir($path)){
                $archivfolder .= '<option>' . str_replace(PATH_TO_LMO . '/' . $dirliga . '/', '', $path) . '</option>';
                showFolders($path);
            }
        }
    }

    $dirHandle->close();
}

// Templates für Statistik-Addon lesen
$template_dir = PATH_TO_TEMPLATEDIR . "/stats/";
$scanned = array_diff(scandir($template_dir), array('..', '.'));
$template_options = '';

foreach ($scanned as $scan) {
    $pathinfo = pathinfo($scan);
    if ($pathinfo["extension"] == "php") {
        $template = substr($pathinfo["filename"], 0, stripos($pathinfo["filename"], '.'));
        $template_options .= '<option>' . $template . '</option>';
    }
}

isset($_POST['createstatsarchiv']) ? $createstatsarchiv = TRUE : $createstatsarchiv = FALSE;
if ($createstatsarchiv == TRUE) {
    echo getMessage($text['stats'][224]);
}
include(PATH_TO_ADDONDIR . "/stats/lmo-adminstatsmenu.php");

?>
      <table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0">
        <tr>
          <th align="center"><h1><?php echo $text['stats'][200] ?></h1></th>
        </tr>
        <tr>
          <td align="left">
            <table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
            <form  name="lmoedit" action="<?php echo $_SERVER['PHP_SELF']?>?action=admin&todo=createstatsarchiv" method="post">
              <tr><td align="center" colspan="2"><h1><?php echo $text['stats'][223];?></h1></td></tr>
              <tr><td align="right"><?php echo $text['stats'][203]?>:&nbsp;</td><td><select name="archiv"><?php echo $archivfolder ?></select></td></tr>
              <tr><td align="right"><?php echo $text['stats'][204]?>:&nbsp;</td><td><input type="radio" name="sortdirection" value="asc"> <?php echo $text['stats'][205]?>&nbsp;&nbsp;<input type="radio" name="sortdirection" value="desc" checked> <?php echo $text['stats'][206]?></td></tr>
              <tr><td align="center" colspan="2"><h1><?php echo $text['stats'][207]?></h1></td></tr>
              <tr><td align="right"><?php echo $text['stats'][208]?>:&nbsp;</td><td><input type="radio" name="modus" value="1" checked> <?php echo $text['stats'][209]?>&nbsp;&nbsp;<input type="radio" name="modus" value="2"> <?php echo $text['stats'][210]?></td></tr>
              <tr><td align="right"><?php echo $text['stats'][211]?>:&nbsp;</td><td><select name="template"><?php echo $template_options ?></select></td></tr>
              <tr><td align="right"><?php echo $text['stats'][212]?>:&nbsp;</td><td><input type="text" name="tordummy" value="_"></td></tr>
              <tr><td align="right"><?php echo $text['stats'][213]?>:&nbsp;</td><td><input type="text" name="www" value="<?php echo $_SERVER['HTTP_HOST']; ?>"></td></tr>
              <tr><td align="right"><?php echo $text['stats'][214]?>:&nbsp;</td><td><input type="text" name="bild" value="logo.png"></td></tr>
              <tr><td align="right"><?php echo $text['stats'][215]?>:&nbsp;</td><td><input type="text" name="spieltageminus"></td></tr>
              <tr><td align="right"><?php echo $text['stats'][216]?>:&nbsp;</td><td><input type="text" name="spieltageplus"></td></tr>
              <tr><td align="right"><?php echo $text['stats'][217]?>:&nbsp;</td><td><input type="radio" name="pdf_verlinken" value="1"> <?php echo $text[181]?>&nbsp;&nbsp;<input type="radio" name="pdf_verlinken" value="0" checked> <?php echo $text[182]?></td></tr>
              <tr><td align="right"><?php echo $text['stats'][218]?>:&nbsp;</td><td><input type="radio" name="notizen_verlinken" value="1"> <?php echo $text[181]?>&nbsp;&nbsp;<input type="radio" name="notizen_verlinken" value="0" checked> <?php echo $text[182]?></td></tr>
              <tr><td align="right"><?php echo $text['stats'][219]?>:&nbsp;</td><td><input type="radio" name="spielberichte_verlinken" value="1"> <?php echo $text[181]?>&nbsp;&nbsp;<input type="radio" name="spielberichte_verlinken" value="0" checked> <?php echo $text[182]?></td></tr>
              <tr><td align="right"><?php echo $text['stats'][220]?>:&nbsp;</td><td><input type="text" name="pdf_symbol" value="pdf.svg"></td></tr>
              <tr><td align="right"><?php echo $text['stats'][221]?>:&nbsp;</td><td><input type="text" name="note_symbol" value="note.svg"></td></tr>
              <tr><td align="right"><?php echo $text['stats'][222]?>:&nbsp;</td><td><input type="text" name="gamereport_symbol" value="gamereport.svg"></td></tr>
              <tr><td colspan="2">&nbsp</td></tr>
              <tr><td align="center" colspan="2"><input class="lmo-formular-button" type="submit" name="createstatsarchiv" value="<?php echo $text['stats'][227]?>"></td></tr>
            </form>
            </table>
          </td>
        </tr>
      </table><?php

if ($createstatsarchiv == TRUE) {
    // Ligenarchiv
    $archiv = $_POST['archiv'];
    $dir = PATH_TO_LMO . '/' . $dirliga . '/' . $archiv;
    $scanned = array_diff(scandir($dir), array('..', '.'));
    $verz = array();
    foreach ($scanned as $scan) {
        $pathinfo = pathinfo($scan);
        if (isset($pathinfo['extension']) && $pathinfo['extension'] == 'l98') {
            $verz[] = $pathinfo['filename'];
        }
    }
    $verz2 = $verz;
    if ($_POST['sortdirection'] == 'asc') {
        sort($verz2);
    }
    else {
        rsort($verz2);
    }

    $files = glob($dest . '*');
    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file);
        }
    }

    foreach ($verz as $liganame) {
        $i = 1;
        $stats = fopen(PATH_TO_CONFIGDIR . '/stats/' . $archiv . '/' . $liganame . '.stats', 'wb');
        fputs($stats, "[config]\r\n");
        fputs($stats, "modus=" . htmlspecialchars($_POST['modus']) . "\r\n");
        fputs($stats, "template=" . htmlspecialchars($_POST["template"]) . "\r\n");
        fputs($stats, "tordummy=" . htmlspecialchars($_POST['tordummy']) . "\r\n");
        fputs($stats, "www=" . htmlspecialchars($_POST['www']) . "\r\n");
        fputs($stats, "bild=" . htmlspecialchars($_POST['bild']) . "\r\n");
        fputs($stats, "spieltageminus=" . htmlspecialchars($_POST['spieltageminus']) . "\r\n");
        fputs($stats, "spieltageplus=" . htmlspecialchars($_POST['spieltageplus']) . "\r\n");
        fputs($stats, "pdf_verlinken=" . htmlspecialchars($_POST['pdf_verlinken']) . "\r\n");
        fputs($stats, "notizen_verlinken=" . htmlspecialchars($_POST['notizen_verlinken']) . "\r\n");
        fputs($stats, "spielberichte_verlinken=" . htmlspecialchars($_POST['spielberichte_verlinken']) . "\r\n");
        fputs($stats, "pdf_symbol=" . htmlspecialchars($_POST['pdf_symbol']) . "\r\n");
        fputs($stats, "note_symbol=" . htmlspecialchars($_POST['note_symbol']) . "\r\n");
        fputs($stats, "gamereport_symbol=" . htmlspecialchars($_POST['gamereport_symbol']) . "\r\n");
        fputs($stats, "\r\n");
        fputs($stats, "[Viewer Ligen]\r\n");
        fputs($stats, "liga" . $i . "=" . $archiv . "/" . $liganame . ".l98\r\n");

        foreach ($verz2 as $oldfiles) {
            if (($oldfiles != $liganame)) {
                $i++;
                fputs($stats, "liga" . $i . "=" . $archiv . "/" . $oldfiles . ".l98\r\n");
            }
        }
    }
    $createstatsarchiv = FALSE;
}?>