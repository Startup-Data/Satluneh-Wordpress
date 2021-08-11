<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

if ( ! class_exists( 'PEshortcodes' ) ) {
	class PEshortcodes {

		static $instance = null;
		public static $data;

		/**
		 * Get instance
		 * @return object
		 */
		public static function instance() {
			if ( self::$instance === null ) {
				self::$instance = new PEshortcodes();
			}

			return self::$instance;
		}

		function __construct() {

			$this->prepareData();
			add_action( 'media_buttons', array( $this, 'addMediaButton' ), 15 );
			add_action( 'admin_enqueue_scripts', array( $this, 'addScripts' ) );
			add_action( 'admin_footer', array( $this, 'addModal' ) );
			add_action( 'in_widget_form', array( $this, 'addWidgetButton' ), 1, 3 );

		}

		public function prepareData() {
			self::$data = array(

				'row' => array(
					'name'        => __( 'Grid', 'pe-terraclassic-plugin' ),
					'description' => __( 'This shortcode allows you to display a grid with row and columns.', 'pe-terraclassic-plugin' ),
					'params'      => array(
						'margin' => array(
							__( 'number 1 or 0', 'pe-terraclassic-plugin' ),
							__( "Enter '1' to enable or '0' to disable the horizontal gutter between columns.", 'pe-terraclassic-plugin' ),
							'string'
						),
						'class'  => array(
							__( 'custom css class', 'pe-terraclassic-plugin' ),
							__( 'Enter a custom CSS class name. Such a class may be useful to add custom styles for the row.', 'pe-terraclassic-plugin' ),
							'string'
						),
					),
					'example'     => '[row] ... [/row]',
					'endtag'      => true,
				),

				'col' => array(
					'name'        => __( 'Column', 'pe-terraclassic-plugin' ),
					'description' => __( 'This shortcode allows you to display a column in the grid.', 'pe-terraclassic-plugin' ),
					'params'      => array(
						'size'   => array(
							__( 'number 1 to 12', 'pe-terraclassic-plugin' ),
							__( 'Enter a number from 1 to 12. It controls the width of the column according to the Bootstrap grid size. The sum of the numbers in a row should be equal to 12.', 'pe-terraclassic-plugin' ),
							'string'
						),
						'screen' => array(
							__( 'xs, md or lg', 'pe-terraclassic-plugin' ),
							__( "Enter a class name to control the column size for specified devices. 'xs' - for extra small devices (<768px), 'md' - for medium devices (≥992px), 'lg' - for large devices (≥1200px).", 'pe-terraclassic-plugin' ),
							'string'
						),
						'class'  => array(
							__( 'custom css class', 'pe-terraclassic-plugin' ),
							__( 'Enter a custom CSS class name. Such a class may be useful to add custom styles for the column.', 'pe-terraclassic-plugin' ),
							'string'
						),
					),
					'example'     => '[col size="12"] ... [/col]',
					'default'     => array(
						'size'   => '12',
						'screen' => 'md',
					),
					'endtag'      => true,
					'parent'      => 'row',
				),

				'testimonial' => array(
					'name'        => __( 'Testimonial', 'pe-terraclassic-plugin' ),
					'description' => __( 'This shortcode allows you to display a testimonial.', 'pe-terraclassic-plugin' ),
					'params'      => array(
						'title'    => array(
							__( 'text or empty', 'pe-terraclassic-plugin' ),
							__( 'Enter a title or author name for the testimonial.', 'pe-terraclassic-plugin' ),
							'string'
						),
						'subtitle' => array(
							__( 'text or empty', 'pe-terraclassic-plugin' ),
							__( 'Enter a subtitle or author description for the testimonial.', 'pe-terraclassic-plugin' ),
							'string'
						),
						'class'    => array(
							__( 'custom css class', 'pe-terraclassic-plugin' ),
							__( 'Enter a custom CSS class name. Such a class may be useful to add custom styles for the testimonial.', 'pe-terraclassic-plugin' ),
							'string'
						),
					),
					'example'     => '[testimonial class="right" title="bill gates" subtitle="famous visionary"] Nunc at pellentesque... [/testimonial]',
					'endtag'      => true,
				),

				'pevideo' => array(
					'name'        => __( 'Video', 'pe-terraclassic-plugin' ),
					'description' => __( 'This shortcode allows you to display a video.', 'pe-terraclassic-plugin' ),
					'params'      => array(
						'id'   => array(
							__( 'ID of video', 'pe-terraclassic-plugin' ),
							__( "Enter an ID of the video. An example ID for a YouTube video is: 'jYjw-GDPZt8'. An example ID for a Vimeo video is: '6199030'.", 'pe-terraclassic-plugin' ),
							'string'
						),
						'web'  => array(
							__( 'youtube / vimeo', 'pe-terraclassic-plugin' ),
							__( "Enter a name of the video host service. 'youtube' - for a Youtube video. 'vimeo' - for a Vimeo video.", 'pe-terraclassic-plugin' ),
							'string'
						),
						'fs'   => array(
							__( '1 / 0', 'pe-terraclassic-plugin' ),
							__( "Enter '1' to enable or '0' to disable the fullscreen mode.", 'pe-terraclassic-plugin' ),
							'string'
						),
						'size' => array(
							__( 'number 1 to 12', 'pe-terraclassic-plugin' ),
							__( 'Enter a number from 1 to 12. It controls the width of the video according to the Bootstrap grid size.', 'pe-terraclassic-plugin' ),
							'string'
						),
					),
					'example'     => '[row][pevideo id="Hq8SzbapPkA" web="youtube" fs="1" size="4"][pevideo id="74195893" web="vimeo" fs="1" size="4"][pevideo id="_XwrAefrCxc" web="youtube" fs="0" size="4"][/row][row][pevideo id="dtncYXTbjOk" web="youtube" fs="1" size="6"][pevideo id="hIhXtoyN_6A" web="youtube" fs="1" size="6"][/row]',
					'endtag'      => false,
				),

				'pegallery' => array(
					'name'        => __( 'Image Gallery', 'pe-terraclassic-plugin' ),
					'description' => __( 'This shortcode allows you to display an image gallery.', 'pe-terraclassic-plugin' ),
					'params'      => array(
						'orderby' => array(
							__( 'none / ID / author / title / date / modified / parent / rand / comment_count / menu_order / post__in', 'pe-terraclassic-plugin' ),
							__( "Enter an image order option. Allowed order options: 'none', 'ID', 'author', 'title', 'date', 'modified', 'parent', 'rand', 'comment_count', 'menu_order', 'post__in'.", 'pe-terraclassic-plugin' ),
							'string'
						),
						'order'   => array(
							__( 'ASC / DESC', 'pe-terraclassic-plugin' ),
							__( "Enter ordering direction 'ASC' or 'DESC'.", 'pe-terraclassic-plugin' ),
							'string'
						),
						'id'      => array(
							__( 'image ID', 'pe-terraclassic-plugin' ),
							__( 'Enter an image ID. You will find the ID number in Media Manager.', 'pe-terraclassic-plugin' ),
							'string'
						),
						'columns' => array(
							__( 'number 1 to 12', 'pe-terraclassic-plugin' ),
							__( 'Enter a number from 1 to 12 according to the Bootstrap grid size.', 'pe-terraclassic-plugin' ),
							'string'
						),
						'size'    => array(
							__( 'full / medium / thumbnail (image size)', 'pe-terraclassic-plugin' ),
							__( "Enter an image thumbnail name. Default options: 'full', 'medium', 'thumbnail'.", 'pe-terraclassic-plugin' ),
							'string'
						),
						'link'    => array(
							__( 'URL with http://', 'pe-terraclassic-plugin' ),
							__( 'Enter a URL address of the link. The URL address should begin with http://. For example: http://yourdomain.com/path/', 'pe-terraclassic-plugin' ),
							'string'
						),
						'modal'   => array(
							__( 'enable / disable', 'pe-terraclassic-plugin' ),
							__( "Enter 'enable' to enable or 'disable' to disable displaying of full-sized image in modal window.", 'pe-terraclassic-plugin' ),
							'string'
						),
					),
					'example'     => '[pegallery modal="enable" size="full" columns="3" ids="2172, 2173, 2174, 2175, 2176, 2177" orderby="rand"]',
					'endtag'      => false,
				),

				'map' => array(
					'name'        => __( 'Map', 'pe-terraclassic-plugin' ),
					'description' => __( 'This shortcode allows you to display a Google Map.', 'pe-terraclassic-plugin' ),
					'params'      => array(
						'address'           => array(
							__( 'text or empty', 'pe-terraclassic-plugin' ),
							__( 'Enter a location address. This area will be displayed on the map.', 'pe-terraclassic-plugin' ),
							'string'
						),
						'latitude'          => array(
							__( 'number', 'pe-terraclassic-plugin' ),
							__( "Enter geographical coordinates (latitude) of the location. Example: '54.6043595'.", 'pe-terraclassic-plugin' ),
							'string'
						),
						'longitude'         => array(
							__( 'number', 'pe-terraclassic-plugin' ),
							__( "Enter geographical coordinates (longitude) of the location. Example: '18.2353667'.", 'pe-terraclassic-plugin' ),
							'string'
						),
						'width'             => array(
							__( 'PX or %', 'pe-terraclassic-plugin' ),
							__( "Enter the map size (width) in px or %. For example: '300px'.", 'pe-terraclassic-plugin' ),
							'string'
						),
						'height'            => array(
							__( 'PX or %', 'pe-terraclassic-plugin' ),
							__( "Enter the map size (height) in px or %. For example: '300px'.", 'pe-terraclassic-plugin' ),
							'string'
						),
						'enablescrollwheel' => array(
							__( 'true / false', 'pe-terraclassic-plugin' ),
							__( "Enter 'true' to enable or 'false' to disable zoom-in or zoom-out of the map using a scroll wheel.", 'pe-terraclassic-plugin' ),
							'string'
						),
						'disablecontrols'   => array(
							__( 'ture / false', 'pe-terraclassic-plugin' ),
							__( "Enter 'true' to enable or 'false' to disable control buttons on the map.", 'pe-terraclassic-plugin' ),
							'string'
						),
						'zoom'              => array(
							__( 'number (0 - 23)', 'pe-terraclassic-plugin' ),
							__( 'Enter the default map zoom. Valid numbers from 0 to 23.', 'pe-terraclassic-plugin' ),
							'string'
						),
						'tooltip'           => array(
							__( 'text or empty', 'pe-terraclassic-plugin' ),
							__( 'Enter a text to display in a tooltip on the map or leave empty.', 'pe-terraclassic-plugin' ),
							'string'
						),
					),
					'example'     => '[map address="New York City"]',
					'endtag'      => false,
				),

				'headline' => array(
					'name'        => __( 'Headline', 'pe-terraclassic-plugin' ),
					'description' => __( 'This shortcode allows you to display a headline with an animated effect.', 'pe-terraclassic-plugin' ),
					'params'      => array(
						'subtitle' => array(
							__( 'coma separated text', 'pe-terraclassic-plugin' ),
							__( 'Enter coma separated words. These words will be rotated with an animated effect.', 'pe-terraclassic-plugin' ),
							'string'
						),
						'class'    => array(
							__( 'custom css class', 'pe-terraclassic-plugin' ),
							__( 'Enter a custom CSS class name. Such a class may be useful to add custom styles for the headline.', 'pe-terraclassic-plugin' ),
							'string'
						),
						'style'    => array(
							__( 'custom css styles', 'pe-terraclassic-plugin' ),
							__( "Enter inline CSS styles for the headline. For example: 'padding: 10px 0; font-size: 20px;'.", 'pe-terraclassic-plugin' ),
							'string'
						),
					),
					'example'     => '[headline subtitle="reliability, experience, effectiveness"] Lorem ipsum dolor sit amet: [/headline]',
					'endtag'      => true,
				),

				'icontext' => array(
					'name'        => __( 'Icontext', 'pe-terraclassic-plugin' ),
					'description' => __( 'This shortcode allows you to display a text with a FontAwesome icon and link.', 'pe-terraclassic-plugin' ),
					'params'      => array(
						'title' => array(
							__( 'text', 'pe-terraclassic-plugin' ),
							__( 'Enter a text that will be displayed along with the icon.', 'pe-terraclassic-plugin' ),
							'string'
						),
						'icon'  => array(
							__( 'font Awesome class', 'pe-terraclassic-plugin' ),
							__( "Enter a FontAwesome icon class name. For example: 'fa-arrow-right'.", 'pe-terraclassic-plugin' ),
							'string'
						),
						'link'  => array(
							__( 'URL with http://', 'pe-terraclassic-plugin' ),
							__( 'Enter a URL address of the link. The URL address should begin with http://. For example: http://yourdomain.com/path/', 'pe-terraclassic-plugin' ),
							'string'
						),
					),
					'example'     => '[icontext link="#" title="Lorem ipsum dolor sit amet" icon="fa-coffee"] Lorem ipsum dolor... [/icontext]',
					'endtag'      => true,
				),

				'readmore' => array(
					'name'        => __( 'Readmore', 'pe-terraclassic-plugin' ),
					'description' => __( 'This shortcode allows you to display a text readmore button.', 'pe-terraclassic-plugin' ),
					'params'      => array(
						'icon' => array(
							__( 'font Awesome class', 'pe-terraclassic-plugin' ),
							__( "Enter a FontAwesome icon class name. For example: 'fa-arrow-right'.", 'pe-terraclassic-plugin' ),
							'string'
						),
						'link' => array(
							__( 'URL with http://', 'pe-terraclassic-plugin' ),
							__( 'Enter a URL address of the link. The URL address should begin with http://. For example: http://yourdomain.com/path/', 'pe-terraclassic-plugin' ),
							'string'
						),
						'type' => array(
							__( 'empty or large', 'pe-terraclassic-plugin' ),
							__( "Enter 'large' to display a large readmore button. For standard size leavy empty.", 'pe-terraclassic-plugin' ),
							'string'
						),
					),
					'example'     => '[readmore link="#" icon="fa-arrow-right"] Lorem ipsum dolor [/readmore]',
					'endtag'      => true,
				),

				'accordion' => array(
					'name'        => __( 'Accordion', 'pe-terraclassic-plugin' ),
					'description' => __( 'This shortcode allows you to display accordion panels.', 'pe-terraclassic-plugin' ),
					'example'     => '[accordion][accordion_content title="Accordion 1" status="active"] Ut lectus felis... [/accordion_content][accordion_content title="Accordion 2"] Ut lectus felis... [/accordion_content][accordion_content title="Accordion 3"] Ut lectus felis... [/accordion_content][/accordion]',
					'endtag'      => true,
				),

				'accordion_content' => array(
					'name'        => __( 'Accordion item', 'pe-terraclassic-plugin' ),
					'description' => __( "This shortcode displays an accordion item. It must be placed inside the 'Accordion', do not drag & drop the 'Accordion item' outside the 'Accordion', otherwise it will not work properly.", 'pe-terraclassic-plugin' ),
					'params'      => array(
						'title'  => array(
							__( 'text', 'pe-terraclassic-plugin' ),
							__( 'Enter an accordion title.', 'pe-terraclassic-plugin' ),
							'string'
						),
						'status' => array(
							__( 'text active for active panel', 'pe-terraclassic-plugin' ),
							__( "Enter 'active' for the 'Accordion item' which you want to be activated on start.", 'pe-terraclassic-plugin' ),
							'string'
						),
					),
					'endtag'      => true,
					'parent'      => 'accordion',
				),

				'tabs' => array(
					'name'        => __( 'Tabs', 'pe-terraclassic-plugin' ),
					'description' => __( 'This shortcode allows you to display tabs.', 'pe-terraclassic-plugin' ),
					'example'     => '[tabs][tab title="Tab 1" status="active"] Sed fringilla purus... [/tab][tab title="Tab 2"] Maecenas laoreet, ligula... [/tab][tab title="Tab 3"] Pellentesque sodales elit... [/tab][/tabs]',
					'endtag'      => true,
				),

				'tab' => array(
					'name'        => __( 'Tab item', 'pe-terraclassic-plugin' ),
					'description' => __( "This shortcode displays a tab item. It must be placed inside the 'Tabs', do not drag & drop the 'Tab item' outside the 'Tabs', otherwise it will not work properly.", 'pe-terraclassic-plugin' ),
					'params'      => array(
						'title'  => array(
							__( 'text', 'pe-terraclassic-plugin' ),
							__( 'Enter a tab title.', 'pe-terraclassic-plugin' ),
							'string'
						),
						'status' => array(
							__( 'text active for active panel', 'pe-terraclassic-plugin' ),
							__( "Enter 'active' for the 'Tab item' which you want to be activated on start.", 'pe-terraclassic-plugin' ),
							'string'
						),
					),
					'endtag'      => true,
					'parent'      => 'tabs',
				),

				'table' => array(
					'name'        => __( 'Table', 'pe-terraclassic-plugin' ),
					'description' => __( 'This shortcode allows you to display a table.', 'pe-terraclassic-plugin' ),
					'params'      => array(
						'width'  => array(
							__( 'width in PX or %', 'pe-terraclassic-plugin' ),
							__( "Enter the width of the table in px or %. For example: '300px'.", 'pe-terraclassic-plugin' ),
							'string'
						),
						'size'   => array(
							__( 'cell(s) width in PX or % (coma separated)', 'pe-terraclassic-plugin' ),
							__( "Enter the width of the table cell(s) in px or % (coma separated). For example: '50px, 50px'.", 'pe-terraclassic-plugin' ),
							'string'
						),
						'head'   => array(
							__( 'true / false (table heading display)', 'pe-terraclassic-plugin' ),
							__( "Enter 'true' to enable or 'false' to disable the table heading.", 'pe-terraclassic-plugin' ),
							'string'
						),
						'fixed'  => array(
							__( 'true / false (table fixed layout)', 'pe-terraclassic-plugin' ),
							__( "Enter 'true' to enable or 'false' to disable the table fixed layout.", 'pe-terraclassic-plugin' ),
							'string'
						),
						'center' => array(
							__( 'true / false (table text align center)', 'pe-terraclassic-plugin' ),
							__( "Enter 'true' to enable or 'false' to disable the center alignement for the table cells.", 'pe-terraclassic-plugin' ),
							'string'
						),
					),
					'example'     => '
[table width="100%" head="true"]
Your title | ipsum | dolor | sit
content | lorem | ipsum | dolor
sit | amet | consectetur | adipiscing
tempus | lacinia | scelerisque | porttitor
laoreet | ultricies | diam | eget
arcu | molestie | dapibus | sollicitudin
[/table]',
					'endtag'      => true,
				),

				'pricing' => array(
					'name'        => __( 'Pricing table', 'pe-terraclassic-plugin' ),
					'description' => __( 'This shortcode allows you to display pricing table.', 'pe-terraclassic-plugin' ),
					'params'      => array(
						'img'          => array(
							__( 'URL to image with http://', 'pe-terraclassic-plugin' ),
							__( 'Enter a URL address of the image. The URL address should begin with http://. For example: http://yourdomain.com/path/', 'pe-terraclassic-plugin' ),
							'string'
						),
						'title'        => array(
							__( 'text', 'pe-terraclassic-plugin' ),
							__( 'Enter a title.', 'pe-terraclassic-plugin' ),
							'string'
						),
						'price'        => array(
							__( 'number', 'pe-terraclassic-plugin' ),
							__( 'Enter a price.', 'pe-terraclassic-plugin' ),
							'string'
						),
						'before_price' => array(
							__( 'text or currency', 'pe-terraclassic-plugin' ),
							__( 'Enter a text or currency for the price. It appears before the price.', 'pe-terraclassic-plugin' ),
							'string'
						),
						'after_price'  => array(
							__( 'text or currency', 'pe-terraclassic-plugin' ),
							__( 'Enter a text or currency for the price. It appears after the price.', 'pe-terraclassic-plugin' ),
							'string'
						),
						'sub'          => array(
							__( 'text', 'pe-terraclassic-plugin' ),
							__( 'Enter a text that will be displayed after the price and currency.', 'pe-terraclassic-plugin' ),
							'string'
						),
						'button_name'  => array(
							__( 'text', 'pe-terraclassic-plugin' ),
							__( 'Enter a text of the button.', 'pe-terraclassic-plugin' ),
							'string'
						),
						'url'          => array(
							__( 'URL with http://', 'pe-terraclassic-plugin' ),
							__( 'Enter a URL address of the button link. The URL address should begin with http://. For example: http://yourdomain.com/path/', 'pe-terraclassic-plugin' ),
							'string'
						),
						'highlight'    => array(
							__( 'true / false', 'pe-terraclassic-plugin' ),
							__( "Enter 'true' to enable or 'false' to disable the highlight effect for the pricing table.", 'pe-terraclassic-plugin' ),
							'string'
						),
						'class'        => array(
							__( 'custom css class', 'pe-terraclassic-plugin' ),
							__( 'Enter a custom CSS class name. Such a class may be useful to add custom styles for the pricing table.', 'pe-terraclassic-plugin' ),
							'string'
						),
					),
					'example'     => '[pricing img="http://placehold.it/480x360" title="LOREM" price="49" before_price="$" sub="PER ONE HOUR" button_name="buy now!" url="#" ]Lorem ipsum dolor sit amet | Consectetur adipiscing elit | Lorem ipsum dolor sit amet[/pricing]',
					'endtag'      => true,
				),

				'fa' => array(
					'name'        => __( 'Fontawesome', 'pe-terraclassic-plugin' ),
					'description' => __( 'This shortcode allows you to display a FontAwesome icon.', 'pe-terraclassic-plugin' ),
					'params'      => array(
						'class' => array(
							__( 'font Awesome class', 'pe-terraclassic-plugin' ),
							__( "Enter a FontAwesome icon class name. For example: 'fa-arrow-right'.", 'pe-terraclassic-plugin' ),
							'string'
						),
					),
					'example'     => '[fa] fa-user fa-3x [/fa]',
					'endtag'      => true,
				),

				'counter' => array(
					'name'        => __( 'Counter', 'pe-terraclassic-plugin' ),
					'description' => __( 'This shortcode allows you to display a counter.', 'pe-terraclassic-plugin' ),
					'params'      => array(
						'icon'   => array(
							__( 'font Awesome class', 'pe-terraclassic-plugin' ),
							__( "Enter a FontAwesome icon class name. For example: 'fa-arrow-right'.", 'pe-terraclassic-plugin' ),
							'string'
						),
						'size'   => array(
							__( 'font size', 'pe-terraclassic-plugin' ),
							__( "Enter a font size with unit. For example: '16px' or '1em'.", 'pe-terraclassic-plugin' ),
							'string'
						),
						'number' => array(
							__( 'number', 'pe-terraclassic-plugin' ),
							__( 'Enter a number to count.', 'pe-terraclassic-plugin' ),
							'string'
						),
						'unit'   => array(
							__( 'text', 'pe-terraclassic-plugin' ),
							__( 'Enter a unit of the number to count.', 'pe-terraclassic-plugin' ),
							'string'
						),
						'link'   => array(
							__( 'URL with http://', 'pe-terraclassic-plugin' ),
							__( 'Enter a URL address of the title link. The URL address should begin with http://. For example: http://yourdomain.com/path/', 'pe-terraclassic-plugin' ),
							'string'
						),
						'title'  => array(
							__( 'text', 'pe-terraclassic-plugin' ),
							__( 'Enter a title of the counter.', 'pe-terraclassic-plugin' ),
							'string'
						),
					),
					'example'     => '[counter number="24" unit="K" title="COFFEES"]',
					'endtag'      => false,
				),

				'anibox' => array(
					'name'        => __( 'Animated box', 'pe-terraclassic-plugin' ),
					'description' => __( 'This shortcode allows you to display an image and its description with an animated CSS3 effect.', 'pe-terraclassic-plugin' ),
					'params'      => array(
						'title'      => array(
							__( 'text', 'pe-terraclassic-plugin' ),
							__( 'Enter a title for the animated box.', 'pe-terraclassic-plugin' ),
							'string'
						),
						'subtitle'   => array(
							__( 'text', 'pe-terraclassic-plugin' ),
							__( 'Enter a subtitle for the animated box. It appears when hovering over the image.', 'pe-terraclassic-plugin' ),
							'string'
						),
						'effect'     => array(
							__( 'saddie / goliath / julia / marley', 'pe-terraclassic-plugin' ),
							__( "Enter a name of the animated effect. You can choose from: 'saddie', 'goliath', 'julia' and 'marley'.", 'pe-terraclassic-plugin' ),
							'string'
						),
						'background' => array(
							__( 'URL to image with http://', 'pe-terraclassic-plugin' ),
							__( 'Enter a URL address of the image. The URL address should begin with http://. For example: http://yourdomain.com/path/', 'pe-terraclassic-plugin' ),
							'string'
						),
						'fontcolor'  => array(
							__( 'color value (HEX)', 'pe-terraclassic-plugin' ),
							__( "Enter a font color value in HEX. For example: '#000000'", 'pe-terraclassic-plugin' ),
							'string'
						),
						'width'      => array(
							__( 'size in PX', 'pe-terraclassic-plugin' ),
							__( "Enter the width of the animated box in px. For example: '300px'.", 'pe-terraclassic-plugin' ),
							'string'
						),
						'height'     => array(
							__( 'size in PX', 'pe-terraclassic-plugin' ),
							__( "Enter the height of the animated box in px. For example: '300px'.", 'pe-terraclassic-plugin' ),
							'string'
						),
						'link'       => array(
							__( 'URL with http://', 'pe-terraclassic-plugin' ),
							__( "'Enter a URL address of the link. The URL address should begin with http://. For example: http://yourdomain.com/path/'", 'pe-terraclassic-plugin' ),
							'string'
						),
						'target'     => array(
							__( '_self / _blank', 'pe-terraclassic-plugin' ),
							__( "Enter '_self' to open the link in the same window or '_blank' to open the link in a new window.", 'pe-terraclassic-plugin' ),
							'string'
						),
					),
					'example'     => '[anibox effect="sadie" background="http://placehold.it/480x360" fontcolor="#000000" width="480" height="360" link="#" title="Example Title" subtitle="Lorem ipsum dolor sit amet."]',
					'endtag'      => false,
				),

				'br' => array(
					'name'        => __( 'Separator', 'pe-terraclassic-plugin' ),
					'description' => __( 'This shortcode allows you to display a separator.', 'pe-terraclassic-plugin' ),
					'example'     => '[br]',
					'endtag'      => false,
				),

			);
		}

		function shortcodeList() {

			echo '<div class="shortcodes-header"><h2>' . __( 'Shortcodes generator', 'pe-terraclassic-plugin' ) . '</h2>';
			echo '<p class="shortcodes-subtitle">' . __( 'Drag & drop or click the item to create a shortcode.', 'pe-terraclassic-plugin' ) . '</p></div>';

			echo '<div class="shortcodes-container cf"><div class="left-column">';
			echo '<ul class="pe-shortcodes-items cf">';
			foreach ( self::$data as $shortcode => $data ) {

				$param_class = ( ! empty( $data['params'] ) ) ? 'shortcode-toggle' : 'shortcode-toggle no-params';

				//default array to object
				if ( ! empty( $data['default'] ) ) {
					$default_array = array();
					foreach ( $data['default'] as $key => $value ) {
						$object          = new stdClass();
						$object->name    = $key;
						$object->value   = $value;
						$default_array[] = $object;
					}
					$default_params = 'data-def="' . htmlspecialchars( json_encode( $default_array ), ENT_QUOTES, 'UTF-8' ) . '"';
				} else {
					$default_params = '';
				}

				$endtag = ( isset( $data['endtag'] ) && $data['endtag'] === true ) ? 'true' : 'false';
				$parent = ( ! empty( $data['parent'] ) ) ? 'data-parent="' . $data['parent'] . '"' : '';
				$clone  = ( ! isset( $data['clone'] ) || $data['clone'] === true ) ? true : false;
				$add    = ( ! isset( $data['add'] ) || $data['add'] === true ) ? true : false;

				echo '<li data-id="0-' . $shortcode . '" data-shortcode="' . $shortcode . '" data-endtag="' . $endtag . '" ' . $parent . ' ' . $default_params . '>
							 <span><a href="#" class="' . $param_class . '">' . $data['name'] . '</a>';
				if ( $add ) {
					echo ' <a href="#" class="add" title="' . __( 'Add another item', 'pe-terraclassic-plugin' ) . '"><span class="dashicons dashicons-plus-alt"></span></a>';
				}
				if ( $clone ) {
					echo ' <a href="#" class="clone" title="' . __( 'Duplicate item', 'pe-terraclassic-plugin' ) . '"><span class="dashicons dashicons-admin-page"></span></a>';
				}
				echo '<a href="#" class="remove" title="' . __( 'Remove item', 'pe-terraclassic-plugin' ) . '"><span class="dashicons dashicons-dismiss"></span></a></span>';
				if ( isset( $data['endtag'] ) && $data['endtag'] === true ) {
					echo '<ul class="children-holder cf"></ul>';
				}
				echo '</li>';
			}
			echo '</ul>';

			echo '<label>' . __( 'Drop area', 'pe-terraclassic-plugin' ) . '</label><ul class="pe-shortcodes-drop cf"></ul>';

			echo '</div><div class="right-column">';

			echo '<div class="pe-shortcodes-content">';
			foreach ( self::$data as $shortcode => $param ) {

				$output_params  = '';
				$output_example = ( ! empty( $param['example'] ) ) ? $param['example'] : '';
				$endtag         = ( isset( $param['endtag'] ) && $param['endtag'] === true ) ? 'true' : 'false';

				if ( ! empty( $param['params'] ) ) {

					foreach ( $param['params'] as $atts => $note ) {
						$tooltip       = ( ! empty( $note[1] ) ) ? 'data-tip="' . $note[1] . '"' : '';
						$output_params .= '<li class="cf"><span class="param-left"><span class="param-name" ' . $tooltip . '>' . $atts . '</span></span><span class="param-right"><input class="shortcode-input" type="text" data-param="' . $atts . '" placeholder=""></span></li>';
					}

				}

				echo '<div class="shortcode-desc" data-shortcode="' . $shortcode . '" data-endtag="' . $endtag . '" style="display: none;">';

				if ( ! empty( $param['description'] ) ) {
					echo '<p class="desc">' . $param['description'] . '</p>';
				}

				if ( ! empty( $param['params'] ) ) {
					echo '<ul class="item-params ' . $shortcode . '-params">';
					echo $output_params;
					if ( isset( $param['endtag'] ) && $param['endtag'] === true ) {
						echo '<li><textarea class="item-content shortcode-input" data-param="content" placeholder="' . __( 'Text', 'pe-terraclassic-plugin' ) . '"></textarea></li>';
					}
					echo '</ul>';
					echo '<a href="#" class="button shortcode-save">' . __( 'Set parameters', 'pe-terraclassic-plugin' ) . '</a>';
				}

				if ( ! empty( $param['example'] ) ) {
					echo ' <a href="#" class="button shortcode-example">' . __( 'Show example', 'pe-terraclassic-plugin' ) . '</a>';
					echo '<div class="example-content" style="display: none;">' . $output_example . '</div>';
				}

				echo '</div>';
			}
			echo '</div>';
			echo '</div></div>';

		}

		function addMediaButton() {
			echo '<a href="#" class="button pe-add-shortcode" data-target="editor" data-mfp-src="#pe-shortcodes-modal">' . __( 'Add shortcodes', 'pe-terraclassic-plugin' ) . '</a>';
		}

		function addWidgetButton( $widget, $return, $instance ) {
			if ( $widget->id_base == 'text' ) {
				$field = '#widget-' . $widget->id . '-text'; //text widget
				echo '<p><a href="#" class="button pe-add-shortcode" data-target="widget" data-field="' . $field . '" data-mfp-src="#pe-shortcodes-modal">' . __( 'Add shortcodes', 'pe-terraclassic-plugin' ) . '</a></p>';
			}

			return $instance;
		}

		function addModal() {
			echo '<div id="pe-shortcodes-modal" class="mfp-modal-content mfp-with-anim mfp-hide">';
			$this->shortcodeList();
			echo '<label>' . __( 'Shortcode preview', 'pe-terraclassic-plugin' ) . '</label><textarea id="pe-shortcodes-code"></textarea>';
			echo '<div class="shortcode-buttons">';
			echo '<a href="#" class="button button-primary shortcode-use">' . __( 'Use shortcode', 'pe-terraclassic-plugin' ) . '</a> ';
			echo '<a href="#" class="button shortcode-copy">' . __( 'Copy to clipboard', 'pe-terraclassic-plugin' ) . '</a> ';
			echo '<a href="#" class="button shortcode-reset">' . __( 'Reset', 'pe-terraclassic-plugin' ) . '</a>';
			echo '</div></div>';
		}

		function addScripts() {
			wp_enqueue_style( 'pe-shortcodes', plugin_dir_url( __FILE__ ) . '/css/shortcodes.css', array(), '1.00', false );
			wp_enqueue_script( 'magnific-popup', get_template_directory_uri() . '/js/jquery.magnific-popup.min.js', array( 'jquery' ), '1.1.0', false );
			wp_enqueue_script( 'pe-sortable', plugin_dir_url( __FILE__ ) . '/js/jquery-sortable.js', array( 'jquery' ), '0.9.13', true );
			wp_enqueue_script( 'pe-shortcodes', plugin_dir_url( __FILE__ ) . '/js/shortcodes.js', array(), '1.00', false );
		}

	}
}
PEshortcodes::instance();

