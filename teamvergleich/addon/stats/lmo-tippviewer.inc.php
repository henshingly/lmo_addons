<?php
if ($stats[$i] == 1){
    echo "&nbsp;";
    echo "<a href=\"javascript:void(0);\" onclick=\"window.open('" . URL_TO_ADDONDIR . "/stats/stats.php?a=";
    echo htmlentities($teama[$i]);
    echo "&b=";
    echo htmlentities($teamb[$i]);
    echo "&c=$liga[$i]";
    echo "', '_blank', 'width=" . $stats_popup_breite . ", height=" . $stats_popup_hoehe . ", left=0, top=0, scrollbars=yes')\"><span class='popup'><strong><center>" . nl2br($teama[$i]) . "<br>" . nl2br(HTML_smallTeamIcon($file,$teama[$i]," alt=''")) . "<br>-<br>" . nl2br(HTML_smallTeamIcon($file,$teamb[$i]," alt=''")) . "<br>" . nl2br($teamb[$i]) . "</center></strong><br><br>" . nl2br($text['stats'][2]) . "<br>" . nl2br($text['stats'][3]) . "</span><img src='" . URL_TO_IMGDIR . "/stats/comparison.svg' width='15' border='0' alt=''></a>";
}
else {
    echo "&nbsp;";
}
?>
