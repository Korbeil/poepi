<?php
/**
 * Created by PhpStorm.
 * User: bleduc
 * Date: 30/08/17
 * Time: 21:31
 */

    namespace App\Commands;

    use App\Libraries\Poe\PublicStash;
    use Cilex\Provider\Console\Command;
    use Symfony\Component\Console\Input\InputArgument;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Input\InputOption;
    use Symfony\Component\Console\Output\OutputInterface;

    class FetchCommand extends Command
    {
        /**
         * {@inheritDoc}
         */
        protected function configure()
        {
            $this
                ->setName('poe:fetch')
                ->setDescription('Fetch data from PoE public Stash API')
                ->addArgument('next_change_id', InputArgument::OPTIONAL, 'The next change ID from your last update')
                ->addOption('json', 'j', InputOption::VALUE_NONE, 'If set, the raw json will be in standard output.');
        }

        /**
         * {@inheritDoc}
         */
        protected function execute(InputInterface $input, OutputInterface $output)
        {
            $next_change_id = $input->getArgument('next_change_id');
            $publicStash    = PublicStash::request($next_change_id);

            if($input->getOption('json')) {
                $output->writeln($publicStash->json());
            }
        }
    }