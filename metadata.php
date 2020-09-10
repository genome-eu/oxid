<?php
/**
 * This file is part of OXID Genome module.
 */

/**
 * Metadata version
 */
$sMetadataVersion = '2.0';

/**
 * Module information
 */
$aModule = array(
    'id'           => 'genome',
    'title'        => 'Genome',
    'description'  => array(
        'de' => 'Modul für die Zahlung mit Genome.',
        'en' => 'Module for Genome payment.',
    ),
    'thumbnail'    => 'logo.png',
    'version'      => '1.0.0',
    'author'       => 'Genome',
    'url'          => 'https://genome.eu',
    'email'        => 'admin@genome.eu',
    'extend'       => array(
        \OxidEsales\Eshop\Core\ViewConfig::class                              => \Genome\GenomeModule\Core\ViewConfig::class,
        \OxidEsales\Eshop\Application\Controller\PaymentController::class     => \Genome\GenomeModule\Controller\PaymentController::class,
        \OxidEsales\Eshop\Application\Controller\ThankYouController::class    => \Genome\GenomeModule\Controller\ThankYouController::class,
        \OxidEsales\Eshop\Application\Controller\FrontendController::class    => \Genome\GenomeModule\Controller\FrontendController::class,
        \OxidEsales\Eshop\Application\Model\User::class                       => \Genome\GenomeModule\Model\User::class,
        \OxidEsales\Eshop\Application\Model\Order::class                      => \Genome\GenomeModule\Model\Order::class,
        \OxidEsales\Eshop\Application\Model\PaymentGateway::class             => \Genome\GenomeModule\Model\PaymentGateway::class,
    ),
    'controllers' => array(
        'genomestandarddispatcher'        => \Genome\GenomeModule\Controller\StandardDispatcher::class,
        'genomeorder'                     => \Genome\GenomeModule\Controller\FrontendController::class,
        'genomerefund_genome'             => \Genome\GenomeModule\Controller\Admin\RefundController::class
    ),
    'events'       => array(
        'onActivate'   => '\Genome\GenomeModule\Core\Events::onActivate',
        'onDeactivate' => '\Genome\GenomeModule\Core\Events::onDeactivate'
    ),
    'templates' => array(
        'order_genome.tpl' => 'genome/views/admin/tpl/order_genome.tpl',
        'refund_success.tpl' => 'genome/views/admin/tpl/refund_success.tpl',
        'refund_failed.tpl' => 'genome/views/admin/tpl/refund_failed.tpl',
        'order_history.tpl' => 'genome/views/tpl/page/account/order_history.tpl',
        'postback.tpl' => 'genome/views/tpl/postback.tpl',
    ),
    'blocks' => array(
        array('template' => 'page/checkout/payment.tpl',          'block'=>'select_payment',                        'file'=>'/views/tpl/genomepaymentselector.tpl'),
        array('template' => 'page/checkout/thankyou.tpl',         'block'=>'checkout_thankyou_proceed',             'file'=>'/views/tpl/thankyou.tpl'),
        array('template' => 'page/account/order.tpl',             'block'=>'account_order_history',                 'file'=>'/views/tpl/page/account/order.tpl'),
     ),
    'settings' => array(
        array('group' => 'genome_settings',    'name' => 'sGenomePublickKey',               'type' => 'str',      'value' => ''),
        array('group' => 'genome_settings',    'name' => 'sGenomePrivateKey',               'type' => 'str',      'value' => ''),
        array('group' => 'genome_development', 'name' => 'blGenomeSandboxMode',             'type' => 'bool',     'value' => 'false'),
        array('group' => 'genome_development', 'name' => 'sGenomeTestPublicKey',            'type' => 'str',      'value' => ''),
        array('group' => 'genome_development', 'name' => 'sGenomeTestPrivateKey',           'type' => 'str',      'value' => ''),
    )
);
