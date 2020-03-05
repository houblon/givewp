<?php

/**
 * Reports base endpoint
 *
 * @package Give
 */

namespace Give\API\Endpoints\Reports;

class PaymentStatuses extends Endpoint {

	public function __construct() {
		$this->endpoint = 'payment-statuses';
	}

	public function get_report( $request ) {

		$start = date_create( $request['start'] );
		$end   = date_create( $request['end'] );

		// Setup args for give_count_payments
		$args = array(
			'start-date' => $start->format( 'Y-m-d H:i:s' ),
			'end-date'   => $end->format( 'Y-m-d H:i:s' ),
		);

		// Use give_count_payments logic to get payments
		$payments = give_count_payments( $args );

		$status = $this->get_give_status();

		return new \WP_REST_Response(
			array(
				'status' => $status,
				'data'   => array(
					'labels'   => array(
						'Completed',
						'Pending',
						'Refunded',
						'Abandoned',
						'Cancelled',
						'Failed',
					),
					'datasets' => array(
						array(
							'data'     => array(
								$payments->publish + $payments->give_subscription,
								$payments->pending,
								$payments->refunded,
								$payments->abandoned,
								$payments->cancelled,
								$payments->failed,
							),
							'tooltips' => array(
								array(
									'title'  => $payments->publish + $payments->give_subscription . ' ' . __( 'Payments', 'give' ),
									'body'   => __( 'Completed', 'give' ),
									'footer' => '',
								),
								array(
									'title'  => $payments->pending . ' ' . __( 'Payments', 'give' ),
									'body'   => __( 'Pending', 'give' ),
									'footer' => '',
								),
								array(
									'title'  => $payments->refunded . ' ' . __( 'Payments', 'give' ),
									'body'   => __( 'Refunded', 'give' ),
									'footer' => '',
								),
								array(
									'title'  => $payments->abandoned . ' ' . __( 'Payments', 'give' ),
									'body'   => __( 'Abandoned', 'give' ),
									'footer' => '',
								),
								array(
									'title'  => $payments->cancelled . ' ' . __( 'Payments', 'give' ),
									'body'   => __( 'Cancelled', 'give' ),
									'footer' => '',
								),
								array(
									'title'  => $payments->failed . ' ' . __( 'Payments', 'give' ),
									'body'   => __( 'Failed', 'give' ),
									'footer' => '',
								),
							),
						),
					),
				),
			)
		);
	}
}
