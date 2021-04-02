<?php

/**
 * This file is part of the VisitorTrackingBundle.
 */

namespace Kematjaya\VisitorTrackingBundle\Repository;

use Kematjaya\VisitorTrackingBundle\Entity\PageView;
use Kematjaya\VisitorTrackingBundle\Entity\Session;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;
use Mukadi\ChartJSBundle\Chart\Builder;
use Mukadi\Chart\Utils\RandomColorFactory;
use Mukadi\Chart\Chart;

/**
 * @package Kematjaya\VisitorTrackingBundle\Repository
 * @license https://opensource.org/licenses/MIT MIT
 * @author  Nur Hidayatullah <kematjaya0@gmail.com>
 */
class VisitorTrackingRepository extends ServiceEntityRepository implements VisitorTrackingRepositoryInterface
{
    
    /**
     * 
     * @var Builder
     */
    protected $chartBuilder;
    
    public function __construct(Builder $chartBuilder, ManagerRegistry $registry)
    {
        $this->chartBuilder = $chartBuilder;
        parent::__construct($registry, Session::class);
    }
    
    /**
     * 
     * @param \DateTimeInterface $date
     * @return array
     */
    public function getVisitorChart(\DateTimeInterface $date): array
    {
        $charts = [
            'daily' => [
                'cols' => 'col-lg-6 col-md-6 col-sm-12',
                'label' => 'visitor_daily', 'query' => $date->format('M Y'),
                'chart' => $this->dailyChart($date)
            ],
            'monthly' => [
                'cols' => 'col-lg-6 col-md-6 col-sm-12',
                'label' => 'visitor_monthly', 'query' => $date->format('Y'),
                'chart' => $this->montlyChart($date)
            ],
            'urls' => [
                'cols' => 'col-lg-12 col-md-12 col-sm-12',
                'label' => 'visitor_by_url', 'query' => $date->format('M Y'),
                'chart' => $this->chartByURL($date)
            ]
        ];
        
        return $charts;
    }
    
    /**
     * 
     * @param \DateTimeInterface $date
     * @return Chart
     */
    public function dailyChart(\DateTimeInterface $date): Chart
    {
        $qb = $this->createDailyChartQuery($date);
        
        return $this->chartBuilder->query($qb->getQuery())
                ->addDataset('total', 'Total', [
                    "backgroundColor" => RandomColorFactory::getRandomRGBAColors(6)
                ])
                ->labels('dd')
                ->buildChart('visitor_daily', Chart::LINE);
    }
    
    /**
     * 
     * @param \DateTimeInterface $date
     * @return QueryBuilder
     */
    public function createDailyChartQuery(\DateTimeInterface $date):QueryBuilder
    {
        return $this->createQueryBuilder('t')
                ->select('YEAR(t.created) as year, MONTH(t.created) as mon, DAY(t.created) as dd, count(t.id) as total')
                ->where('YEAR(t.created) = :yyyy')->setParameter('yyyy', $date->format('Y'))
                ->andWhere('MONTH(t.created) = :mm')->setParameter('mm', $date->format('m'))
                ->groupBy('year, mon, dd');
    }
    
    /**
     * 
     * @param \DateTimeInterface $date
     * @return Chart
     */
    public function montlyChart(\DateTimeInterface $date): Chart
    {
        $qb = $this->createMonthlyChartQuery($date);
        
        return $this->chartBuilder->query($qb->getQuery())
                ->addDataset('total', 'Total', [
                    "backgroundColor" => RandomColorFactory::getRandomRGBAColors(6)
                ])
                ->labels('mon')
                ->buildChart('visitor_monthly', Chart::LINE);
    }
    
    /**
     * 
     * @param \DateTimeInterface $date
     * @return QueryBuilder
     */
    public function createMonthlyChartQuery(\DateTimeInterface $date):QueryBuilder
    {
        return $this->createQueryBuilder('t')
                ->select('YEAR(t.created) as year, MONTH(t.created) as mon, count(t.id) as total')
                ->where('YEAR(t.created) = :yyyy')->setParameter('yyyy', $date->format('Y'))
                ->groupBy('year, mon');
    }
    
    /**
     * 
     * @param \DateTimeInterface $date
     * @return Chart
     */
    public function chartByURL(\DateTimeInterface $date): Chart
    {
        $qb = $this->createURLStatChartQuery($date);
        
        return $this->chartBuilder->query($qb->getQuery())
                ->addDataset('total', 'Total', [
                    "backgroundColor" => RandomColorFactory::getRandomRGBAColors(6)
                ])
                ->labels('url')
                ->buildChart('visitor_url', Chart::BAR);
    }
    
    /**
     * 
     * @param \DateTimeInterface $date
     * @return QueryBuilder
     */
    public function createURLStatChartQuery(\DateTimeInterface $date):QueryBuilder
    {
        return $this->_em->getRepository(PageView::class)->createQueryBuilder('t')
                ->select('YEAR(t.created) as year, MONTH(t.created) as mon, t.url as url, count(t.id) as total')
                ->where('YEAR(t.created) = :yyyy')->setParameter('yyyy', $date->format('Y'))
                ->andWhere('MONTH(t.created) = :mm')->setParameter('mm', $date->format('m'))
                ->groupBy('year, mon, url');
    }
}
