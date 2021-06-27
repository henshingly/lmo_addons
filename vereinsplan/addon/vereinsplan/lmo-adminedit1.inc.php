<?php
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
  * $Id: lmo-adminedit1.inc.php,v 1.3.0 2009/08/06 $
  */
/** Vereinsplan 1.3.0
  *
  * Credits:
  * Vereinsplan based on and uses following
  * - LMO-Addon Viewer 4.0 Beta 3
  * - JoomlaWorks "Tabs & Slides" Module for Joomla! 1.5.x - Version 1.0
  *
  */
if($_SESSION['lmouserok']>0 ){
  require_once(PATH_TO_LMO."/ini.fct");

  $MyAddonName     = 'vereinsplan';
  $ThisAddonDir      = PATH_TO_ADDONDIR.'/'.$MyAddonName;
  $ThisConfigDir     = PATH_TO_CONFIGDIR.'/'.$MyAddonName;
  //Default-cfg-File
  $DefaultCfgFileName = $MyAddonName;
  $DefaultCfgFileNameExt = $MyAddonName.'.cfg';
  $ConfigLastV112= $MyAddonName.'.lastcfg';
  $ConfigLastFileName= $MyAddonName.'.lastcfg';
  $GeneralCfgFileName= $MyAddonName.'.generalcfg';
  $cfgAktiv_name = '';$cfgAktiv_exists = -2;   /* -2: nicht definiert, -1: Datei fehlt, n:Dateinummer  */
  $cfgLast_name  = '';$cfgLast_exists  = -2;

  /* Allgemeine Config-Datei einlesen */
  if (file_exists($ThisConfigDir.'/'.$GeneralCfgFileName)) {
     $GetGeneralCfg_array = parse_ini_file($ThisConfigDir.'/'.$GeneralCfgFileName);
  }
  $vereinsplanhidesection=$GetGeneralCfg_array['vereinsplan_hidesection'];
  if ($vereinsplanhidesection == '') {$vereinsplanhidesection=0;}
  $vereinsplancreateplan=$GetGeneralCfg_array['vereinsplan_createplan'];
  if ($vereinsplancreateplan == '') {$vereinsplancreateplan=1;}

  // Name der aktiven Konfigurationsdatei
  $cfgAktiv_name = $GetGeneralCfg_array['vereinsplan_activecfg'];
  // Name der letzten Konfigurationsdatei
  $cfgLast_name = $GetGeneralCfg_array['vereinsplan_lastcfg'];
  if ($cfgLast_name == '' && file_exists($ThisConfigDir.'/'.$ConfigLastV112)) {
    // Versuch den Namen aus Vorversion (bis 1.1.2) einzulesen
     $cfgLast_name_file = fopen($ThisConfigDir.'/'.$ConfigLastV112, "rb");
     $cfgLast_name = trim(fgets($cfgLast_name_file));
     fclose($cfgLast_name_file);
  }

  if ($cfgLast_name !== '') {
      $cfgLast_exists = -1;
  }
  if ($cfgAktiv_name !== '') {
      $cfgAktiv_exists = -1;
      $MyCfgNameAuswahl = $cfgAktiv_name;
  }
  if (isset($vereinsplan_cfg_auswahl)) {$MyCfgNameAuswahl=$vereinsplan_cfg_auswahl;}

  //Vereinsplan-cfg-Datei
  $MyCfgFileExt      = $MyCfgNameAuswahl.'.cfg';
  $MyCfgFile = $ThisConfigDir.'/'.$MyCfgFileExt;
  $MyCfgFileAktiv = $ThisConfigDir.'/'.$MyCfgFileNameAktiv.'.cfg';

  if(is_dir($ThisConfigDir)) {
    //alle cfg-Dateien einlesen
    $cfg_verz=substr($ThisConfigDir,-1)=='/'?opendir(substr($ThisConfigDir.'/',0,-1)):opendir($ThisConfigDir.'/');
    $cfg_counter = 0;
    $cfg_exists = -1;$cfg_default_exists = -1;
    while($t_files=readdir($cfg_verz)) {
      if (strtolower(substr($t_files,-4))==".cfg"){
        $cfg_files[$cfg_counter++]=substr($t_files,0,-4);
        if (strtolower($MyCfgNameAuswahl)==strtolower($cfg_files[$cfg_counter-1])) {$cfg_exists=($cfg_counter-1);}
        if (strtolower($cfgAktiv_name)==strtolower($cfg_files[$cfg_counter-1])) {$cfgAktiv_exists=($cfg_counter-1);}
        if (strtolower($cfgLast_name)==strtolower($cfg_files[$cfg_counter-1])) {$cfgLast_exists=($cfg_counter-1);}
        if (strtolower($DefaultCfgFileName)==strtolower($cfg_files[$cfg_counter-1])) {$cfg_default_exists=($cfg_counter-1);}
      }
    }
    closedir($cfg_verz);
  }
  if ($cfg_exists==-1 && $cfg_counter>0) {
    if ($cfgAktiv_exists>-1) {$cfg_exists=$cfgAktiv_exists;}
    else {
      if ($cfgLast_exists>-1) {$cfg_exists=$cfgLast_exists;}
      else {
        if ($cfg_default_exists>-1) {$cfg_exists=$cfg_default_exists;}
        else {$cfg_exists=0;}
      }
    }
  }

  ?>

  <?php
  //$GetMyCfg_array = parse_ini_file($MyCfgFile);

  if ($_SESSION['lmouserok']>1 && $vereinsplanhidesection==1)  {$vereinsplanhidesection=0;}
  if ($cfg_counter>0) {
  ?>
          <tr <?php if ($vereinsplanhidesection==1) { echo ' style="display:none"';}?>>
            <th class="nobr" colspan="18" align="center"><?php echo $text[$MyAddonName][7141];  ?></th>

          </tr>
          <tr <?php if ($vereinsplanhidesection==1) { echo ' style="display:none"';}?>>
            <td colspan="<?php echo $breite; ?>" align="center">
              <table class="lmoInner" cellspacing="0" cellpadding="0" border="0" width="100%">
                 <tr>
                   <td class="nobr" align="right"<?php if ($cfgAktiv_exists==-1 && $cfgAktiv_name <>"") {echo ' style="color:red"';}?>><?php echo $text[$MyAddonName][7011]; ?>&nbsp;</td>
                   <td class="nobr" align="left">
                      <select class="lmo-formular-input" name="vereinsplan_cfg_auswahl" size="1">
                      <?php
             if ($cfgAktiv_exists==-1) {
                echo '            <option disabled="disabled">'.$cfgAktiv_name.'</option>'.chr(13);
             }
             for ($cfg=0; $cfg<$cfg_counter; $cfg++) {
                if ($cfg==$cfg_exists) {echo '              <option selected="selected">'.$cfg_files[$cfg].'</option>'.chr(13).'          ';}
                else {echo '              <option>'.$cfg_files[$cfg].'</option>'.chr(13).'          ';}
             }
          ?>
            </select>
                    </td>
                   <td class="nobr" align="right"><input class="lmo-formular-input" type="checkbox" <?php if ($vereinsplancreateplan==1) {echo ' checked="checked"';}?> name="vereinsplan_plan_erstellen">&nbsp;&nbsp;</td>
                   <td class="nobr" align="left" id="vereinsplan_txtcreateplan"><?php echo $text[$MyAddonName][7019];  ?></td>
                </table>
            </td>

          </tr>
  <?php
  }
  else {
    if ($vereinsplanhidesection==0) {
      echo '          <tr><td colspan="'.$breite.'" align="center">'.$MyAddonName.': '.$text[$MyAddonName][7172].'</td></tr>';
    }
  }
}
?>