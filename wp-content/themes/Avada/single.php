<?php
/**
 * Template used for single posts and other post-types
 * that don't have a specific template.
 *
 * @package Avada
 * @subpackage Templates
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
<?php get_header(); ?>

<section id="content" <?php Avada()->layout->add_style( 'content_style' ); ?>>
	<?php $post_pagination = get_post_meta( $post->ID, 'pyre_post_pagination', true ); ?>
	<?php if ( ( Avada()->settings->get( 'blog_pn_nav' ) && 'no' !== $post_pagination ) || ( ! Avada()->settings->get( 'blog_pn_nav' ) && 'yes' === $post_pagination ) ) : ?>
		<div class="single-navigation clearfix">
			<div class="fusion-single-navigation-wrapper">
				<?php previous_post_link( '%link', esc_attr__( 'Previous', 'Avada' ) ); ?>
				<?php next_post_link( '%link', esc_attr__( 'Next', 'Avada' ) ); ?>
			</div>
		</div>
	<?php endif; ?>

	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'post' ); ?>>
			<?php $full_image = ''; ?>
			<?php if ( 'above' == Avada()->settings->get( 'blog_post_title' ) ) : ?>
				<?php if ( 'below_title' === Avada()->settings->get( 'blog_post_meta_position' ) ) : ?>
					<div class="fusion-post-title-meta-wrap">
				<?php endif; ?>
				<?php echo avada_render_post_title( $post->ID, false, '', '2' ); // WPCS: XSS ok. ?>
				<?php if ( 'below_title' === Avada()->settings->get( 'blog_post_meta_position' ) ) : ?>
					<?php echo avada_render_post_metadata( 'single' ); // WPCS: XSS ok. ?>
					</div>
				<?php endif; ?>
			<?php elseif ( 'disabled' == Avada()->settings->get( 'blog_post_title' ) && Avada()->settings->get( 'disable_date_rich_snippet_pages' ) && Avada()->settings->get( 'disable_rich_snippet_title' ) ) : ?>
				<span class="entry-title" style="display: none;"><?php the_title(); ?></span>
			<?php endif; ?>

			<?php if ( ! post_password_required( $post->ID ) ) : ?>
				<?php if ( Avada()->settings->get( 'featured_images_single' ) ) : ?>
					<?php $video = get_post_meta( $post->ID, 'pyre_video', true ); ?>
					<?php if ( 0 < avada_number_of_featured_images() || $video ) : ?>
						<?php
						Avada()->images->set_grid_image_meta(
							array(
								'layout' => strtolower( 'large' ),
								'columns' => '1',
							)
						);
						?>
						<div class="fusion-flexslider flexslider fusion-flexslider-loading post-slideshow fusion-post-slideshow">
							<ul class="slides">
								<?php if ( $video ) : ?>
									<li>
										<div class="full-video">
											<?php echo $video; // WPCS: XSS ok. ?>
										</div>
									</li>
								<?php endif; ?>
								<?php if ( has_post_thumbnail() && 'yes' != get_post_meta( $post->ID, 'pyre_show_first_featured_image', true ) ) : ?>
									<?php $attachment_data = Avada()->images->get_attachment_data( get_post_thumbnail_id() ); ?>
									<?php if ( is_array( $attachment_data ) ) : ?>
										<li>
											<?php if ( Avada()->settings->get( 'status_lightbox' ) && Avada()->settings->get( 'status_lightbox_single' ) ) : ?>
												<a href="<?php echo esc_url_raw( $attachment_data['url'] ); ?>" data-rel="iLightbox[gallery<?php the_ID(); ?>]" title="<?php echo esc_attr( $attachment_data['caption_attribute'] ); ?>" data-title="<?php echo esc_attr( $attachment_data['title_attribute'] ); ?>" data-caption="<?php echo esc_attr( $attachment_data['caption_attribute'] ); ?>" aria-label="<?php echo esc_attr( $attachment_data['title_attribute'] ); ?>">
													<span class="screen-reader-text"><?php esc_attr_e( 'View Larger Image', 'Avada' ); ?></span>
													<?php echo get_the_post_thumbnail( $post->ID, 'full' ); ?>
												</a>
											<?php else : ?>
												<?php echo get_the_post_thumbnail( $post->ID, 'full' ); ?>
											<?php endif; ?>
										</li>
									<?php endif; ?>
								<?php endif; ?>
								<?php $i = 2; ?>
								<?php while ( $i <= Avada()->settings->get( 'posts_slideshow_number' ) ) : ?>
									<?php $attachment_new_id = fusion_get_featured_image_id( 'featured-image-' . $i, 'post' ); ?>
									<?php if ( $attachment_new_id ) : ?>
										<?php $attachment_data = Avada()->images->get_attachment_data( $attachment_new_id ); ?>
										<?php if ( is_array( $attachment_data ) ) : ?>
											<li>
												<?php if ( Avada()->settings->get( 'status_lightbox' ) && Avada()->settings->get( 'status_lightbox_single' ) ) : ?>
													<a href="<?php echo esc_url_raw( $attachment_data['url'] ); ?>" data-rel="iLightbox[gallery<?php the_ID(); ?>]" title="<?php echo esc_attr( $attachment_data['caption_attribute'] ); ?>" data-title="<?php echo esc_attr( $attachment_data['title_attribute'] ); ?>" data-caption="<?php echo esc_attr( $attachment_data['caption_attribute'] ); ?>" aria-label="<?php echo esc_attr( $attachment_data['title_attribute'] ); ?>">
														<?php echo wp_get_attachment_image( $attachment_new_id, 'full' ); ?>
													</a>
												<?php else : ?>
													<?php echo wp_get_attachment_image( $attachment_new_id, 'full' ); ?>
												<?php endif; ?>
											</li>
										<?php endif; ?>
									<?php endif; ?>
									<?php $i++; ?>
								<?php endwhile; ?>
							</ul>
						</div>
						<?php Avada()->images->set_grid_image_meta( array() ); ?>
					<?php endif; ?>
				<?php endif; ?>
			<?php endif; ?>

			<?php if ( 'below' == Avada()->settings->get( 'blog_post_title' ) ) : ?>
				<?php if ( 'below_title' === Avada()->settings->get( 'blog_post_meta_position' ) ) : ?>
					<div class="fusion-post-title-meta-wrap">
				<?php endif; ?>
				<?php echo avada_render_post_title( $post->ID, false, '', '2' ); // WPCS: XSS ok. ?>
				<?php if ( 'below_title' === Avada()->settings->get( 'blog_post_meta_position' ) ) : ?>
					<?php echo avada_render_post_metadata( 'single' ); // WPCS: XSS ok. ?>
					</div>
				<?php endif; ?>
			<?php endif; ?>
			<div class="post-content">
				<?php the_content(); ?>
				<?php fusion_link_pages(); ?>
			</div>

			<?php if ( ! post_password_required( $post->ID ) ) : ?>
				<?php if ( '' === Avada()->settings->get( 'blog_post_meta_position' ) || 'below_article' === Avada()->settings->get( 'blog_post_meta_position' ) ) : ?>
					<?php echo avada_render_post_metadata( 'single' ); // WPCS: XSS ok. ?>
				<?php endif; ?>
				<?php do_action( 'avada_before_additional_post_content' ); ?>
				<?php avada_render_social_sharing(); ?>
				<?php $author_info = get_post_meta( $post->ID, 'pyre_author_info', true ); ?>
				<?php if ( ( Avada()->settings->get( 'author_info' ) && 'no' !== $author_info ) || ( ! Avada()->settings->get( 'author_info' ) && 'yes' === $author_info ) ) : ?>
					<section class="about-author">
						<?php ob_start(); ?>
						<?php the_author_posts_link(); ?>
						<?php /* translators: The link. */ ?>
						<?php $title = sprintf( __( 'About the Author: %s', 'Avada' ), ob_get_clean() ); ?>
						<?php Avada()->template->title_template( $title, '3' ); ?>
						<div class="about-author-container">
							<div class="avatar">
								<?php echo get_avatar( get_the_author_meta( 'email' ), '72' ); ?>
							</div>
							<div class="description">
								<?php the_author_meta( 'description' ); ?>
							</div>
						</div>
					</section>
				<?php endif; ?>
				<?php avada_render_related_posts( get_post_type() ); // Render Related Posts. ?>

				<?php $post_comments = get_post_meta( $post->ID, 'pyre_post_comments', true ); ?>
				<?php if ( ( Avada()->settings->get( 'blog_comments' ) && 'no' !== $post_comments ) || ( ! Avada()->settings->get( 'blog_comments' ) && 'yes' === $post_comments ) ) : ?>
					<?php wp_reset_postdata(); ?>
					<?php comments_template(); ?>
				<?php endif; ?>
				<?php do_action( 'avada_after_additional_post_content' ); ?>
			<?php endif; ?>
		</article>
	<?php endwhile; ?>
	<?php wp_reset_postdata(); ?>
