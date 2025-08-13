<?php

namespace Accurateweb\ContentHotspotBundle\Service;

use Accurateweb\ContentHotspotBundle\Exception\HotspotNotFoundException;
use Accurateweb\ContentHotspotBundle\Model\ContentHotspot;
use Accurateweb\ContentHotspotBundle\Model\ContentHotspotInterface;

class ContentHotspotPool
{
  /**
   * @var array|iterable|ContentHotspotInterface[]
   */
  private $hotspots;

  public function __construct ($hotspots)
  {
    $this->hotspots = [];

    foreach ($hotspots as $hotspot)
    {
      $this->hotspots[$hotspots->getAlias()] = $hotspot;
    }
  }

  /**
   * @return ContentHotspotInterface[]|iterable|array
   */
  public function getHotspots ()
  {
    return $this->hotspots;
  }

  /**
   * @param string $name
   * @return ContentHotspotInterface
   * @throws HotspotNotFoundException
   */
  public function getHotspot ($name)
  {
    if (isset($this->hotspots[$name]))
    {
      return $this->hotspots[$name];
    }
    
    throw new HotspotNotFoundException(sprintf('Hotspot %s not found', $name));
  }

  /**
   * @param string $name
   * @param array $item
   */
  public function addHotspot ($name, $item=[])
  {
    $hotspot = new ContentHotspot();
    $hotspot->setAlias($name);
    $hotspot->setText(isset($item['text']) ? $item['text'] : null);
    $hotspot->setTitle(isset($item['title']) ? $item['title'] : null);
    $this->hotspots[$name] = $hotspot;
  }
}