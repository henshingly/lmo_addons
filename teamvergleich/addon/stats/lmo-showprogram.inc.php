<?php
$liga = substr($file, 0, strlen($file) - 4);
if ($stats == 1) {
    echo "&nbsp;";
    echo "<a href=\"javascript:void(0);\" onclick=\"window.open('" . URL_TO_ADDONDIR . "/stats/stats.php?a=";
    echo strip_tags($teams[$teama[$j][$i]]);
    echo "&amp;b=";
    echo strip_tags($teams[$teamb[$j][$i]]);
    echo "&amp;c=" . $liga;
    echo "', '_blank', 'width=" . $stats_popup_breite . ", height=" . $stats_popup_hoehe . ", left=0, top=0, scrollbars=yes')\"><span class='popup'><strong><center>" . nl2br($teams[$teama[$j][$i]]) . "<br>" . nl2br(HTML_smallTeamIcon($file,$teams[$teama[$j][$i]]," alt=''")) . "<br>-<br>" . nl2br(HTML_smallTeamIcon($file,$teams[$teamb[$j][$i]]," alt=''")) . "<br>" . nl2br($teams[$teamb[$j][$i]]) . "</center></strong><br><br>" . nl2br($text['stats'][2]) . "<br>" . nl2br($text['stats'][3]) . "</span><img src='" . URL_TO_IMGDIR . "/stats/comparison.svg' width='15' border='0' alt=''></a>";
}
else {
    echo " ";
}
?>
