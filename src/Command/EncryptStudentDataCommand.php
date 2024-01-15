<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\Lyceen;



#[AsCommand(
    name: 'EncryptStudentDataCommand',
    description: 'Commande pour chiffrer les données personnelles des élèves',
)]
class EncryptStudentDataCommand extends Command
{

    private $entityManager;
    private $passwordEncoder;



    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        parent::__construct();

        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    protected function configure()
    {
        $this
            ->setName('app:encrypt-student-data')
            ->setDescription('Commande pour chiffrer les données personnelles des élèves');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $repository = $this->entityManager->getRepository(Lyceen::class);
            $lyceens = $repository->findBy(['createdAt' => new \DateTimeImmutable('-1 month')]);

            foreach ($lyceens as $lyceen) {
                // Chiffrez les données sensibles (nom, prenom, email, etc.)
                $encryptedNom = $this->passwordEncoder->encodePassword($lyceen, $lyceen->getNom());
                $encryptedPrenom = $this->passwordEncoder->encodePassword($lyceen, $lyceen->getPrenom());
                $encryptedEmail = $this->passwordEncoder->encodePassword($lyceen, $lyceen->getEmail());
                $encryptedTel = $this->passwordEncoder->encodePassword($lyceen, $lyceen->getTel());

                // Mettez à jour l'entité avec les nouvelles données chiffrées
                $lyceen->setNom($encryptedNom);
                $lyceen->setPrenom($encryptedPrenom);
                $lyceen->setEmail($encryptedEmail);
                $lyceen->setTel($encryptedTel);

                // Persistez les changements dans la base de données
                $this->entityManager->persist($lyceen);
            }

            $this->entityManager->flush();

            $io->success('Données chiffrées avec succès');
        } catch (\Exception $e) {
            $io->error('Erreur: ' . $e->getMessage());
        }
    }
}
