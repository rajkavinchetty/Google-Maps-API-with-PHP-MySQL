<?php
        $locations=array(); 
        $uname="root";
        $pass="";
        $servername="localhost";
        $dbname="bcremote";
        $db=new mysqli($servername,$uname,$pass,$dbname);
        $query =  $db->query("SELECT * FROM location");
        //$number_of_rows = mysql_num_rows($db);  
        //echo $number_of_rows;

        while( $row = $query->fetch_assoc() ){
            $name = $row['uname'];
            $longitude = $row['longitude'];                              
            $latitude = $row['latitude'];
            $link=$row['link'];
            /* Each row is added as a new array */
            $locations[]=array( 'name'=>$name, 'lat'=>$latitude, 'lng'=>$longitude, 'lnk'=>$link );
        }


        //echo $locations[0]['name'].": In stock: ".$locations[0]['lat'].", sold: ".$locations[0]['lng'].".<br>";
        //echo $locations[1]['name'].": In stock: ".$locations[1]['lat'].", sold: ".$locations[1]['lng'].".<br>";
    ?>
    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=Your-Google-Map-API-Key"></script> 
    <script type="text/javascript">
    var map;
    var Markers = {};
    var infowindow;
    var locations = [
        <?php for($i=0;$i<sizeof($locations);$i++){ $j=$i+1;?>
        [
            'AMC Service',
            '<p><a href="<?php echo $locations[0]['lnk'];?>">Book this Person Now</a></p>',
            <?php echo $locations[$i]['lat'];?>,
            <?php echo $locations[$i]['lng'];?>,
            0
        ]<?php if($j!=sizeof($locations))echo ","; }?>
    ];
    var origin = new google.maps.LatLng(locations[0][2], locations[0][3]);

    function initialize() {
      var mapOptions = {
        zoom: 9,
        center: origin
      };

      map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

        infowindow = new google.maps.InfoWindow();

        for(i=0; i<locations.length; i++) {
            var position = new google.maps.LatLng(locations[i][2], locations[i][3]);
            var marker = new google.maps.Marker({
                position: position,
                map: map,
            });
            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    infowindow.setContent(locations[i][1]);
                    infowindow.setOptions({maxWidth: 200});
                    infowindow.open(map, marker);
                }
            }) (marker, i));
            Markers[locations[i][4]] = marker;
        }

        locate(0);

    }

    function locate(marker_id) {
        var myMarker = Markers[marker_id];
        var markerPosition = myMarker.getPosition();
        map.setCenter(markerPosition);
        google.maps.event.trigger(myMarker, 'click');
    }

    google.maps.event.addDomListener(window, 'load', initialize);

    </script>
    <body id="map-canvas">
