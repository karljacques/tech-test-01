<?php

namespace App\Ports\API;

use App\Domain\Model\ListContact;
use App\Domain\Repository\ListContactRepository;
use DevCoder\Renderer\PhpRenderer;
use Pecee\SimpleRouter\SimpleRouter;

final readonly class AddListContactController
{
    public function __construct(
        private ListContactRepository $listContactRepository,
        private PhpRenderer $renderer
    )
    {

    }

    public function add(): string
    {
        // I'd use some framework features here to do validation
        // With more time, I could do that validation with raw php functions, but I'm not familiar with them
        // You'd also have some CSRF token here too
        $name = $_POST['name'];
        $email = $_POST['emailAddress'];

        if (!is_string($name) || !is_string($email)) {
            SimpleRouter::response()->httpCode(422);
            return '';
        }

        // I'd usually put this data into a command and dispatch the command, but having a command bus is a bit too big in scope now.
        $entity = new ListContact(
            $email,
            $name,
        );


        $this->listContactRepository->save($entity);

        // This is the happy path only, we'd need to consider what happens if the email is already in the list
        return $this->renderer->render('entry.php', ['item' => $entity]);

    }
}
