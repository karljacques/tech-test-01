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
        $listContactArr = $this->listContactRepository->findAll('created_at', 'DESC');

        return $this->renderer->render('list.php', [
            'items' => $listContactArr
        ]);
    }

}
