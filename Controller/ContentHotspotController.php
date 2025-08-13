<?php

namespace Accurateweb\ContentHotspotBundle\Controller;

use Accurateweb\ContentHotspotBundle\Model\ContentHotspot;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ContentHotspotController extends Controller
{
  public function editAction(Request $request)
  {
    $alias = $request->get('alias');
    $text = $request->get('text');
    $className = $this->getParameter('hotspot_entity');
    
    $clickZone = $this->getDoctrine()
      ->getRepository($className)
      ->findOneBy(['alias' => $alias]);
    
    if (!$clickZone)
    {
      $clickZone = new $className();
      $clickZone->setAlias($alias);
    }
    
    $clickZone->setText($text);
    
    $this->getDoctrine()->getManager()->persist($clickZone);
    try
    {
      $this->getDoctrine()->getManager()->flush();
    } catch (\Exception $exception)
    {
      return new JsonResponse(['error' => $exception->getMessage()], 400);
    }
    
    return new JsonResponse(['text' => $clickZone->getText()], 200);
    
  }
}