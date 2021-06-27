<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1"<!--xmlTag-->>
<meta http-equiv="Content-Script-Type" content="text/javascript"<!--xmlTag-->>

<title><!--FensterTitel--></title>
<!--TPL-Info-->
<style type="text/css" media="screen">
        @import "<!--urlVereinsTemplate-->/css/<!--BasisCssName-->.css";
</style>

<!-- BEGIN BasicsSlider -->
<style type="text/css" media="screen">
        @import "<!--urlVereinsTemplate1-->/css/<!--BasisCssNameSlider-->_slides.css";
</style>
<!-- BEGIN MooTools --><script type="text/javascript" src="<!--urlVereinsJs-->/mootools.js"></script><!-- END MooTools -->
<script type="text/javascript" <!--EventJs-->>
  <!--EventZeile-->
</script>
<!-- END BasicsSlider -->

</head>
<body>

<div>
  <table class="Tab_Basis">
    <tr>
      <td class="Zelle_Basis">
        <table class="Tab_Kopf1">
          <tr>
            <th class="Kopf1_ZelleLinks">&loz; <!--PlanArt--> &loz;</th>
            <th class="Kopf1_ZelleRechts">&loz; <!--VereinsNameLang--> &loz;</th>
          </tr>
        </table>

        <table class="Tab_Plan_Menu">
          <tr>
            <td class="topmenu">&nbsp;<!--topmenutext1-->&nbsp;</td>
            <td class="chktext">&nbsp;<a class="menu" <!--urlAuswahl1-->><!--txtAuswahl1--></a>&nbsp;</td>
            <td class="chktext">&nbsp;<a class="menu" <!--urlAuswahl2-->><!--txtAuswahl2--></a>&nbsp;</td>
          </tr>
        </table>

        <!-- BEGIN SliderMenu -->
        <table class="Tab_Slider_Menu">
          <tr>
            <td class="topmenu">&nbsp;<!--slidermenutxt1-->&nbsp;</td>
            <td class="chktext" onclick="OpenClose('show')"><img class="slideimg" src="<!--urlImg-->/open.gif" alt="<!--imgTitel1-->"/><a class="menu" title="<!--imgTitel1-->">&nbsp;<!--imgText1-->&nbsp;</a>&nbsp;</td>
            <td class="chktext" onclick="OpenClose('hide')"><img class="slideimg" src="<!--urlImg-->/close.gif" alt="<!--imgTitel2-->"/><a class="menu" title="<!--imgTitel2-->">&nbsp;<!--imgText2-->&nbsp;</a>&nbsp;</td>
          </tr>
        </table>
        <!-- END SliderMenu -->

        <table class="Tab_Inhalt1">
          <tr>
            <td class="Zelle_Inhalt1">
            <!-- BEGIN Inhalt -->
            <!--Monatszeile-->

              <!-- BEGIN SliderDev -->
              <!--MonatsInfoSlider-->
              <div class="tvhplan_title_left">
                <div class="tvhplan_title">
                  <a class="tvhplan_title_text" id="toggleplan_<!--MonatNameKlein-->" name="toggleplan_<!--MonatNameKlein-->"><!--MonatName--></a>
                </div>
              </div>
              <div class="slideText" id="plan_<!--MonatNameKlein-->">
              <!-- END SliderDev -->

              <!-- BEGIN KopfMonat -->
                <!--InfoKopfMonat-->
                <table class="Tab_Inhalt2">
                  <tr>
                    <td class="Kopf2_U_Nr"><!--KSpielNr--></td>
                    <td class="Kopf2_U_Wt"><!--KWoTag--></td>
                    <td class="Kopf2_U_Da"><!--KDatum--></td>
                    <td class="Kopf2_U_Ze"><!--KUhrzeit--></td>
                    <td class="Kopf2_U_TH"><!--KHeim--></td>
                    <td class="Kopf2_U_Tr"><!--KTrenn--></td>
                    <td class="Kopf2_U_TG"><!--KGast--></td>
                    <td class="Kopf2_U_To"><!--KTore--></td>
                    <td class="Kopf2_U_N"><!--KLiganame--></td>
                    <td class="Kopf2_U_No"><!--KNotiz--></td>
                  </tr>
                <!-- END KopfMonat -->

                <!-- BEGIN MonatszeileStat -->
                  <!--MonatsInfoStat-->
                  <tr><td class="sptzeile" colspan="10"><a name="monat<!--MonatNrStat-->"><!--MonatNameStat--></a></td></tr>
                <!-- END MonatszeileStat -->

                  <!--KWzeile-->
                  <!-- BEGIN WochenNr -->
                  <tr><td  class="kwzeile" colspan="10"><a name="kw<!--KWNr-->">&nbsp;</a></td></tr>
                  <!-- END WochenNr -->

                  <!-- BEGIN BackColor1 -->
                  <tr class="BackColor1"><!--Setme1-->
                  <!-- END BackColor1 -->
                  <!-- BEGIN BackColor2 -->
                  <tr class="BackColor2"><!--Setme2-->
                  <!-- END BackColor2 -->
                    <td class="xinhalt_Nr"><!--SpielNr--></td>
                    <td class="xinhalt_Wt"><!--WoTag--></td>
                    <td class="xinhalt_Da"><!--Datum--></td>
                    <td class="xinhalt_Ze"><!--Uhrzeit--></td>
                    <td class="xinhalt_TH"><!--Heim--></td>
                    <td class="xinhalt_Tr"><!--Trenn--></td>
                    <td class="xinhalt_TG"><!--Gast--></td>
                    <td class="xinhalt_To"><!--Tore--></td>
                    <td class="xinhalt_N"><!--Liganame--></td>
                    <td class="xinhalt_No"><!--Notiz--></td>
                  </tr>
            <!-- END Inhalt -->

              <!-- BEGIN SliderDevEnd -->
                </table>
              </div><!--SliderDevEndDummy-->
              <!-- END SliderDevEnd -->

                <!-- BEGIN StaticEnd -->
                </table><!--StaticEndDummy-->
                <!-- END StaticEnd -->
            </td>
          </tr>
          <tr>
            <td>
              <table class="Tab_Fuss">
                <tr>
                  <td class="infoL"><!--VERSION-->&nbsp;<!--ZEITSTEMPEL--></td>
                  <!-- BEGIN CREATEPDF -->
                  <td class="infoR"><a class="menu" <!--targetPDF--> <!--urlPDF-->><!--txtPDF--></a></td>
                  <!-- END CREATEPDF -->
                </tr>
              </table>
            </td>
          </tr>
        </table>
        <!-- END Liga -->

      </td>
    </tr>
  </table>
</div>
</body></html>