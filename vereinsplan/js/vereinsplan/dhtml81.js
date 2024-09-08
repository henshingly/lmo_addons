/* DHTML-Bibliothek */

var DHTML = false, DOM = false;
var MSIE5 = false, MSIE4 = false, MS=false;
var NS4 = false, OP = false, GF = false;
var NaviText = navigator.userAgent;
var msievers5 =NaviText.search(/MSIE 5.+/);
var gecko = NaviText.search(/Gecko.+/);
var firefox = NaviText.search(/Firefox.+/);

if (msievers5 != -1) {MSIE5=1;}
if (gecko != -1 || firefox != -1) {GF=1;}

if (document.getElementById) {
  DHTML = true;
  DOM = true;
} else {
  if (document.all) {
    DHTML = true;
    MSIE4 = true;
  } else {
    if (document.layers) {
      DHTML = true;
      NS4 = true;
    }
  }
}
if (window.opera) {OP = true;}
if (document.all && !OP) {MS = true;}

//Original: keine Abfrage über Framegrenzen hinweg
function getElement (Mode, Identifier, ElementNumber) {
  var Element;
  if (DOM) {
    if (Mode.toLowerCase() == "id") {
      if (typeof document.getElementById(Identifier) == "object") {
        Element = document.getElementById(Identifier);
      } else {
        Element = false;
      }
      return Element;
    }
    if (Mode.toLowerCase() == "name") {
      var ElementList = document.getElementsByName(Identifier);
      if (typeof ElementList == "object" || (OP && typeof ElementList == "function")) {
        Element = ElementList[ElementNumber];
      } else {
        Element = false;
      }
      return Element;
    }
    if (Mode.toLowerCase() == "tagname") {
      var ElementList = document.getElementsByTagName(Identifier);
      if (typeof ElementList == "object" || (OP && typeof ElementList == "function")) {
        Element = ElementList[ElementNumber];
      } else {
        Element = false;
      }
      return Element;
    }
    return null;
  }
  if (MSIE4) {
    if (Mode.toLowerCase() == "id") {
      if (typeof document.all[Identifier] == "object") {
        Element = document.all[Identifier];
      } else {
        Element = false;
      }
      return Element;
    }
    if (Mode.toLowerCase() == "tagname") {
      if (typeof document.all.tags(Identifier) == "object") {
        Element = document.all.tags(Identifier)[ElementNumber];
      } else {
        Element = false;
      }
      return Element;
    }
    if (Mode.toLowerCase() == "name") {
      if (typeof document[Identifier] == "object") {
        Element = document[Identifier];
      } else {
        Element = false;
      }
      return Element;
    }
    return false;
  }
  if (NS4) {
    if (Mode.toLowerCase() == "id" || Mode.toLowerCase() == "name") {
      if (typeof document[Identifier] == "object") {
        Element = document[Identifier];
      } else {
        Element = false;
      }
      return Element;
    }
    if (Mode.toLowerCase() == "index") {
      if (typeof document.layers[Identifier] == "object") {
        Element = document.layers[Identifier];
      } else {
        Element = false;
      }
      return Element;
    }
    return false;
  }
  return false;
}

function getContent (Mode, Identifier, ElementNumber) {
  var Content;
  var Element = getElement(Mode, Identifier, ElementNumber);
  if (!Element) {
    return false;
  }
  if (DOM && Element.firstChild) {
    if (Element.firstChild.nodeType == 3) {
      Content = Element.firstChild.nodeValue;
    } else {
      Content = "";
    }
    return Content;
  }
  if (MSIE4) {
    Content = Element.innerText;
    return Content;
  }
  return false;
}

