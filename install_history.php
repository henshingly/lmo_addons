<?
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
  * History Table Addon for LigaManager Online
  * Copyright (C) 2005 by Marcus Schug
  * langer77@gmx.de
  *   
  * @author René Marth/LMO Group (install.php)
  * @author <a href="mailto:langer77@gmx.de">Marcus Schug</a>
  * 
  * @version 1.0
  * 
  * This file is a copy of install.php with some changes to create the cfg.txt
  * from the Historytable Addon
  * 
  * History:
  * 1.0: initial Release 
  */

session_start();
if (!isset($_SESSION['ftpserver'])) {
  $_SESSION['ftpserver'] ='';
}
if (!isset($_SESSION['ftpuser'])) {
  $_SESSION['ftpuser'] ='';
}
$_SESSION['userlang']=isset($_GET['userlang'])?$_GET['userlang']:(isset($_SESSION['userlang'])?$_SESSION['userlang']:'DE');
$userlang = $_SESSION['userlang'];

$filelist=array(
  '666'=>array('config/history/cfg.txt')
);
$lang=array(
    'DE'=>array(
      'HEADER'=>'Installation des Liga Manager Online 4 Ewige Tabelle Addons',
      'PROCEED'=>'Weiter',
      'SUCCESS'=>'Erfolg',
      'ERROR'=>'Fehler',
      'CHECK_AGAIN'=>'Neu prüfen',
      'ERROR_WRONG_PATH'=>'Der Pfad ist nicht korrekt!',
      'ERROR_CONFIRM'=>'Es sind noch Fehler vorhanden! Trotzdem fortfahren?',
      
      'STEP0'=>'FTP-Zugangsdaten',
      'STEP0_DESCRIPTION'=>'Um den LMO vollautomatisch zu installieren, ist ein Zugang per FTP notwendig. 
         Dazu müssen Sie die Logindaten für Ihren FTP-Zugang angeben. Die Daten werden vom LMO 
         nicht gespeichert oder in irgendeiner anderen Weise weiterverwendet. Falls Sie 
         manuell installieren möchten gelangen Sie 
         <a href="'.$_SERVER['PHP_SELF'].'?step=2&amp;man=1">hier zur manuellen Installation.</a>',
      'STEP0_FTP_SERVER'=>'Geben sie hier die Adresse ihres FTP-Servers ein',
      'STEP0_FTP_SERVER_EXAMPLE'=>'Bsp.: <em><kbd>ftp.beispiel.de</kbd></em>',
      'STEP0_FTP_LOGIN'=>'Geben Sie hier Ihren Usernamen und Ihr Passwort ein',
      'STEP0_FTP_NO_CONNECTION'=>'Keine Verbindung zu "'.$_SESSION['ftpserver'].'" möglich. Korrigieren Sie die Adresse oder <a href="'.$_SERVER['PHP_SELF'].'?step=2&amp;man=1">installieren Sie manuell</a>',
      'STEP0_FTP_NO_LOGIN'=>'Fehler beim Einloggen. Korrigieren Sie die Benutzerdaten oder <a href="'.$_SERVER['PHP_SELF'].'?step=2&amp;man=1">installieren Sie manuell</a>',
      
      'STEP1'=>'LMO-Verzeichnis auswählen',
      'STEP1_SELECT_FTP_DIR'=>'Wählen Sie das LMO Verzeichnis aus',
      
      'STEP2'=>'Dateirechte setzen',
      'STEP2_MANUAL'=>'Setzen sie die benötigten Rechte über ihr FTP-Programm und aktualisieren Sie diese 
         Seite <a href="#" onclick="location.reload();return false;">[Reload]</a>, um 
         zu überprüfen, ob alle Rechte richtig gesetzt sind. <a href="'.$_SERVER['PHP_SELF'].'">zurück zur automatischen Installation</a>',
      
      'STEP3'=>'Konfigurationsdatei erstellen',
      'STEP3_ERROR_INI_FILE_NOT_OPENABLE'=>'Konnte Datei config/history/cfg.txt nicht öffnen! Bitte setzen Sie die Rechte auf chmod 666 und <a href="#" onclick="location.reload();return false;">aktualisieren Sie diese Seite</a>, um den Vorgang zu wiederholen.',
      'STEP3_ERROR_INI_FILE_NOT_WRITEABLE'=>'Konnte die Konfiguration nicht speichern.Vergewissern Sie sich, dass die Datei <code>init-parameters.php</code> die Rechte 666 besitzt. Bitte setzen Sie die Rechte auf chmod 666 und <a href="#" onclick="location.reload();return false;">aktualisieren Sie diese Seite</a>, um den Vorgang zu wiederholen.',
      'STEP3_INI_FILE'=>'Konfiguratiosndatei',
      'STEP3_SUCCESS_INI_FILE'=>'Die Konfiguration wurde erfolgreich gespeichert!',
      'STEP3_ERROR_INI_FILE'=>'Die Konfiguration konnte nicht gespeichert werden!',    
      
      'STEP4'=>'Installation erfolgreich',
      'STEP4_TEXT1'=>'Das ewige Tabelle Addon ist installiert worden!',
      'STEP4_TEXT2'=>'Falls Fehler aufgetreten sind, wiederholen sie die Installation oder installieren Sie den LMO manuell, indem Sie 
    die Datei <code>config/history/cfg.txt</code> mit einem Texteditor anpassen und die Schreibrechte mit einem FTP-Programm 
    manuell vergeben.',
      'STEP4_TEXT3'=>'Bitte löschen Sie jetzt unbedingt die Datei <code>install_history.php</code> vom Server oder geben Sie der Datei chmod 000.',
      'STEP4_TEXT4'=>'Der <acronym title="Liga Manager Online">LMO</acronym> ist jetzt unter der Adresse <code><a href="lmo.php">lmo.php</a></code> 
    zu erreichen, den Adminbereich finden Sie unter <code><a href="lmoadmin.php">lmoadmin.php</a></code> (Standardlogin ist <kbd>admin</kbd>/<kbd>lmo</kbd>).',
      'STEP4_TEXT5'=>'Eine ausführliche Benutzeranleitung <a href="http://www.liga-manager-online.de/dedi/projekt01/de/homepage/lmo4/hilfe/">für den LMO</a> 
      und <a href="http://www.liga-manager-online.de/dedi/projekt01/de/homepage/lmo4/addons/">seinen Addons</a> finden Sie auf der Homepage des LMO.',
      'STEP4_TEXT6'=>'Viel Spaß!',
    ),

);

