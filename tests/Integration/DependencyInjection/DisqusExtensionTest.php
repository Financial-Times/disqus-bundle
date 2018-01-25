<?php

namespace Inviqa\DisqusBundle\Tests\Integration\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Inviqa\DisqusBundle\DependencyInjection\DisqusExtension;
use PHPUnit\Framework\TestCase;

class DisqusExtensionTest extends TestCase
{
    public function testExtension()
    {
        $configs = [ [
            'public_key' => '1234',
            'secret_key' => '1234',
            'forum_name' => 'hello'
        ] ];

        $container = new ContainerBuilder();
        $extension = new DisqusExtension();
        $extension->load($configs, $container);

        foreach ($container->getServiceIds() as $serviceId) {
            $container->get($serviceId);
        }

        $this->addToAssertionCount(1);
    }
}
