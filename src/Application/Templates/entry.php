<?php
use App\Domain\Model\ListContact;
/** @var ListContact $item */
?>


<tr data-row-id="<?= $item->getId(); ?>">
    <th><?= $item->getName(); ?></th>
    <th><?= $item->getEmail(); ?></th>
    <th><?= $item->getCreatedAt()->format('F j, Y, g:i a'); ?> </th>
    <th><button class="btn btn-danger delete-row" data-entity-id="<?= $item->getId(); ?>">Delete</button></th>
</tr>
