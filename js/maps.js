var map;
function initialize()
{
    var myLatlng1 = new google.maps.LatLng(53.65914, 0.072050);

    var mapOptions = 
    {
        zoom: 10,
        center: myLatlng1,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var map = new google.maps.Map(document.getElementById('mapholder'),
    mapOptions);


    <?php
        $sql = mysql_query("SELECT * FROM data ORDER BY ID DESC");
        while($row =mysql_fetch_array($sql))
        {
            $desc = $row['DESCRIPTION'];
            $location = $row['LOCATION'];
            $counter += 1; 
        ?>

    var marker = new google.maps.Marker({
        position: new google.maps.LatLng(<?php echo $location; ?>),
        map: map,
        title: '<?php echo $desc; ?>',
        icon: '/image/cam.png'
    });

   navigator.geolocation.getCurrentPosition(showPosition);  
}

var showPosition = function (position) 
   {
       map.setCenter(new google.maps.LatLng(position.coords.latitude, position.coords.longitude), 16);

   }

google.maps.event.addDomListener(window, 'load', initialize);

