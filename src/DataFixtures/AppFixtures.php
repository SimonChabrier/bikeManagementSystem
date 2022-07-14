<?php

namespace App\DataFixtures;

use App\Entity\Bike;
use App\Entity\User;
use App\Entity\Repair;
use App\Entity\Station;
use Doctrine\DBAL\Connection;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $hasher;
    private $connexion;

    public function __construct(Connection $connexion, UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
        $this->connexion = $connexion;
    }

    private function truncate()
    {
        //  on désactive la vérification des FK
        // Sinon les truncate ne fonctionne pas.
        $this->connexion->executeQuery('SET foreign_key_checks = 0');

        // la requete TRUNCATE remet l'auto increment à 1
        $this->connexion->executeQuery('TRUNCATE TABLE user');
        $this->connexion->executeQuery('TRUNCATE TABLE bike');
        $this->connexion->executeQuery('TRUNCATE TABLE station');
        $this->connexion->executeQuery('TRUNCATE TABLE repair');
    }

    public function load(ObjectManager $manager): void
    {   

        $this->truncate();

        //USER

        $user = new User();
        $user->setStatus(1);
        $user->setRoles(["ROLE_ADMINISTRATEUR"]);
        $user->setEmail("admin@admin.fr");
        $user->setIsVerified(1);
        $user->setPassword($this->hasher->hashPassword($user,"simon"));
        $user->setCompany("autre");
        $user->setJob("partenaire");
        $user->setFirstName("Simon");
        $user->setLastName("Chabrier");
        $user->setAddress("168 Quai Baudin");
        $user->setZip("47000");
        $user->setCity("Agen");
        $user->setPhone("0556667543");

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
        $repair->setReference('ref_' . $key);
        $repair->setName($repairName);

        $manager->persist($repair);
        }

        //BIKE

        for ($i = 425; $i <= 434; $i++){
            $bike = new Bike();
            $bike->setReference('ref_' . $i);
            $bike->setNumber($i);
            $bike->setRate(mt_rand(5, 10));
            $bike->setStatus(mt_rand(0, 1));

            $manager->persist($bike);
        }

        for ($i = 473; $i <= 484; $i++){
            $bike = new Bike();
            $bike->setReference('ref_' . $i);
            $bike->setNumber($i);
            $bike->setRate(mt_rand(5, 10));
            $bike->setStatus(mt_rand(0, 1));

            $manager->persist($bike);
        }

        for ($i = 538; $i <= 552; $i++){
            $bike = new Bike();
            $bike->setReference('ref_' . $i);
            $bike->setNumber($i);
            $bike->setRate(mt_rand(5, 10));
            $bike->setStatus(mt_rand(0, 1));

            $manager->persist($bike);
        }

        for ($i = 554; $i <= 560; $i++){
            $bike = new Bike();
            $bike->setReference('ref_' . $i);
            $bike->setNumber($i);
            $bike->setRate(mt_rand(5, 10));
            $bike->setStatus(mt_rand(0, 1));

            $manager->persist($bike);
        }
        
        for ($i = 1272; $i <= 1310; $i++){
            $bike = new Bike();
            $bike->setReference('ref_' . $i);
            $bike->setNumber($i);
            $bike->setRate(mt_rand(5, 10));
            $bike->setStatus(mt_rand(0, 1));

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
            $station->setNumber($key);
            $station->setReference('ref_' . $key);
            $station->setName($stationName);
            $station->setCapacity(mt_rand(3, 20));
            

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


        // PERSIST ALL IN DATA BASE
        $manager->flush();

    }
}