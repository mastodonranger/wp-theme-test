<?php
/**
* Countdown
*/
class WPBakeryShortCode_VC_mad_countdown extends WPBakeryShortCode {

    protected function content($atts, $content = null) {

        $this->atts = shortcode_atts(array(
            'title' => '',
            'datetime'=>'',
            'text_align' => '',
            'el_class' => '',
        ), $atts, 'vc_mad_countdown');

        return $this->html();
    }

    public function html() {

        $title = $datetime = $text_align = $el_class = $class_align = '';

        extract($this->atts);

        if ( $text_align == 'center' ){
            $class_align = 'align_center';
        } else if ( $text_align == 'right' ) {
            $class_align = 'align_right';
        } else if ( $text_align == 'left' ) {
            $class_align = 'align_left';
        }

        ob_start(); ?>

        <div class="shortcode-countdown <?php echo sanitize_html_class($class_align); ?>">
            <?php if ( $title != '' ) : ?><p class="mini_title"><?php echo esc_attr( $title ); ?></p><?php endif; ?>
            <div class="countdown type_2 <?php echo sanitize_html_class($el_class); ?>" data-terminal-date="<?php echo esc_attr($datetime); ?>" data-time-now="<?php echo str_replace('-', '/', current_time('mysql'));?>"></div>
        </div>

        <?php return ob_get_clean();
    }

}