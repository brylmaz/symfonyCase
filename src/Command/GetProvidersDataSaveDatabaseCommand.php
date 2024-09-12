<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Jobs;
use App\Entity\Providers;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Doctrine\ORM\EntityManagerInterface;

class GetProvidersDataSaveDatabaseCommand extends Command
{
    // php bin/console providers:getDataSaveDatabase"
    public function __construct(
        private HttpClientInterface $client,
        private ParameterBagInterface $parameters,
        private EntityManagerInterface $entityManager
    )
    {
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('providers:getDataSaveDatabase')
            ->setDescription('data will be extracted from the providers and saved in the database');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        foreach ($_ENV as $key => $value) {
            if (strpos($key, 'PROVIDER') === 0 && strpos($key, '_URL') !== false) {
                $response = $this->client->request('GET', $value);

                $provider = new Providers();
                $provider->setName($key);
                $this->entityManager->persist($provider);
                $this->entityManager->flush();

                $jsonDataArr = $response->toArray();
                foreach ($jsonDataArr as $jsonData) {
                    $jobEntity = new Jobs();
                    $jobEntity->setProvider($provider);
                    $jobEntity->setStatus(true);

                    if(isset($jsonData['value'])){
                        $jobEntity->setDifficulty($jsonData['value']);
                    }else{
                        $jobEntity->setDifficulty($jsonData['zorluk']);
                    }

                    if(isset($jsonData['estimated_duration'])){
                        $jobEntity->setDuration($jsonData['estimated_duration']);
                    }else{
                        $jobEntity->setDuration($jsonData['sure']);
                    }

                    $this->entityManager->persist($jobEntity);
                    $this->entityManager->flush();

                }
            }
        }

        return Command::SUCCESS;
    }
}
