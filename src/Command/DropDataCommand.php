<?php
namespace App\Command;

use App\Repository\ProductRepository;
use App\Repository\RegionTaxRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:drop-data',
    description: 'Drops all data',
    hidden: false
)]
class DropDataCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $em,
        private ProductRepository $productRepository,
        private RegionTaxRepository $regionTaxRepository
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $done = $this->productRepository
            ->createQueryBuilder('p')
            ->delete()
            ->getQuery()
            ->execute();

        $done += $this->regionTaxRepository
            ->createQueryBuilder('rt')
            ->delete()
            ->getQuery()
            ->execute();

        $output->writeln('Done! Removed: '.$done);

        return 0;
    }
}