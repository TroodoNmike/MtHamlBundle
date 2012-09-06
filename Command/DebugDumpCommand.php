<?php

namespace MtHamlBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DebugDumpCommand extends ContainerAwareCommand
{
    public function configure()
    {
        $this
            ->setName('mthaml:debug:dump')
            ->setDefinition(array(
                new InputArgument('template-name', InputArgument::REQUIRED, 'A template name'),
            ))
            ->setDescription('Compiles a HAML template and dumps the resulting Twig template')
            ->setHelp(<<<EOF
The <info>%command.name%</info> command compiles a HAML template and dumps the resulting Twig template.

Example:

  <info>php %command.full_name% AcmeDemoBundle:Demo:index.html.haml</info>
EOF
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $loader = $container->get('twig.loader');
        $env = $container->get('mthaml');

        $templateName = $input->getArgument('template-name');

        $source = $loader->getSource($templateName);

        $output->write($env->compileString($source, $templateName));
    }
}
