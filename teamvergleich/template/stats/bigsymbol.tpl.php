<style type="text/css">
body   {
	background: #c0c0c0;
  font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
  font-size: 10px;
  scrollbar-face-color: #CED9F9;
  scrollbar-highlight-color: #66CCFF;
  scrollbar-3dlight-color: #969696;
  scrollbar-darkshadow-color: #000099;
  scrollbar-shadow-color: #0000CC;
  scrollbar-arrow-color: #ffffff;
  scrollbar-track-color: #DDDDDD;
}
p {
  font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
  font-size: 10px;
}
h1 {
  background: #CED9F9;
  color: black;
  font-size: 11px;
}
a:hover {
  font-style: none;
  bgcolor: blue;
  color: white;
}
a:link {
  text-decoration: none;
  color: blue;
  }

a:visited {
  text-decoration: none;
  color: blue;
}

a span.popup, a:link span.popup{
  display: none;
}

a:hover span.popup{
  display: inline;
  font-size:100%;
  position: absolute;
  background: white repeat;
  width: 10em;
  margin: 1.5em 0 0 -4em;
  padding: 0.2em;
  z-index: 999;
  white-space:normal;
  text-decoration:none !important;
  text-align:center;
  border: 1px solid #ffffff;
}

table {
  background-color: #3399ff;
  color: black;
}
td, th {
   font-size: 12px;
   vertical-align: middle;
}
tr {
  border: 1px solid #ffffff;
}
.vTitle {
  font-size: 12px;
  line-height: 18px;
  color: white;
  font-weight: bold;
  background-color: #0033cc;
  white-space:nowrap;
}

.vZeilenklasse {
  background-color:#33ccff;
}
.Zeilenklasse {
  background-color:#ffffff;
}
.vFooter {
  font-size:9px;
}
</style>
<table width="100%" >
  <tr>
    <td class="vTitle" align="center" colspan="5">
      <p><b><font size=3><!--Text1--></font></b></p>
    </td>
  </tr>
  <tr>
    <th align="right"><!--Teama--></th><th><!--IconHeimBig--></th><th><!--Text2--></th><th><!--IconGastBig--></th><th align="left"><!--Teamb--></th>
  </tr>
  <tr>
    <td colspan="5">
      <!--Statistik-->
      <br>
      <table cellspacing="2" align="center">
        <tr class="vTitle">
          <td align="center" colspan="3"><!--highWin--></td>
        </tr>
        <tr class="vZeilenklasse">
          <td ><b><!--Team--></b></td>
          <td align="center"><b><!--highHome--></b></td>
          <td align="center"><b><!--highAway--></b></td>
        </tr>
        <tr class="Zeilenklasse">
          <td><!--Teama--></td>
          <td align="center"><!--HeimsiegA--></td>
          <td align="center"><!--GastsiegA--></td>
        </tr>
        <tr class="Zeilenklasse">
          <td><!--Teamb--></td>
          <td align="center"><!--HeimsiegB--></td>
          <td align="center"><!--GastsiegB--></td>
        </tr>
      </table>
      <br>
      <!-- BEGIN Liga -->
	  <table width=80% align="center">
        <tr>
          <td  class="vTitle" align="center" colspan=7><!--Liganame--></td>
        </tr>
        <tr>
          <td>
            <table width=100%  cellspacing="0"  cellpadding="2">
            <!-- BEGIN Inhalt -->
              <tr class="Zeilenklasse">
                <td><!--Datum--> <!--Uhr--></td>
                <td align="right"><!--Heim--></td>
                <td align="center">&nbsp;&nbsp;-&nbsp;&nbsp;</td>
                <td  align="left"><!--Gast--></td>
                <td><!--Tore--></td>
                <td><!--Spielbericht--></td>
                <td><!--Notiz--></td>
              </tr>
            <!-- END Inhalt -->
            </table>
          </td>
        </tr>
      </table>
      <!-- END Liga -->
    </td>
  </tr>
  <br>
</table>
<table  width="100%">
  <tr>
    <td width="40%" class="vFooter"><!--Pdf--></td>
    <td width="60%" class="vFooter"><br><!--VERSION--><br><!--VERSIONa--><br><!--SPRACHE--><br><!--Dauer--></td>
  </tr>
</table>
