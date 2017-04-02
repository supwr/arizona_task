<?php

namespace Entities;

/**
 * @Entity @Table(name="country")
 **/
class Country
{

    /** @id @Column(type="integer") @GeneratedValue **/
    private $id;

    /** @code @Column(type="string") **/
    private $code;

    /** @name @Column(type="string") **/
    private $name;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

}