<?php defined( 'ABSPATH' ) || die;


/**
 * Adds Column add functionality
 * usage:
 * $cpt = new Zorbix_CPT( 'Post Type name', array('supports' => array('title')) );
 * $cpt->add_column(array('category', 'thumbnail'))
 * $cpt->get_taxonomy_id()
 * $cpt->get_post_type
 */
class  Zorbix_CPT extends Cuztom_Post_Type {

	private $taxonomy_id;

	/**
	 * Adds a column
	 */
	public function add_column( $column_types ) {

		$this->post_type_name = $this->name;

		add_filter( 'manage_' . $this->post_type_name . '_posts_columns', array( $this, 'add_col_function' ), 10 );

		add_action( 'manage_' . $this->post_type_name . '_posts_custom_column',
			array( $this, 'add_custom_col_function' ),
			10,
			2 );

		$this->column_types = $column_types;

	}

	// Extent taxonomy function to get the taxonomy name fot the getter
	public function add_taxonomy( $name, $args = array(), $labels = array() ) {

		$this->taxonomy_id = Cuztom::uglify( $name );

		parent::add_taxonomy( $name, $args = array(), $labels = array() );
	}


	public function get_taxonomy_id() {
		return $this->taxonomy_id;
	}


	public function get_post_type() {
		return $this->post_type_name;
	}

	public function add_col_function( $defaults ) {
		if ( in_array( 'category', $this->column_types ) ) {
			$defaults = $defaults + array( 'zorbix_category' => esc_html__( 'Category', 'zorbix' ) );
		}
		if ( in_array( 'thumbnail', $this->column_types ) ) {
			$defaults = array( 'zorbix_thumbnail' => esc_html__( 'Thumbnail', 'zorbix' ) ) + $defaults;
		}

		return $defaults;
	}

	public function add_custom_col_function( $column_name, $post_id ) {
		if ( $column_name === 'zorbix_thumbnail' ) {
			the_post_thumbnail( 'thumbnail' );
		} elseif ( $column_name === 'zorbix_category' ) {
			$post_type = get_post_type( $post_id );
			$terms     = get_the_terms( $post_id, $this->taxonomy_id );
			if ( ! empty( $terms ) ) {
				foreach ( $terms as $term ) {
					$term->slug;
					$post_terms[] = "<a href='edit.php?post_type={$post_type}&{$this->taxonomy_id}={$term->slug}'> "
					                . esc_html( sanitize_term_field( 'name',
							$term->name,
							$term->term_id,
							$this->taxonomy_id,
							'edit' ) ) . '</a>';
				}
				echo join( ', ', $post_terms );
			} else {
				echo '<i>No Location Set.</i>';
			}
		}
	}

}
