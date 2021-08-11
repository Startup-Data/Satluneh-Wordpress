<?php
/*--------------------------------------------------------------
Copyright (C) pixelemu.com
License: https://www.pixelemu.com/company/license PixelEmu Proprietary Use License
Website: https://www.pixelemu.com
Support: info@pixelemu.com
---------------------------------------------------------------*/
?>
<?php

if( !class_exists('PE_Team_Carousel') ){

class PE_Team_Carousel extends WP_Widget {

		function __construct() {
			$widget_ops = array( 'classname' => 'PE_Team_Carousel', 'description' => __('Display Team Members carousel.','PixelEmu') );
			parent::__construct( 'PE_Team_Carousel', __('PE Team Carousel','PixelEmu'), $widget_ops );
		}
	    function PE_Team_Carousel()
	    {
	        self::__construct();
	    }
	
		function widget($args, $instance) {
	
			extract($args);
	
			$title = apply_filters('widget_title', $instance['title']);
	
			if ( empty($title) ) $title = false;
	
			$select_view = $instance['select_view'];
			$avatar_size = $instance['avatar_size'];
			if(isset($instance['members_ids'])){
				$members_ids = $instance['members_ids'];
			}
			$total_to_show = $instance['total_to_show'];
			$members_per_row = $instance['members_per_row'];
			$desc_limit =  $instance['desc_limit'];
			$member_name = ( $instance['member_name'] === 1 ) ? true : false;
			$member_profession = ( $instance['member_profession'] === 1 ) ? true : false;
			$member_avatar = ( $instance['member_avatar'] === 1 ) ? true : false;
			$member_desc = ( $instance['member_desc'] === 1 ) ? true : false;
			$social_icon = ( $instance['social_icon'] === 1 ) ? true : false;
	
	
			if ($members_per_row > 12 || $members_per_row < 1 ){
				$members_per_row = 12;
			}
	
			$col_number = floor(12 / $members_per_row);
			$two_rows = ( $members_per_row * 2 );
			if ($members_per_row == 1) {
				$two_rows == 2;
			}
			$desc_float = 'pull-left';
			if ( $member_desc ) {
				$desc_float = '';
			}
			
			// make an array from members IDs
			if(!empty($members_ids)){
				$post_in = explode(',', $members_ids);
				$count_post_in = count($post_in);
				// prevent wrong number of selected user IDs if user writes comma at the end of input
				if(end($post_in) == ''){
					$count_post_in = $count_post_in - 1;
				}
				if($total_to_show > $count_post_in){
					$total_to_show = $count_post_in;
				}
			} else{
				$post_in = '';
			}
			
			$member_args = array(
				'post_type' => 'member',
				'posts_per_page' => $total_to_show,
				'post__in' => $post_in
			);
	
			$member_query = new WP_Query($member_args);
	
			echo $before_widget;
	
			if($title):
				echo $before_title;
				echo $title;
				echo $after_title;
			endif;
	
			if($member_query->have_posts()): ?>
	
			<?php if ($select_view==1) : ?>
			<?php $show_indicators = ( $total_to_show > $two_rows ) ? 'show-indicators' : ''; ?>

			<!-- Team slider -->
			<div id="pe-team-carousel" class="carousel slide <?php echo $show_indicators; ?>" data-ride="carousel" data-interval="false">
			<?php if ( $total_to_show > $two_rows ) {
			
			$i = 0; ?>
				<!-- Indicators -->
				<ol class="carousel-indicators">
				<?php
					while ($member_query -> have_posts()) : $member_query -> the_post();
					$i++;
					if (($i % $two_rows == 1) || $two_rows == 1) {
						if ($i == 1) {
							echo "<li data-target='#pe-team-carousel' data-slide-to='0' class='active'></li>";
						} else {
							echo "<li data-target='#pe-team-carousel' data-slide-to='" . ($i - 1) / $two_rows . "'></li>";
						}
					}
					endwhile;
				?>
				</ol>
				<?php } ?>
	
				<!-- Wrapper for slides -->
				<div class="carousel-inner" role="listbox">
				<?php
					$counter = 0;
					while($member_query->have_posts()): $member_query->the_post();
					$counter++;
				?>
				<?php if ($counter % $two_rows == 1) { ?>
					<?php if ($counter == 1) { ?>
					<div class="item active">
						<div class="pe-avatar-box">
							<div class="row">
					<?php } else { ?>
					<div class="item">
						<div class="pe-avatar-box">
							<div class="row">
					<?php } ?>
				<?php } ?>
	
					<div class="col-md-<?php echo $col_number; ?>">
						<div class="pe-avatar-item clearfix">
							<?php if($member_avatar && has_post_thumbnail()) { ?>
							<div class="image">
								<a href="<?php the_permalink(); ?>">
								<?php
									if ($avatar_size == 1) {
										the_post_thumbnail('member-carousel-small');
									} elseif ($avatar_size == 2) {
										the_post_thumbnail('member-carousel-large');
									}
								?>
								</a>
							</div>
							<?php } ?>
							<div class="description <?php echo $desc_float ?>">
								<?php if ( $member_name ) : ?>
								<span class="title"><a href="<?php the_permalink(); ?>"> <?php the_title(); ?> </a></span>
								<?php endif; ?>
								<?php if ( $member_profession ) : ?>
								<span class="subtitle"> <?php echo get_post_meta(get_the_ID(), 'member_position', true); ?> </span>
								<?php endif; ?>
								<?php if ( $member_desc ) : ?>
								<span class="text"><?php pe_excerpt($desc_limit); ?></span>
								<?php endif ?>
								<?php 
								$member_fb = get_post_meta(get_the_ID(), 'member_fb',true);
								$member_tw = get_post_meta(get_the_ID(), 'member_tw',true);
								$member_li = get_post_meta(get_the_ID(), 'member_li',true); 
								if ( $social_icon && (!empty($member_fb) || ($member_tw) || ($member_li) ) ) { ?>
								<span class="social">
									<?php if (!empty( $member_fb )) { ?>
									<a class="facebook" href="<?php echo $member_fb ?>">&nbsp;</a>
									<?php } ?>
									<?php if (!empty( $member_tw )) { ?>
									<a class="twitter" href="<?php echo $member_tw ?>">&nbsp;</a>
									<?php } ?>
									<?php if (!empty( $member_li )) { ?>
									<a class="link" href="<?php echo $member_li ?>">&nbsp;</a>
									<?php } ?>
								</span>
								<?php } ?>
							</div>
						</div>
					</div>
	
					<?php if ($counter % $two_rows == 0) { ?>
							</div>
						</div>
					</div>
					<?php } ?>
	
					<?php endwhile; ?>
	
					<?php if ((($counter % $two_rows) != 0) && ($counter >= $two_rows)) { ?>
								</div>
							</div>
						</div>
					<?php } ?>
						</div>
					</div>
					<?php endif; ?>
	
					<?php if ($select_view==2) : ?>
					<div class="pe-meet-our-team">
					<?php
						$counter = 0;
						while($member_query->have_posts()): $member_query->the_post();
						$counter++;
					?>
					<?php if ($members_per_row == 1) {
						if ($counter % $members_per_row == 0){ ?>
							<div class="row">
						<?php } ?>
					<?php } else {
						 if (($counter % $members_per_row == 1)) { ?>
							<div class="row">
						<?php }
					} ?>
						<div class="col-md-<?php echo $col_number; ?>">
							<div class="pe-box">
								<span class="image">
								<?php
									if ($member_avatar && has_post_thumbnail()) {
										if ($avatar_size == 1) {
											the_post_thumbnail('member-grid-small');
										} elseif ($avatar_size == 2) {
											the_post_thumbnail('member-grid-large');
										}
									} 
								?>
								<?php 
									$member_fb = get_post_meta(get_the_ID(), 'member_fb',true);
									$member_tw = get_post_meta(get_the_ID(), 'member_tw',true);
									$member_li = get_post_meta(get_the_ID(), 'member_li',true); 
									if ( $social_icon && (!empty($member_fb) || ($member_tw) || ($member_li) ) ) { 
								?>
										<span class="social">
										<?php if (!empty( $member_fb )) {?>
											<a class="facebook" href="<?php echo $member_fb ?>">&nbsp;</a>
										<?php } ?>
										<?php if (!empty( $member_tw )) {?>
											<a class="twitter" href="<?php echo $member_tw ?>">&nbsp;</a>
										<?php } ?>
										<?php if (!empty( $member_li )) {?>
											<a class="link" href="<?php echo $member_li ?>">&nbsp;</a>
										<?php } ?>
										</span>
								<?php } ?>
								</span>
								<a class="member-link" href="<?php the_permalink(); ?>">
									<span class="description">
									<?php if ( $member_name ) : ?>
										<span class="title"><?php the_title(); ?></span>
									<?php endif; ?>
									<?php if ( $member_profession ) : ?>
										<span class="subtitle"><?php echo get_post_meta(get_the_ID(), 'member_position', true); ?></span>
									<?php endif; ?>
									<?php if ( $member_desc ) : ?>
										<span class="text"><?php pe_excerpt($desc_limit); ?></span>
									<?php endif ?>
									</span>
								</a>
							</div>
						</div>
	
					<?php if ( $counter % $members_per_row == 0 ) { ?>
						</div>
					<?php } ?>
					<?php endwhile; ?>
					<?php if ((($counter % $members_per_row) != 0) && ($counter >= $members_per_row)) { ?>
						</div>
					<?php } ?>
						</div>
					<?php endif; ?>
					<?php wp_reset_query(); else: ?>
					<ul class="members-not-found">
					<?php
						echo '<li>';
							_e('No Members Found!', 'PixelEmu');
						echo '</li>';
					?>
					</ul>
			<?php endif;
			echo $after_widget;
		}
	
		function form($instance) {
	
			$instance = wp_parse_args( (array) $instance, array(
				'title'				=> 'MEET OUR TEAM',
				'select_view'		=> 1,
				'avatar_size'		=> 1,
				'members_ids'		=> '',
				'total_to_show'		=> 4,
				'members_per_row'	=> 2,
				'desc_limit'		=> 10,
				'member_name'		=> 1,
				'member_profession'	=> 1,
				'member_avatar'		=> 1,
				'member_desc'		=> 1,
				'social_icon'		=> 1,
				)
			);
	
			$title= esc_attr($instance['title']);
			$select_view = $instance['select_view'];
			$avatar_size = $instance['avatar_size'];
			$members_ids = $instance['members_ids'];
			$total_to_show = $instance['total_to_show'];
			$members_per_row =  $instance['members_per_row'];
			$desc_limit =  $instance['desc_limit'];
			$member_name = ( $instance['member_name'] === 1 ) ? true : false;
			$member_profession = ( $instance['member_profession'] === 1 ) ? true : false;
			$member_avatar = ( $instance['member_avatar'] === 1 ) ? true : false;
			$member_desc = ( $instance['member_desc'] === 1 ) ? true : false;
			$social_icon = ( $instance['social_icon'] === 1 ) ? true : false;
		?>
	
			<p>
				<label for="<?php echo $this -> get_field_id('title'); ?>"><?php _e('Widget Title', 'PixelEmu'); ?></label>
				<input class="widefat" id="<?php echo $this -> get_field_id('title'); ?>" name="<?php echo $this -> get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
			</p>
			<p>
				<label for="<?php echo $this -> get_field_id('select_view'); ?>"><?php _e('Select View', 'PixelEmu'); ?></label>
				<select class="widefat" id="<?php echo $this -> get_field_id('select_view'); ?>" name="<?php echo $this -> get_field_name('select_view'); ?>" style="width:100%;">
					<option value='1'<?php echo($select_view == '1') ? 'selected' : ''; ?>><?php _e('Carousel View', 'PixelEmu'); ?></option>
					<option value='2'<?php echo($select_view == '2') ? 'selected' : ''; ?>><?php _e('Grid View', 'PixelEmu'); ?></option>
				</select>
			</p>
			<p>
				<label for="<?php echo $this -> get_field_id('avatar_size'); ?>"><?php _e('Select image size', 'PixelEmu'); ?></label>
				<select class="widefat" id="<?php echo $this -> get_field_id('avatar_size'); ?>" name="<?php echo $this -> get_field_name('avatar_size'); ?>" style="width:100%;">
					<option value='1'<?php echo($avatar_size == '1') ? 'selected' : ''; ?>><?php _e('Small Image', 'PixelEmu'); ?></option>
					<option value='2'<?php echo($avatar_size == '2') ? 'selected' : ''; ?>><?php _e('Large Image', 'PixelEmu'); ?></option>
				</select>
			</p>
			<p>
				<label for="<?php echo $this -> get_field_id('members_ids'); ?>"><?php _e('IDs of members to show (separated by the comma):<br /><strong>Enter only if you want to show specific members.</strong>', 'PixelEmu'); ?></label>
				<input id="<?php echo $this -> get_field_id('members_ids'); ?>" name="<?php echo $this -> get_field_name('members_ids'); ?>" type="text" value="<?php echo $members_ids; ?>" style="width:100%;" />
			</p>
			<p>
				<label for="<?php echo $this -> get_field_id('total_to_show'); ?>"><?php _e('Number of Members', 'PixelEmu'); ?></label>
				<input id="<?php echo $this -> get_field_id('total_to_show'); ?>" name="<?php echo $this -> get_field_name('total_to_show'); ?>" type="text" value="<?php echo $total_to_show; ?>" size="3" />
			</p>
			<p>
				<label for="<?php echo $this -> get_field_id('members_per_row'); ?>"><?php _e('Number of Members in Row', 'PixelEmu'); ?></label>
				<input id="<?php echo $this -> get_field_id('members_per_row'); ?>" name="<?php echo $this -> get_field_name('members_per_row'); ?>" type="text" value="<?php echo $members_per_row; ?>" size="3" />
			</p>
			<p>
				<label for="<?php echo $this -> get_field_id('desc_limit'); ?>"><?php _e('Member description limit', 'PixelEmu'); ?></label>
				<input id="<?php echo $this -> get_field_id('desc_limit'); ?>" name="<?php echo $this -> get_field_name('desc_limit'); ?>" type="text" value="<?php echo $desc_limit; ?>" size="3" />
			</p>
			<p>
				<input class="checkbox" id="<?php echo $this -> get_field_id('social_icon'); ?>" name="<?php echo $this -> get_field_name('social_icon'); ?>" type="checkbox" <?php checked($social_icon, 1); ?>/>
				<label for="<?php echo $this -> get_field_id('social_icon'); ?>"><?php _e('Show Social Icons.', 'PixelEmu'); ?></label>
			</p>
			<p>
				<input class="checkbox" id="<?php echo $this -> get_field_id('member_name'); ?>" name="<?php echo $this -> get_field_name('member_name'); ?>" type="checkbox" <?php checked($member_name, 1); ?>/>
				<label for="<?php echo $this -> get_field_id('member_name'); ?>"><?php _e('Show Member Name.', 'PixelEmu'); ?></label>
			</p>
			<p>
				<input class="checkbox" id="<?php echo $this -> get_field_id('member_profession'); ?>" name="<?php echo $this -> get_field_name('member_profession'); ?>" type="checkbox" <?php checked($member_profession, 1); ?>/>
				<label for="<?php echo $this -> get_field_id('member_profession'); ?>"><?php _e('Show Member Profession.', 'PixelEmu'); ?></label>
			</p>
			<p>
				<input class="checkbox" id="<?php echo $this -> get_field_id('member_avatar'); ?>" name="<?php echo $this -> get_field_name('member_avatar'); ?>" type="checkbox" <?php checked($member_avatar, 1); ?>/>
				<label for="<?php echo $this -> get_field_id('member_avatar'); ?>"><?php _e('Show Member Avatar.', 'PixelEmu'); ?></label>
			</p>
			<p>
				<input class="checkbox" id="<?php echo $this -> get_field_id('member_desc'); ?>" name="<?php echo $this -> get_field_name('member_desc'); ?>" type="checkbox" <?php checked($member_desc, 1); ?>/>
				<label for="<?php echo $this -> get_field_id('member_desc'); ?>"><?php _e('Show Member Description.', 'PixelEmu'); ?></label>
			</p>
	<?php }
	
		function update($new_instance, $old_instance) {
			$instance = $old_instance;
		
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['select_view'] = $new_instance['select_view'];
			$instance['avatar_size'] = $new_instance['avatar_size'];
			$instance['members_ids'] = $new_instance['members_ids'];
			$instance['total_to_show'] = $new_instance['total_to_show'];
			$instance['members_per_row'] = $new_instance['members_per_row'];
			$instance['desc_limit'] = $new_instance['desc_limit'];
			$instance['member_name'] = isset( $new_instance['member_name'] ) ? 1 : 0;
			$instance['member_profession'] = isset( $new_instance['member_profession'] ) ? 1 : 0;
			$instance['member_avatar'] = isset( $new_instance['member_avatar'] ) ? 1 : 0;
			$instance['member_desc'] = isset( $new_instance['member_desc'] ) ? 1 : 0;
			$instance['social_icon'] = isset( $new_instance['social_icon'] ) ? 1 : 0;
		
			return $instance;
		}

	}
}
?>