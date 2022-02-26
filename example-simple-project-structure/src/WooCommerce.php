<?php

namespace Wordcamp\Prague\Wpify;

class WooCommerce {
	/**
	 * @param PDF $pdf
	 */
	public function __construct( private PDF $pdf ) {
		add_action( 'woocommerce_process_product_meta', [ $this, 'save_custom_fields' ] );
	}

	/**
	 * Save custom fields
	 *
	 * @param $post_id
	 *
	 * @return void
	 */
	public function save_custom_fields( $post_id ) {
		$woocommerce_custom_product_a_field = $_POST['_custom_field_a'];
		update_post_meta( $post_id, '_custom_field_a', esc_attr( $woocommerce_custom_product_a_field ) );

		if ( ! empty( $woocommerce_custom_product_a_field ) && ! is_array( $woocommerce_custom_product_a_field ) ) {
			$this->pdf->generate_pdf();
		}
	}
}