<?php

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TagRepository::class)
 */
class Tag
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=TagTest::class, mappedBy="tag")
     */
    private $tagTests;

    public function __construct()
    {
        $this->tagTests = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, TagTest>
     */
    public function getTagTests(): Collection
    {
        return $this->tagTests;
    }

    public function addTagTest(TagTest $tagTest): self
    {
        if (!$this->tagTests->contains($tagTest)) {
            $this->tagTests[] = $tagTest;
            $tagTest->setTag($this);
        }

        return $this;
    }

    public function removeTagTest(TagTest $tagTest): self
    {
        if ($this->tagTests->removeElement($tagTest)) {
            // set the owning side to null (unless already changed)
            if ($tagTest->getTag() === $this) {
                $tagTest->setTag(null);
            }
        }

        return $this;
    }
}
