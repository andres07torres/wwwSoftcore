<?php

namespace App\Command;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create-admin',
    description: 'Crea o actualiza un usuario administrador para el panel administrativo.',
)]
final class CreateAdminCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly UserRepository $userRepository,
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::REQUIRED, 'Correo electrónico del administrador')
            ->addArgument('password', InputArgument::REQUIRED, 'Contraseña en texto plano')
            ->addOption('name', null, InputOption::VALUE_REQUIRED, 'Nombre completo del administrador', 'Administrador SoftCorec')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $email = mb_strtolower(trim((string) $input->getArgument('email')));
        $plainPassword = (string) $input->getArgument('password');
        $fullName = trim((string) $input->getOption('name'));

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $io->error(sprintf('El correo "%s" no tiene un formato válido.', $email));

            return Command::INVALID;
        }

        if (mb_strlen($plainPassword) < 8) {
            $io->error('La contraseña debe tener al menos 8 caracteres.');

            return Command::INVALID;
        }

        $user = $this->userRepository->findOneByEmail($email);
        $isNew = null === $user;

        if ($isNew) {
            $user = new User();
            $user->setEmail($email);
        }

        $user->setFullName('' !== $fullName ? $fullName : 'Administrador SoftCorec');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setIsActive(true);
        $user->setPassword($this->passwordHasher->hashPassword($user, $plainPassword));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $io->success(sprintf(
            $isNew ? 'Usuario administrador "%s" creado correctamente.' : 'Usuario administrador "%s" actualizado correctamente.',
            $user->getEmail()
        ));

        return Command::SUCCESS;
    }
}
