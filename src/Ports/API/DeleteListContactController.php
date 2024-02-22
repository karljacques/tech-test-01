<?php

namespace App\Ports\API;

use App\Domain\Repository\ListContactRepository;
use Pecee\SimpleRouter\SimpleRouter;

final readonly class DeleteListContactController
{
    public function __construct(
        private ListContactRepository $listContactRepository,
    )
    {

    }

    public function delete(int $id): string
    {
        $this->listContactRepository->removeById($id);

        SimpleRouter::response()->httpCode(202);
        return '';
    }
}
