<?php

declare(strict_types=1);

namespace Srkits\SyliusRazorPayPlugin\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('srkits_sylius_razor_pay_plugin');
        $rootNode = $treeBuilder->getRootNode();

        return $treeBuilder;
    }
}