function getAttribute (Mode, Identifier, ElementNumber, AttributeName) {
  var Attribute;
  var Element = getElement(Mode, Identifier, ElementNumber);
  if (!Element) {
    return false;
  }
  if (DOM || MSIE4) {
    Attribute = Element.getAttribute(AttributeName);
    return Attribute;
  }
  if (NS4) {
    if (typeof Element[ElementNumber] == "object") {
      Attribute = Element[ElementNumber][AttributeName];
    } else {
      Attribute = Element[AttributeName]
    }
    return Attribute;
  }
  return false;
}

function setContent (Mode, Identifier, ElementNumber, Text) {
  var Element = getElement(Mode, Identifier, ElementNumber);
  if (!Element) {
    return false;
  }
  if (DOM && Element.firstChild) {
    Element.firstChild.nodeValue = Text;
    return true;
  }
  if (MSIE4) {
    Element.innerText = Text;
    return true;
  }
  if (NS4) {
    Element.document.open();
    Element.document.write(Text);
    Element.document.close();
    return true;
  }
}

//angepasste Version: Abfrage über Framegrenzen hinweg
function getFElem (FrameNumber, Mode, Identifier, ElementNumber) {
 with (this.frames[FrameNumber]) {
  var Element;
  if (DOM) {
    if (Mode.toLowerCase() == "id") {
      if (typeof document.getElementById(Identifier) == "object") {
        Element = document.getElementById(Identifier);
      } else {
        Element = false;
      }
      return Element;
    }
    if (Mode.toLowerCase() == "name") {
      var ElementList = document.getElementsByName(Identifier);
      if (typeof ElementList == "object" || (OP && typeof ElementList == "function")) {
        Element = ElementList[ElementNumber];
      } else {
        Element = false;
      }
      return Element;
    }
    if (Mode.toLowerCase() == "tagname") {
      var ElementList = document.getElementsByTagName(Identifier);
      if (typeof ElementList == "object" || (OP && typeof ElementList == "function")) {
        Element = ElementList[ElementNumber];
      } else {
        Element = false;
      }
      return Element;
    }
    return null;
  }
  if (MSIE4) {
    if (Mode.toLowerCase() == "id") {
      if (typeof document.all[Identifier] == "object") {
        Element = document.all[Identifier];
      } else {
        Element = false;
      }
      return Element;
    }
    if (Mode.toLowerCase() == "tagname") {
      if (typeof document.all.tags(Identifier) == "object") {
        Element = document.all.tags(Identifier)[ElementNumber];
      } else {
        Element = false;
      }
      return Element;
    }
    if (Mode.toLowerCase() == "name") {
      if (typeof document[Identifier] == "object") {
        Element = document[Identifier];
      } else {
        Element = false;
      }
      return Element;
    }
    return false;
  }
  if (NS4) {
    if (Mode.toLowerCase() == "id" || Mode.toLowerCase() == "name") {
      if (typeof document[Identifier] == "object") {
        Element = document[Identifier];
      } else {
        Element = false;
      }
      return Element;
    }
    if (Mode.toLowerCase() == "index") {
      if (typeof document.layers[Identifier] == "object") {
        Element = document.layers[Identifier];
      } else {
        Element = false;
      }
      return Element;
    }
    return false;
  }
  return false;
 }
}

function getFCont (FrameNumber, Mode, Identifier, ElementNumber) {
  var Content;
  var Element = getFElem(FrameNumber, Mode, Identifier, ElementNumber);
  if (!Element) {
    return false;
  }
  if (DOM && Element.firstChild) {
    if (Element.firstChild.nodeType == 3) {
      Content = Element.firstChild.nodeValue;
    } else {
      Content = "";
    }
    return Content;
  }
  if (MSIE4) {
    Content = Element.innerText;
    return Content;
  }
  return false;
}

