<?php

declare(strict_types=1);

namespace App\Tests\Behat;

use App\DataFixtures\AppFixtures;
use Behatch\Context\RestContext;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;


/**
 * This context class contains the definitions of the steps used by the demo
 * feature file. Learn how to get started with Behat and BDD on Behat's website.
 *
 * @see http://behat.org/en/latest/quick_start.html
 */
final class DemoContext extends RestContext
{
    /**
     * @var AppFixtures
     */
    private $fixtures;
    /**
     * @var \Coduo\PHPMatcher\Factory\MatcherFactory
     */
    private $matcher;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(
        \Behatch\HttpCall\Request $request,
        AppFixtures $fixtures,
        EntityManagerInterface $entityManager
    )
    {
        parent::__construct($request);
        $this->fixtures = $fixtures;
        $this->matcher = (new \Coduo\PHPMatcher\Factory\MatcherFactory());
        $this->entityManager = $entityManager;
    }

    /**
     * @BeforeScenario @createSchema
     */
    public function createSchema()
    {
        // get entity metadata
        $classes = $this->entityManager->getMetadataFactory()
            ->getAllMetadata();

        //drop and create schema
        $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($this->entityManager);
        $schemaTool->dropSchema($classes);
        $schemaTool->createSchema($classes);

        //load fixtures... and execute
        $purger = new ORMPurger($this->entityManager);
        $fixturesExecutor =
            new ORMExecutor($this->entityManager, $purger);

        $fixturesExecutor->execute([
           $this->fixtures
        ]);
    }
}
