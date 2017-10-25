<?php

namespace BH\SeoBundle\Entity;

use BH\SeoBundle\Model\Seo as Model;
use Doctrine\ORM\Mapping as ORM;

/**
 * Seo
 *
 * @ORM\Table(name="seo")
 * @ORM\Entity(repositoryClass="BH\SeoBundle\Repository\SeoRepository")
 */
class Seo extends Model {

    public function __construct() {
        $this->createdAt = new \DateTime();
    }
}