/*  Configbereich Ende */

if (!empty($_GET['debug']) || !empty($_SESSION['debug'])) {
  $_SESSION['debug']=true;
  @error_reporting(E_ALL);
  @ini_set("display_errors","On");
}

$step=isset($_REQUEST['step'])?$_REQUEST['step']:0;
if (isset($_POST['check'])) $step=3;
$_SESSION['man']=!empty($_REQUEST['man'])?TRUE:FALSE;

$patherror='';
$urlerror='';
$installerror='';
$loginerror='';
$path=str_replace('\\','/',dirname(__FILE__));
$url='http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']);



if ($step==1) {
  //FTP-Daten testen

  $_SESSION['ftpserver']= isset($_POST['ftpserver'])? trim($_POST['ftpserver']):(!empty($_SESSION['ftpserver'])?$_SESSION['ftpserver']:'');
  $_SESSION['ftpuser'] =   isset($_POST['ftpuser'])?   trim($_POST['ftpuser']):(!empty($_SESSION['ftpuser'])?$_SESSION['ftpuser']:'');
  $_SESSION['ftppass'] =   isset($_POST['ftppass'])?   trim($_POST['ftppass']):(!empty($_SESSION['ftppass'])?$_SESSION['ftppass']:'');

  $conn = ftp_connect($_SESSION['ftpserver']);
  if (!$conn) {
    $urlerror.='<p class="error"><img src="img/wrong.gif" border="0" width="12" height="12" alt="'.$lang[$userlang]['ERROR'].'"> '.$lang[$userlang]['STEP0_FTP_NO_CONNECTION'].'</p>';
    $step=0;
  } else {
    $conn2= ftp_login($conn, $_SESSION['ftpuser'], $_SESSION['ftppass']);
    if (!$conn2) {
      $loginerror.='<p class="error"><img src="img/wrong.gif" border="0" width="12" height="12" alt="'.$lang[$userlang]['ERROR'].'"> '.$lang[$userlang]['STEP0_FTP_NO_LOGIN'].'</p>';
      $step=0;
    }
  }

  if ($conn && $conn2) {
    $_SESSION['ftpdir'] =   isset($_POST['ftpdir'])?   trim(str_replace(".",'',$_POST['ftpdir']))   : '';
    if(empty($_POST['ftpdir'])) {
      //Pfad aussuchen
      $_SESSION['view'] =   isset($_GET['view'])?   trim(str_replace(".",'',$_GET['view']))   : '';
      $filelist = filecollect($conn,$_SESSION['view']);
    } else {
      //Pfad ausgesucht -> Rechte setzen
      $base = ftp_pwd($conn)  ;
      ftp_chdir($conn, "$base/".$ftpdir);
      if (ftp_size($conn, "install_history.php") == -1) {
        //Pathtest
        $patherror.='<p class="error"><img src="img/wrong.gif" border="0" width="12" height="12" alt="'.$lang[$userlang]['ERROR'].'"> "'.$ftpdir.'": '.$lang[$userlang]['ERROR_WRONG_PATH'].'</p>';
        $filelist = array();
        $step=1;
      } else {
        foreach ($filelist as $chmod=>$files) {
          foreach ($files as $file) {
              ftp_site($conn, "CHMOD 0$chmod $base/".$ftpdir."/".$file);
          }
        }
        $step=2;
      }
    }
    ftp_close($conn);
  }
}


