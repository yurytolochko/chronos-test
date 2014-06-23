<?php

namespace Acme\DemoBundle\Command;

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
class RecoverCommand extends Command
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
        if (file_exists('status.tmp')) {
            $status = file_get_contents('status.tmp');
        } else {
            $status = 'done';
        }

        $status = $status == 'done' ? 'fail' : 'done';

        file_put_contents('status.tmp', $status);
        file_put_contents('output.log', date('Y-m-d H:i:s') . ' RecodeCommand: ' . $status . PHP_EOL, FILE_APPEND);
        $output->writeln($status);

        return $status == 'done' ? 0 : 1;
    }
}
