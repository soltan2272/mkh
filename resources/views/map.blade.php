@extends('layout.layout')
@section('content')

 <style>
  /* Set the size of the div element that contains the map */
  #map {
   height: 400px;  /* The height is 400 pixels */
   width: 100%;  /* The width is the width of the web page */
  }
 </style>
<!--The div element for the map -->
<div id="map"></div>
<script type="text/javascript">

    function initMap() {
        // The location of Uluru
        var uluru = {lat: 27.377788, lng: 31.098221};
        // The map, centered at Uluru
        var map = new google.maps.Map(
            document.getElementById('map'), {zoom: 7, center: uluru});
        // The marker, positioned at Uluru
    //    var marker = new google.maps.Marker({position: uluru, map: map});

        var locations = [
                @foreach($locations as $location)
                @foreach($location as $loc)
            ['{{$loc->address}}', {{$loc->lat}}, {{$loc->lang}}
            ],
            // ['Coogee Beach', 27.1955446, 31.1756373],
            // ['Cronulla Beach', 27.2053315, 31.1945828],
            // ['Manly Beach', 27.2027018, 31.1952399],
            @endforeach
            @endforeach

        ];

        var infowindow = new google.maps.InfoWindow();

        var i=0;
        var t=0;
       // for (i = 0; i < locations.length; i++) {


         var marker=[];
         var arr1=[];
         var arr2=[];
         var arr3=[];
        @forEach($cat as $c)
            @if($c==1)

                if(! arr1.includes(locations[i][0])) {
                marker[i] = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][1] + t / 1500, locations[i][2] + t),
                map: map,
                icon: 'http://maps.google.com/mapfiles/ms/icons/green-dot.png'
            });
            arr1.push(locations[i][0]);
        }
            @elseif($c==2)
            if(! arr2.includes(locations[i][0])) {
                marker[i] = new google.maps.Marker({
                    position: new google.maps.LatLng(locations[i][1] + t, locations[i][2] + t),
                    map: map,

                });
                arr2.push(locations[i][0]);
            }
              @else
            if(! arr3.includes(locations[i][0])) {
                marker[i] = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][1] + t, locations[i][2] + t),
                map: map,
                icon: 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png'
            });
            arr3.push(locations[i][0]);
        }
        @endif
            i+=1;
            t+=0.0185;
        @endforeach
    //}




       /* google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
                infowindow.setContent(locations[i][0]);
                infowindow.open(map, marker);
            }
        })(marker, i));*/
    }
</script>
<!--Load the API from the specified URL
* The async attribute allows the browser to render the page while the API loads
* The key parameter will contain your own API key (which is not needed for this tutorial)
* The callback parameter executes the initMap() function
-->
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAtxTjUI11VOLaFVnOVYd5cYW3o0e0_cxQ&callback=initMap">
</script>
</body>
@foreach($home as $h)
  @endforeach
@endsection