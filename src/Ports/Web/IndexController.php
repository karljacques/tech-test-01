<?php

namespace App\Ports\Web;

use App\Domain\Repository\ListContactRepository;
use DevCoder\Renderer\PhpRenderer;

final readonly class IndexController
{
    public function __construct(
        private ListContactRepository $listContactRepository,
        private PhpRenderer $renderer
    ) {

    }
    public function __invoke(): string
    {
        // I'd use a query here (CQRS query) rather than using repository directly.
        // Potentially even split out a View object, rather than exposing Domain entities to the
        // presentation layer.
        $listContactArr = $this->listContactRepository->findAll('created_at', 'DESC');

        return $this->renderer->render('list.php', [
            'items' => $listContactArr
        ]);
    }

}
