<?php
/**
 * Created by Khang Nguyen.
 * Email: nguyennhukhangvn@gmail.com
 * Date: 7/30/2017
 * Time: 4:58 PM
 */
?>
<div id="map"></div>
<script type="text/javascript">
	function initMap() {
		var uluru = {lat: <?=$product->Latitude?>, lng: <?=$product->Longitude?>};
		var infoWindow = new google.maps.InfoWindow;
		var map = new google.maps.Map(document.getElementById('map'), {
			zoom: 17,
			center: uluru
		});

		var marker = new google.maps.Marker({
			position: uluru,
			map: map,
			label: 'K'
		});

		var infowincontent = document.createElement('div');
		var strong = document.createElement('strong');
		strong.textContent = '<?=$product->Address?>';
		infowincontent.appendChild(strong);
		infowincontent.appendChild(document.createElement('br'));

		marker.addListener('click', function() {
			infoWindow.setContent(infowincontent);
			infoWindow.open(map, marker);
		});

		google.maps.event.addListener(map, 'click', function(event) {
			updateCoordinators('<?=$product->ProductID?>', event.latLng.lng(), event.latLng.lat());
			marker.setPosition(event.latLng);
		});

		// Open by default
		infoWindow.setContent(infowincontent);
		infoWindow.open(map, marker);
	}
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?=GOOGLE_MAP_KEY?>&callback=initMap"></script>
