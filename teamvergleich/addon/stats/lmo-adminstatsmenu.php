
      <table class="lmoSubmenu" width="99%" cellspacing="0" cellpadding="0" border="0">
        <tr>
          <td align="right" width="47%"><?php
if ($todo!='createstats') {?>
      <a href='<?php echo $comparison_addr_stats?>' onclick="return chklmolink();" title="<?php echo $text['stats'][0]?>"><?php echo $text['stats'][0]?></a><?php
} else {
  echo $text['stats'][0];
}?></td><td align="left" width="5%">
          <td align="left" width="47%"><?php
if ($todo!='createstatsarchiv') {?>
      <a href='<?php echo $comparison_addr_archiv?>' onclick="return chklmolink();" title="<?php echo $text['stats'][7]?>"><?php echo $text['stats'][7]?></a><?php
} else {
  echo $text['stats'][7];
}?> </td>
        </tr>
      </table>