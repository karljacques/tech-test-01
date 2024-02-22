<?php

use App\Domain\Model\ListContact;

/** @var ListContact[] $items */
?>

<?php $this->extend('layout.php'); ?>

<?php $this->startBlock('content'); ?>
<form id="create-new-form">
    <div class="form-group">
        <label for="email">Email address</label>
        <input type="email" class="form-control" id="email" name="emailAddress" aria-describedby="emailHelp"
               placeholder="Enter email">
    </div>
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name">
    </div>

    <button type="submit" class="btn btn-primary">Add</button>
</form>
<table id="list" class="table table-striped">
    <thead>
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Created At</th>
        <th></th>
    </tr>
    </thead>

    <tbody>
    <?php foreach ($items as $item): ?>
        <?php include "entry.php" ?>

    <?php endforeach; ?>
    </tbody>
</table>
<?php $this->endBlock(); ?>
