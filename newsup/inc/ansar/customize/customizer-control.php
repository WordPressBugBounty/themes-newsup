<?php
/**
 * Custom Customizer Controls.
 *
 * @package Newsup
 */

/**
 * Custom Controls of theme
 *
 * @since 1.0.0
 *
 * @see WP_Customize_Control
 */

class Newsup_Section_Title extends WP_Customize_Control {
    public $type = 'section-title';
    public $label = '';
    public $description = '';

    public function enqueue(){
        wp_enqueue_style('newsup-custom-controls-css', trailingslashit(get_template_directory_uri()) . '/inc/ansar/customize/assets/css/customizer.css', array(), '1.0', 'all');
    }

    public function render_content() { ?>
        <h3><?php echo esc_html( $this->label ); ?></h3>
        <?php if (!empty($this->description)) { ?>
            <span class="customize-control-description"><?php echo esc_html($this->description); ?></span>
        <?php } ?>
        <?php
    }
}

/**
 * Customize Control for Taxonomy Select.
 *
 * @since 1.0.0
 *
 * @see WP_Customize_Control
 */
class Newsup_Dropdown_Taxonomies_Control extends WP_Customize_Control {

    /**
     * Control type.
     *
     * @access public
     * @var string
     */
    public $type = 'dropdown-taxonomies';

    /**
     * Taxonomy.
     *
     * @access public
     * @var string
     */
    public $taxonomy = '';

    /**
     * Constructor.
     *
     * @since 1.0.0
     *
     * @param WP_Customize_Manager $manager Customizer bootstrap instance.
     * @param string               $id      Control ID.
     * @param array                $args    Optional. Arguments to override class property defaults.
     */
    public function __construct( $manager, $id, $args = array() ) {

        $our_taxonomy = 'category';
        if ( isset( $args['taxonomy'] ) ) {
            $taxonomy_exist = taxonomy_exists( $args['taxonomy']  );
            if ( true === $taxonomy_exist ) {
                $our_taxonomy =  $args['taxonomy'];
            }
        }
        $args['taxonomy'] = $our_taxonomy;
        $this->taxonomy =  $our_taxonomy;

        parent::__construct( $manager, $id, $args );
    }

    /**
     * Render content.
     *
     * @since 1.0.0
     */
    public function render_content() {

        $tax_args = array(
            'hierarchical' => 0,
            'taxonomy'     => $this->taxonomy,
        );
        $all_taxonomies = get_categories( $tax_args );

        ?>
        <label>
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <?php if ( ! empty( $this->description ) ) : ?>
                <span class="description customize-control-description"><?php echo $this->description; ?></span>
            <?php endif; ?>
            <select <?php $this->link(); ?>>
                <?php
                printf( '<option value="%s" %s>%s</option>', 0, selected( $this->value(), '', false ), __( 'All', 'newsup' )  );
                ?>
                <?php if ( ! empty( $all_taxonomies ) ) :  ?>
                    <?php foreach ( $all_taxonomies as $key => $tax ) :  ?>
                        <?php
                        printf( '<option value="%s" %s>%s</option>', esc_attr( $tax->term_id ), selected( $this->value(), $tax->term_id, false ), esc_html( $tax->name ) );
                        ?>
                    <?php endforeach ?>
                <?php endif ?>
            </select>
        </label>
        <?php
    }
}


/**
 * Customize Control for Radio Image.
 *
 * @since 1.0.0
 *
 * @see WP_Customize_Control
 */
class Newsup_Radio_Image_Control extends WP_Customize_Control {

	public $type = 'radio-image';

	public function enqueue() {
		wp_enqueue_script( 'jquery-ui-button' );
	}

	public function render_content() {

		if ( empty( $this->choices ) ) {
			return;
		}

		$name = '_customize-radio-' . $this->id;
		?>

		<span class="customize-control-title">
			<?php echo esc_html( $this->label ); ?>
			<?php if ( ! empty( $this->description ) ) : ?>
				<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
			<?php endif; ?>
		</span>

		<div id="input_<?php echo esc_attr( $this->id ); ?>" class="newsup-radio-image image">
			<?php foreach ( $this->choices as $value => $image ) : ?>
				<input class="image-select" type="radio" id="<?php echo esc_attr( $this->id . $value ); ?>" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( $value ); ?>" <?php $this->link(); checked( $this->value(), $value ); ?> />
				<label class="newsup-radio-image-choices" for="<?php echo esc_attr( $this->id . $value ); ?>">
					<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $value ); ?>" title="<?php echo esc_attr( $value ); ?>" />
				</label>
			<?php endforeach; ?>
		</div>

		<?php
	}
}

/**
 * Newsup Info Box Control
 */

class Newsup_Info_Box_Control extends WP_Customize_Control {
    /**
     * The type of control being rendered.
     */
    public $type = 'newsup-info-box';

    /**
     * Custom properties
     */
    public $features = array();
    public $url = '';
    public $btn_text = '';

    /**
     * Pass data from PHP to JS template
     */
    public function to_json() {
        parent::to_json();
        $this->json['features']        = $this->features ?? array();
        $this->json['url']         = $this->url ?? '';
        $this->json['btn_text'] = $this->btn_text ?: __( 'Upgrade to Pro ☆', 'newsup' );
    }

    protected function content_template() {
        ?>
        <div class="newsup-info-box-container">
            <div class="info-box-icon">
                <span class="dashicons dashicons-info-outline"></span>
            </div>
            
            <# if ( data.label ) { #>
                <h3 class="info-box-title">{{ data.label }}</h3>
            <# } #>
            <# if ( data.description ) { #>
                <p class="info-box-description">{{ data.description }}</p>
            <# } #>
                
            <# if ( data.features ) { #>
            <ul class="info-box-features">
                <# _.each( data.features, function( feature ) { #>
                    <li>
                        <span class="dashicons dashicons-yes"></span>
                        {{{ feature }}}
                    </li>
                <# } ); #>
            </ul>
            <# } #>

            <# if ( data.btn_text ) { #>
            <div class="info-box-buttons">
                <# if ( data.url ) { #>
                    <a href="{{ data.url }}" class="button button-info-box-primary button-secondary" target="_blank">
                        {{ data.btn_text }}
                    </a>
                <# } #>
            </div>
            <# } #>
        </div>
        <?php
    }
}