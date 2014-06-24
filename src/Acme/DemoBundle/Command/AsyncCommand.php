<?php

namespace Acme\DemoBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Trivago\Chronos\Chronos;

/**
 * Hello World command for demo purposes.
 *
 * You could also extend from Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand
 * to get access to the container via $this->getContainer().
 *
 * @author Tobias Schultze <http://tobion.de>
 */
class AsyncCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('acme:async');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $folder = $this->getContainer()->getParameter('kernel.root_dir') . '/../';

        $client = new Chronos('192.168.1.51:8080');
        $client->completeAsyncJob($_SERVER['MESOS_TASK_ID'], 0);

        file_put_contents($folder . 'output.log', date('Y-m-d H:i:s') . ' AsyncCommand ' . $_SERVER['MESOS_TASK_ID'] . PHP_EOL, FILE_APPEND);
        $output->writeln('Async done!');
        return 0;
    }
}
