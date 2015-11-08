<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!-- Icons -->
    <link href="scripts/icons/general/stylesheets/general_foundicons.css" media="screen" rel="stylesheet" type="text/css" />  
    <link href="scripts/icons/social/stylesheets/social_foundicons.css" media="screen" rel="stylesheet" type="text/css" />
    <!--[if lt IE 8]>
        <link href="scripts/icons/general/stylesheets/general_foundicons_ie7.css" media="screen" rel="stylesheet" type="text/css" />
        <link href="scripts/icons/social/stylesheets/social_foundicons_ie7.css" media="screen" rel="stylesheet" type="text/css" />
    <![endif]-->

    <link href="http://fonts.googleapis.com/css?family=Chewy" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Abel" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Terminal+Dosis+Light" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Maven+Pro" rel="stylesheet" type="text/css">

    <title>closest</title>
</head>
<body>
	<div class="span8" id="mapholder" style="margin-left:20%"></div>
</body>
<script type="text/javascript">
	var iframe    = document.createElement("iframe");
	iframe.width  = "80%";
	iframe.height = "800px";	
	// document.body.appendChild(iframe);
	document.getElementById("mapholder").appendChild(iframe);
	var doc = iframe.contentWindow || iframe.contentDocument;
	if (doc.document) { doc = doc.document;}

	var func = "function showNewMap() { "+
	    "var mapContainer =  document.createElement('div');"+
	    "mapContainer.setAttribute('style','width: 100%; height: 100%');"+
	    "document.body.appendChild(mapContainer);"+

	    "var mapOptions = {"+ 
	    "    center: new google.maps.LatLng(52.3427658, 4.8216493),"+
	    "    zoom: 15,"+
	    "   mapTypeId: google.maps.MapTypeId.ROADMAP"+
	    "};"+

	    "var map = new google.maps.Map(mapContainer,mapOptions);"+
	"}";

	var scriptMap = doc.createElement('script');
	scriptMap.type = 'text/javascript';
	var newContent = document.createTextNode(func);
	scriptMap.appendChild(newContent);
	doc.getElementsByTagName('head')[0].appendChild(scriptMap);

	var script = doc.createElement('script');
	script.type = 'text/javascript';
	script.src = 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=true&' +'callback=window.showNewMap';
	doc.getElementsByTagName('head')[0].appendChild(script);
</script>

</html>
