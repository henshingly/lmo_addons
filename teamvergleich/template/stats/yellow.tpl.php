<style type="text/css">
body   {
	background: black;
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
  background-color: #FFFF00;
  color: black;
}
td, th {
   font-size: 12px;
}
tr {
  border: 1px solid #ffffff;
}
.vTitle {
  font-size: 12px;
  line-height: 18px;
  color: white;
  font-weight: bold;
  background-color: red;
  white-space:nowrap;
}

.vZeilenklasse {
  background-color:#ffcc00;
}
.Zeilenklasse {
  background-color:#ffccff;
}
.vFooter {
  font-size:9px;
}
</style>
<table width="100%" >
  <tr>
    <td class="vTitle" align="center">
      <p><b><font size=3><!--Text--></font></b></p>
    </td>
  </tr>
  <tr>
    <th><!--Text1--><br><!--Teama--> <!--Iconheim--> <!--Text2--> <!--Icongast--> <!--Teamb--></th>
  </tr>
  <tr>
    <td>
<!--Tabelle-->
      <br>
      <table width="95%" align="center"><!-- BEGIN Liga -->
        <tr>
          <td  class="vTitle" align="center"colspan=6><!--Liganame--></td>
        </tr>
        <tr>
          <td>
            <table width=100%  cellspacing="0"  cellpadding="2"><!-- BEGIN Inhalt -->
              <tr class="Zeilenklasse">
                <td><!--Datum--></td>
                <td align="right"><!--Heim--></td>
                <td>&nbsp;&nbsp;-&nbsp;&nbsp;</td>
                <td  align="left"><!--Gast--></td>
                <td><!--Tore--></td>
                <td><!--Spielbericht--></td>
                <td><!--Notiz--></td>
              </tr><!-- END Inhalt -->
            </table>
          </td>
        </tr><!-- END Liga -->
      </table>
      <br><!--Statistik-->
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