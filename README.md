# Google-Maps-API-with-PHP-MySQL
A Snippet of code to help you in Google Maps API. In this Script PHP Array and MySQL is used to store Latitude and Longitude. This script is made for those who needs a Map with Multiple Markers which changes it's Position Dynamically. In other words, This is made for people who need t a Map solution for Uber Like Application


<h2>Array Creation</h2>
<code>$locations=array();</code>

This Part of the Code Snippet creates an Array called $locations without giving any input on Creation

<h2>Connection Establishment and Array Data Feeding</h2>

        $uname="root";

        $pass="";
        
        $servername="localhost";
        
        $dbname="bcremote";
        
        $db=new mysqli($servername,$uname,$pass,$dbname);
        
        $query =  $db->query("SELECT * FROM location where work='$work'");
        
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

This Part of the Code Snippet establishes an Secure Connection with MySQL Database in which I have created a Table Containing Latitude and Logitude. 
It also contains an OnClick Link as <code>$link</code>. This is a Link that's going to be placed inside the Infowindow
All the Fetched Data's are Converted into an Array within the While loop to ensure Zero Errors.


<h1>Checking Whether the data is feeded or not</h1>

       //echo $locations[0]['name'].": In stock: ".$locations[0]['lat'].", sold: ".$locations[0]['lng'].".<br>";
       //echo $locations[1]['name'].": In stock: ".$locations[1]['lat'].", sold: ".$locations[1]['lng'].".<br>";
       
Before Executing the Whole Script you can try Un Commenting these two Lines of Code to see whether it has Data's or Not. It would be safer because once after Executing the Whole Script if you get any errors it would be very Confusing. So do this First to prevent such scenarios


<h1>Initializing Google Maps API</h1>


    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAfFN8NuvYyNkewBVMsk9ZNIcUWDEqHg2U"></script> 
    <script type="text/javascript">
    var map;
    var Markers = {};
    var infowindow;
    

The Heading would have explained you what's done here. But for better understanding I would like to Explain It. In this particular Snippet of code, We're calling Google Maps API and creating Some Useful and Important Variables in JS.


<h1>Feeding PHP datas to Javascript Array</h1>


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

    
In this part of code, We are creating an Javascript array with PHP Array's Data. In the first line we have created an Variable called Locations in the second line a For Loop is created with sizeof Function to determine the Length of     $locations     array. After the creation of loop we have created a variable called $J to determine whether it's the final Data or Not. We're checking this in order to prevent future JS array Mishandle Bugs. In other words, We're checking this to remove the comma-quotation(,) in the final Data


<h1>Finalized Code</h1>


    <?php
            $locations=array();
            $work=$_GET["service"];
            $uname="root";
            $pass="";
            $servername="localhost";
            $dbname="bcremote";
            $db=new mysqli($servername,$uname,$pass,$dbname);
            $query =  $db->query("SELECT * FROM location where work='$work'");
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
        <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAfFN8NuvYyNkewBVMsk9ZNIcUWDEqHg2U"></script> 
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
        
        
This Code Helped you? Don't forget to give a Star to appreciate my Work. Also feel free to post any bugs in this code. I will try to resolve it.
