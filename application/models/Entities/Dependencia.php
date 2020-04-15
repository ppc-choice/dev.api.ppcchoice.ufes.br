<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Dependencia
 */
class Dependencia
{
    /**
     * @var \Entities\ComponenteCurricular
     */
    private $componenteCurricular;

    /**
     * @var \Entities\ComponenteCurricular
     */
    private $preRequisito;


    /**
     * Set componenteCurricular
     *
     * @param \Entities\ComponenteCurricular $componenteCurricular
     * @return Dependencia
     */
    public function setComponenteCurricular(\Entities\ComponenteCurricular $componenteCurricular)
    {
        $this->componenteCurricular = $componenteCurricular;
    
        return $this;
    }

    /**
     * Get componenteCurricular
     *
     * @return \Entities\ComponenteCurricular 
     */
    public function getComponenteCurricular()
    {
        return $this->componenteCurricular;
    }

    /**
     * Set preRequisito
     *
     * @param \Entities\ComponenteCurricular $preRequisito
     * @return Dependencia
     */
    public function setPreRequisito(\Entities\ComponenteCurricular $preRequisito)
    {
        $this->preRequisito = $preRequisito;
    
        return $this;
    }

    /**
     * Get preRequisito
     *
     * @return \Entities\ComponenteCurricular 
     */
    public function getPreRequisito()
    {
        return $this->preRequisito;
    }
}