</section>
<?php do_action( 'avada_after_content' ); ?>

<style>
	.formulario{
		position:fixed;
		top: 0px;
		padding: 50px;
		width:100%;
		height : 100%;
		display: none;
	}
	.formulario .fusion-layout-column{

	}
</style>
<div id="formulario" class="formulario">
   <div class="fusion-layout-column fusion_builder_column fusion_builder_column_1_1  fusion-one-full fusion-column-first fusion-column-last fusion-column-no-min-height 1_1" style="margin-top:0px;margin-bottom:0px;">
      <div class="fusion-column-wrapper" style="background-position:left top;background-repeat:no-repeat;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;" data-bg-url="">
         <div role="form" class="wpcf7" id="wpcf7-f661-p611-o1" lang="en-US" dir="ltr">
            <div class="screen-reader-response"></div>
            <form action="/contact/#wpcf7-f661-p611-o1" method="post" class="wpcf7-form" novalidate="novalidate">
               <div style="display: none;">
                  <input type="hidden" name="_wpcf7" value="661">
                  <input type="hidden" name="_wpcf7_version" value="5.0">
                  <input type="hidden" name="_wpcf7_locale" value="en_US">
                  <input type="hidden" name="_wpcf7_unit_tag" value="wpcf7-f661-p611-o1">
                  <input type="hidden" name="_wpcf7_container_post" value="611">
               </div>
               <div style="color: #fff;">
                  <div class="fusion-one-third fusion-layout-column fusion-spacing-yes"><label>Your Name <span class="wpcf7-form-control-wrap your-name"><input type="text" name="your-name" value="" size="40" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required" aria-required="true" aria-invalid="false"></span></label></div>
                  <div class="fusion-one-third fusion-layout-column fusion-spacing-yes"><label>Email <span class="wpcf7-form-control-wrap your-email"><input type="email" name="your-email" value="" size="40" class="wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email" aria-required="true" aria-invalid="false"></span></label></div>
                  <div class="fusion-one-third fusion-layout-column fusion-column-last fusion-spacing-yes"><label>Subject<span class="wpcf7-form-control-wrap your-name"><input type="text" name="your-name" value="" size="40" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required" aria-required="true" aria-invalid="false"></span></label></div>
                  <div class="fusion-one-half fusion-layout-column fusion-spacing-yes">
                     <label>
                        Select Plan
                        <span class="wpcf7-form-control-wrap menu-962">
                           <div class="wpcf7-select-parent">
                              <select name="menu-962" class="wpcf7-form-control wpcf7-select" aria-invalid="false">
                                 <option value="Personal $29">Personal $29</option>
                                 <option value="Enterprise $89">Enterprise $89</option>
                                 <option value="Business $239">Business $239</option>
                              </select>
                              <div class="select-arrow" style="height: 43px; width: 43px; line-height: 43px;"></div>
                           </div>
                        </span>
                     </label>
                  </div>
                  <div class="fusion-one-half fusion-layout-column fusion-column-last fusion-spacing-yes">
                     <label>
                        Additional Installs 
                        <span class="wpcf7-form-control-wrap menu-962">
                           <div class="wpcf7-select-parent">
                              <select name="menu-962" class="wpcf7-form-control wpcf7-select" aria-invalid="false">
                                 <option value="1 for $10/month">1 for $10/month</option>
                                 <option value="5 for $29/month">5 for $29/month</option>
                                 <option value="10 for $50/month">10 for $50/month</option>
                              </select>
                              <div class="select-arrow" style="height: 43px; width: 43px; line-height: 43px;"></div>
                           </div>
                        </span>
                     </label>
                  </div>
                  <div class="fusion-one-third fusion-layout-column fusion-spacing-yes">
                     <label>
                        Additional Storage
                        <span class="wpcf7-form-control-wrap menu-962">
                           <div class="wpcf7-select-parent">
                              <select name="menu-962" class="wpcf7-form-control wpcf7-select" aria-invalid="false">
                                 <option value="10GB for $10/month">10GB for $10/month</option>
                                 <option value="20GB for $19/month">20GB for $19/month</option>
                                 <option value="30GB for $25/month">30GB for $25/month</option>
                                 <option value="50GB for $35/month">50GB for $35/month</option>
                              </select>
                              <div class="select-arrow" style="height: 43px; width: 43px; line-height: 43px;"></div>
                           </div>
                        </span>
                     </label>
                  </div>
                  <div class="fusion-one-third fusion-layout-column fusion-spacing-yes">
                     <label>
                        Additional RAM
                        <span class="wpcf7-form-control-wrap menu-962">
                           <div class="wpcf7-select-parent">
                              <select name="menu-962" class="wpcf7-form-control wpcf7-select" aria-invalid="false">
                                 <option value="2GB for $15/month">2GB for $15/month</option>
                                 <option value="4GB for $25/month">4GB for $25/month</option>
                                 <option value="8GB for $35/month">8GB for $35/month</option>
                                 <option value="12GB for $45/month">12GB for $45/month</option>
                                 <option value="30GB for $75/month">30GB for $75/month</option>
                              </select>
                              <div class="select-arrow" style="height: 43px; width: 43px; line-height: 43px;"></div>
                           </div>
                        </span>
                     </label>
                  </div>
                  <div class="fusion-one-third fusion-layout-column fusion-column-last fusion-spacing-yes">
                     <label>
                        Monthly Visitors
                        <span class="wpcf7-form-control-wrap menu-962">
                           <div class="wpcf7-select-parent">
                              <select name="menu-962" class="wpcf7-form-control wpcf7-select" aria-invalid="false">
                                 <option value="50K">50K</option>
                                 <option value="100K">100K</option>
                                 <option value="250K">250K</option>
                                 <option value="500K">500K</option>
                                 <option value="1 Million+">1 Million+</option>
                              </select>
                              <div class="select-arrow" style="height: 43px; width: 43px; line-height: 43px;"></div>
                           </div>
                        </span>
                     </label>
                  </div>
                  <p><label>Your Message <span class="wpcf7-form-control-wrap your-message"><textarea name="your-message" cols="40" rows="10" class="wpcf7-form-control wpcf7-textarea" aria-invalid="false"></textarea></span></label></p>
                  <p><input type="submit" value="Enviar" class="wpcf7-form-control wpcf7-submit">
                  <div class="fusion-slider-loading"></div>
                  </p>
               </div>
               <div class="wpcf7-response-output wpcf7-display-none"></div>
            </form>
         </div>
         <div class="fusion-clearfix"></div>
      </div>
   </div>
</div>

<?php
get_footer();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
