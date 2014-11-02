<?php
/**
 * zf2-doctrine2-skeleton
 *
 * @link        https://github.com/basarevych/zf2-doctrine2-skeleton
 * @copyright   Copyright (c) 2014 basarevych@gmail.com
 * @license     http://choosealicense.com/licenses/mit/ MIT
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractConsoleController;
use Application\Entity\Sample as SampleEntity;

/**
 * Console controller
 *
 * @category    Application
 * @package     Controller
 */
class ConsoleController extends AbstractConsoleController
{
    /**
     * Cron script action template
     */
    public function cronAction()
    {
        // Ensure there is only one cron script running at a time.
        $fpSingleton = fopen(__FILE__, "r") or die("Could not open " . __FILE__);
        if (!flock($fpSingleton, LOCK_EX | LOCK_NB)) {
            fclose($fpSingleton);
            return "Another cron job is running" . PHP_EOL;
        }

        // Cron job here
    }

    /**
     * Populate the database
     */
    public function populateDbAction()
    {
        $sl = $this->getServiceLocator();
        $em = $sl->get('Doctrine\ORM\EntityManager');

        $repo = $em->getRepository('Application\Entity\Sample');
        $repo->removeAll();

        $dt = new \DateTime("2010-05-11 13:00:00");
        for ($i = 0; $i < 100; $i++) {
            $dt->add(new \DateInterval('PT10S'));

            $entity = new SampleEntity();
            $entity->setValueString("string $i");
            $entity->setValueInteger($i);
            $entity->setValueFloat($i / 100);
            $entity->setValueBoolean($i % 2 == 0);
            $entity->setValueDatetime($dt);
            $em->persist($entity);
        }
        $em->flush();
    }
} 
