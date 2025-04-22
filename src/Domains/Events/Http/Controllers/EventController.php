<?php

namespace App\Domains\Events\Http\Controllers;

use App\Domains\Events\Dtos\AddUserToEventDto;
use App\Domains\Events\Exceptions\UserAlreadyRegisteredOnEventException;
use App\Domains\Events\Handlers\AddUserToEventHandler;
use App\Domains\Events\Repository\EventRepository;
use App\Entity\Event;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class EventController extends AbstractController
{
    public function __construct(
        private readonly EventRepository $eventRepository,
        private readonly SerializerInterface $serializer,
        private readonly AddUserToEventHandler $addUserToEventHandler
    )
    {
    }

    /**
     * Get all listing events
     * @throws NonUniqueResultException
     * @return JsonResponse<Event[]>
     */
    #[Route('/events', name: 'events.index', methods: ['GET'])]
    public function index(): Response
    {
        $events = $this->eventRepository->getAll();

        return (new JsonResponse())
            ->setJson(
                $this->serializer->serialize($events, 'json', ['groups' => ['event:read']])
            );
    }

    #[Route('/events/{id}', name: 'events.show', methods: ['GET'])]
    public function show(Event $event): Response
    {
        return (new JsonResponse())
            ->setJson(
                $this->serializer->serialize($event, 'json', ['groups' => ['event:read']])
            );
    }

    /**
     * Add a user to an event
     * @throws UserAlreadyRegisteredOnEventException
     */
    #[Route('/events/add-user/{id}', name: 'events.add-user', methods: ['POST'])]
    public function addUserToEvent(
        #[MapRequestPayload] AddUserToEventDto $dto,
        Event $event
    ): JsonResponse
    {
        $event = $this->addUserToEventHandler->handle($dto, $event);

        return (new JsonResponse())
            ->setJson(
                $this->serializer->serialize($event, 'json', ['groups' => ['event:read']])
            );
    }
}