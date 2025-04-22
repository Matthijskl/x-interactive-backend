<?php

namespace App\Domains\Events\Dtos;

use Symfony\Component\Validator\Constraints as Assert;

readonly class AddUserToEventDto
{
    public function __construct(
        #[Assert\NotBlank(message: 'First name is required')]
        public string $firstName,

        #[Assert\NotBlank(message: 'Last name is required')]
        public string $lastName,

        #[Assert\NotBlank(message: 'Email is required')]
        #[Assert\Email(message: 'Email is not valid')]
        public string $email,

        #[Assert\NotBlank(message: 'Company is required')]
        public string $company
    )
    {
    }
}