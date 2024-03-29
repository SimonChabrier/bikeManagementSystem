<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Bike;
use App\Entity\User;
use App\Entity\Repair;
use App\Entity\Station;
use App\Entity\Inventory;
use App\Entity\Balance;
use App\Entity\Vandalism;
use App\Entity\RepairAct;
use DateTimeImmutable;
//  https://fakerphp.github.io/
use Faker\Factory as Faker;
use Doctrine\DBAL\Connection;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use PhpParser\Node\Expr\New_;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $hasher;
    private $connexion;
    protected $faker;

    public function __construct(Connection $connexion, UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
        $this->connexion = $connexion;
    }

    private function truncate()
    {
        // Unactive foreign key check to make truncate command working
        // TRUNCATE set Auto Increment and Id start at 1
        $this->connexion->executeQuery('SET foreign_key_checks = 0');
        $this->connexion->executeQuery('TRUNCATE TABLE user');
        $this->connexion->executeQuery('TRUNCATE TABLE bike');
        $this->connexion->executeQuery('TRUNCATE TABLE station');
        $this->connexion->executeQuery('TRUNCATE TABLE repair');
        $this->connexion->executeQuery('TRUNCATE TABLE vandalism');
        $this->connexion->executeQuery('TRUNCATE TABLE inventory');
        $this->connexion->executeQuery('TRUNCATE TABLE inventory_bike');
        $this->connexion->executeQuery('TRUNCATE TABLE repair_act');
        $this->connexion->executeQuery('TRUNCATE TABLE balance');
        $this->connexion->executeQuery('TRUNCATE TABLE balance_station');
    }

    public function load(ObjectManager $manager): void
    {   
        // empty all database entitities before start
        $this->truncate(); 

        $faker = Faker::create('fr_FR');

        // prepare table for use later
        $allStationEntity = [];
        $allBikeEntity = [];
        $allRepairEntity = [];

        //USER
        $user = new User();
        $user->setStatus(1)
            ->setRoles(["ROLE_ADMINISTRATEUR"])
            ->setEmail("admin@admin.fr")
            ->setIsVerified(1)
            ->setPassword($this->hasher->hashPassword($user,"password"))
            ->setCompany("autre")
            ->setJob("developpeur")
            ->setFirstName("Simon")
            ->setLastName("Chabrier")
            ->setAddress("168 Quai Baudin")
            ->setZip("47000")
            ->setCity("Agen")
            ->setPhone("0556667543");

        $manager->persist($user);    

        $user = new User();
        $user->setStatus(1)
            ->setRoles(["ROLE_MONITEUR"])
            ->setEmail('moniteur@moniteur.fr')
            ->setIsVerified(1)
            ->setPassword($this->hasher->hashPassword($user,"password"))
            ->setCompany("Serbat")
            ->setJob("Moniteur")
            ->setFirstName("Moniteur")
            ->setLastName("Le Moniteur")
            ->setAddress("16 rue de jonquilles")
            ->setZip("47000")
            ->setCity("Agen")
            ->setPhone("0556567389");

        $manager->persist($user);   

        $user = new User();
        $user->setStatus(1)
            ->setRoles(["ROLE_PARTENAIRE"])
            ->setEmail('partenaire@partenaire.fr')
            ->setIsVerified(1)
            ->setPassword($this->hasher->hashPassword($user,"password"))
            ->setCompany("Tempo")
            ->setJob("Partenaire")
            ->setFirstName("Partenaire")
            ->setLastName("Le Partenaire")
            ->setAddress("16 rue de jonquilles")
            ->setZip("47000")
            ->setCity("Agen")
            ->setPhone("0556567389");

        $manager->persist($user);   

        $user = new User();
        $user->setStatus(1)
            ->setRoles(["ROLE_TRAVAILLEUR"])
            ->setEmail('travailleur@travailleur.fr')
            ->setIsVerified(1)
            ->setPassword($this->hasher->hashPassword($user,"password"))
            ->setCompany("Serbat")
            ->setJob("Travailleur")
            ->setFirstName("Travailleur")
            ->setLastName("Le Travailleur")
            ->setAddress("16 rue de jonquilles")
            ->setZip("47000")
            ->setCity("Agen")
            ->setPhone("0556567389");

        $manager->persist($user);    
        
        //REPAIR
        $repairList = [
            "Serrure", 
            "Boitier de commande", 
            "Garde-boue AV", 
            "Eclairage AV", 
            "Roue AR crevée", 
            "Eclairage AR", 
            "Pédalier", 
            "Batterie", 
            "Garde-boue AR",
            "Roue AV crevée",
            "Assistance électrique",
            "Dérailleur",
            "Selle",
            "Catadioptre manquant",
            "Autre",
            "Bouton activation clavier gelé",
            "Buée intérieure sur tableau de bord vélo",
        ];

        foreach ($repairList as $key => $repairName) {
            $repair = new Repair();
            $repair->setReference('ref_' . $key)
                    ->setName($repairName);

            $allRepairEntity[] = $repair;

            $manager->persist($repair);
        }

        

        //BIKE
        for ($i = 425; $i <= 434; $i++){
 
            $date = \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-15 days', 'now'));
            
            $bike = new Bike();
            $bike->setReference('ref_' . $i)
            ->setNumber($i)
            ->setUpdatedAt($date)
            ->setRate(mt_rand(2, 5));

            $allBikeEntity[] = $bike;

            // set random value for $avalability
            $avalability = mt_rand(1, 5);

            if($avalability === 1 ){
                $avalability = "Disponible";
                $bike->setStatus(true);
            };
            if($avalability === 2 ){
                $avalability = "Bloqué - Maintenance";
                $bike->setStatus(false);
            };
            if($avalability === 3 ){
                $avalability = "Dépôt - Panne";
                $bike->setStatus(false);
            };
            if($avalability === 4 ){
                $avalability = "Dépôt - Stock";
                $bike->setStatus(false);
            };
            if($avalability === 5 ){
                $avalability = "Disparu";
                $bike->setStatus(false);
            };

            $bike->setAvailablity($avalability);

            $manager->persist($bike);
        }

        for ($i = 473; $i <= 484; $i++){
           
            $bike = new Bike();
            $bike->setReference('ref_' . $i)
                ->setNumber($i)
                ->setRate(mt_rand(3, 5))
                ->setUpdatedAt($date)
                ->setStatus(true);

            $allBikeEntity[] = $bike;

            $manager->persist($bike);
        }

        for ($i = 538; $i <= 552; $i++){
            $bike = new Bike();
            $bike->setReference('ref_' . $i)
                ->setNumber($i)
                ->setUpdatedAt($date)
                ->setRate(mt_rand(2, 4))
                ->setStatus(true);

          $allBikeEntity[] = $bike;

            $manager->persist($bike);
        }

        for ($i = 554; $i <= 560; $i++){
            $bike = new Bike();
            $bike->setReference('ref_' . $i)
                ->setNumber($i)
                ->setUpdatedAt($date)
                ->setRate(mt_rand(3, 5))
                ->setStatus(true);

            $allBikeEntity[] = $bike;

            $manager->persist($bike);
        }
        
        for ($i = 1272; $i <= 1310; $i++){
            $bike = new Bike();
            $bike->setReference('ref_' . $i)
                ->setNumber($i)
                ->setUpdatedAt($date)
                ->setRate(mt_rand(3, 5))
                ->setStatus(true);

            $allBikeEntity[] = $bike;

            $manager->persist($bike);
        }

        //STATION
        $stationList = [
            1 => "Gare", 
            2 =>"Université", 
            3 => "Jasmin", 
            4 => "Préfecture", 
            5 => "Pin", 
            5 => "Place des Laitiers", 
            6 => "Jayan", 
            8 => "Gravier", 
            9 => "Toussaint",
            10 =>"Stade",
            11 => "Parc Chabot",
            12 => "Duvergé",
            13 => "Schumann",
            14 => "La Passage - Poste",
            15 => "Bon Encontre - Mairie",
            16 => "Pont-Du-Casse - Mairie",
            ];
        
        foreach ($stationList as $key => $stationName) {
            $station = new Station();
            $station->setNumber($key)
                ->setReference('ref_' . $key)
                ->setName($stationName)
                ->setCapacity(mt_rand(3, 20))
                ->setMainPicture('https://www.agglo-agen.net/fileadmin/_processed_/f/0/csm_stations-velos-keolys-details_8b5165c4eb.jpg');
            
            $allStationEntity[] = $station;

            if ($key != 14 || $key != 15 || $key != 16 ) {
                $station->setZip("47000");
                $station->setCity("Agen");
                $station->setAddress("La station est à Agen");
            };

            if($key === 14) {
                $station->setZip("47520");
                $station->setCity("Le Passage");
                $station->setAddress("La station est à Le Passage");
            };

            if($key === 15) {
                $station->setZip("47240");
                $station->setCity("Bon Encontre");
                $station->setAddress("La station est à Bon Encontre");
            };

            if($key === 16) {
                $station->setZip("47480");
                $station->setCity("Pont du Casse");
                $station->setAddress("La station est à Pont du Casse");
            };

            $manager->persist($station);
        }

        //VANDALISM
        for ($i = 1; $i <= 50; $i++){

            $date = \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-8 days', 'now'));
            $randomStation = $allStationEntity[mt_rand(1, count($allStationEntity) - 1)];
            $randomBike = $allBikeEntity[mt_rand(1, count($allBikeEntity) - 1)];
            
            $vandalism = new Vandalism();
            $vandalism->setMainPicture('https://picsum.photos/id/'.mt_rand(1, 100).'/400/400')
            ->setContent($faker->sentence(10))
            ->setStation($randomStation)
            ->setBike($randomBike)
            ->setCreatedAt($date);
            
            $manager->persist($vandalism);
        }

        //INVENTORY
        for ($i = 1; $i <= 50; $i++){

            $date = \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-8 days', 'now'));

            $randomStation = $allStationEntity[mt_rand(1, count($allStationEntity) - 1)];

            $inventory = New Inventory();
            $inventory->setCreatedAt($date)
            ->setStation($randomStation);

            $manager->persist($inventory);

            for ($j = 1; $j <= 10; $j++){

                $randomBike = $allBikeEntity[array_rand($allBikeEntity)];
                $inventory->addBike($randomBike);

                $manager->persist($inventory);
            
            };
        }

        //BALANCE
        for ($i = 1; $i <= 50; $i++){

            $date = \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-8 days', 'now'));
            $randomBike = $allBikeEntity[array_rand($allBikeEntity)];
            
            $balance = New Balance();
            $balance->setCreatedAt($date)
            ->setBike($randomBike);

                $randomStationFrom = $allStationEntity[mt_rand(8, count($allStationEntity) - 1)];
                $balance->addStation($randomStationFrom);
            
                $randomStationTo = $allStationEntity[mt_rand(1, 7 - 1)];
                $balance->addStation($randomStationTo);
            

            $manager->persist($balance);
        }

        //REPAIR ACT
        for ($i = 1; $i <= 50; $i++){

            $date = \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-8 days', 'now'));
            $randomStation = $allStationEntity[mt_rand(1, count($allStationEntity) - 1)];
            $randomBike = $allBikeEntity[mt_rand(1, count($allBikeEntity) - 1)];
            $randomRepair = $allRepairEntity[mt_rand(1, count($allRepairEntity) - 1)];

            $repairAct = New RepairAct();
            $repairAct->setCreatedAt($date)
            ->setStation($randomStation)
            ->setBike($randomBike)
            ->setRepair($randomRepair);

            $manager->persist($repairAct);
        }

        // PERSIST ALL ACTIONS IN DATA BASE
        $manager->flush();

    }
}