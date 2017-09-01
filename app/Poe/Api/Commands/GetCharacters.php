<?php
/**
 * Created by PhpStorm.
 * User: bleduc
 * Date: 31/08/17
 * Time: 15:02
 */

    namespace App\Poe\Api\Commands;

    class GetCharacters extends ApiCommand
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