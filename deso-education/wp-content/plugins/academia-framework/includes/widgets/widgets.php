<?php
include_once( PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/widgets/g5plus-widget.php' );
include_once( PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/widgets/g5plus-acf-widget.php' );
include_once( PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/widgets/social-profile.php' );
include_once( PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/widgets/footer-logo-widget.php' );
include_once( PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/widgets/posts.php' );
include_once( PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/widgets/payment-gate.php' );
include_once( PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/widgets/myaccount.php' );
include_once( PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/widgets/free-text.php' );
include_once( PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/widgets/mailchimp.php' );

include_once( PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/widgets/course-related.php' );
include_once( PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/widgets/course.php' );
include_once( PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/widgets/course-categories.php' );



if (!function_exists('g5plus_get_social_icon')) {
	function g5plus_get_social_icon($icons,$class = '') {
		$g5plus_options = &academia_get_options_config();
		$twitter = '';
		if ( isset( $g5plus_options['twitter_url'] ) ) {
			$twitter = $g5plus_options['twitter_url'];
		}

		$facebook = '';
		if ( isset( $g5plus_options['facebook_url'] ) ) {
			$facebook = $g5plus_options['facebook_url'];
		}

		$dribbble = '';
		if ( isset( $g5plus_options['dribbble_url'] ) ) {
			$dribbble = $g5plus_options['dribbble_url'];
		}

		$vimeo = '';
		if ( isset( $g5plus_options['vimeo_url'] ) ) {
			$vimeo = $g5plus_options['vimeo_url'];
		}

		$tumblr = '';
		if ( isset( $g5plus_options['tumblr_url'] ) ) {
			$tumblr = $g5plus_options['tumblr_url'];
		}

		$skype = $g5plus_options['skype_username'];
		if ( isset( $g5plus_options['skype_username'] ) ) {
			$skype = $g5plus_options['skype_username'];
		}

		$linkedin = '';
		if ( isset( $g5plus_options['linkedin_url'] ) ) {
			$linkedin = $g5plus_options['linkedin_url'];
		}

		$googleplus = '';
		if ( isset( $g5plus_options['googleplus_url'] ) ) {
			$googleplus = $g5plus_options['googleplus_url'];
		}

		$flickr = '';
		if ( isset( $g5plus_options['flickr_url'] ) ) {
			$flickr = $g5plus_options['flickr_url'];
		}

		$youtube = '';
		if ( isset( $g5plus_options['youtube_url'] ) ) {
			$youtube = $g5plus_options['youtube_url'];
		}

		$pinterest = '';
		if ( isset( $g5plus_options['pinterest_url'] ) ) {
			$pinterest = $g5plus_options['pinterest_url'];
		}

		$foursquare = $g5plus_options['foursquare_url'];
		if ( isset( $g5plus_options['foursquare_url'] ) ) {
			$foursquare = $g5plus_options['foursquare_url'];
		}

		$instagram = '';
		if ( isset( $g5plus_options['instagram_url'] ) ) {
			$instagram = $g5plus_options['instagram_url'];
		}

		$github = '';
		if ( isset( $g5plus_options['github_url'] ) ) {
			$github = $g5plus_options['github_url'];
		}

		$xing = $g5plus_options['xing_url'];
		if ( isset( $g5plus_options['xing_url'] ) ) {
			$xing = $g5plus_options['xing_url'];
		}

		$rss = '';
		if ( isset( $g5plus_options['rss_url'] ) ) {
			$rss = $g5plus_options['rss_url'];
		}

		$behance = '';
		if ( isset( $g5plus_options['behance_url'] ) ) {
			$behance = $g5plus_options['behance_url'];
		}

		$soundcloud = '';
		if ( isset( $g5plus_options['soundcloud_url'] ) ) {
			$soundcloud = $g5plus_options['soundcloud_url'];
		}

		$deviantart = '';
		if ( isset( $g5plus_options['deviantart_url'] ) ) {
			$deviantart = $g5plus_options['deviantart_url'];
		}

		$yelp = "";
		if ( isset( $g5plus_options['yelp_url'] ) ) {
			$yelp = $g5plus_options['yelp_url'];
		}

		$email = "";
		if ( isset( $g5plus_options['email_address'] ) ) {
			$email = $g5plus_options['email_address'];
		}

		$social_icons = '<ul class="'. $class .'">';

		if ( empty( $icons ) ) {
			if ( $twitter ) {
				$social_icons .= '<li><a title="'. esc_html__('Twitter','g5plus-academia') .'" href="' . esc_url( $twitter ) . '" target="_blank"><i class="fa fa-twitter"></i>'. esc_html__('Twitter','g5plus-academia') .'</a></li>' . "\n";
			}
			if ( $facebook ) {
				$social_icons .= '<li><a title="'. esc_html__('Facebook','g5plus-academia') .'" href="' . esc_url( $facebook ) . '" target="_blank"><i class="fa fa-facebook"></i>'. esc_html__('Facebook','g5plus-academia') .'</a></li>' . "\n";
			}
			if ( $dribbble ) {
				$social_icons .= '<li><a title="'. esc_html__('Dribbble','g5plus-academia') .'" href="' . esc_url( $dribbble ) . '" target="_blank"><i class="fa fa-dribbble"></i>'. esc_html__('Dribbble','g5plus-academia') .'</a></li>' . "\n";
			}
			if ( $youtube ) {
				$social_icons .= '<li><a title="'. esc_html__('Youtube','g5plus-academia') .'" href="' . esc_url( $youtube ) . '" target="_blank"><i class="fa fa-youtube"></i>'. esc_html__('Youtube','g5plus-academia') .'</a></li>' . "\n";
			}
			if ( $vimeo ) {
				$social_icons .= '<li><a title="'. esc_html__('Vimeo','g5plus-academia') .'" href="' . esc_url( $vimeo ) . '" target="_blank"><i class="fa fa-vimeo-square"></i>'. esc_html__('Vimeo','g5plus-academia') .'</a></li>' . "\n";
			}
			if ( $tumblr ) {
				$social_icons .= '<li><a title="'. esc_html__('Tumblr','g5plus-academia') .'" href="' . esc_url( $tumblr ) . '" target="_blank"><i class="fa fa-tumblr"></i>'. esc_html__('Tumblr','g5plus-academia') .'</a></li>' . "\n";
			}
			if ( $skype ) {
				$social_icons .= '<li><a title="'. esc_html__('Skype','g5plus-academia') .'" href="skype:' . esc_attr( $skype ) . '" target="_blank"><i class="fa fa-skype"></i>'. esc_html__('Skype','g5plus-academia') .'</a></li>' . "\n";
			}
			if ( $linkedin ) {
				$social_icons .= '<li><a title="'. esc_html__('Linkedin','g5plus-academia') .'" href="' . esc_url( $linkedin ) . '" target="_blank"><i class="fa fa-linkedin"></i>'. esc_html__('Linkedin','g5plus-academia') .'</a></li>' . "\n";
			}
			if ( $googleplus ) {
				$social_icons .= '<li><a title="'. esc_html__('GooglePlus','g5plus-academia') .'" href="' . esc_url( $googleplus ) . '" target="_blank"><i class="fa fa-google-plus"></i>'. esc_html__('GooglePlus','g5plus-academia') .'</a></li>' . "\n";
			}
			if ( $flickr ) {
				$social_icons .= '<li><a title="'. esc_html__('Flickr','g5plus-academia') .'" href="' . esc_url( $flickr ) . '" target="_blank"><i class="fa fa-flickr"></i>'. esc_html__('Flickr','g5plus-academia') .'</a></li>' . "\n";
			}
			if ( $pinterest ) {
				$social_icons .= '<li><a title="'. esc_html__('Pinterest','g5plus-academia') .'" href="' . esc_url( $pinterest ) . '" target="_blank"><i class="fa fa-pinterest"></i>'. esc_html__('Pinterest','g5plus-academia') .'</a></li>' . "\n";
			}
			if ( $foursquare ) {
				$social_icons .= '<li><a title="'. esc_html__('Foursquare','g5plus-academia') .'" href="' . esc_url( $foursquare ) . '" target="_blank"><i class="fa fa-foursquare"></i>'. esc_html__('Foursquare','g5plus-academia') .'</a></li>' . "\n";
			}
			if ( $instagram ) {
				$social_icons .= '<li><a title="'. esc_html__('Instagram','g5plus-academia') .'" href="' . esc_url( $instagram ) . '" target="_blank"><i class="fa fa-instagram"></i>'. esc_html__('Instagram','g5plus-academia') .'</a></li>' . "\n";
			}
			if ( $github ) {
				$social_icons .= '<li><a title="'. esc_html__('GitHub','g5plus-academia') .'" href="' . esc_url( $github ) . '" target="_blank"><i class="fa fa-github"></i>'. esc_html__('GitHub','g5plus-academia') .'</a></li>' . "\n";
			}
			if ( $xing ) {
				$social_icons .= '<li><a title="'. esc_html__('Xing','g5plus-academia') .'" href="' . esc_url( $xing ) . '" target="_blank"><i class="fa fa-xing"></i>'. esc_html__('Xing','g5plus-academia') .'</a></li>' . "\n";
			}
			if ( $behance ) {
				$social_icons .= '<li><a title="'. esc_html__('Behance','g5plus-academia') .'" href="' . esc_url( $behance ) . '" target="_blank"><i class="fa fa-behance"></i>'. esc_html__('Behance','g5plus-academia') .'</a></li>' . "\n";
			}
			if ( $deviantart ) {
				$social_icons .= '<li><a title="'. esc_html__('Deviantart','g5plus-academia') .'" href="' . esc_url( $deviantart ) . '" target="_blank"><i class="fa fa-deviantart"></i>'. esc_html__('Deviantart','g5plus-academia') .'</a></li>' . "\n";
			}
			if ( $soundcloud ) {
				$social_icons .= '<li><a title="'. esc_html__('SoundCloud','g5plus-academia') .'" href="' . esc_url( $soundcloud ) . '" target="_blank"><i class="fa fa-soundcloud"></i>'. esc_html__('SoundCloud','g5plus-academia') .'</a></li>' . "\n";
			}
			if ( $yelp ) {
				$social_icons .= '<li><a title="'. esc_html__('Yelp','g5plus-academia') .'" href="' . esc_url( $yelp ) . '" target="_blank"><i class="fa fa-yelp"></i>'. esc_html__('Yelp','g5plus-academia') .'</a></li>' . "\n";
			}
			if ( $rss ) {
				$social_icons .= '<li><a title="'. esc_html__('rss','g5plus-academia') .'" href="' . esc_url( $rss ) . '" target="_blank"><i class="fa fa-rss"></i>'. esc_html__('rss','g5plus-academia') .'</a></li>' . "\n";
			}
			if ( $email ) {
				$social_icons .= '<li><a title="'. esc_html__('Email','g5plus-academia') .'" href="mailto:' . esc_attr( $email ) . '" target="_blank"><i class="fa fa-vk"></i>'. esc_html__('Email','g5plus-academia') .'</a></li>' . "\n";
			}
		} else {

			$social_type = explode( ',', $icons );
			if (empty($twitter)) { $twitter = '#'; }
			if (empty($facebook)) { $facebook = '#'; }
			if (empty($dribbble)) { $dribbble = '#'; }
			if (empty($youtube)) { $youtube = '#'; }
			if (empty($vimeo)) { $vimeo = '#'; }
			if (empty($tumblr)) { $tumblr = '#'; }
			if (empty($skype)) { $skype = '#'; }
			if (empty($linkedin)) { $linkedin = '#'; }
			if (empty($googleplus)) { $googleplus = '#'; }
			if (empty($flickr)) { $flickr = '#'; }
			if (empty($pinterest)) { $pinterest = '#'; }
			if (empty($foursquare)) { $foursquare = '#'; }
			if (empty($instagram)) { $instagram = '#'; }
			if (empty($github)) { $github = '#'; }
			if (empty($xing)) { $xing = '#'; }
			if (empty($behance)) { $behance = '#'; }
			if (empty($deviantart)) { $deviantart = '#'; }
			if (empty($soundcloud)) { $soundcloud = '#'; }
			if (empty($yelp)) { $yelp = '#'; }
			if (empty($rss)) { $rss = '#'; }
			if (empty($email)) { $email = '#'; }

			foreach ( $social_type as $id ) {
				if ( ( $id == 'twitter' ) && $twitter ) {
					$social_icons .= '<li><a title="'. esc_html__('Twitter','g5plus-academia') .'" href="' . esc_url( $twitter ) . '" target="_blank"><i class="fa fa-twitter"></i>'. esc_html__('Twitter','g5plus-academia') .'</a></li>' . "\n";
				}
				if ( ( $id == 'facebook' ) && $facebook ) {
					$social_icons .= '<li><a title="'. esc_html__('Facebook','g5plus-academia') .'" href="' . esc_url( $facebook ) . '" target="_blank"><i class="fa fa-facebook"></i>'. esc_html__('Facebook','g5plus-academia') .'</a></li>' . "\n";
				}
				if ( ( $id == 'dribbble' ) && $dribbble ) {
					$social_icons .= '<li><a title="'. esc_html__('Dribbble','g5plus-academia') .'" href="' . esc_url( $dribbble ) . '" target="_blank"><i class="fa fa-dribbble"></i>'. esc_html__('Dribbble','g5plus-academia') .'</a></li>' . "\n";
				}
				if ( ( $id == 'youtube' ) && $youtube ) {
					$social_icons .= '<li><a title="'. esc_html__('Youtube','g5plus-academia') .'" href="' . esc_url( $youtube ) . '" target="_blank"><i class="fa fa-youtube"></i>'. esc_html__('Youtube','g5plus-academia') .'</a></li>' . "\n";
				}
				if ( ( $id == 'vimeo' ) && $vimeo ) {
					$social_icons .= '<li><a title="'. esc_html__('Vimeo','g5plus-academia') .'" href="' . esc_url( $vimeo ) . '" target="_blank"><i class="fa fa-vimeo-square"></i>'. esc_html__('Vimeo','g5plus-academia') .'</a></li>' . "\n";
				}
				if ( ( $id == 'tumblr' ) && $tumblr ) {
					$social_icons .= '<li><a title="'. esc_html__('Tumblr','g5plus-academia') .'" href="' . esc_url( $tumblr ) . '" target="_blank"><i class="fa fa-tumblr"></i>'. esc_html__('Tumblr','g5plus-academia') .'</a></li>' . "\n";
				}
				if ( ( $id == 'skype' ) && $skype ) {
					$social_icons .= '<li><a title="'. esc_html__('Skype','g5plus-academia') .'" href="skype:' . esc_attr( $skype ) . '" target="_blank"><i class="fa fa-skype"></i>'. esc_html__('Skype','g5plus-academia') .'</a></li>' . "\n";
				}
				if ( ( $id == 'linkedin' ) && $linkedin ) {
					$social_icons .= '<li><a title="'. esc_html__('Linkedin','g5plus-academia') .'" href="' . esc_url( $linkedin ) . '" target="_blank"><i class="fa fa-linkedin"></i>'. esc_html__('Linkedin','g5plus-academia') .'</a></li>' . "\n";
				}
				if ( ( $id == 'googleplus' ) && $googleplus ) {
					$social_icons .= '<li><a title="'. esc_html__('GooglePlus','g5plus-academia') .'" href="' . esc_url( $googleplus ) . '" target="_blank"><i class="fa fa-google-plus"></i>'. esc_html__('GooglePlus','g5plus-academia') .'</a></li>' . "\n";
				}
				if ( ( $id == 'flickr' ) && $flickr ) {
					$social_icons .= '<li><a title="'. esc_html__('Flickr','g5plus-academia') .'" href="' . esc_url( $flickr ) . '" target="_blank"><i class="fa fa-flickr"></i>'. esc_html__('Flickr','g5plus-academia') .'</a></li>' . "\n";
				}
				if ( ( $id == 'pinterest' ) && $pinterest ) {
					$social_icons .= '<li><a title="'. esc_html__('Pinterest','g5plus-academia') .'" href="' . esc_url( $pinterest ) . '" target="_blank"><i class="fa fa-pinterest"></i>'. esc_html__('Pinterest','g5plus-academia') .'</a></li>' . "\n";
				}
				if ( ( $id == 'foursquare' ) && $foursquare ) {
					$social_icons .= '<li><a title="'. esc_html__('Foursquare','g5plus-academia') .'" href="' . esc_url( $foursquare ) . '" target="_blank"><i class="fa fa-foursquare"></i>'. esc_html__('Foursquare','g5plus-academia') .'</a></li>' . "\n";
				}
				if ( ( $id == 'instagram' ) && $instagram ) {
					$social_icons .= '<li><a title="'. esc_html__('Instagram','g5plus-academia') .'" href="' . esc_url( $instagram ) . '" target="_blank"><i class="fa fa-instagram"></i>'. esc_html__('Instagram','g5plus-academia') .'</a></li>' . "\n";
				}
				if ( ( $id == 'github' ) && $github ) {
					$social_icons .= '<li><a title="'. esc_html__('GitHub','g5plus-academia') .'" href="' . esc_url( $github ) . '" target="_blank"><i class="fa fa-github"></i>'. esc_html__('GitHub','g5plus-academia') .'</a></li>' . "\n";
				}
				if ( ( $id == 'xing' ) && $xing ) {
					$social_icons .= '<li><a title="'. esc_html__('Xing','g5plus-academia') .'" href="' . esc_url( $xing ) . '" target="_blank"><i class="fa fa-xing"></i>'. esc_html__('Xing','g5plus-academia') .'</a></li>' . "\n";
				}
				if ( ( $id == 'behance' ) && $behance ) {
					$social_icons .= '<li><a title="'. esc_html__('Behance','g5plus-academia') .'" href="' . esc_url( $behance ) . '" target="_blank"><i class="fa fa-behance"></i>'. esc_html__('Behance','g5plus-academia') .'</a></li>' . "\n";
				}
				if ( ( $id == 'deviantart' ) && $deviantart ) {
					$social_icons .= '<li><a title="'. esc_html__('Deviantart','g5plus-academia') .'" href="' . esc_url( $deviantart ) . '" target="_blank"><i class="fa fa-deviantart"></i>'. esc_html__('Deviantart','g5plus-academia') .'</a></li>' . "\n";
				}
				if ( ( $id == 'soundcloud' ) && $soundcloud ) {
					$social_icons .= '<li><a title="'. esc_html__('SoundCloud','g5plus-academia') .'" href="' . esc_url( $soundcloud ) . '" target="_blank"><i class="fa fa-soundcloud"></i>'. esc_html__('SoundCloud','g5plus-academia') .'</a></li>' . "\n";
				}
				if ( ( $id == 'yelp' ) && $yelp ) {
					$social_icons .= '<li><a title="'. esc_html__('Yelp','g5plus-academia') .'" href="' . esc_url( $yelp ) . '" target="_blank"><i class="fa fa-yelp"></i>'. esc_html__('Yelp','g5plus-academia') .'</a></li>' . "\n";
				}
				if ( ( $id == 'rss' ) && $rss ) {
					$social_icons .= '<li><a title="'. esc_html__('Rss','g5plus-academia') .'" href="' . esc_url( $rss ) . '" target="_blank"><i class="fa fa-rss"></i>'. esc_html__('Rss','g5plus-academia') .'</a></li>' . "\n";
				}
				if ( ( $id == 'email' ) && $email ) {
					$social_icons .= '<li><a title="'. esc_html__('Email','g5plus-academia') .'" href="mailto:' . esc_attr( $email ) . '" target="_blank"><i class="fa fa-vk"></i>'. esc_html__('Email','g5plus-academia') .'</a></li>' . "\n";
				}
			}
		}

		$social_icons .= '</ul>';

		return $social_icons;
	}
}
