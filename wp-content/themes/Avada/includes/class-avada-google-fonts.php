<?php
/**
 * Processes typography-related fields
 * and generates the google-font link.
 *
 * Modified version from the Kirki framework for use with the Avada theme.
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       1.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if ( ! class_exists( 'Avada_Google_Fonts' ) ) {

	/**
	 * Manages the way Google Fonts are enqueued.
	 */
	final class Avada_Google_Fonts {

		/**
		 * The array of fonts
		 *
		 * @access private
		 * @var array
		 */
		private $fonts = array();

		/**
		 * An array of all google fonts.
		 *
		 * @static
		 * @access private
		 * @var array
		 */
		private $google_fonts = array();

		/**
		 * The array of subsets
		 *
		 * @access private
		 * @var array
		 */
		private $subsets = array();

		/**
		 * The google link
		 *
		 * @access private
		 * @var string
		 */
		private $link = '';

		/**
		 * The class constructor.
		 */
		public function __construct() {

			// Populate the array of google fonts.
			$this->google_fonts = $this->get_google_fonts();

			// Enqueue link.
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ), 105 );

		}

		/**
		 * Calls all the other necessary methods to populate and create the link.
		 */
		public function enqueue() {

			// Go through our fields and populate $this->fonts.
			$this->loop_fields();

			// Goes through $this->fonts and adds or removes things as needed.
			$this->process_fonts();

			// Go through $this->fonts and populate $this->link.
			$this->create_link();

			// If $this->link is not empty then enqueue it.
			if ( '' !== $this->link ) {
				wp_enqueue_style( 'avada_google_fonts', $this->link, array(), null );
			}

		}

		/**
		 * Goes through all our fields and then populates the $this->fonts property.
		 */
		private function loop_fields() {
			$fields  = array(
				'footer_headings_typography',
				'nav_typography',
				'button_typography',
				'body_typography',
				'h1_typography',
				'h2_typography',
				'h3_typography',
				'h4_typography',
				'h5_typography',
				'h6_typography',
			);
			foreach ( $fields as $field ) {
				$this->generate_google_font( $field );
			}
		}

		/**
		 * Processes the field.
		 *
		 * @param array $field The field arguments.
		 */
		private function generate_google_font( $field ) {

			// Get the value.
			$value = Avada()->settings->get( $field );

			// If we don't have a font-family then we can skip this.
			if ( ! isset( $value['font-family'] ) ) {
				return;
			}

			// Convert font-weight to variant.
			if ( isset( $value['font-weight'] ) && ( ! isset( $value['variant'] ) || empty( $value['variant'] ) ) ) {
				$value['variant'] = $value['font-weight'];
			}

			// Set a default value for variants.
			if ( ! isset( $value['variant'] ) ) {
				$value['variant'] = '400';
			}

			// Add "i" to font-weight to make italics properly load.
			if ( is_numeric( $value['variant'] ) ) {
				if ( isset( $value['font-style'] ) && 'italic' === $value['font-style'] ) {
					$value['variant'] .= 'i';
				}
			}

			if ( isset( $value['subsets'] ) ) {

				// Add the subset directly to the array of subsets in the Kirki_GoogleFonts_Manager object.
				// Subsets must be applied to ALL fonts if possible.
				if ( ! is_array( $value['subsets'] ) ) {
					$this->subsets[] = $value['subsets'];
				} else {
					foreach ( $value['subsets'] as $subset ) {
						$this->subsets[] = $subset;
					}
				}
			}

			// Add the requested google-font.
			if ( ! isset( $this->fonts[ $value['font-family'] ] ) ) {
				$this->fonts[ $value['font-family'] ] = array();
			}
			if ( ! in_array( $value['variant'], $this->fonts[ $value['font-family'] ], true ) ) {
				$this->fonts[ $value['font-family'] ][] = $value['variant'];
			}

		}

		/**
		 * Determines the validity of the selected font as well as its properties.
		 * This is vital to make sure that the google-font script that we'll generate later
		 * does not contain any invalid options.
		 */
		private function process_fonts() {

			// Early exit if font-family is empty.
			if ( empty( $this->fonts ) ) {
				return;
			}

			$valid_subsets = array();
			foreach ( $this->fonts as $font => $variants ) {

				// Determine if this is indeed a google font or not.
				// If it's not, then just remove it from the array.
				if ( ! array_key_exists( $font, $this->google_fonts ) ) {
					unset( $this->fonts[ $font ] );
					continue;
				}

				// Get all valid font variants for this font.
				$font_variants = array();
				if ( isset( $this->google_fonts[ $font ]['variants'] ) ) {
					$font_variants = $this->google_fonts[ $font ]['variants'];
				}

				// Check if the selected subsets exist, even in one of the selected fonts.
				// If they don't, then they have to be removed otherwise the link will fail.
				if ( isset( $this->google_fonts[ $font ]['subsets'] ) ) {
					foreach ( $this->subsets as $subset ) {
						if ( in_array( $subset, $this->google_fonts[ $font ]['subsets'], true ) ) {
							$valid_subsets[] = $subset;
						}
					}
				}
			}
			$this->subsets = $valid_subsets;
		}

		/**
		 * Creates the google-fonts link.
		 */
		private function create_link() {

			// If we don't have any fonts then we can exit.
			if ( empty( $this->fonts ) ) {
				return;
			}

			// Get font-family + subsets.
			$link_fonts = array();
			foreach ( $this->fonts as $font => $variants ) {

				$variants = implode( ',', $variants );

				$link_font = str_replace( ' ', '+', $font );
				if ( ! empty( $variants ) ) {
					$link_font .= ':' . $variants;
				}
				$link_fonts[] = $link_font;
			}

			if ( ! empty( $this->subsets ) ) {
				$this->subsets = array_unique( $this->subsets );
			}

			$this->link = add_query_arg( array(
				'family' => str_replace( '%2B', '+', urlencode( implode( '|', $link_fonts ) ) ),
				'subset' => urlencode( implode( ',', $this->subsets ) ),
			), 'https://fonts.googleapis.com/css' );

		}

		/**
		 * Return an array of all available Google Fonts.
		 *
		 * @return array    All Google Fonts.
		 */
		private function get_google_fonts() {

			if ( null === $this->google_fonts || empty( $this->google_fonts ) ) {

				$fonts = include_once wp_normalize_path( Avada::$template_dir_path . '/includes/avadaredux/custom-fields/typography/googlefonts-array.php' );

				$google_fonts = array();
				if ( is_array( $fonts ) ) {
					foreach ( $fonts['items'] as $font ) {
						$google_fonts[ $font['family'] ] = array(
							'label'    => $font['family'],
							'variants' => $font['variants'],
							'subsets'  => $font['subsets'],
							'category' => $font['category'],
						);
					}
				}

				$this->google_fonts = $google_fonts;
			}

			return $this->google_fonts;

		}
	}
}
