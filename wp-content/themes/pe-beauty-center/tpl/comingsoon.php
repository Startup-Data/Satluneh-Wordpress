<?php 
/*--------------------------------------------------------------
Copyright (C) pixelemu.com
License: https://www.pixelemu.com/company/license PixelEmu Proprietary Use License
Website: https://www.pixelemu.com
Support: info@pixelemu.com
---------------------------------------------------------------*/

$otdateFormat = ot_get_option( 'coming-soon-date' );
$comingsoondateFormat = date('j F Y h:i:s', strtotime($otdateFormat));

?>

<!DOCTYPE html>

<html <?php language_attributes(); // language attributes ?>>

    <head>

        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); // address pingback ?>">
        <!--[if lt IE 9]>
            <script src="<?php echo get_template_directory_uri(); ?>/js/html5shiv.js"></script>
        <![endif]-->
        
        <?php 
            $favicon = ot_get_option( 'favicon' );

        if($favicon) { ?>

            <link rel="icon" href="<?php echo esc_url( $favicon ); ?>" type="image/x-icon" />
            <link rel="shortcut icon" href="<?php echo esc_url( $favicon ); ?>" type="image/x-icon" />    

        <?php } ?>

        <?php get_template_part( 'tpl/analyticstracking' ); ?>

        <?php wp_head(); ?>
    </head>

    <body class="coming-soon">
        <!-- Begin of main page -->
        <div id="pe-main">
            <div id="pe-coming-soon">
                <div class="container-fluid">
                    <div id="pe-logo">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php echo esc_url( ot_get_option( 'logo' ) ); ?>" alt="<?php bloginfo( 'name' ); ?>"></a>
                    </div>

                    <?php if(is_active_sidebar('coming-soon-sidebar')) : ?>
                    <div id="pe-coming-module">
                        <?php if ( ! dynamic_sidebar( __('ComingSoon','PixelEmu') )) : endif; ?>
                    </div>
                    <?php endif; ?>

                    <!-- Begin of Count Down -->
                    <div id="countdown">
                        <p class="d">
                            <span class="days">00</span>
                            <span class="timeRefDays"><?php _e('days', 'PixelEmu'); ?></span>
                        </p>

                        <p>
                            <span class="hours">00</span>
                            <span class="timeRefHours"><?php _e('hours', 'PixelEmu'); ?></span>
                        </p>

                        <p>
                            <span class="minutes">00</span>
                            <span class="timeRefMinutes"><?php _e('minutes', 'PixelEmu'); ?></span>
                        </p>

                        <p>
                            <span class="seconds">00</span>
                            <span class="timeRefSeconds"><?php _e('seconds', 'PixelEmu'); ?></span>
                        </p>
                    </div>
                    <!-- End of Count Down -->

                </div>
            </div>
        </div>

        <!-- Count Down Script -->
        <script type="text/javascript">
            /*
            * Basic Count Down to Date and Time
            * Author: @mrwigster / trulycode.com
            */
            (function (e) {
                e.fn.countdown = function (t, n) {
                function i() {
                    eventDate = Date.parse(r.date) / 1e3;
                    currentDate = Math.floor(e.now() / 1e3);
                    if (eventDate <= currentDate) {
                        n.call(this);
                        clearInterval(interval)
                    }
                    seconds = eventDate - currentDate;
                    days = Math.floor(seconds / 86400);
                    seconds -= days * 60 * 60 * 24;
                    hours = Math.floor(seconds / 3600);
                    seconds -= hours * 60 * 60;
                    minutes = Math.floor(seconds / 60);
                    seconds -= minutes * 60;
                    days == 1 ? thisEl.find(".timeRefDays").text("day") : thisEl.find(".timeRefDays").text("days");
                    hours == 1 ? thisEl.find(".timeRefHours").text("hour") : thisEl.find(".timeRefHours").text("hours");
                    minutes == 1 ? thisEl.find(".timeRefMinutes").text("minute") : thisEl.find(".timeRefMinutes").text("minutes");
                    seconds == 1 ? thisEl.find(".timeRefSeconds").text("second") : thisEl.find(".timeRefSeconds").text("seconds");
                    if (r["format"] == "on") {
                        days = String(days).length >= 2 ? days : "0" + days;
                        hours = String(hours).length >= 2 ? hours : "0" + hours;
                        minutes = String(minutes).length >= 2 ? minutes : "0" + minutes;
                        seconds = String(seconds).length >= 2 ? seconds : "0" + seconds
                    }
                    if (!isNaN(eventDate)) {
                        thisEl.find(".days").text(days);
                        thisEl.find(".hours").text(hours);
                        thisEl.find(".minutes").text(minutes);
                        thisEl.find(".seconds").text(seconds)
                    } else {
                        alert("Invalid date. Example: 30 Tuesday 2013 15:50:00");
                        clearInterval(interval)
                    }
                }
                var thisEl = e(this);
                var r = {
                    date: null,
                    format: null
                };
                t && e.extend(r, t);
                i();
                interval = setInterval(i, 1e3)
                }
                })(jQuery);
                jQuery(document).ready(function () {
                function e() {
                    var e = new Date;
                    e.setDate(e.getDate() + 60);
                    dd = e.getDate();
                    mm = e.getMonth() + 1;
                    y = e.getFullYear();
                    futureFormattedDate = mm + "/" + dd + "/" + y;
                    return futureFormattedDate
                }
                jQuery("#countdown").countdown({
                    date: "<?php echo $comingsoondateFormat; ?>",
                    format: "on"
                });
            });
        </script>

    <?php wp_footer(); ?>

    </body>

</html>