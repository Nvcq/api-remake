<?php

namespace App\Command;

use App\Entity\Coin;
use App\Entity\Exchange;
use App\Entity\Tag;
use App\Entity\Ticker;
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
        $randomUserApi = $this->client->request(
            'GET',
            'https://randomuser.me/api/?results=10&inc=gender,name,email,dob,location,picture',
        );

        $content = $randomUserApi->getContent();
        $data = json_decode($content);

        $exchangeApiCall = $this->client->request(
            'GET',
            'https://api.coinpaprika.com/v1/exchanges',
        );
        $exchangeData = $exchangeApiCall->getContent();
        $exchanges = json_decode($exchangeData);

        $coinApiCall = $this->client->request(
            'GET',
            'https://api.coinpaprika.com/v1/coins',
        );
        $coinData = $coinApiCall->getContent();
        $coins = json_decode($coinData);

        $tagApiCall = $this->client->request(
            'GET',
            'https://api.coinpaprika.com/v1/tags',
        );
        $tagData = $tagApiCall->getContent();
        $tags = json_decode($tagData);

        $tickerApiCall = $this->client->request(
            'GET',
            'https://api.coinpaprika.com/v1/ticker',
        );
        $tickerData = $tickerApiCall->getContent();
        $tickers = json_decode($tickerData);


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

            $exchange = new Exchange();
            $exchange->setName($exchanges[$i]->name);
            $exchange->setDescription($exchanges[$i]->description);
            $exchange->setActive($exchanges[$i]->active);
            $exchange->setMessage($exchanges[$i]->message);
            $exchange->setWebsite($exchanges[$i]->links->website[0]);
            $this->em->persist($exchange);

            $coin = new Coin();
            $coin->setName($coins[$i]->name);
            $coin->setSymbol($coins[$i]->symbol);
            $coin->setRanked($coins[$i]->rank);
            $coin->setIsNew($coins[$i]->is_new);
            $coin->setIsActive($coins[$i]->is_active);
            $coin->setType($coins[$i]->type);
            $this->em->persist($coin);

            $tag = new Tag();
            $tag->setName($tags[$i]->name);
            $tag->setDescription($tags[$i]->description);
            $tag->setType($tags[$i]->type);
            $tag->setCoinCounter($tags[$i]->coin_counter);
            $tag->setIcoCounter($tags[$i]->ico_counter);
            $this->em->persist($tag);

            $ticker = new Ticker();
            $ticker->setName($tickers[$i]->name);
            $ticker->setSymbol($tickers[$i]->symbol);
            $ticker->setRanked($tickers[$i]->rank);
            $ticker->setCirculatingSupply($tickers[$i]->circulating_supply / 1000);
            $ticker->setTotalSupply($tickers[$i]->total_supply / 1000);
            $ticker->setPrice($tickers[$i]->price_usd);
            $this->em->persist($ticker);

        }

        $this->em->flush();

        $output->writeln("Data inserted");

        return Command::SUCCESS;
    }
}