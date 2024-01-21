<?php

namespace App\Console;

use App\Models\Company;
use App\Models\Employee;
use App\Models\Office;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Support\Facades\Schema;
use Slim\App;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Faker\Factory as FakerFactory;

class PopulateDatabaseCommand extends Command
{
    private App $app;
    private $faker;

    public function __construct(App $app)
    {
        $this->app = $app;
        $this->faker = FakerFactory::create();
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('db:populate');
        $this->setDescription('Populate database');
    }

    protected function execute(InputInterface $input, OutputInterface $output ): int
    {
        $output->writeln('Populate database...');

        $this->populateCompanies();
        $this->populateOffices();
        $this->populateEmployees();

        $output->writeln('Database created successfully!');
        return 0;
    }

    private function populateCompanies()
    {
        $db = $this->app->getContainer()->get('db');

        // Utilisation de Faker pour générer des données aléatoires pour les entreprises
        $db->table('companies')->insert([
            [
                'name' => $this->faker->company,
                'phone' => $this->faker->phoneNumber,
                'email' => $this->faker->companyEmail,
                'website' =>  'http://'.$this->faker->company.'.com',
                'image' => $this->faker->url,
                'created_at' =>  $this->faker->date,
                'updated_at' =>  $this->faker->date
            ],
        ]);
    }

    private function populateOffices()
    {
        $db = $this->app->getContainer()->get('db');

        // Utilisation de Faker pour générer des données aléatoires pour les bureaux
        $db->table('offices')->insert([
            [
                'name' => $this->faker->company . ' Office',
                'address' => $this->faker->address,
                'city' => $this->faker->city,
                'zip_code' => $this->faker->postcode,
                'country' => $this->faker->country,
                'email' => $this->faker->companyEmail,
                'phone'=> $this->faker->phoneNumber,
                'company_id'=>$this->faker->numberBetween(0,5),
                'created_at' =>  $this->faker->date,
                'updated_at' =>  $this->faker->date
            ]
        ]);
    }

    private function populateEmployees()
    {
        $db = $this->app->getContainer()->get('db');

        // Utilisation de Faker pour générer des données aléatoires pour les employés
        $db->table('employees')->insert([
            [
                'first_name' => $this->faker->firstName,
                'last_name' => $this->faker->lastName,
                'office_id' => $this->faker->numberBetween(1, 4),
                'email' => $this->faker->email,
                'phone'=> $this->faker->phoneNumber,
                'job_title' => $this->faker->jobTitle,
                'created_at' =>  $this->faker->date,
                'updated_at' =>  $this->faker->date
            ]
        ]);
    }
}
