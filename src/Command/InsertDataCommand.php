<?php

namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use App\Entity\RandomUser;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsCommand(
    name: 'app:insert-data',
    description: 'Creates a new random user.',
    hidden: false,
    aliases: ['app:insert-data']
)]
class InsertDataCommand extends Command
{
    public function __construct(EntityManagerInterface $em, HttpClientInterface $client)
    {
        parent::__construct();
        $this->em = $em;
        $this->client = $client;
    }

    protected function configure()
    {
        $this->setName('insertData')
            ->setDescription('Insert data in database')
            ->setHelp('This command insert data in the database');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $response = $this->client->request(
            'GET',
            'https://randomuser.me/api/?results=10&inc=gender,name,email,dob,location,picture',
        );

        $content = $response->getContent();
        $data = json_decode($content);

        for ($i = 0; $i <= 9; $i++) {
            $randomUser = new RandomUser();
            $randomUser->setGender($data->results[$i]->gender);
            $randomUser->setLastname($data->results[$i]->name->last);
            $randomUser->setFirstname($data->results[$i]->name->first);
            $randomUser->setEmail($data->results[$i]->email);
            $randomUser->setAge($data->results[$i]->dob->age);
            $randomUser->setCountry($data->results[$i]->location->country);
            $randomUser->setPicture($data->results[$i]->picture->thumbnail);

            $this->em->persist($randomUser);
        }

        $this->em->flush();

        $output->writeln("Data inserted");

        return Command::SUCCESS;
    }
}