<?php
$liga = substr($file, 0, strlen($file) - 4);
if ($stats == 1) {
    echo "&nbsp;";
    echo "<a href=\"javascript:void(0);\" onclick=\"window.open('" . URL_TO_ADDONDIR . "/stats/stats.php?a=";
    echo strip_tags($teams[$teama[$st - 1][$i]]);
    echo "&b=";
    echo strip_tags($teams[$teamb[$st - 1][$i]]);
    echo "&c=$liga";
    echo "', '_blank', 'width=" . $stats_popup_breite . ', height=' . $stats_popup_hoehe . ", left=0, top=0')\" data-bs-toggle='tooltip' data-bs-placement='top' data-bs-title='" . nl2br($text['stats'][2]) . "'><i class='bi bi-clipboard-data text-danger' style='font-size: 1.3rem;'></i></a>";
}
else {
    echo "&nbsp;";
}
?>

