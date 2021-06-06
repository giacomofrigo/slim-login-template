<?php

namespace App\Service;

use App\Exception\LoginFailedException;
use App\Model\User;
use App\Exception\ValidationException;

/**
 * Service.
 */
final class UserService extends BaseService
{
    /**
     * Create a new user.
     *
     * @param array $data The form data
     *
     * @return User The new user
     */
    public function createUser(array $data): User
    {
        // Input validation
        $this->validateNewUser($data);

        // Insert user
        $user = new User();
        $user->setUsername($data['username']);
        $user->setPassword($data['password']);
        $user->setRole($data['role']);

        $this->em->persist($user);
        $this->em->flush();

        // Logging here: User created successfully
        //$this->logger->info(sprintf('User created successfully: %s', $userId));

        return $user;
    }

    /**
     * Input validation.
     *
     * @param array $data The form data
     *
     * @throws ValidationException
     *
     * @return void
     */
    private function validateNewUser(array $data): void
    {
        $errors = [];

        // Here you can also use your preferred validation library

        if (empty($data['username'])) {
            $errors['username'] = 'Input required';
        }

        if (empty($data['password'])) {
            $errors['password'] = 'Input required';
        }

        if ($errors) {
            throw new ValidationException('Please check your input', 400, $errors);
        }
    }

    /**
     * Log in.
     *
     * @param array $data The form data
     *
     * @return User The new user
     */
    public function login(array $data): User
    {
        // take the user
        $user = $this->em->getRepository(User::class)->findBy(array('username' => $data['username']));

        if (count($user) == 0){
            $this->logger->warning(sprintf("User %s not found", $data['username']));
            throw new LoginFailedException();
        }else{
            $user = $user[0];
            $this->logger->debug($user->getPassword());
        }
        
        if ($user->isActive() != 1){
            throw new LoginFailedException("Login failed", ["user active" => False]);
        }

        if (!(password_verify($data['password'], $user->getPassword()))){
            $this->logger->warning(sprintf("Login failed with username %s, wrong password", $data['username']));
            throw new LoginFailedException();
        }else{
            $this->logger->info(sprintf("User %s successfully logged in", $user->getUsername()));
            return $user;
        }
        return $user;
    }

}