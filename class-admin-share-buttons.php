<?php 

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class SSSB_AdminShareButtons {
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
	 * All social networks
     */
    private $social_networks;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_init', array( $this, 'page_init' ) );
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        add_menu_page(
            'Social Hub - Share Buttons', 
            'Social Hub', 
            'manage_options', 
            'sssb-setting', 
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'sssb_options' );

        ?>
        <div class="wrap">
            <h1>Social Hub - Share Buttons</h1>
            <form id="sssb_horizontal" method="post" action="options.php">
	            <?php
	                // This prints out all hidden setting fields
	                settings_fields( 'sssb_option_group' );
	                do_settings_sections( 'sssb-setting' );
	                submit_button();
	            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {        
    	// social networks
        $this->social_networks = get_option( 'sssb_social_networks' );

        register_setting(
            'sssb_option_group',
            'sssb_options'
        );

        add_settings_section(
            'sssb_social_networks',
            '',
            null,
            'sssb-setting'
        );

        add_settings_field(
            'sssb_is_active',
            'Is Active',
            array( $this, 'is_active_field' ),
            'sssb-setting',
            'sssb_social_networks'     
        );

        // network fields
        add_settings_field(
            'sssb_social_networks',
            'Social Network',
            array( $this, 'sssb_social_networks_field' ),
            'sssb-setting',
            'sssb_social_networks'
        );

        add_settings_section(
            'sssb_panel_options',
            'Panel Options',
            null,
            'sssb-setting'
        );

        // panel position
        add_settings_field(
            'sssb_panel_position', 
            'Panel Position', 
            array( $this, 'panel_position_field' ), 
            'sssb-setting', 
            'sssb_panel_options'
        );

        // panel size
        add_settings_field(
            'sssb_panel_size', 
            'Panel Size', 
            array( $this, 'panel_size_field' ), 
            'sssb-setting', 
            'sssb_panel_options'
        );

        // panel style
        add_settings_field(
            'sssb_panel_style', 
            'Panel Style', 
            array( $this, 'panel_style_field' ), 
            'sssb-setting', 
            'sssb_panel_options'
        );
    }

    /** 
     * Active field
     */
    public function is_active_field()
    {
        printf(
            '<input type="checkbox" id="%1$s" name="sssb_options[%1$s]" %2$s />',
            'is_active',
            checked( isset( $this->options['is_active'] ), true, false )
        );
    }

    /** 
     * Network Field
     */
    public function sssb_social_networks_field()
    {
        foreach ($this->social_networks as $network_slug => $network_name) {
	        printf(
	            '<label for="panel_position">
	            <input type="checkbox" id="%1$s" name="sssb_options[networks][%1$s]" %2$s />
				'. $network_name .'</label>
				<br>
	            ',
	            $network_slug,
	            checked( isset( $this->options[ 'networks'][$network_slug] ), true, false)
	        );
	    }
    }

    /** 
     * Panel position
     */
    public function panel_position_field()
    {
        printf(
	        '<label for="panel_position">
	        <input name="sssb_options[panel_position]" type="radio" value="both" %1$s />
	        Both</label>',
	        checked( isset($this->options['panel_position']) ? $this->options['panel_position'] : '', 'both', false)
        );
        printf(
	        '<label for="panel_position">
	        <input name="sssb_options[panel_position]" type="radio" value="top" %1$s />
	        Top</label>',
	        checked( isset($this->options['panel_position']) ? $this->options['panel_position'] : '', 'top', false)
        );
	    printf(
	        '<label for="panel_position">
	        <input name="sssb_options[panel_position]" type="radio" value="bottom" %1$s />
	        Bottom</label>',
	        checked( isset($this->options['panel_position']) ? $this->options['panel_position'] : '', 'bottom', false)
        );
    }

    /** 
     * Panel size
     */
    public function panel_size_field()
    {
        printf(
	        '<label for="panel_size">
	        <input name="sssb_options[panel_size]" type="radio" value="size-1x" %1$s />
	        1X</label>',
	        checked( isset($this->options['panel_size']) ? $this->options['panel_size'] : '', 'size-1x', false)
        );
        printf(
	        '<label for="panel_size">
	        <input name="sssb_options[panel_size]" type="radio" value="size-2x" %1$s />
	        2X</label>',
	        checked( isset($this->options['panel_size']) ? $this->options['panel_size'] : '', 'size-2x', false)
        );
	    printf(
	        '<label for="panel_size">
	        <input name="sssb_options[panel_size]" type="radio" value="size-3x" %1$s />
	        3X</label>',
	        checked( isset($this->options['panel_size']) ? $this->options['panel_size'] : '', 'size-3x', false)
        );
	    printf(
	        '<label for="panel_size">
	        <input name="sssb_options[panel_size]" type="radio" value="size-4x" %1$s />
	        4X</label>',
	        checked( isset($this->options['panel_size']) ? $this->options['panel_size'] : '', 'size-4x', false)
        );
	    printf(
	        '<label for="panel_size">
	        <input name="sssb_options[panel_size]" type="radio" value="size-5x" %1$s />
	        5X</label>',
	        checked( isset($this->options['panel_size']) ? $this->options['panel_size'] : '', 'size-5x', false)
        );
    }

    /** 
     * Panel style
     */
    public function panel_style_field()
    {
    	for ($i=1; $i <= 5; $i++) {
	        printf(
		        '<div class="sssb-horizontal">
		        <input class="panel_style" name="sssb_options[panel_style]" type="radio" value="sssb-style-%1$s" %2$s />',
		        $i,
		        checked( isset($this->options['panel_style']) ? $this->options['panel_style'] : '', 'sssb-style-'.$i, false)
	        );
	        ?>
	        
			    <ul class="sssb-style-<?php echo $i; ?>">
			    	<?php 
			    	$icon_count = 1; 
			    	foreach ($this->social_networks as $network_slug => $network_name) : ?>
			    		<?php if($icon_count > 5) continue; ?>
				        <li>
				            <a class="<?php echo $network_slug; ?> size-2x"
				            	href="#" 
				            	alt="Share on <?php echo $network_name; ?>" title="Share on <?php echo $network_name; ?>"
				            	target=""
				            >
								<span class="socicon socicon-<?php echo $network_slug; ?>"></span>
				            </a>
				        </li>

				    <?php $icon_count++; endforeach; ?>
			    </ul>
			</div>
		    <?php 
	    }
    }
}




