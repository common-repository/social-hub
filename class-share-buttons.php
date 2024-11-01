<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class SSSB_ShareButtons {

    static $popinWidth = 545;
    static $popinHight = 433;

    /*
     *  PLUGIN INSTALL
     */
    public static function sssb_activation() {

        // add to database
        $social_networks = [
            'facebook' => 'Facebook',
            'twitter' => 'Twitter',
            'googleplus' => 'Google plus',
            'linkedin' => 'LinkedIn',
            'pinterest' => 'Pinterest',
            'tumblr' => 'Tumblr'
        ];

        update_option('sssb_social_networks', $social_networks);
        
    }

    /*
     *  PLUGIN UNINSTALL
     */
    public static function sssb_deactivation() {

        
    }

    /*
     * Add plugin's Css and Js to head
     */
    public static function sssb_add_style_script() {
        // socicon
        wp_enqueue_style('socicon', 'https://file.myfontastic.com/n6vo44Re5QaWo8oCKShBs7/icons.css', array(), null );
        wp_enqueue_style('sssb_style', plugins_url('/assets/css/style.css', __FILE__));
        wp_enqueue_script('sssb_script', plugins_url('/assets/js/scripts.js', __FILE__));
    }

    public static function sssb_admin_style_script() {
        wp_enqueue_style('socicon', 'https://file.myfontastic.com/n6vo44Re5QaWo8oCKShBs7/icons.css', array(), null );
        wp_enqueue_style('sssb_style', plugins_url('/assets/css/style.css', __FILE__), false, '1.0.0');
        wp_enqueue_style('sssb_admin_css', plugins_url('/assets/css/admin-style.css', __FILE__), false, '1.0.0');
    }

    public static function sssb_getSocialShare($content) {

        $socialList = array();

        $all_networks = get_option( 'sssb_social_networks' );
        $sssb_options = get_option( 'sssb_options' );


        foreach ($sssb_options['networks'] as $network => $active) {
            if($active) {
                $socialList['social'][$network] = [
                    'name' => $all_networks[$network],
                    'link' => self::sssb_getLink($network)
                ];
            }
        }

        $templates = new SSSB_Template_Loader;
        $templates->set_template_data([
            'socialList' => $socialList, 
            'panelStyle' => $sssb_options['panel_style'],
            'panelSize' => $sssb_options['panel_size'],
        ]);

        ob_start();
        $templates->get_template_part( 'socials', 'links' );
        $socials_content = ob_get_clean();

        if (!isset($sssb_options['is_active']) || $sssb_options['is_active'] == false) {
            return $content;
        } else if (isset($sssb_options['panel_position']) && $sssb_options['panel_position'] == 'top') {
            return $socials_content . $content;
        } else if (isset($sssb_options['panel_position']) && $sssb_options['panel_position'] == 'bottom') {
            return $content . $socials_content;
        } else {
            return $socials_content . $content . $socials_content;
        }
    }

    /*
     * Get sharing links
     */

    public static function sssb_getLink($social) {

        global $post;
        $blogName = get_option('blogname');
        $blogUrl = get_home_url();
        $link = "";
        $url = apply_filters("the_permalink", get_permalink());
        $title = urlencode(get_the_title());


        switch ($social) {
            case 'facebook': 
                // http://www.facebook.com/sharer/sharer.php?u=[URL]&title=[TITLE]
                $link = 'http://www.facebook.com/sharer/sharer.php?u='. $url .'&title='. $title;
                break;

            case 'twitter': 
                // http://twitter.com/intent/tweet?status=[TITLE]+[URL]
                $link = 'http://twitter.com/intent/tweet?status='. $title .'+'. $url;
                break;

            case 'googleplus': 
                // https://plus.google.com/share?url=[URL]
                $link = 'https://plus.google.com/share?url='. $url;
                break;

            case 'linkedin': 
                // http://www.linkedin.com/shareArticle?mini=true&url=[URL]&title=[TITLE]&source=[SOURCE/DOMAIN]
                $link = 'http://www.linkedin.com/shareArticle?mini=true&url='. $url .'&title='. $title .'&source='. $blogUrl;
                break;

            case 'pinterest': 
                // http://pinterest.com/pin/create/bookmarklet/?media=[MEDIA]&url=[URL]&is_video=false&description=[TITLE]
                $link = 'http://pinterest.com/pin/create/bookmarklet/?url='. $url .'&is_video=false&description='. $title .'';
                break;

            case 'tumblr': 
                // http://www.tumblr.com/share?v=3&u=[URL]&t=[TITLE]
                $link = 'http://www.tumblr.com/share?v=3&u='. $url .'&t='. $title .'';
                break;

            /*

            http://petragregorova.com/articles/social-share-buttons-with-custom-icons/

            Reddit:
            http://www.reddit.com/submit?url=[URL]&title=[TITLE]

            Delicious: 
            http://del.icio.us/post?url=[URL]&title=[TITLE]&notes=[DESCRIPTION]

            Digg
            https://digg.com/submit?url=[URL]&title=[TITLE]

            blogger': 
            href="https://www.blogger.com/blog-this.g?u=''&n='&t=''" 

            Tapiture
            http://tapiture.com/bookmarklet/image?img_src=[IMAGE]&page_url=[URL]&page_title=[TITLE]&img_title=[TITLE]&img_width=[IMG WIDTH]img_height=[IMG HEIGHT]

            StumbleUpon
            http://www.stumbleupon.com/submit?url=[URL]&title=[TITLE]

            */
            default: $link = '';
                break;
        }
        return $link;
    }

    /*
     * Set image in header for post share
     */
    public static function sssb_get_post_image() {
        global $post;

        $args = array(
            'post_type' => 'attachment',
            'post_mime_type' => 'image',
            'post_parent' => $post->ID
        );
        $images = get_posts($args);
        $src = array();
        foreach ($images as $image) {
            $src[] = wp_get_attachment_url($image->ID, array(120, 120));
        }
        if ($src) {
            $postImage = $src [0];
        }
        if (empty($postImage)) {
            $postImage = SM_URL . '/assets/css/images/logo_big.png';
        }
        echo '<meta property="og:image" content="' . $postImage . '"/>';
    }

}