if ($step==3) {
  $path=isset($_POST['path'])?$_POST['path']:$path;
  $url= isset($_POST['url'])? $_POST['url']:$url;
  $path=substr($path,-1)=='/'?substr($path, 0, -1):$path;
  $url= substr($url,-1)=='/'? substr($url, 0, -1): $url;

  $filename = $path."/config/history/cfg.txt";
  $somecontent1='lmo_ftpdir='.$_SESSION['ftpdir'].'\n';
  $somecontent2='lmo_ftpuser='.$_SESSION['ftpuser'].' \n';
  $somecontent3='lmo_ftpserver='.$_SESSION['ftpserver'].' \n';
  $somecontent4='lmo_ftppass='.$_SESSION['ftppass'].' \n';
  // Sichergehen, dass die Datei existiert und beschreibbar ist
  if (is_writable($filename)) {
    if (!$handle = fopen($filename, "wb")) {
      $installerror.= '<p class="error"><img src="img/wrong.gif" border="0" width="12" height="12" alt="'.$lang[$userlang]['ERROR'].'"> '.$lang[$userlang]['STEP3_ERROR_INI_FILE_NOT_OPENABLE'].'</p>';
    }
    fwrite($handle,"lmo_ftpdir=".$_SESSION['ftpdir']);
    fwrite($handle,"\n");
    fwrite($handle,"lmo_ftpuser=".$_SESSION['ftpuser']);
    fwrite($handle,"\n");
    fwrite($handle,"lmo_ftpserver=".$_SESSION['ftpserver']);
    fwrite($handle,"\n");
    fwrite($handle,"lmo_ftppass=".$_SESSION['ftppass']);
    fwrite($handle,"\n");
    fwrite($handle,"lmo_autocreate=1");
    fwrite($handle,"\n");    
    $installerror.='<p><em><img src="img/right.gif" border="0" width="12" height="12" alt="'.$lang[$userlang]['SUCCESS'].'"> '.$lang[$userlang]['STEP3_SUCCESS_INI_FILE'].'</em></p>';
    fclose($handle);
  } else {
    $installerror.= '<p class="error"><img src="img/wrong.gif" border="0" width="12" height="12" alt="'.$lang[$userlang]['ERROR'].'"> '.$lang[$userlang]['STEP3_ERROR_INI_FILE_NOT_WRITEABLE'].'</p>';
  }
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="<?=$userlang?>">
  <head>
    <title><?=$lang[$userlang]['HEADER'];?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" >
    <style type="text/css">
      @media all {
        body     {  max-width:60em;margin: 0.5em auto;padding:0 0.9em;font-size:85%;background-color: #ffffff;color: #000000;font-family:Tahoma, Verdana, sans-serif;border:1px solid #999;-moz-border-radius:8px;}
        acronym  {  cursor:help;border-bottom:1px dotted;}
        table    {  margin:auto;}
        em       {  font-style:normal;font-weight:bold;color:#080;}
        img      {  border:0;}
        dd       {  margin: 0.5em 3em;}
        dt       {  padding:0.1em 1em;line-height:135%;font-weight:bold;background-color:#009;color:#fcfcff;}
        dl       {  border:1px solid #aca;background:#e0e7ff;padding:0.4em;-moz-border-radius:8px;}
        strong   {  color:#fa6;}
        h1, h2   {  font-family:"Trebuchet MS", Georgia, sans-serif;}
        h1       {  font-size:135%;text-align:center;}
        h2       {  font-size:115%;}
        p        {  margin:0.3em;}
        .error   {  border:1px solid #d99;background:#ffe7e0;padding:0.4em;-moz-border-radius:8px;}
        .foot    {  text-align:left;margin-top:1em;font-size:85%;}
        .w3cbutton3 {  float:right; margin:0.5em;  border: 1px solid #999;  font-family: helvetica,arial,sans-serif;  font-size: 70%;  font-weight: bold;}
        .w3cbutton3 a {  display: block;  /*width: 100%;*/}
        .w3cbutton3 a:link,
        .w3cbutton3 a:visited,
        .w3cbutton3 a:hover {   background-color: #fc6;  color: #000;  text-decoration: none;}
        .w3cbutton3 span.w3c {  padding: 0 0.4em;  background-color: #fff;  color: #0c479d;}
      }
    </style>
  </head>
  <body>
  <h1><?=$lang[$userlang]['HEADER'];?></h1><?
  
echo $patherror;
if ($step==0) {?>
  <?
   if (!$_SESSION['man']) {
  ?>
  <h2><?=$lang[$userlang]['STEP0']?></h2>
  <table width="90%">
    <tr>
      <td>
         <?=$lang[$userlang]['STEP0_DESCRIPTION']?>
      </td>
    </tr><?
      if (function_exists('ftp_connect')) {?>
    <tr>
      <td align="center">
        <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
          <dl>
            <dt><?=$lang[$userlang]['STEP0_FTP_SERVER']?></dt>
            <dd>
            <?=$urlerror?>
              <input name="ftpserver" type="text" size="50" value="<?=$_SESSION['ftpserver']?>"> <?=$lang[$userlang]['STEP0_FTP_SERVER_EXAMPLE']?>
            </dd>
            <dt><?=$lang[$userlang]['STEP0_FTP_LOGIN']?></dt>
            <dd>
            <?=$loginerror?>
              User:<input name="ftpuser" type="text" size="25" value="<?=$_SESSION['ftpuser']?>"> Pass:<input name="ftppass" type="password" size="25" value="">
              <input type="hidden" name="step" value="1">
            </dd>
            <dt>
              <input type="submit" value="<?=$lang[$userlang]['PROCEED']?>">
            </dt>
          </dl>
        </form>
      </td>
    </tr><?
      } else {?>
    <tr>
      <td align="center">
        <dl>
          <dt><a href="<?=$_SERVER['PHP_SELF']."?step=2&amp;man=1"?>><?=$lang[$userlang]['STEP2']?></a></dt>
        </dl>
      </td>
    </tr>
      <?
      }
      ?>
  </table><?

    } else {
     $step=2;
    }
}    

if ($step == 1) {?>
  <h2><?=$lang[$userlang]['STEP1']?></h2>
  <table width="90%">
    <tr>
      <td>
        <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
          <dl>
            <dt><?=$lang[$userlang]['STEP1_SELECT_FTP_DIR']?></dt>
        <?
  foreach ($filelist as $ftpdir) {
    echo "<dd><input type='radio' value='$ftpdir' name='ftpdir'> <a href='$PHP_SELF?step=1&amp;view=$ftpdir'>$ftpdir</a></dd>";
  }
  if ($_SESSION['view'] != '') {
    echo "<dd>&nbsp; &nbsp;<a href='".$_SERVER['PHP_SELF']."?step=1&amp;view=".dirname($view)."'>..</a></dd>";
  }?>

            <dt>
              <input type="hidden" name="step" value="1">
              <input type="submit" value="<?=$lang[$userlang]['PROCEED']?>">
            </dt>
          </dl>
        </form>
      </td>
    </tr>
  </table>
    
    <?
}

if ($step==2) {
     

     //Manuell?>
  <h2><?=$lang[$userlang]['STEP2']?></h2>
  <table width="90%"><?
   if ($_SESSION['man']) {?>
    <tr>
      <td>
        <?=$lang[$userlang]['STEP2_MANUAL']?>   
      </td>
    </tr><?
   }?>
    <tr>
      <td>
        <form action="<?=$_SERVER['PHP_SELF']?>" method="post" onSubmit="return check();">
          <dl><?
  $error=0;
  foreach ($filelist as $chmod=>$files) {
    echo "<dt>chmod $chmod</dt>";
    foreach ($files as $file) {
      echo "<dd>";
      if (strpos($file,'*')) {
        $handle = opendir (dirname($file));
        while (false !== ($file2 = readdir($handle))) {
          if ($file2 != "." && $file2 != ".." && !is_dir(dirname($file)."/$file2")) {
            if (is_writable(dirname($file)."/$file2")) {
              echo "<img src='img/right.gif' border='0' width='12' height='12' alt='".$lang[$userlang]['SUCCESS']."'> ".dirname($file)."/$file2"." <small>($chmod)</small><dd>";
            } else {
              echo "<img src='img/wrong.gif' border='0' width='12' height='12' alt='".$lang[$userlang]['ERROR']."'> ".dirname($file)."/$file2"." <small>($chmod)</small><dd>";
              $error++;
            }
          }
  
        }
      } else{
        if (is_writable($file)) {
          echo "<img src='img/right.gif' border='0' width='12' height='12' alt='".$lang[$userlang]['SUCCESS']."'> $file <small>($chmod)</small>";
        } else {
          echo "<img src='img/wrong.gif' border='0' width='12' height='12' alt='".$lang[$userlang]['ERROR']."'> $file <small>($chmod)</small>";
          $error++;
        }
      }
  
  
    }
  }?>     
          </dd>
          <dt>
            <input type="hidden" name="step" value="3">  
            <input type="submit" value="<?=$lang[$userlang]['PROCEED']?>">
          </dt>
        </dl>
      </form>
        <script type="text/javascript">
        function check() {
          if (<?=$error?> > 0) {
            return confirm("<?=$lang[$userlang]['ERROR_CONFIRM']?>");
          }
          return true;
        }
        </script>  
    </td>
   </tr>
  </table><?
}
if ($step==3) {?>
  <h2><?=$lang[$userlang]['STEP3']?></h2>
  <table width="90%">
    <tr>
      <td>
        <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
          <dl>
          	<dt><?=$lang[$userlang]['STEP3_INI_FILE']?></dt>
            <dd><?
              if (file_exists($path."/config/history/cfg.txt")) {
                echo "<img src='img/right.gif' border='0' width='12' height='12' alt='".$lang[$userlang]['SUCCESS']."'> ".$lang[$userlang]['STEP3_SUCCESS_INI_FILE'];
              } else {
                echo "<img src='img/wrong.gif' border='0' width='12' height='12' alt='".$lang[$userlang]['ERROR']."'> ".$lang[$userlang]['STEP3_ERROR_INI_FILE'];
                $error=1;
              }?>
            </dd>
            <dt>
              <input type="hidden" name="step" value="4">
              <input type="submit" value="<?=$lang[$userlang]['PROCEED']?>">
            </dt>
          </dl>
          <script type="text/javascript">
            function check() {
              if (<?=$error?> > 0) {
                return confirm("<?=$lang[$userlang]['ERROR_CONFIRM']?>");
              }
              return true;
            }
          </script>  
        </form>
      <td>
    <tr>
  </table><?
}

if ($step==4) {?>
  <h2><?=$lang[$userlang]['STEP4']?></h2>
  <dl>
    <dt><?=$lang[$userlang]['STEP4_TEXT1']?></dt>
    <dd><?=$lang[$userlang]['STEP4_TEXT2']?></dd>
    <dd class="error"><?=$lang[$userlang]['STEP4_TEXT3']?></dd>
    <dd><?=$lang[$userlang]['STEP4_TEXT4']?></dd>
    <dd class="error"><?=$lang[$userlang]['STEP4_TEXT5']?></dd>
    <dt><?=$lang[$userlang]['STEP4_TEXT6']?></dt>
  </dl><?
}?>

  <div class="foot">
  
  <div class="w3cbutton3">
    <a href="http://validator.w3.org/check/referer"><span class="w3c">W3C</span>
    <span class="spec">HTML 4.01</span></a></div>
    <div class="w3cbutton3">
    <a href=" http://jigsaw.w3.org/css-validator/check/referer"><span class="w3c">W3C</span>
    <span class="spec">CSS 2.1</span></a></div>
    <?if ($step==0) {?>
    <div class="w3cbutton3">
    <a href="install.php?userlang=FR"><img src="img/Francais.gif" alt="FR" width="16"></a>
    </div>
    <div class="w3cbutton3">
    <a href="install.php?userlang=EN"><img src="img/English.gif" alt="EN" width="16"></a>
    </div>
    <div class="w3cbutton3">
    <a href="install.php?userlang=DE"><img src="img/Deutsch.gif" alt="DE" width="16"></a>
    </div>
    <?} else {?>
    <div class="w3cbutton3">
    <a href="install_history.php"><span class="w3c">RE</span>
    <span class="spec">START</span></a></div>
    
    <?}?>
     © Marcus Schug/<a href="http://liga-manager-online.de/">LMO Group</a>
  </div>    
  </body>
</html>

<?

function filecollect($cid,$dir='.') {
  static $flist=array();
  
  if ($files = ftp_nlist($cid,"./".$dir)){
    foreach ($files as $file) {
      if (ftp_size($cid, $file) == "-1")
      $flist[] = str_replace('./','',$file);
    }
  }
  return $flist;
}

?>