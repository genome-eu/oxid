<?php
/**
 * This file is part of OXID Genome module.
 */

namespace Genome\GenomeModule\Model;

use Genome\Lib\Util\SignatureHelper;

/**
 * Payment gateway manager.
 * Checks and sets payment method data, executes payment.
 *
 * @mixin \OxidEsales\Eshop\Application\Model\PaymentGateway
 */
class PaymentGateway extends PaymentGateway_parent
{
    use CommonTrait;
    
    public function __construct() {
        $this->getLogger();
        $this->getGenomeService();
        $this->logger->setTitle('Order payment proceed');
        parent::__construct();
    }
    
    /**
     * Executes payment, returns true on success.
     *
     * @param float                            $amount Goods amount.
     * @param \Genomee\GenomeModule\Model\Order $order  User ordering object.
     *
     * @return bool
     */
    public function executePayment(float $amount, \Genome\GenomeModule\Model\Order &$order): bool
    {
        $success = parent::executePayment($amount, $order);
        $session = \OxidEsales\Eshop\Core\Registry::getSession();

        if ( ($session->getVariable('paymentid') == 'oxidgenome')
             || ($session->getBasket()->getPaymentId() == 'oxidgenome')
        ) {
            $success = $this->doCheckoutPayment();
        }

        return $success;
    }

    /**
     * Executes "DoCheckoutPayment" to Genome
     *
     * @return bool
     */
    public function doCheckoutPayment(): bool
    {
        $order = oxNew(\OxidEsales\Eshop\Application\Model\Order::class);
        $order->loadGenomeOrder();
        $orderId = $order->getId();
        $session = \OxidEsales\Eshop\Core\Registry::getSession();

        try {
            
            $lang = $this->genomeService->getLangCode();
            
            $basket = $session->getBasket();
            $user = $this->getUser();
            $userDetails = $user->getDetails();

            $params = [
                'key' => $this->genomeService->getPublicKey(),
                'uniqueuserid' => $userDetails['customer_id'],
                'email' => $userDetails['email'],
                'firstname' => $userDetails['firstname'],
                'lastname' => $userDetails['lastname'],
                'locale' => $lang . '-' . strtoupper($lang),
                'city' => $userDetails['city'],
                'zip' => $userDetails['zip'],
                'address' => $userDetails['address'],
                'country' => $userDetails['country'],
                'phone' => $userDetails['phone'],
            ];
            
            if ($order && $orderId) {
                $order->genomeUpdateOrderNumber();
                
                $params['uniqueTransactionId'] = $orderId;
                $params['customProduct'] = '[' . json_encode([
                    'productType' => 'fixedProduct',
                    'productId'   => $orderId,
                    'productName' => 'Order id #' . $orderId,
                    'currency'    => $basket->getBasketCurrency()->name,
                    'amount'      => $basket->getPriceForPayment(),
                ]) . ']';

                $params['signature'] = (new SignatureHelper())->generateForArray($params, $this->genomeService->getPrivateKey(), true);
                $params['customProduct'] = htmlspecialchars($params['customProduct']);
            }

        } catch (\OxidEsales\Eshop\Core\Exception\StandardException $excp) {
            return false;
        }
        $this->logger->log('Redirect to genome payment processing');
        $this->genomeService->redirect($params);

        return true;
    }
}
