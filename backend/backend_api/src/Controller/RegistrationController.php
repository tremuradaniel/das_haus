<?php

namespace App\Controller;

use Exception;
use Throwable;
use App\Entity\User;
use Psr\Log\LoggerInterface;
use App\Service\Helper\ResponseHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationController extends AbstractController
{
    #[Route('/registration', name: 'app_registration', methods: ['POST'])]
    public function index(
        Request $request, 
        UserPasswordHasherInterface $passwordHasher,
        ValidatorInterface $validator,
        EntityManagerInterface $entityManager,
        LoggerInterface $logger
    ): Response {
        $user = new User();

        $jsonContent = $request->getContent();
        $data = json_decode($jsonContent, true);

        $email = $data["email"] ?? null;
        $password = $data["password"] ?? null;

        if (!isset($email, $password)) {
            return new Response(
                json_encode(["general_error" => "missing email or/and password"]), 400
            );
        }

        $user->setPassword($password);
        $user->setEmail($email);

        $errors = $validator->validate($user);

        if (count($errors) > 0) {
            return new Response(ResponseHelper::serializeViolations($errors), 400);
        }

        // hash the password (based on the security.yaml config for the $user class)
        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $password
        );

        $user->setPassword($hashedPassword);

        try {
            throw new Exception("This is an error");
            $entityManager->persist($user);
            $entityManager->flush();
        } catch (Throwable $e) {
            $logger->error($e->getMessage(), [ $e->getTrace() ]);

            return new Response(
                json_encode(["general_error" => "Something went wrong on the server"]), 500
            );
        }

        return new Response("User registered successfully!");
    }
}
