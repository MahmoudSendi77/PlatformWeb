<?php

namespace ForumBundle\Controller;

use ForumBundle\Entity\CategorieSu;
use ForumBundle\Entity\CommentaireSu;
use ForumBundle\Entity\Sujet;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ob\HighchartsBundle\Highcharts\Highchart;


class ChartSuController extends Controller
{


    public function chartAction()
    {
        $ob = new Highchart();
        $ob->chart->renderTo('piechart');
        $ob->title->text('Categorie used by users while creating subjects in our forum');
        $ob->plotOptions->pie(array(
            'allowPointSelect' => true,
            'cursor' => 'pointer',
            'dataLabels' => array('enabled' => false),
            'showInLegend' => true
        ));
        $categorie = $this->getDoctrine()->getRepository(CategorieSu::class)->findAll();
        for ($i = 0; $i < count($categorie); ++$i) {
            $sujet = $this->getDoctrine()->getRepository(Sujet::class)->findBy(array('categorieSu' => $categorie[$i]));
            $nbr = count($sujet);
            $data[] = array($categorie[$i]->getCategorieName(), $nbr);


        }


        $ob->series(array(array('type' => 'pie', 'name' => 'Browser share', 'data' => $data)));
        return $this->render('@Forum/Sujets/chartsu.html.twig', array(
            'chart' => $ob));

    }



    public function chartClientAction()
    {
        $ob = new Highchart();
        $ob->chart->renderTo('piechart');
        $ob->title->text('Categorie used by users while creating subjects in our forum');
        $ob->plotOptions->pie(array(
            'allowPointSelect' => true,
            'cursor' => 'pointer',
            'dataLabels' => array('enabled' => false),
            'showInLegend' => true
        ));
        $categorie = $this->getDoctrine()->getRepository(CategorieSu::class)->findAll();
        for ($i = 0; $i < count($categorie); ++$i) {
            $sujet = $this->getDoctrine()->getRepository(Sujet::class)->findBy(array('categorieSu' => $categorie[$i]));
            $nbr = count($sujet);
            $data[] = array($categorie[$i]->getCategorieName(), $nbr);


        }


        $ob->series(array(array('type' => 'pie', 'name' => 'Browser share', 'data' => $data)));
        return $this->render('@Forum/Sujets/chartsuClient.html.twig', array(
            'chart' => $ob));

    }
}