function getFAttr (FrameNumber, Mode, Identifier, ElementNumber, AttributeName) {
  var Attribute;
  var Element = getFElem(FrameNumber, Mode, Identifier, ElementNumber);
  alert(Element.id);
  if (!Element) {
    return false;
  }
  if (DOM || MSIE4) {
    Attribute = Element.getAttribute(AttributeName);
    return Attribute;
  }
  if (NS4) {
    if (typeof Element[ElementNumber] == "object") {
      Attribute = Element[ElementNumber][AttributeName];
    } else {
      Attribute = Element[AttributeName]
    }
    alert("2 Attr "+Attribute);
    return Attribute;
  }
  return false;
}

function getFBgColor (FrameNumber, Mode, Identifier, ElementNumber, AttributeName) {
  var Attribute;
  var Element = getFElem(FrameNumber, Mode, Identifier, ElementNumber);
  if (!Element) {
    return false;
  }
  if (DOM) {
    Attribute = Element.style.backgroundColor;      //style.fontSize
    if (GF==1) {
       var x, s, r ,g ,b;
       x=Attribute.substr(4);x=x.substr(0,x.length-1);
       s = x.split(",");
       r=s[0];g=s[1];b=s[2];
       Attribute="#"+d2x(r)+d2x(g)+d2x(b);
       //alert("DomStyle "+Attribute+"\n"+x+"\n"+r+" "+g+" "+b);
    }
    return Attribute;
  }
    if (MSIE4) {
  alert(Element);
//    Attribute = Element.getAttribute(AttributeName);
    Attribute = Element.style.getAttribute(AttributeName, "false");
    alert("MsiStyle "+Attribute);
    return Attribute;
  }
  if (NS4) {
    if (typeof Element[ElementNumber] == "object") {
      Attribute = Element[ElementNumber][AttributeName];
    } else {
      Attribute = Element[AttributeName]
    }
    alert("2 Attr "+Attribute);
    return Attribute;
  }
  return false;
}

function setFCont (FrameNumber, Mode, Identifier, ElementNumber, Text) {
  var Element = getFElem(FrameNumber, Mode, Identifier, ElementNumber);
  if (!Element) {
    return false;
  }
  if (DOM && Element.firstChild) {
    Element.firstChild.nodeValue = Text;
    return true;
  }
  if (MSIE4) {
    Element.innerText = Text;
    return true;
  }
  if (NS4) {
    Element.document.open();
    Element.document.write(Text);
    Element.document.close();
    return true;
  }
}

//noch nicht getestet, nur als Merkzettel....
function setFAttr (FrameNumber, Mode, Identifier, ElementNumber, AttributeName) {
  var Attribute;
  var Element = getFElem(FrameNumber, Mode, Identifier, ElementNumber);
  if (!Element) {
    return false;
  }
  if (DOM || MSIE4) {
    Attribute = Element.setAttribute(AttributeName);
    return Attribute;
  }
  if (NS4) {
    if (typeof Element[ElementNumber] == "object") {
      Attribute = Element[ElementNumber][AttributeName];
    } else {
      Attribute = Element[AttributeName]
    }
    return Attribute;
  }
  return false;
}

function d2x (dzahl) {
  var max = 255, hex="",ganzzahl=dzahl;

  if (dzahl>max || dzahl<0 || isNaN(dzahl)==true) {return false;}
  if (dzahl==0) {return "00";}
  if (dzahl==128) {return "80";}
  if (dzahl==255) {return "FF";}
  var hexz = new Array("0","1","2","3","4","5","6","7","8","9","A","B","C","D","E","F");
  var i=1;
  //wie oft passt 15 in die Zahl
  while (ganzzahl>15) { ganzzahl = Math.floor(ganzzahl/16);i++;}
  //alert(dzahl+" "+i);
  ganzzahl = dzahl;
  for (j=i; j >= 1; j--) {
    hex = hex + hexz[Math.floor(ganzzahl / Math.pow(16,j-1))];
    ganzzahl = ganzzahl - (Math.floor(ganzzahl / Math.pow(16,j-1)) * Math.pow(16,j-1));
  }
  if (dzahl <= 15)
    hex = "0" + hex;
  return hex;
}