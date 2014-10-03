<?php
/**
 * Merge Shortcode
 *
 * @package   Amazing System
 * @author    Scott Lesovic <scott@scottlesovic.com>
 * @license   GPL-2.0+
 * @link      http://amazingsystemtraining.com/as-wordpress-plugin/
 * @copyright 2014 David Farr Direct and Scott Lesovic
 */

class AmSys_Shortcode_Block {

	public static $tag = 'block';
	protected static $instance;

	protected $data;


	protected function __construct() {
		add_shortcode ( self::$tag, array( $this, 'fire' ) );

		$this->data = MagicAmazingSystemPlugin::$request;
	}

	/**
	 * Return an instance of this class.
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Shortcode Callback
	 *
	 * @param  array  $atts User defined attributes in shortcode tag
	 * @return string|void  Contents of shortcode
	 */
	public function fire( array $atts, $content = null )  {

    $atts = shortcode_atts(
      array(
        'field'    => false,
        'value'    => false,
        'operator' => 'eq'
      ),
      $atts,
      self::$tag  // WP 3.6 shortcode_atts_{$shortcode} filter
    );

		// Thou shall not `extract()`
    $field    = $atts[ 'field' ];
    $value    = $atts[ 'value' ];
    $operator = $atts[ 'operator' ];

    if ( false === $field ) {
			return;
		}

		$data = $this->get_field( $field, false );

		switch ( $operator ) {
			case 'eq': // equals
			default: // fall through is intentional
				$display = ( $value === $data ) ? true : false;
				break;
			case 'ne': // not equals
				$display = ( $value !== $data ) ? true : false;
				break;
			case 'gt':
				$display = $this->is_greater_than( $value, $data );
				break;
			case 'lt':
				$display = $this->is_less_than( $value, $data );
				break;
			case 'ge':
				$display = $this->is_greater_than_or_equal_to( $value, $data );
				break;
			case 'le':
				$display = $this->is_less_than_or_equal_to( $value, $data );
				break;
			case 'one of':
				$display = $this->is_one_of( $value, $data );
			case 'contains':
				$display = ( strpos( $data, $value ) ) ? true : false;
				break;
			case 'starts with':
				$display = $this->string_starts_with( $value, $data );
				break;
			case 'ends with':
				$display = $this->string_ends_with( $value, $data );
				break;
      case 'empty':
        $display = ( isset( $this->data[ $field ] ) && empty( $this->data[ $field ] ) ) ? true : false;
        break;
		}

		if ( true === $display ) {
			add_shortcode( 'else', array( $this, 'elimate_else') );
			$clean = do_shortcode( $content );
			remove_shortcode( 'else' );
			return $clean;
		} else {
			return $this->display_else( $content );
		}
	}

	private function get_field( $key, $default = null) {
		$data = $this->data;

		if ( ! isset( $data[ $key ] ) || empty( $data[ $key ] ) ) {
			return $default;
		}

		if ( isset( $data[ $key ] ) ) {
			return $data[ $key ];
		}

		return false;
	}

	private function is_greater_than( $value, $data ) {
		if ( false === $data ) {
			return false;
		}
		if ( is_numeric( $value ) && is_numeric( $data ) ) {
			return ( (float) $data > (float) $value ) ? true : false;
		}

		if ( strlen( $data ) > strlen( $value ) ) {
			return true;
		}

		return false;
	}

	private function is_less_than( $value, $data ) {
		if ( false === $data ) {
			return false;
		}

		if ( is_numeric( $value ) && is_numeric( $data ) ) {
			return ( (float) $data < (float) $value ) ? true : false;
		}

		if ( strlen( $data ) < strlen( $value ) ) {
			return true;
		}

		return false;
	}

	private function is_greater_than_or_equal_to( $value, $data ) {
		if ( false === $data ) {
			return false;
		}
		if ( (float) $data >= (float) $value ) {
			return true;
		} else {
			return false;
		}

		if ( strlen( $data ) >= strlen( $value ) ) {
			echo "is true" . PHP_EOL;
			return true;
		}

		return false;
	}

	private function is_less_than_or_equal_to( $value, $data ) {
		if ( false === $data ) {
			return false;
		}
		if ( is_numeric( $value ) && is_numeric( $data ) ) {
			return ( (float) $data <= (float) $value ) ? true : false;
		}

		if ( strlen( $data ) <= strlen( $value ) ) {
			return true;
		}

		return false;
	}

	private function is_one_of( $value, $data ) {
		if ( false === $data ) {
			return false;
		}
		$values = explode( ',', $value );

		return in_array( $data, $values ) ? true : false;
	}

	private function string_starts_with( $value, $data ) {
		if ( false === $data ) {
			return false;
		}
		return ( 0 === strpos( $data, $value ) ) ? true : false;
	}

	private function string_ends_with( $value, $data ) {
		if ( false === $data ) {
			return false;
		}
		$end_of_string = -1 * strlen( $value );

		return ( $value === substr( $data, $end_of_string ) );
	}

	private function display_else( $content = null ) {
		if ( ! preg_match( '/\[else\]/', $content ) ) {
			return;
		}
		$clean_beginnings = preg_replace( '/.*\[else\]/', '', $content );
		$clean_ends = preg_replace( '/\[\/else\].*/', '', $clean_beginnings);

		$trimmed = trim( $clean_ends );
		return do_shortcode( $trimmed );
	}

	public function elimate_else() {
		return '';
	}
}
