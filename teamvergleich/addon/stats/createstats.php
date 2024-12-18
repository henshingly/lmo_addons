<?php

require (__DIR__ . '/../../init.php');
require_once (PATH_TO_ADDONDIR . '/classlib/ini.php');

// Ligenarchiv
$dir = dir(PATH_TO_LMO . '/' . $dirliga . '/archiv');
$verzarch = '';
while (FALSE !== ($entry = $dir->read())) {
    if (is_dir(PATH_TO_LMO . '/' . $dirliga . '/archiv/' . $entry) && substr($entry, 0, 1) != '.')
        $verzarch .= '<option>' . 'archiv/' . $entry . '</option>';
}

// Ligen
$dir = PATH_TO_LMO . '/' . $dirliga;
$scanned = array_diff(scandir($dir), array('..', '.'));
$verz = "";
foreach ($scanned as $scan) {
    $pathinfo = pathinfo($scan);
    if (isset($pathinfo["extension"]) && $pathinfo["extension"] == "l98") {
        $file = $pathinfo["filename"];
        $verz .= "<option>" . $file . "</option>";
    }
}

// Templates für Statistik-Addon lesen
$dir = PATH_TO_TEMPLATEDIR . "/stats/";
$scanned = array_diff(scandir($dir), array('..', '.'));
$template_options = "";

foreach ($scanned as $scan) {
    $pathinfo = pathinfo($scan);
    if ($pathinfo["extension"] == "php") {
        $template = substr($pathinfo["filename"], 0, stripos($pathinfo["filename"], '.'));
        $template_options .= '<option>' . $template . '</option>';
    }
}

isset($_POST['createstats']) ? $createstats = True : $createstats = FALSE;

if ($createstats == FALSE) { ?>
<form action="<?php echo $_SERVER['PHP_SELF']?>?action=admin&todo=stats" method="post">
<table>
  <tr><td align="center" colspan="2"><h1><?php echo $text['stats'][200];?></h1></td></tr>
  <tr><td align="center" colspan="2"><h3><?php echo $text['stats'][201]?></h3></td></tr>
  <tr><td align="right"><?php echo $text['stats'][202]?>:&nbsp;</td><td><select name="liganame"><?php echo $verz ?></select></td></tr>
  <tr><td align="right"><?php echo $text['stats'][203]?>:&nbsp;</td><td><select name="archiv"><?php echo $verzarch ?></select></td></tr>
  <tr><td align="right"><?php echo $text['stats'][204]?>:&nbsp;</td><td><input type="radio" name="sortdirection" value="asc"> <?php echo $text['stats'][205]?>&nbsp;&nbsp;<input type="radio" name="sortdirection" value="desc" checked> <?php echo $text['stats'][206]?></td></tr>
  <tr><td coslpan="2">&nbsp;</td><tr>
  <tr><td align="center" colspan="2"><h3><?php echo $text['stats'][207]?></h3></td></tr>
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
</table>
<input type="hidden" name="createstats" value="1">
<input type="submit" value="<?php echo $text['stats'][227]?>">
</form><br><br>
<?php
}
if ($createstats == True) {
    $archiv = htmlspecialchars($_POST['archiv']);
    $liganame = htmlspecialchars($_POST['liganame']);
    $i = 1;
    $stats = fopen(PATH_TO_CONFIGDIR . '/stats/' . $liganame . '.stats', "wb");
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
    fputs($stats, "liga" . $i . "=" . $liganame . ".l98\r\n");

    $ligendir = scan(PATH_TO_LMO . '/' . $dirliga . $archiv);

    if ($_POST['sortdirection'] == 'asc') {
        sort($ligendir);
    } else {
        rsort($ligendir);
    }

    foreach ($ligendir as $ligadir) {
        $pathinfo = pathinfo(substr($ligadir, strrpos($ligadir, '/') + 1, strlen($ligadir)));
        if (isset($pathinfo["extension"])) {
            $extension = $pathinfo["extension"];
            if ($extension == "l98") {
                $i++;
                fputs($stats, "liga" . $i . "=" . $archiv . $ligadir . "\r\n");
            }
        }
    }
    $createstats = FALSE;
    echo "<br><br>" . $liganame . $text['stats'][225]; ?><br><input type="submit" onclick="location.href='<?php echo $_SERVER['REQUEST_URI']; ?>'" value="<?php echo $text[562]; ?>"><br><br><?php
}

function scan($folder) {
    /* eigene Funktion, get_dir() aus lmo-functions.php ruft sich nicht selbst auf */
    global $out, $archiv;

    if ($content = opendir($folder)){
        while(FALSE !== ($file = readdir($content))){
            if (is_dir("$folder/$file") && $file != "." && $file != ".."){
                scan("$folder/$file");
            } elseif ($file != "." && $file != ".."){
                $verz = substr($folder, strrpos($folder, $archiv) + strlen($archiv), strlen($folder));
                $out[] = "$verz/$file";
            }
        }
        closedir($content);
    }
    return $out;
}
$file = "";
?>
