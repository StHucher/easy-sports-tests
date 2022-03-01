<?php

namespace App\Entity;

use App\Repository\TagTestRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TagTestRepository::class)
 */
class TagTest
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $isPrimary;

    /**
     * @ORM\ManyToOne(targetEntity=Tag::class, inversedBy="tagTests")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tag;

    /**
     * @ORM\ManyToOne(targetEntity=Test::class, inversedBy="tagTests")
     * @ORM\JoinColumn(nullable=false)
     */
    private $test;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsPrimary(): ?int
    {
        return $this->isPrimary;
    }

    public function setIsPrimary(int $isPrimary): self
    {
        $this->isPrimary = $isPrimary;

        return $this;
    }

    public function getTag(): ?Tag
    {
        return $this->tag;
    }

    public function setTag(?Tag $tag): self
    {
        $this->tag = $tag;

        return $this;
    }

    public function getTest(): ?Test
    {
        return $this->test;
    }

    public function setTest(?Test $test): self
    {
        $this->test = $test;

        return $this;
    }
}
