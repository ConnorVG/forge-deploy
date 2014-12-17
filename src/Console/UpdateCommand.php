<?php namespace ConnorVG\Deploy\Console;

use ConnorVG\Deploy\DataInteractor;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Created by Connor S. Parks.
 */
class UpdateCommand extends Command {

    /**
     * Configure the command options.
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('update')
            ->setDescription('Updates a deployment endpoint')
            ->addArgument('name', InputArgument::REQUIRED, 'The name of the deployment')
            ->addArgument('endpoint', InputArgument::REQUIRED, 'The endpoint of the deployment')
            ->addOption('config', 'c', InputOption::VALUE_OPTIONAL, 'The configuration to use');;
    }

    /**
     * Execute the command.
     *
     * @param  \Symfony\Component\Console\Input\InputInterface  $input
     * @param  \Symfony\Component\Console\Output\OutputInterface  $output
     * @return void
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        $endpoint = $input->getArgument('endpoint');
        $config = $input->getOption('config') ?: 'default';

        $data = DataInteractor::load($config);
        if (!array_key_exists($name, $data))
        {
            $output->writeln('<error>A deployment with the name ' . $name . ' doesn\'t exist!</error>');

            return;
        }

        $data[$name] = $endpoint;
        DataInteractor::save($data, $config);

        $output->writeln('<info>' . $name . ' has been updated for the ' . $config . ' config!</info>');
    }

}
