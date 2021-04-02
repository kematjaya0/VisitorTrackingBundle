<?php

/**
 * This file is part of the VisitorTrackingBundle.
 */

namespace Kematjaya\VisitorTrackingBundle\Repository;

use DateTimeInterface;
use Mukadi\Chart\Chart;
use Doctrine\ORM\QueryBuilder;

/**
 * @package Kematjaya\VisitorTrackingBundle\Repository
 * @license https://opensource.org/licenses/MIT MIT
 * @author  Nur Hidayatullah <kematjaya0@gmail.com>
 */
interface VisitorTrackingRepositoryInterface 
{
    /**
     * 
     * @param DateTimeInterface $date
     * @return array
     */
    public function getVisitorChart(DateTimeInterface $date): array;
    
    /**
     * 
     * @param DateTimeInterface $date
     * @return Chart
     */
    public function dailyChart(DateTimeInterface $date): Chart;
    
    /**
     * 
     * @param DateTimeInterface $date
     * @return QueryBuilder
     */
    public function createDailyChartQuery(DateTimeInterface $date):QueryBuilder;
    
    /**
     * 
     * @param DateTimeInterface $date
     * @return Chart
     */
    public function montlyChart(DateTimeInterface $date): Chart;
    
    /**
     * 
     * @param DateTimeInterface $date
     * @return QueryBuilder
     */
    public function createMonthlyChartQuery(DateTimeInterface $date):QueryBuilder;
    
    /**
     * 
     * @param DateTimeInterface $date
     * @return Chart
     */
    public function chartByURL(DateTimeInterface $date): Chart;
    
    /**
     * 
     * @param DateTimeInterface $date
     * @return QueryBuilder
     */
    public function createURLStatChartQuery(DateTimeInterface $date):QueryBuilder;
}
