/**
 * Javascript functions for the Viewer-Addon for Liga Manager Online 4
 *
 * @package viewer
 * @author Rene Marth/lmogroup
 */
/*
 * Add some function used by vereinsplan-addon
 *    changelog:
 *    08.09.2009  Eingabe-Prüfungen für PDF-Werte eingefügt
 *    13.09.2009  An LMO-Forum übergeben
 *    23.11.2010  Abfragen Aktiv/Last für Version 1.3.0
 */

/**
 * checks all checkboxes in a form
 *
 *
 * @param elm  Object  Element of the form that shall check all boxes
 *
 */
function checkAll(elm) {
  for (var i = 0; i < elm.form.elements.length; i++) {
    if (elm.form.elements[i].type == "checkbox") {
      elm.form.elements[i].checked = true;
    }
  }
  cntChkActiv(elm);
}
/**
 * unchecks all checkboxes in a form
 *
 *
 * @param elm  Object  Element of the form that shall uncheck all boxes
 */
function uncheckAll(elm) {
  for (var i = 0; i < elm.form.elements.length; i++) {
    if (elm.form.elements[i].type == "checkbox") {
      elm.form.elements[i].checked = false;
    }
  }
  cntChkActiv(elm);
}

/**
 * switches the state of all checkboxes in a form
 *
 *
 * @param elm  Object  Element of the form that shall switch all boxes
 */
function switchAll(elm) {
  for (var i = 0; i < elm.form.elements.length; i++) {
    if (elm.form.elements[i].type == "checkbox") {
      elm.form.elements[i].checked = !elm.form.elements[i].checked;
    }
  }
  cntChkActiv(elm);
}

/**
 * turns on the by Matchday-Cobnfig-Items / turns off the by Date-Config-Items
 *
 *
 * @param elm  Object  Element to enable by Date
 */
function byDay (elm) {
  elm.form.anzahl_spieltage_vor.disabled=false;
  elm.form.anzahl_spieltage_zurueck.disabled=false;
  elm.form.anzahl_tage_plus.disabled=true;
  elm.form.anzahl_tage_minus.disabled=true;
}

/**
 * turns on the by Date-Config-Items / turns off the by Matchday-Cobnfig-Items
 *
 *
 * @param elm  Object  Element to enable by Matchday
 */
function byDate (elm) {
  elm.form.anzahl_spieltage_vor.disabled=true;
  elm.form.anzahl_spieltage_zurueck.disabled=true;
  elm.form.anzahl_tage_plus.disabled=false;
  elm.form.anzahl_tage_minus.disabled=false;
}

/**
 * toggles style and access of filename inputbox
 *
 * @param elm  Object  Optionelement (radio) of the form to toggle style and access of inputbox
 * @param wert 0/1     value of radio element
 *
 */

function useCfg(elm,wert) {
     var zelle1= getElement("id","vereinsplancfgnew");
     var zelle2= getElement("id","vereinsplancfgnew2");
     var zelle3= getElement("id","vereinsplantxtcreateplan");
     var inhalt = trim(elm.form.vereinsplandateiname.value);
  if (wert == "1") {
      //cfg direkt überschreiben
      elm.form.vereinsplandateiname.style.color="gray";
      elm.form.vereinsplandateiname.disabled="disabled";
      if (zelle1) {zelle1.style.color="gray";}
      if (zelle2) {zelle2.style.color="gray";}
      if (zelle3) {zelle3.style.color="black";}
      setContent("id","vereinsplantxtoutfile1",null,elm.form.vereinsplancfg_auswahl.value+".txt");
      setContent("id","vereinsplantxtoutfile2",null,elm.form.vereinsplancfg_auswahl.value+"_res.txt");
      setContent("id","vereinsplantxtpdffile",null,elm.form.vereinsplancfg_auswahl.value+".pdf.txt");
      elm.form.vereinsplanplan_erstellen.disabled="";
      elm.form.vereinsplanB1.disabled="";
      elm.form.vereinsplanB1.style.color="blue";
  }
  else {
      elm.form.vereinsplandateiname.style.color="black";
      elm.form.vereinsplandateiname.disabled="";
      elm.form.vereinsplanplan_erstellen.disabled="disabled";
      setContent("id","vereinsplantxtoutfile1",null,elm.form.vereinsplandateiname.value+".txt");
      setContent("id","vereinsplantxtoutfile2",null,elm.form.vereinsplandateiname.value+"_res.txt");
      setContent("id","vereinsplantxtpdffile",null,elm.form.vereinsplandateiname.value+".pdf.txt");
      if (zelle3) {zelle3.style.color="gray";}
      if (inhalt=="") {
         if (zelle1) {zelle1.style.color="red";}
         if (zelle2) {zelle2.style.color="red";}
         elm.form.vereinsplanB1.disabled="disabled";
         elm.form.vereinsplanB1.style.color="gray";
      }
      else {
         if (zelle1) {zelle1.style.color="black";}
         if (zelle2) {zelle2.style.color="black";}
      }
  }
}

