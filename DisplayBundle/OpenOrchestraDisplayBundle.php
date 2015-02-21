<?php

namespace OpenOrchestra\DisplayBundle;

use OpenOrchestra\DisplayBundle\DependencyInjection\Compiler\DisplayBlockCompilerPass;
use OpenOrchestra\DisplayBundle\DependencyInjection\Compiler\DisplayFieldCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class OpenOrchestraDisplayBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container); // TODO: Change the autogenerated stub

        $container->addCompilerPass(new DisplayBlockCompilerPass());
    }
}