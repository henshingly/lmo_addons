************************************************************
Vereinsplan-Addon 1.3.0 für LMO 4
************************************************************
Das Addon vereinsplan kann aus allen Ligen ein
Gesamtspielplan des Vereins und eine Ergebnisliste nur
des aktuellen Spieletages erstellen.

Dabei sind die Ligen und die entsprechenden Mannschaften
frei wählbar.
Die Ausgabedateien können dann über einen Link in die
Homepage integriert werden.

Das Ausgabeformat des Gesamtspielplanes kann wahlweise als
dynamische (Slider-Funktion je Monat) oder statische Ansicht
erfolgen.
Die Pläne könne auch als PDF-Dokument erstellt werden.

Die Verwaltung des Vereinsplan-Addons wird über die
LMO-Admin-Oberfläche bereitgestellt und unterstützt eine
Vielzahl von LMO-Variablen zur Formatsteuerung und Template-
Ausgabe.

++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
Hinweis:
Vor Anpassungen an Standard-LMO-Dateien unbedingt
vorher Sicherungs-Kopien erstellen.
Dies gilt auch für alle selbst angepassten Vereinsplan-Dateien
von Vorgängerversionen , z.B. cfg-Konfigurations-, Template-
und/oder CSS-Stylesheets-Dateien.
++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

************************************************************
1.0 Vereinsplan-Addon in LMO installieren
************************************************************
Alle notwendigen Dateien vom Addon-vereinsplan befinden sich
der Zip-Datei.

 1.1 Die Zip-Datei muss entpackt werden.
 1.2 Alle Verzeichnisse bzw. Dateien müssen in das LMO-Verzeichnis
     der Homepage kopiert bzw. übertragen werden.
     Bei der Erstinstallation werden keine Dateien überschrieben.
     ACHTUNG!
     Nicht kompatibel:
     Bis Version 1.0.0 : Templates, CSS, z.T. Programmdateien
     Bis Version 1.2.0 : Templates
 1.3 Es werden Schreibrechte u.a. in lmo/config/vereinsplan benötigt.
 1.4 Addon in LMO-Oberfläche einbinden
 1.5 Addon aufrufen, konfigurieren und Plan erstellen

**************************************************
2.0 Einbinden in LMO-Admin-Oberfläche
**************************************************
KEINE Änderungen zur Version 1.1.2
bei der Einbindung in die Oberfläche
**************************************************
 2.1 Datei lmo-adminmain.php anpassen
 *************************************************
  2.1.1 Addon-Menu-Eintrag
  ************************************************
  folgende Zeilen suchen:

  /*Viewer-Addon*/
  echo "&nbsp;";
  if (($todo!="vieweroptions")){
    echo "<a href='{$adda}vieweroptions' onclick='return chklmolink();' title='{$text['viewer'][21]}'>{$text['viewer'][20]}</a>";
  } else {
    echo $text['viewer'][20];
  }
  /*Viewer-Addon*/

  und an den Anfang (!) der nächsten Zeile folgenden Addon-Text kopieren

  /*Vereinsplan-Addon*/
  include(PATH_TO_ADDONDIR."/vereinsplan/lmo-adminmain.inc.php");
  /*Vereinsplan-Addon*/


  *****************************
  2.1.2 Addon-Aufruf definieren
  *****************************
  folgende Zeilen suchen:

    /*Viewer-Addon*/
    $viewer_addr_optionen = $_SERVER['PHP_SELF']."?action=admin&amp;todo=vieweroptions";
    /*Viewer-Addon*/

    und an den Anfang (!) der nächsten Zeile folgenden Addon-Text kopieren

    /*Vereinsplan-Addon*/
    $vereinsplan_addr_optionen = $_SERVER['PHP_SELF']."?action=admin&amp;todo=vereinsplanoptions";
    /*Vereinsplan-Addon*/


  ****************************
  2.1.3 Addon-Befehl einbinden
  ****************************
  folgende Zeilen suchen:

    /*Viewer-Addon*/
    elseif($todo=="vieweroptions"){
      require(PATH_TO_ADDONDIR."/viewer/lmo-adminvieweroptions.php");
    }
    /*Viewer-Addon*/

    und an den Anfang (!) der nächsten Zeile folgenden Addon-Text kopieren

    /*Vereinsplan-Addon*/
    elseif($todo=="vereinsplanoptions"){
      require(PATH_TO_ADDONDIR."/vereinsplan/lmo-adminvereinsplanoptions.php");
    }
    /*Vereinsplan-Addon*/



********************************************************************
 Hinweis:
 die folgenden Anpassungen sind nur notwendig, falls beim Speichern
 einer Liga automatisch ein Vereinsplan erstellt werden soll.
********************************************************************

 ************************************
 2.2 Datei lmo-adminedit.php anpassen
 ************************************
  2.2.1 Addon-Wertübergabe einbinden
  ***********************************
  folgende Zeilen suchen:

      <form name="lmoedit" action="<?=$_SERVER['PHP_SELF']; ?>" method="post" onSubmit="return chklmopass()">
        <input type="hidden" name="action" value="admin">
        <input type="hidden" name="todo" value="edit">
        <input type="hidden" name="save" value="1">
        <input type="hidden" name="file" value="<?=$file; ?>">
        <input type="hidden" name="st" value="<?=$st; ?>">


  und an den Anfang (!) der nächsten Zeile folgenden Addon-Text kopieren

        <!-- Vereinsplan-Addon -->
        <?php include(PATH_TO_ADDONDIR."/vereinsplan/lmo-adminedit.inc.php");?>
        <!-- Vereinsplan-Addon -->


  **********************************
  2.2.2 Addon-Wertübergabe einbinden
  **********************************
  folgende Zeilen am Ende der Datei suchen:

          <tr>
            <td colspan="<?=$breite; ?>" align="center">
              <acronym title="<?=$text[210] ?>">Tickertext: </acronym><textarea class="lmo-formular-input" name="xnlines" cols="50" rows="4" onChange="dolmoedit()"><? if(count($nlines)>0){foreach($nlines as $y){echo $y."\n";}} ?></textarea>
            </td>
          </tr>


  und an den Anfang (!) der nächsten Zeile folgenden Addon-Text kopieren

          <!-- Addon vereinsplan -->
          <?php include(PATH_TO_ADDONDIR."/vereinsplan/lmo-adminedit1.inc.php");?>
          <!-- Addon vereinsplan -->


 *************************************
 2.3 Datei lmo-savefile.php anpassen
 *************************************
  2.2.2 Addon-Planerstellung einbinden
  ************************************
  folgende Zeilen am Ende der Datei suchen:

        flock($datei,LOCK_UN);
        if (file_exists(PATH_TO_LMO.'/'.$diroutput.'/viewer_'.substr($file,0,-4).'_count.txt')) {
          unlink(PATH_TO_LMO.'/'.$diroutput.'/viewer_'.substr($file,0,-4).'_count.txt');
        }
        fclose($datei);


  und an den Anfang (!) der nächsten Zeile folgenden Addon-Text kopieren

        /* addon vereinsplan */
        include(PATH_TO_ADDONDIR."/vereinsplan/lmo-savefile.inc.php");
        /* addon vereinsplan */