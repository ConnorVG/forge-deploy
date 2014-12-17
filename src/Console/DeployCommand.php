<?php namespace ConnorVG\Deploy\Console;

use GuzzleHttp\Client;
use ConnorVG\Deploy\DataInteractor;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Created by Connor S. Parks.
 */
class DeployCommand extends Command {

    /**
     * Configure the command options.
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('deploy')
            ->setDescription('Deploys to an endpoint')
            ->addArgument('name', InputArgument::REQUIRED, 'The name of the deployment')
            ->addOption('config', 'c', InputOption::VALUE_OPTIONAL, 'The configuration to use');
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
        $config = $input->getOption('config') ?: 'default';

        $data = DataInteractor::load($config);
        if (!array_key_exists($name, $data))
        {
            $output->writeln('<error>A deployment with the name ' . $name . ' doesn\'t exist!</error>');

            return;
        }

        $client = new Client();
        $response = $client->get($data[$name]);

        if ($response->getStatusCode() !== 200)
        {
            $output->writeln('<error>The endpoint returned an non-200 response!</error>');
            $output->writeln('<comment>Deployment may not of occurred.</comment>');

            return;
        }

        $output->writeln('<info>' . $name . ' has been deployed for the ' . $config . ' config!</info>');
    }

}
