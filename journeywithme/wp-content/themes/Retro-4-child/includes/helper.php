<?php
/* get social links */
function retro_get_social_links() {
	$social = '<ul>';
	if ( $i = op_theme_opt( 'twitter' ) )
		$social .= '<li><a href="' . esc_url( $i ) . '" target="_blank"><span class="icon retroicon-twitter"></span></a></li>';
	if ( $i = op_theme_opt( 'facebook' ) )
		$social .= '<li><a href="' . esc_url( $i ) . '" target="_blank"><span class="icon retroicon-facebook"></span></a></li>';
	if ( $i = op_theme_opt( 'google-plus' ) )
		$social .= '<li><a href="' . esc_url( $i ) . '" target="_blank"><span class="icon retroicon-gplus"></span></a></li>';
	if ( $i = op_theme_opt( 'pinterest' ) )
		$social .= '<li><a href="' . esc_url( $i ) . '" target="_blank"><span class="icon retroicon-pinterest"></span></a></li>';
	if ( $i = op_theme_opt( 'linkedin' ) )
		$social .= '<li><a href="' . esc_url( $i ) . '" target="_blank"><span class="icon retroicon-linkedin"></span></a></li>';
	if ( $i = op_theme_opt( 'dribbble' ) )
		$social .= '<li><a href="' . esc_url( $i ) . '" target="_blank"><span class="icon retroicon-dribbble"></span></a></li>';
	if ( $i = op_theme_opt( 'flickr' ) )
		$social .= '<li><a href="' . esc_url( $i ) . '" target="_blank"><span class="icon retroicon-flickr"></span></a></li>';
	if ( $i = op_theme_opt( 'tumblr' ) )
		$social .= '<li><a href="' . esc_url( $i ) . '" target="_blank"><span class="icon retroicon-tumblr"></span></a></li>';
	if ( $i = op_theme_opt( 'youtube' ) )
		$social .= '<li><a href="' . esc_url( $i ) . '" target="_blank"><span class="icon retroicon-youtube"></span></a></li>';
	if ( $i = op_theme_opt( 'instagram' ) )
		$social .= '<li><a href="' . esc_url( $i ) . '" target="_blank"><span class="icon retroicon-instagram"></span></a></li>';
	if ( $i = op_theme_opt( 'skype' ) )
		$social .= '<li><a href="' . $i . '" target="_blank"><span class="icon retroicon-skype"></span></a></li>';
	if ( $i = op_theme_opt( 'dropbox' ) )
		$social .= '<li><a href="' . esc_url( $i ) . '" target="_blank"><span class="icon retroicon-dropbox"></span></a></li>';
	if ( $i = op_theme_opt( 'github' ) )
		$social .= '<li><a href="' . esc_url( $i ) . '" target="_blank"><span class="icon retroicon-github-1"></span></a></li>';
	if ( $i = op_theme_opt( 'behance' ) )
		$social .= '<li><a href="' . esc_url( $i ) . '" target="_blank"><span class="icon retroicon-behance"></span></a></li>';
	if ( $i = op_theme_opt( 'vimeo' ) )
		$social .= '<li><a href="' . esc_url( $i ) . '" target="_blank"><span class="icon retroicon-vimeo"></span></a></li>';
	$social .= '</ul>';
	return $social;
}

?>