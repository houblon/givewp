<?php

namespace Give\Framework\PaymentGateways\Contracts;

use Give\Framework\LegacyPaymentGateways\Contracts\LegacyPaymentGatewayInterface;
use Give\PaymentGateways\DataTransferObjects\FormData;
use Give\PaymentGateways\DataTransferObjects\SubscriptionData;

/**
 * @unreleased
 */
abstract class PaymentGateway implements PaymentGatewayInterface, LegacyPaymentGatewayInterface {
	public $subscriptionModule;

	/**
	 * @inheritDoc
	 */
	public function mountSubscriptionModule( $subscriptionModuleClass ) {
		$this->subscriptionModule = $subscriptionModuleClass;
	}

	/**
	 * @inheritDoc
	 */
	public function getSubscriptionModule() {
		return give( $this->subscriptionModule );
	}


	/**
	 * @inheritDoc
	 */
	public function hasSubscriptionModule() {
		return isset( $this->subscriptionModule );
	}

	/**
	 * @inheritDoc
	 */
	public function handleSubscriptionRequest( $donationId, FormData $formData, SubscriptionData $subscriptionData ) {
		return $this->getSubscriptionModule()->handleSubscriptionRequest( $donationId, $formData, $subscriptionData );
	}

}
