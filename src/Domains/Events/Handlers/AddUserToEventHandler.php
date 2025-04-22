<?php

namespace App\Domains\Events\Handlers;

use App\Domains\Events\Dtos\AddUserToEventDto;
use App\Domains\Events\Exceptions\UserAlreadyRegisteredOnEventException;
use App\Domains\Events\Repository\EventRepository;
use App\Entity\EventUser;
use Doctrine\Common\Collections\Collection;
use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;

class AddUserToEventHandler
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    )
    {
    }

    /**
     * @throws UserAlreadyRegisteredOnEventException
     */
    public function handle(AddUserToEventDto $dto, Event $event): Event
    {
        /** @var Collection<int, string> $userEmails */
        $userEmails = $event
            ->users()
            ->map(fn (EventUser $user): string => $user->getEmail());

        if ($userEmails->contains($dto->email)) {
            throw new UserAlreadyRegisteredOnEventException();
        }

        $newEventUser = new EventUser();
        $newEventUser->setFirstName($dto->firstName);
        $newEventUser->setLastName($dto->lastName);
        $newEventUser->setEmail($dto->email);
        $newEventUser->setCompany($dto->company);
        $newEventUser->setEvent($event);

        $this->entityManager->persist($newEventUser);
        $this->entityManager->flush();

        return $event;
    }
}