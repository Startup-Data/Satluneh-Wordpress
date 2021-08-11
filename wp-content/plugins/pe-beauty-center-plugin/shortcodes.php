<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

if ( !class_exists ( 'PEshortcodes' ) ) {
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
				add_action( 'media_buttons', array( $this, 'addMediaButton'), 15 );
				add_action( 'admin_enqueue_scripts', array( $this, 'addScripts' ) );
				add_action( 'admin_footer', array( $this, 'addModal' ) );
				add_action( 'in_widget_form', array( $this, 'addWidgetButton' ), 1, 3 );

		}

		public function prepareData() {
			self::$data = array(

				'row' => array(
						'name'        => __('Grid', 'PixelEmu'),
						'description' => __('This shortcode allows you to display a grid with row and columns.', 'PixelEmu'),
						'params'      => array(
							'margin' => array( __('number 1 or 0', 'PixelEmu'), __("Enter '1' to enable or '0' to disable the horizontal gutter between columns.", 'PixelEmu'), 'string' ),
							'class'  => array( __('custom css class', 'PixelEmu'), __('Enter a custom CSS class name. Such a class may be useful to add custom styles for the row.', 'PixelEmu'), 'string' ),
						),
						'example' => '[row] ... [/row]',
						'endtag' => true,
					),

				'col' => array(
						'name'        => __('Column', 'PixelEmu'),
						'description' => __('This shortcode allows you to display a column in the grid.', 'PixelEmu'),
						'params' => array(
							'size'   => array( __('number 1 to 12', 'PixelEmu'), __('Enter a number from 1 to 12. It controls the width of the column according to the Bootstrap grid size. The sum of the numbers in a row should be equal to 12.', 'PixelEmu'), 'string' ),
							'screen' => array( __('xs, md or lg', 'PixelEmu'), __("Enter a class name to control the column size for specified devices. 'xs' - for extra small devices (<768px), 'md' - for medium devices (≥992px), 'lg' - for large devices (≥1200px).", 'PixelEmu'), 'string' ),
							'class'  => array( __('custom css class', 'PixelEmu'), __('Enter a custom CSS class name. Such a class may be useful to add custom styles for the column.', 'PixelEmu'), 'string' ),
						),
						'example' => '[col size="12"] ... [/col]',
						'default' => array(
													'size'   => '12',
													'screen' => 'md',
												 ),
						'endtag' => true,
						'parent' => 'row',
					),

					'testimonial' => array(
						'name'        => __('Testimonial', 'PixelEmu'),
						'description' => __('This shortcode allows you to display a testimonial.', 'PixelEmu'),
						'params' => array(
							'title'    => array( __('text or empty', 'PixelEmu'), __('Enter a title or author name for the testimonial.', 'PixelEmu'), 'string' ),
							'subtitle' => array( __('text or empty', 'PixelEmu'), __('Enter a subtitle or author description for the testimonial.', 'PixelEmu'), 'string' ),
							'class'    => array( __('custom css class', 'PixelEmu'), __('Enter a custom CSS class name. Such a class may be useful to add custom styles for the testimonial.', 'PixelEmu'), 'string' ),
						),
						'example' => '[testimonial class="right" title="bill gates" subtitle="famous visionary"] Nunc at pellentesque... [/testimonial]',
						'endtag' => true,
					),

					'pe_video' => array(
						'name'        => __('Video', 'PixelEmu'),
						'description' => __('This shortcode allows you to display a video.', 'PixelEmu'),
						'params' => array(
							'id'   => array( __('ID of video', 'PixelEmu'), __("Enter an ID of the video. An example ID for a YouTube video is: 'jYjw-GDPZt8'. An example ID for a Vimeo video is: '6199030'.", 'PixelEmu'), 'string' ),
							'web'  => array( __('youtube / vimeo', 'PixelEmu'), __("Enter a name of the video host service. 'youtube' - for a Youtube video. 'vimeo' - for a Vimeo video.", 'PixelEmu'), 'string' ),
							'fs'   => array( __('1 / 0', 'PixelEmu'), __("Enter '1' to enable or '0' to disable the fullscreen mode.", 'PixelEmu'), 'string' ),
							'size' => array( __('number 1 to 12', 'PixelEmu'), __('Enter a number from 1 to 12. It controls the width of the video according to the Bootstrap grid size.', 'PixelEmu'), 'string' ),
						),
						'example' => '[row][pe_video id="Hq8SzbapPkA" web="youtube" fs="1" size="4"][pe_video id="74195893" web="vimeo" fs="1" size="4"][pe_video id="ixduuC4fH3E" web="youtube" fs="0" size="4"][/row][row][pe_video id="xAsF-LgqKrE" web="youtube" fs="1" size="6"][pe_video id="73847928" web="vimeo" fs="1" size="6"][/row]',
						'endtag' => false,
					),

					'gallery' => array(
						'name'        => __('Image Gallery', 'PixelEmu'),
						'description' => __('This shortcode allows you to display an image gallery.', 'PixelEmu'),
						'params' => array(
							'orderby' => array( __('none / ID / author / title / date / modified / parent / rand / comment_count / menu_order / post__in', 'PixelEmu'), __("Enter an image order option. Allowed order options: 'none', 'ID', 'author', 'title', 'date', 'modified', 'parent', 'rand', 'comment_count', 'menu_order', 'post__in'.", 'PixelEmu'), 'string' ),
							'ids'     => array( __('image ID', 'PixelEmu'), __('Enter an image ID. You will find the ID number in Media Manager.', 'PixelEmu'), 'string' ),
							'columns' => array( __('number 1 to 12', 'PixelEmu'), __('Enter a number from 1 to 12 according to the Bootstrap grid size.', 'PixelEmu'), 'string' ),
							'size'    => array( __('full / medium / thumbnail (image size)', 'PixelEmu'), __("Enter an image thumbnail name. Default options: 'full', 'medium', 'thumbnail'.", 'PixelEmu'), 'string' ),
							'pe_image_modal'   => array( __('enable / disable', 'PixelEmu'), __("Enter 'enable' to enable or 'disable' to disable displaying of full-sized image in modal window.", 'PixelEmu'), 'string' ),
						),
						'example' => '[gallery pe_image_modal="enable" size="full" columns="3" ids="2172, 2173, 2174, 2175, 2176, 2177" orderby="rand"]',
						'endtag' => false,
					),

					'accordion' => array(
						'name'        => __('Accordion', 'PixelEmu'),
						'description' => __('This shortcode allows you to display accordion panels.', 'PixelEmu'),
						'example' => '[accordion][accordion_content title="Accordion 1" status="1"] Ut lectus felis... [/accordion_content][accordion_content title="Accordion 2"] Ut lectus felis... [/accordion_content][accordion_content title="Accordion 3"] Ut lectus felis... [/accordion_content][/accordion]',
						'endtag' => true,
					),

					'accordion_content' => array(
						'name'        => __('Accordion item', 'PixelEmu'),
						'description' => __("This shortcode displays an accordion item. It must be placed inside the 'Accordion', do not drag & drop the 'Accordion item' outside the 'Accordion', otherwise it will not work properly.", 'PixelEmu'),
						'params' => array(
							'title' => array( __('text', 'PixelEmu'), __('Enter an accordion title.', 'PixelEmu'), 'string' ),
							'status' => array( __('number 1 for active panel', 'PixelEmu'), __("Enter '1' for the 'Accordion item' which you want to be activated on start.", 'PixelEmu'), 'string' ),
						),
						'endtag' => true,
						'parent' => 'accordion',
					),

					'tabs' => array(
						'name'        => __('Tabs', 'PixelEmu'),
						'description' => __('This shortcode allows you to display tabs.', 'PixelEmu'),
						'example' => '[tabs][tab title="Tab 1" status="active"] Sed fringilla purus... [/tab][tab title="Tab 2"] Maecenas laoreet, ligula... [/tab][tab title="Tab 3"] Pellentesque sodales elit... [/tab][/tabs]',
						'endtag' => true,
					),

					'tab' => array(
						'name'        => __('Tab item', 'PixelEmu'),
						'description' => __("This shortcode displays a tab item. It must be placed inside the 'Tabs', do not drag & drop the 'Tab item' outside the 'Tabs', otherwise it will not work properly.", 'PixelEmu'),
						'params' => array(
							'title' => array( __('text', 'PixelEmu'), __('Enter a tab title.', 'PixelEmu'), 'string' ),
							'status' => array( __('text active for active panel', 'PixelEmu'), __("Enter 'active' for the 'Tab item' which you want to be activated on start.", 'PixelEmu'), 'string' ),
						),
						'endtag' => true,
						'parent' => 'tabs',
					),

					'pricing_table' => array(
						'name'        => __('Pricing Table', 'PixelEmu'),
						'description' => __('This shortcode allows you to display Pricing Table.', 'PixelEmu'),
						'params' => array(
							'title' => array( __('text', 'PixelEmu'), __('Enter an table title.', 'PixelEmu'), 'string' ),
							'size' => array( __('width in PX or %', 'PixelEmu'), __("Enter the table size (width) in px or %. For example: '33%'.", 'PixelEmu'), 'string' ),
						),
						'example' => '[pricing_table title="Service 1" size="33%"][service_item service_title="Lorem ipsum dolor" service_price="$39"][service_item service_title="Donec lobortis quam" service_price="$45"][service_item service_title="Pellentesque habitant" service_price="$68"][service_item service_title="In a facilisis augue" service_price="$28"][service_item service_title="Aenean et placerat erat" service_price="$55"][service_item service_title="Nam neque massa" service_price="$78"][/pricing_table]',
						'endtag' => true,
					),

					'service_item' => array(
						'name'        => __('Table row', 'PixelEmu'),
						'description' => __("This shortcode displays an table row. It must be placed inside the 'Pricing Table', do not drag & drop the 'Table row' outside the 'Pricing Table', otherwise it will not work properly.", 'PixelEmu'),
						'params' => array(
							'service_title' => array( __('text', 'PixelEmu'), __('Enter text which will be visible in table row.', 'PixelEmu'), 'string' ),
							'service_price' => array( __('text', 'PixelEmu'), __("Enter price which will be visible in table row.", 'PixelEmu'), 'string' ),
						),
						'endtag' => false,
						'parent' => 'pricing_table',
					),

					'box' => array(
						'name'        => __('Box', 'PixelEmu'),
						'description' => __("This shortcode displays white or dark box with image", 'PixelEmu'),
						'params' => array(
							'style'    => array( __('text', 'PixelEmu'), __("Enter text 'white' for white design or 'dark' for dark design.", 'PixelEmu'), 'string' ),
							'icon'     => array( __('text', 'PixelEmu'), __("Enter text 'icon1', 'icon2' or 'icon3' to display icons (for white design only).", 'PixelEmu'), 'string' ),
							'link'     => array( __('text', 'PixelEmu'), __("Enter valid URL address with http://", 'PixelEmu'), 'string' ),
							'imgsrc'   => array( __('text', 'PixelEmu'), __("Enter image URL address. You will find URL in WordPress Media Manager.", 'PixelEmu'), 'string' ),
							'alt'      => array( __('text', 'PixelEmu'), __("Enter alt attribute for image.", 'PixelEmu'), 'string' ),
							'title'    => array( __('text', 'PixelEmu'), __("Enter text which will be used for box title.", 'PixelEmu'), 'string' ),
							'subtitle' => array( __('text', 'PixelEmu'), __("Enter text which will be used for box subtitle (for white design only).", 'PixelEmu'), 'string' ),
							'text'     => array( __('text', 'PixelEmu'), __("Enter text which will be displayed in the box (for dark design only).", 'PixelEmu'), 'string' ),
						),
						'example' => '[row][col size="4" ][box style="light" icon="icon2" link="/services/" imgsrc="/wp-content/uploads/2015/09/box1.jpg" alt="Leading Article" subtitle="Our" title="Services" price="Price from $15 to $150"][/col][col size="4" ][box style="light" icon="icon1" link="/register/" imgsrc="/wp-content/uploads/2015/09/box2.jpg" alt="Join our gym" subtitle="Join Our" title="Gym" price="Price from $8 to $230"][/col][col size="4"][box style="light" icon="icon3" link="/gallery/" imgsrc="/wp-content/uploads/2015/09/box3.jpg" alt="Watch video" subtitle="Watch" title="Video" price="For free"][/col][/row]',
						'endtag' => false,
					),

					'first_box' => array(
						'name'        => __('Animated box 1', 'PixelEmu'),
						'description' => __("This shortcode allows you to display an image and its description with animated CSS3 effect.", 'PixelEmu'),
						'params' => array(
							'imagebg'     => array( __('text', 'PixelEmu'), __('Enter image URL address. You will find URL in WordPress Media Manager.', 'PixelEmu'), 'string' ),
							'link'        => array( __('text', 'PixelEmu'), __("Enter valid URL address with http://", 'PixelEmu'), 'string' ),
							'firsttitle'  => array( __('text', 'PixelEmu'), __("Enter title text.", 'PixelEmu'), 'string' ),
							'secondtitle' => array( __('text', 'PixelEmu'), __("Enter subtitle text.", 'PixelEmu'), 'string' ),
						),
						'example' => '[first_box imagebg="http://demo.pixelemu.com/pe-beauty-center-watermark/wp-content/uploads/2015/09/animated.jpg" link="#link" firsttitle="CHECK OUR" secondtitle="NEW OFFER!"]',
						'endtag' => false,
					),

					'second_box' => array(
						'name'        => __('Animated box 2', 'PixelEmu'),
						'description' => __("This shortcode allows you to display an image and its description with animated CSS3 effect.", 'PixelEmu'),
						'params' => array(
							'imagebg'     => array( __('text', 'PixelEmu'), __('Enter image URL address. You will find URL in WordPress Media Manager.', 'PixelEmu'), 'string' ),
							'link'        => array( __('text', 'PixelEmu'), __("Enter valid URL address with http://", 'PixelEmu'), 'string' ),
							'firsttitle'  => array( __('text', 'PixelEmu'), __("Enter title text.", 'PixelEmu'), 'string' ),
							'secondtitle' => array( __('text', 'PixelEmu'), __("Enter subtitle text.", 'PixelEmu'), 'string' ),
						),
						'example' => '[second_box imagebg="http://demo.pixelemu.com/pe-beauty-center-watermark/wp-content/uploads/2015/09/animated.jpg" link="#link" firsttitle="CHECK OUR" secondtitle="NEW OFFER!"]',
						'endtag' => false,
					),

					'third_box' => array(
						'name'        => __('Animated box 3', 'PixelEmu'),
						'description' => __("This shortcode allows you to display an image and its description with animated CSS3 effect.", 'PixelEmu'),
						'params' => array(
							'imagebg'     => array( __('text', 'PixelEmu'), __('Enter image URL address. You will find URL in WordPress Media Manager.', 'PixelEmu'), 'string' ),
							'link'        => array( __('text', 'PixelEmu'), __("Enter valid URL address with http://", 'PixelEmu'), 'string' ),
							'firsttitle'  => array( __('text', 'PixelEmu'), __("Enter title text.", 'PixelEmu'), 'string' ),
							'secondtitle' => array( __('text', 'PixelEmu'), __("Enter subtitle text.", 'PixelEmu'), 'string' ),
						),
						'example' => '[third_box imagebg="http://demo.pixelemu.com/pe-beauty-center-watermark/wp-content/uploads/2015/09/animated.jpg" link="#link" firsttitle="CHECK OUR" secondtitle="NEW OFFER!"]',
						'endtag' => false,
					),

					'video_box' => array(
						'name'        => __('Animated box 4', 'PixelEmu'),
						'description' => __("This shortcode allows you to display an image and its description with animated CSS3 effect.", 'PixelEmu'),
						'params' => array(
							'imagebg' => array( __('text', 'PixelEmu'), __('Enter image URL address. You will find URL in WordPress Media Manager.', 'PixelEmu'), 'string' ),
							'link'    => array( __('text', 'PixelEmu'), __("Enter valid URL address with http://", 'PixelEmu'), 'string' ),
							'title'   => array( __('text', 'PixelEmu'), __("Enter title text.", 'PixelEmu'), 'string' ),
						),
						'example' => '[video_box imagebg="http://demo.pixelemu.com/pe-beauty-center-watermark/wp-content/uploads/2015/09/animated.jpg" alt="Animated Video box" link="#link" title="Watch the video"]',
						'endtag' => false,
					),

			);
		}

		function shortcodeList() {

			echo '<div class="shortcodes-header"><h2>' . __('Shortcodes generator', 'PixelEmu') . '</h2>';
			echo '<p class="shortcodes-subtitle">' . __('Drag & drop or click the item to create a shortcode.', 'PixelEmu') . '</p></div>';

			echo '<div class="shortcodes-container cf"><div class="left-column">';
			echo '<ul class="pe-shortcodes-items cf">';
				foreach (self::$data as $shortcode => $data) {

					$param_class = ( !empty($data['params']) ) ? 'shortcode-toggle' : 'shortcode-toggle no-params';

					//default array to object
					if( !empty($data['default']) ) {
						$default_array = array();
						foreach ($data['default'] as $key => $value) {
							$object = new stdClass();
							$object->name = $key;
							$object->value = $value;
							$default_array[] = $object;
						}
						$defob = new stdClass();
						$default_params = 'data-def="' . htmlspecialchars(json_encode($default_array), ENT_QUOTES, 'UTF-8') . '"';
					} else {
						$default_params = '';
					}

					$endtag = ( isset($data['endtag']) && $data['endtag'] === true ) ? 'true' : 'false';
					$parent = ( !empty($data['parent']) ) ? 'data-parent="' . $data['parent'] . '"' : '';
					$clone = ( !isset($data['clone']) || $data['clone'] === true ) ? true : false;
					$add = ( !isset($data['add']) || $data['add'] === true ) ? true : false;

					echo '<li data-id="0-' . $shortcode . '" data-shortcode="' . $shortcode . '" data-endtag="' . $endtag . '" ' . $parent . ' ' . $default_params . '>
							 <span><a href="#" class="' . $param_class . '">' . $data['name'] . '</a>';
					if( $add ) {
						echo ' <a href="#" class="add" title="' . __('Add another item', 'PixelEmu') . '"><span class="dashicons dashicons-plus-alt"></span></a>';
					}
					if( $clone ) {
						echo ' <a href="#" class="clone" title="' . __('Duplicate item', 'PixelEmu') . '"><span class="dashicons dashicons-admin-page"></span></a>';
					}
					echo '<a href="#" class="remove" title="' . __('Remove item', 'PixelEmu') . '"><span class="dashicons dashicons-dismiss"></span></a></span>';
					if( isset($data['endtag']) && $data['endtag'] === true ) {
						echo '<ul class="children-holder cf"></ul>';
					}
					echo '</li>';
				}
			echo '</ul>';

			echo '<label>' . __('Drop area', 'PixelEmu') . '</label><ul class="pe-shortcodes-drop cf"></ul>';

			echo '</div><div class="right-column">';

			echo '<div class="pe-shortcodes-content">';
				foreach (self::$data as $shortcode => $param) {

					$output_params = '';
					$output_example = ( !empty($param['example']) ) ? $param['example'] : '';
					$endtag = ( isset($param['endtag']) && $param['endtag'] === true ) ? 'true' : 'false';

					if( !empty($param['params']) ) {

						foreach ($param['params'] as $atts => $note ) {
							$tooltip = ( !empty($note[1]) ) ? 'data-tip="' . $note[1] . '"' : '';
							$output_params .= '<li class="cf"><span class="param-left"><span class="param-name" ' . $tooltip . '>' . $atts . '</span></span><span class="param-right"><input class="shortcode-input" type="text" data-param="' . $atts . '" placeholder=""></span></li>';
						}

					}

					echo '<div class="shortcode-desc" data-shortcode="' . $shortcode . '" data-endtag="' . $endtag . '" style="display: none;">';

						if( !empty($param['description']) ) {
							echo '<p class="desc">' . $param['description'] . '</p>';
						}

						if( !empty($param['params']) ) {
							echo '<ul class="item-params ' . $shortcode . '-params">';
								echo $output_params;
								if( isset($param['endtag']) && $param['endtag'] === true ) {
									echo '<li><textarea class="item-content shortcode-input" data-param="content" placeholder="' . __('Text', 'PixelEmu') . '"></textarea></li>';
								}
							echo '</ul>';
							echo '<a href="#" class="button shortcode-save">' . __('Set parameters', 'PixelEmu') . '</a>';
						}

						if( !empty($param['example']) ) {
							echo ' <a href="#" class="button shortcode-example">' . __('Show example', 'PixelEmu') . '</a>';
							echo '<div class="example-content" style="display: none;">' . $output_example . '</div>';
						}

					echo '</div>';
				}
			echo '</div>';
			echo '</div></div>';

		}

		function addMediaButton() {
			echo '<a href="#" class="button pe-add-shortcode" data-target="editor" data-mfp-src="#pe-shortcodes-modal">' . __('Add shortcodes', 'PixelEmu') . '</a>';
		}

		function addWidgetButton( $widget, $return, $instance ) {
			if( $widget->id_base == 'text' ) {
				$field = '#widget-' . $widget->id . '-text'; //text widget
				echo '<p><a href="#" class="button pe-add-shortcode" data-target="widget" data-field="' . $field . '" data-mfp-src="#pe-shortcodes-modal">' . __('Add shortcodes', 'PixelEmu') . '</a></p>';
			}
			return $instance;
		}

		function addModal() {
			echo '<div id="pe-shortcodes-modal" class="mfp-modal-content mfp-with-anim mfp-hide" style="display: none;">';
			$this->shortcodeList();
			echo '<label>' . __('Shortcode preview', 'PixelEmu') . '</label><textarea id="pe-shortcodes-code"></textarea>';
			echo '<div class="shortcode-buttons">';
			echo '<a href="#" class="button button-primary shortcode-use">' . __('Use shortcode', 'PixelEmu') . '</a> ';
			echo '<a href="#" class="button shortcode-copy">' . __('Copy to clipboard', 'PixelEmu') . '</a> ';
			echo '<a href="#" class="button shortcode-reset">' . __('Reset', 'PixelEmu') . '</a>';
			echo '</div></div>';
		}

		function addScripts() {
			wp_enqueue_style( 'pe-shortcodes', plugin_dir_url( __FILE__ ) . '/css/shortcodes.css', array(), '1.00', false );
			wp_enqueue_script( 'magnific-popup', plugin_dir_url( __FILE__ ) . '/js/jquery.magnific-popup.min.js', array( 'jquery' ), '1.1.0', false );
			wp_enqueue_script( 'pe-sortable', plugin_dir_url( __FILE__ ) . '/js/jquery-sortable.js', array( 'jquery' ), '0.9.13', true );
			wp_enqueue_script( 'pe-shortcodes', plugin_dir_url( __FILE__ ) . '/js/shortcodes.js', array(), '1.00', false );
		}

	}
}
PEshortcodes::instance();