/**
 * checks some input-values, e.g. cfg-filename and toggles access to continue-Button
 *
 * @param elm  Object    object of form
 * @param wert filename  value of object
 * @param evt  0/1       onchange/onblur
 *
 */

function chkinput(elm,wert,evt) {
  var oName = elm.name;
  var l1=wert.length;
  wert=trim(wert);
  var l2=wert.length;
  var setchanges=false;

  switch (oName) {
    case "vereinsplandateiname":
       var zelle1= getElement("id","vereinsplancfgnew");
       var zelle2= getElement("id","vereinsplancfgnew2");
       if (wert == "") {
         //alert("Cfg-Dateiname ist Pflicht!");
         elm.form.vereinsplanB1.disabled="disabled";
         elm.form.vereinsplanB1.style.color="gray";
         if (zelle1) {zelle1.style.color="red";}
         if (zelle2) {zelle2.style.color="red";}
         //elm.form.dateiname.focus();
         return false;
       }
       else {
         if (zelle1) {zelle1.style.color="black";}
         if (zelle2) {zelle2.style.color="black";}
         if (evt=="1") { //blur
           if (l1!=l2) {elm.form.vereinsplandateiname.value=wert;}
         }
         elm.form.vereinsplanB1.disabled="";
         elm.form.vereinsplanB1.style.color="blue";
       }
       setContent("id","vereinsplantxtoutfile1",null,wert+".txt");
       setContent("id","vereinsplantxtoutfile2",null,wert+"_res.txt");
       setContent("id","vereinsplantxtpdffile",null,wert+".pdf.txt");
       break;
    case "vereinsplancfgAktiv_auswahl":
       var zelle1= getElement("id","vereinsplancfgAktivtxt");
       if (zelle1) {zelle1.style.color="black";}
       elm.form.vereinsplanE10.disabled="";
       var zelle2= getElement("id","vereinsplancfgAktiv_exists");
       if (zelle2) {zelle2.value="1";}
       break;
    case "vereinsplancfg_auswahl":
       var zelle1= getElement("id","vereinsplancfgLasttxt");
       if (zelle1) {zelle1.style.color="black";}
       elm.form.vereinsplanB0.disabled="";
       var zelle2= getElement("id","vereinsplancfg_exists");
       if (zelle2) {zelle2.value="1";}
       break;

    default:
       var zelle1= getElement("id",oName+"txt");
       var chknum = false;
       if (oName.substring(0,18) == 'vereinsplanpdflogo') {if (oName.length>19) {chknum=isNaN(wert);}}
       if (wert == "" || chknum) {if (zelle1) {zelle1.style.color="red";} return false;}
       else {
          if (zelle1) {zelle1.style.color="black";}
          if (evt=="1") { if (l1!=l2) {elm.value=wert;} }
       }
      break;
  }
}

function trimpfad(elm,wert) {
  var oName = elm.name;
  var l1=wert.length;
  wert=trim(wert);
  wert=trim(wert,"/");
  wert=trim(wert);
  var l2=wert.length;
  if (l1!=l2) {elm.form.vereinsplanligapfad.value=wert;}
}

function trim(s,ss) {
 if (typeof(ss)=='undefined') {ss = ' ';}
  while (s.substring(0,1) == ss) {
     s = s.substring(1, s.length);
 }
  while (s.substring(s.length-1, s.length) == ss) {
     s = s.substring(0, s.length-1);
 }
 return s;
}


