<?php

namespace Wordcamp\Prague\Wpify;

use WordcampDeps\Psr\Log\LoggerInterface;

class PDF {
	public function __construct( private Data $data, private LoggerInterface $logger ) {
	}

	/**
	 * Generate the PDF
	 * @return void
	 */
	public function generate_pdf() {
		$data = $this->data->get_data();
		// Normally we'd probably get the Mpdf from some Factory here, simplified for the example.
		$mpdf = new Mpdf\Mpdf();
		$mpdf->WriteHTML( $data );
		$mpdf->Output( 'pdfs/doc.pdf' );
		$this->logger->info( 'PDF Generated' );
		exit();
	}
}

