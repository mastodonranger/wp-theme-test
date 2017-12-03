<?php
/**
 * Share template
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Wishlist
 * @version 2.0.13
 */

if ( ! defined( 'YITH_WCWL' ) ) {
    exit;
} // Exit if accessed directly
?>

<div class="yith-wcwl-share">

   <?php echo sprintf('%s', $share_title) ?>

    <ul class="social_links">
        <?php if( $share_facebook_enabled ): ?>
			<li><a target="_blank" href="https://www.facebook.com/sharer.php?s=100&amp;p%5Btitle%5D=<?php echo $share_link_title ?>&amp;p%5Burl%5D=<?php echo $share_link_url ?>&amp;p%5Bsummary%5D=<?php echo $share_summary ?>&amp;p%5Bimages%5D%5B0%5D=<?php echo $share_image_url ?>" title="<?php esc_html_e( 'Facebook', 'terminus' ) ?>" class="btn icon_only small rd-grey tooltip_container">
					<span class="tooltip top"><?php esc_html_e( 'Facebook', 'terminus' ) ?></span>
					<i class="icon-facebook"></i>
				</a>
			</li>
        <?php endif; ?>

        <?php if( $share_twitter_enabled ): ?>
			<li><a target="_blank" href="https://twitter.com/share?url=<?php echo $share_link_url ?>&amp;text=<?php echo $share_twitter_summary ?>" title="<?php esc_html_e( 'Twitter', 'terminus' ) ?>" class="btn icon_only small rd-grey tooltip_container">
					<span class="tooltip top"><?php esc_html_e( 'Twitter', 'terminus' ) ?></span>
					<i class="icon-twitter"></i>
				</a>
			</li>
        <?php endif; ?>

		<?php if( $share_pinterest_enabled ): ?>
			<li><a target="_blank" href="http://pinterest.com/pin/create/button/?url=<?php echo $share_link_url ?>&amp;description=<?php echo $share_summary ?>&amp;media=<?php echo $share_image_url ?>" title="<?php esc_html_e( 'Pinterest', 'terminus' ) ?>" onclick="window.open(this.href); return false;" class="btn icon_only small rd-grey tooltip_container">
					<span class="tooltip top"><?php esc_html_e( 'Pinterest', 'terminus' ) ?></span>
					<i class="icon-pinterest-circled"></i>
				</a>
			</li>
        <?php endif; ?>

        <?php if( $share_googleplus_enabled ): ?>
			<li><a target="_blank" href="https://plus.google.com/share?url=<?php echo $share_link_url ?>&amp;title=<?php echo $share_link_title ?>" title="<?php esc_html_e( 'Google+', 'terminus' ) ?>" onclick='javascript:window.open(this.href, "", "menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600");return false;' class="btn icon_only small rd-grey tooltip_container">
					<span class="tooltip top"><?php esc_html_e( 'Google+', 'terminus' ) ?></span>
					<i class="icon-gplus"></i>
				</a>
			</li>
        <?php endif; ?>

        <?php if( $share_email_enabled ): ?>
			<li><a href="mailto:?subject=<?php echo urlencode( apply_filters( 'yith_wcwl_email_share_subject', esc_html__( 'I wanted you to see this site', 'terminus' ) ) )?>&amp;body=<?php echo apply_filters( 'yith_wcwl_email_share_body', $share_link_url ) ?>&amp;title=<?php echo $share_link_title ?>" title="<?php esc_html_e( 'I wanted you to see this site', 'terminus' ) ?>" class="btn icon_only small rd-grey tooltip_container">
					<span class="tooltip top"><?php esc_html_e( 'I wanted you to see this site', 'terminus' ) ?></span>
					<i class="icon-mail-alt"></i>
				</a>
			</li>
        <?php endif; ?>
    </ul>
</div>