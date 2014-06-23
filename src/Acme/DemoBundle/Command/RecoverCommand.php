<?php

namespace Acme\DemoBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Hello World command for demo purposes.
 *
 * You could also extend from Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand
 * to get access to the container via $this->getContainer().
 *
 * @author Tobias Schultze <http://tobion.de>
 */
class RecoverCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('acme:recover');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $folder = $this->getContainer()->getParameter('kernel.root_dir') . '/../';

        if (file_exists($folder . 'status.tmp')) {
            $status = file_get_contents($folder . 'status.tmp');
        } else {
            $status = 'done';
        }

        $status = $status == 'done' ? 'fail' : 'done';

        file_put_contents($folder . 'status.tmp', $status);
        file_put_contents($folder . 'output.log', date('Y-m-d H:i:s') . ' RecodeCommand: ' . $status . PHP_EOL, FILE_APPEND);
        $output->writeln($status);

        return $status == 'done' ? 0 : 1;
    }
}
