<SCRIPT language="JavaScript">
<!--hide
/*
var password;

var pass1="ACCEPT";
var pass2="accept";
var pass3="Accept";

password=prompt('This map is offered as a service. It is not to be used as a legal listing of properties and we cannot assume all properties are geocoded properly. If we were not able to geocode the property it is not listed on this map. By typing \'ACCEPT\' in the box and clicking \'OK\' you agree to use this map only as a visual guide and not a legal listing of auctions.',' ');

if (password==pass1 || password==pass2 || password==pass3)
  alert('Thank you, you may now view our map of auctions!');
else
   {
    window.location="home.php";
    }
*/
//-->
</SCRIPT>


<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAA2ArF_EF7s8gt5SlN-66dGRSDwiOJjXtIz2bb2tX6zkVuu1lXuxQ_mZTPk-otfXUittH4129cC1VyvQ"
      type="text/javascript"></script>
<body onUnload="GUnload()">
<center>
<div id="map" style="width: 900px; height: 500px; text-align:left;"></div></center>
<script type="text/javascript">
    if (GBrowserIsCompatible()) {
      var gmarkers = [];
      var htmls = [];
      var i = 0;

      function createMarker(point,name,html) {
        var marker = new GMarker(point);
        GEvent.addListener(marker, "click", function() {
          marker.openInfoWindowHtml(html);
        });
        gmarkers[i] = marker;
        htmls[i] = html;
        i++;
        return marker;
      }

      function myclick(i) {
        gmarkers[i].openInfoWindowHtml(htmls[i]);
      }

      var map = new GMap2(document.getElementById("map"));
      map.addControl(new GLargeMapControl());
      map.addControl(new GMapTypeControl());
      map.setCenter(new GLatLng( 39.3,-76.6), 10);

      var request = GXmlHttp.create();
      request.open("GET", "ps_xml.php?id=<?=$_GET[id]?>", true);
      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          var xmlDoc = request.responseXML;
          var markers = xmlDoc.documentElement.getElementsByTagName("marker");
          for (var i = 0; i < markers.length; i++) {
            var lat = parseFloat(markers[i].getAttribute("lat"));
            var lng = parseFloat(markers[i].getAttribute("lng"));
            var point = new GLatLng(lat,lng);
            var html = markers[i].getAttribute("html");
            var label = markers[i].getAttribute("label");
            var marker = createMarker(point,label,html);
            map.addOverlay(marker);
          }
        }
      }
      request.send(null);
    }

    else {
      alert("Sorry, the Google Maps API is not compatible with this browser");
    }
    </script>
