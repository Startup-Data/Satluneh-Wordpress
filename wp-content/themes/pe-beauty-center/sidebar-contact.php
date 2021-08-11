<?php
/*--------------------------------------------------------------
Copyright (C) pixelemu.com
License: https://www.pixelemu.com/company/license PixelEmu Proprietary Use License
Website: https://www.pixelemu.com
Support: info@pixelemu.com
---------------------------------------------------------------*/
$map_lati = ot_get_option('map_latitude');
$map_longi = ot_get_option('map_longitude');
$map_zoom = ot_get_option('map_zoom');

$contact_address = stripslashes(ot_get_option('contact_address'));
$email_address = sanitize_email( ot_get_option('email_address') );
$email_address = is_email($email_address);

$contact_details = ot_get_option( 'contact_details', 'on' );
$contact_map = ot_get_option( 'google_map', 'on' );
$contact_form = ot_get_option('contact_form', 'on');
$side_col = 7;
if ($contact_form != 'on') {
	$side_col = 12;
}
?>
<!-- Right sidebar -->
<aside id="pe-right" class="col-md-<?php echo $side_col ?>">

    <?php if($contact_details == 'on') : ?>

    <div class="pe-module clearfix">
    <?php if (!empty($contact_address)) {
        echo $contact_address;
    } ?>
    <?php if (!empty($email_address)) { ?>
    <?php _e('e-mail', 'PixelEmu'); ?>:&nbsp;<a href="mailto:<?php echo antispambot( $email_address ); ?>" ><?php echo antispambot( $email_address ); ?></a>
    <?php } ?>
    
    </div>
    <?php endif; ?>

    <?php if($contact_map == 'on') : ?>
    <div class="pe-module clearfix">
        <div id="map_canvas" class="embed-responsive embed-responsive-4by3"></div>
        <script type="text/javascript">
            // Google Map
            function initializeContactMap() {
                var officeLocation = new google.maps.LatLng(<?php echo $map_lati; ?>, <?php echo $map_longi; ?>);
                var contactMapOptions = {
                    center: officeLocation,
                    zoom: <?php echo $map_zoom; ?>,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    scrollwheel: false
                };
                var contactMap = new google.maps.Map(document.getElementById("map_canvas"), contactMapOptions);
                var contactMarker = new google.maps.Marker({
                    position: officeLocation,
                    map: contactMap
                });
            }

            google.maps.event.addDomListener(window, "load", initializeContactMap);
        </script>
    </div>
    <?php endif; ?>
</aside>