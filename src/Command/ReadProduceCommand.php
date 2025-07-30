<?php
namespace App\Command;

use App\Service\ProduceService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:read-produce',
    description: 'Reads a JSON file containing vegetables and fruits and adds them to the database.'
)]
class ReadProduceCommand extends Command
{
    public function __construct(private ProduceService $produceService) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $fileContent = file_get_contents($input->getArgument('file'));

        if ($fileContent === false) {
            $output->writeln('Error reading input file!');
            return Command::FAILURE;
        }
        
        $parsed = json_decode($fileContent, true);

        if ($parsed === null) {
            $output->writeln('Error decoding input file as JSON!');
            return Command::FAILURE;
        }

        $processedItems = $this->produceService->loadProduceData($parsed);

        $output->writeln("Successfully loaded $processedItems items of produce data!");

        return Command::SUCCESS;
    }

    protected function configure(): void
    {
        $this->addArgument('file', InputArgument::OPTIONAL, 'The file to read JSON data from.', 'request.json');
    }
}