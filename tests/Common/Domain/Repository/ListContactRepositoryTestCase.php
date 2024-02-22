<?php

namespace App\Tests\Common\Domain\Repository;

use App\Domain\Model\ListContact;
use App\Domain\Repository\ListContactRepository;
use Carbon\CarbonImmutable;
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

        $this->assertEquals($entity->getId(),$firstElement->getId());
        $this->assertEquals($entity->getCreatedAt()->format('Y-m-d H:i:s'), $firstElement->getCreatedAt()->format('Y-m-d H:i:s'));
        $this->assertEquals($entity->getName(), $firstElement->getName());
        $this->assertEquals($entity->getEmail(), $firstElement->getEmail());
    }

    public function test_it_should_be_able_to_order_by_created_at_when_finding_all_entities(): void
    {
        $sut = $this->getRepositoryUnderTest();

        CarbonImmutable::setTestNow("2022-01-01");
        $entity1 = new ListContact(
            'alan@example.com',
            'Alan Shearer'
        );

        CarbonImmutable::setTestNow('2023-01-01');
        $entity2 = new ListContact(
            'callum@example.com',
            'Callum Wilson'
        );

        CarbonImmutable::setTestNow('2021-05-23 12:54');
        $entity3 = new ListContact(
            'alexander@example.com',
            'Alexander Isak'
        );

        $sut->save($entity1);
        $sut->save($entity2);
        $sut->save($entity3);

        CarbonImmutable::setTestNow(null);

        $results = $sut->findAll('created_at', 'ASC');

        $this->assertCount(3, $results);

        // First element should be Alexander Isak
        $first = reset($results);

        $this->assertEquals('alexander@example.com', $first->getEmail());

        // Second element should be Alan Shearer
        $second = next($results);

        $this->assertEquals('alan@example.com', $second->getEmail());

        // Final element should be Callum Wilson
        $third = next($results);

        $this->assertEquals('callum@example.com', $third->getEmail());
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

    protected function tearDown(): void
    {
        CarbonImmutable::setTestNow(null);
    }
}
