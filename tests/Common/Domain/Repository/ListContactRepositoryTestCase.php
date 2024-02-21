<?php

namespace App\Tests\Common\Domain\Repository;

use App\Domain\Model\ListContact;
use App\Domain\Repository\ListContactRepository;
use PHPUnit\Framework\TestCase;

abstract class ListContactRepositoryTestCase extends TestCase
{
    abstract protected function getRepositoryUnderTest(): ListContactRepository;

    public function test_it_should_be_able_to_save_entity_and_find_it(): void
    {
        $entity = new ListContact(
            'alan@example.com',
            'Alan Shearer'
        );

        $sut = $this->getRepositoryUnderTest();

        $sut->save($entity);

        // We know it has been saved if:
        // a) We now have an ID on the entity
        // b) We get a result when we call findAll

        $this->assertIsInt($entity->getId());

        $result = $sut->findAll();

        $this->assertCount(1, $result);

        $firstElement = reset($result);

        $this->assertEquals($entity, $firstElement);

    }

    public function test_it_should_be_able_to_order_by_when_finding_all_entities(): void
    {
        $this->markTestIncomplete();
    }

    /** @depends test_it_should_be_able_to_save_entity_and_find_it */
    public function test_it_should_be_able_to_remove_entity_by_id(): void
    {
        $entity = new ListContact(
            'alan@example.com',
            'Alan Shearer'
        );

        $sut = $this->getRepositoryUnderTest();

        $sut->save($entity);

        $sut->removeById($entity->getId());

        $results = $sut->findAll();

        $this->assertCount(0, $results);
    }
}