/**
 * minimum 1 checked checkbox is needed to continue
 * Changes state of continue-button
 *
 * @param elm  Object  changed checkbox element
 */
function cntChkActiv(elm) {
  var is_checked_form=0;
  var is_notchecked_liga=0;
  var formular=elm.form.name;
  var xpos=-1;
  var farbe="blue";
  var disable=false;
  var l=0; var i; var ii;
  var liga = new Array(); liga[0]=0;
  var chkliga = new Array(); chkliga[0]=0;
  var ligax="";

  switch (formular) {
     case "vereinsplanB2":
       var knopf=elm.form.vereinsplanB2;
       break;
     case "vereinsplanB3":
       var knopf=elm.form.vereinsplanB3;
       break;
     default: break;
  }

  for (var i = 0; i < elm.form.elements.length; i++) {
    if (elm.form.elements[i].type == "checkbox") {
      if (formular=="vereinsplanB3") {
         xpos=elm.form.elements[i].value.indexOf("[");
         if (xpos!=-1) {
            ligax = elm.form.elements[i].value.substr(0,xpos);
            liganeu=true;
            for (var ii = 0;ii<=l;ii++) {
               if (ligax==liga[ii]) {liganeu=false;ii=l+1;}
            }
            if (liganeu) {
               ++l;
               liga.length=l;chkliga.length=l
               liga[l]=ligax;chkliga[l]=0;
            }
         }
      }
      if (elm.form.elements[i].checked) {
         ++is_checked_form;
         if (formular=="vereinsplanB3" && xpos!=-1 ) {++chkliga[l];}
      }
    }
  }


  for (var i=1;i<liga.length;i++) {
    if (chkliga[i]>0) {++chkliga[0];}
  }

  if (is_checked_form==0) {
     disable=true;
     farbe="gray";
  }
  else {
     disable=false;
     farbe="blue";
     if (formular=="vereinsplanB3" && chkliga[0]!=liga.length-1 ) {
        disable=true;
        farbe="gray";
     }
  }
  knopf.disabled=disable;
  knopf.style.color=farbe;

}

/**
 * pdf-oriantation: portrait/landscape
 * saves cuurent values to hidden object and toggles image x/y-position
 *
 * @param elm  Object  changed checkbox element
 *        wert Value   not used yet
 */

function chgProps(elm,wert) {
  var oName = elm.name;

  switch (oName) {
    case "vereinsplanpdfformat":
      if (elm.checked) { //Querformat
        elm.form.vereinsplanpdflogo1xh.value=elm.form.vereinsplanpdflogo1x.value;
        elm.form.vereinsplanpdflogo1yh.value=elm.form.vereinsplanpdflogo1y.value;
        elm.form.vereinsplanpdflogo2xh.value=elm.form.vereinsplanpdflogo2x.value;
        elm.form.vereinsplanpdflogo2yh.value=elm.form.vereinsplanpdflogo2y.value;

        elm.form.vereinsplanpdflogo1x.value=elm.form.vereinsplanpdflogo1xq.value;
        elm.form.vereinsplanpdflogo1y.value=elm.form.vereinsplanpdflogo1yq.value;
        elm.form.vereinsplanpdflogo2x.value=elm.form.vereinsplanpdflogo2xq.value;
        elm.form.vereinsplanpdflogo2y.value=elm.form.vereinsplanpdflogo2yq.value;
      }
      else {
        elm.form.vereinsplanpdflogo1xq.value=elm.form.vereinsplanpdflogo1x.value;
        elm.form.vereinsplanpdflogo1yq.value=elm.form.vereinsplanpdflogo1y.value;
        elm.form.vereinsplanpdflogo2xq.value=elm.form.vereinsplanpdflogo2x.value;
        elm.form.vereinsplanpdflogo2yq.value=elm.form.vereinsplanpdflogo2y.value;

        elm.form.vereinsplanpdflogo1x.value=elm.form.vereinsplanpdflogo1xh.value;
        elm.form.vereinsplanpdflogo1y.value=elm.form.vereinsplanpdflogo1yh.value;
        elm.form.vereinsplanpdflogo2x.value=elm.form.vereinsplanpdflogo2xh.value;
        elm.form.vereinsplanpdflogo2y.value=elm.form.vereinsplanpdflogo2yh.value;
      }
      break;
    default:
      break;
  }
}