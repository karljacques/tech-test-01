<?php
use App\Domain\Model\ListContact;
/** @var ListContact[] $items */
?>

<?php $this->extend('layout.php'); ?>

<?php $this->startBlock('content'); ?>
<table class="table table-striped">
    <thead>
    <tr>
        <th>Name</th>
        <th>Email</th>
    </tr>
    </thead>

    <tbody>
    <?php foreach ($items as $item): ?>
    <tr>
        <th><?= $item->getName(); ?></th>
        <th><?= $item->getEmail(); ?></th>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php $this->endBlock(); ?>
