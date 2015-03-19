<?php

namespace Example\Model;

use PHPMentors\DomainKata\Entity\EntityInterface;
use Example\Util\BusinessDate;

/**
 * 商品エンティティ
 */
class Product implements EntityInterface
{
    /**
     * 商品ID
     * @var int
     */
    private $id;

    /**
     * 商品名
     * @var string
     */
    private $name;

    /**
     * 商品のカテゴリ
     * @var Category
     */
    private $Category;

    /**
     * 更新日
     * @var BusinessDate
     */
    private $updatedAt;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return Category
     */
    public function getCategory()
    {
        return $this->Category;
    }

    /**
     * @param Category $Category
     */
    public function setCategory($Category)
    {
        $this->Category = $Category;
    }

    /**
     * @return BusinessDate
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Sets updated datetime
     * detailed description here
     *
     * @param BusinessDate $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }
}
