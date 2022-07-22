<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Bike;
use App\Entity\User;
use App\Entity\Repair;
use App\Entity\Station;
use App\Entity\Inventory;
use App\Entity\Vandalism;
use Faker\Factory as Faker;
//  https://fakerphp.github.io/
use Doctrine\DBAL\Connection;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
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
        // On désactive la vérification des FK
        // Sinon les truncate ne fonctionne pas.
        $this->connexion->executeQuery('SET foreign_key_checks = 0');
        // la requete TRUNCATE remet l'auto increment à 1
        $this->connexion->executeQuery('TRUNCATE TABLE user');
        $this->connexion->executeQuery('TRUNCATE TABLE bike');
        $this->connexion->executeQuery('TRUNCATE TABLE station');
        $this->connexion->executeQuery('TRUNCATE TABLE repair');
        $this->connexion->executeQuery('TRUNCATE TABLE vandalism');
        $this->connexion->executeQuery('TRUNCATE TABLE inventory');
        $this->connexion->executeQuery('TRUNCATE TABLE inventory_bike');
    }

    public function load(ObjectManager $manager): void
    {   
        // empty all database entitities before start
        $this->truncate(); 

        // https://fakerphp.github.io/#localization
        $faker = Faker::create('fr_FR');

        $allStationEntity = [];
        $allBikeEntity = [];

        //USER

        $user = new User();
        $user->setStatus(1)
            ->setRoles(["ROLE_ADMINISTRATEUR"])
            ->setEmail("admin@admin.fr")
            ->setIsVerified(1)
            ->setPassword($this->hasher->hashPassword($user,"simon"))
            ->setCompany("autre")
            ->setJob("partenaire")
            ->setFirstName("Simon")
            ->setLastName("Chabrier")
            ->setAddress("168 Quai Baudin")
            ->setZip("47000")
            ->setCity("Agen")
            ->setPhone("0556667543");

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

        $manager->persist($repair);
        }

        //BIKE

        for ($i = 425; $i <= 434; $i++){
            $bike = new Bike();
            $bike->setReference('ref_' . $i)
            ->setNumber($i)
            ->setRate(mt_rand(2, 5))
            ->setStatus(mt_rand(0, 1));

            $allBikeEntity[] = $bike;

            // set random value for $avalability
            $avalability = mt_rand(1, 5);

            if($avalability === 1 ){
                $avalability = "Disponible";
            };
            if($avalability === 2 ){
                $avalability = "Bloqué - Maintenance";
            };
            if($avalability === 3 ){
                $avalability = "Dépôt - Panne";
            };
            if($avalability === 4 ){
                $avalability = "Dépôt - Stock";
            };
            if($avalability === 5 ){
                $avalability = "Disparu";
            };

            $bike->setAvailablity($avalability);

            $manager->persist($bike);
        }

        for ($i = 473; $i <= 484; $i++){
            $bike = new Bike();
            $bike->setReference('ref_' . $i)
                ->setNumber($i)
                ->setRate(mt_rand(3, 5))
                ->setStatus(mt_rand(0, 1));

            $allBikeEntity[] = $bike;

            $manager->persist($bike);
        }

        for ($i = 538; $i <= 552; $i++){
            $bike = new Bike();
            $bike->setReference('ref_' . $i)
                ->setNumber($i)
                ->setRate(mt_rand(2, 4))
                ->setStatus(mt_rand(0, 1));

            $allBikeEntity[] = $bike;
            // set random value for $avalability
            $avalability = mt_rand(1, 5);

            if($avalability === 1 ){
                $avalability = "Disponible";
            };
            if($avalability === 2 ){
                $avalability = "Bloqué - Maintenance";
            };
            if($avalability === 3 ){
                $avalability = "Dépôt - Panne";
            };
            if($avalability === 4 ){
                $avalability = "Dépôt - Stock";
            };
            if($avalability === 5 ){
                $avalability = "Disparu";
            };

          $bike->setAvailablity($avalability);

            $manager->persist($bike);
        }

        for ($i = 554; $i <= 560; $i++){
            $bike = new Bike();
            $bike->setReference('ref_' . $i)
                ->setNumber($i)
                ->setRate(mt_rand(3, 5))
                ->setStatus(mt_rand(0, 1));

            $allBikeEntity[] = $bike;

            $manager->persist($bike);
        }
        
        for ($i = 1272; $i <= 1310; $i++){
            $bike = new Bike();
            $bike->setReference('ref_' . $i)
                ->setNumber($i)
                ->setRate(mt_rand(3, 5))
                ->setStatus(mt_rand(0, 1));

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
                ->setMainPicture('https://picsum.photos/id/'.mt_rand(1, 100).'/400/400');
            
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
        //! Unactive and Reactive setCreatedAt in Entity 

        for ($i = 1; $i <= 30; $i++){

            $date = \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-30 days', 'now'));
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
        //! Unactive and Reactive setCreatedAt in Entity 
        for ($i = 1; $i <= 30; $i++){

            $date = \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-30 days', 'now'));
            $randomStation = $allStationEntity[mt_rand(1, count($allStationEntity) - 1)];

            $inventory = New Inventory();
            $inventory->setCreatedAt($date);
            $inventory->setStation($randomStation);
            $manager->persist($inventory);

            for ($j = 1; $j <= 10; $j++){
                $randomBike = $allBikeEntity[array_rand($allBikeEntity)];
                $inventory->addBike($randomBike);
                $manager->persist($inventory);
            
            };
        }

        // PERSIST ALL ACTIONS IN DATA BASE
        $manager->flush();

    }
}