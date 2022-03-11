<?php

namespace App\Entity;

use App\Repository\TestRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass=TestRepository::class)
 */
class Test
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"show_test"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"show_test"})
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Groups({"show_test"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"show_test"})
     */
    private $media;

    /**
     * @ORM\Column(type="string", length=64)
     * @Groups({"show_test"})
     */
    private $unit;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity=Result::class, mappedBy="test")
     */
    private $results;

    /**
     * @ORM\OneToMany(targetEntity=TagTest::class, mappedBy="test",cascade={"remove"} )
     */
    private $tagTests;

    public function __construct()
    {
        $this->results = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getMedia(): ?string
    {
        return $this->media;
    }

    public function setMedia(?string $media): self
    {
        $this->media = $media;

        return $this;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function setUnit(string $unit): self
    {
        $this->unit = $unit;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection<int, Result>
     */
    public function getResults(): Collection
    {
        return $this->results;
    }

    public function addResult(Result $result): self
    {
        if (!$this->results->contains($result)) {
            $this->results[] = $result;
            $result->setTest($this);
        }

        return $this;
    }

    public function removeResult(Result $result): self
    {
        if ($this->results->removeElement($result)) {
            // set the owning side to null (unless already changed)
            if ($result->getTest() === $this) {
                $result->setTest(null);
            }
        }

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
            $tagTest->setTest($this);
        }

        return $this;
    }

    public function removeTagTest(TagTest $tagTest): self
    {
        if ($this->tagTests->removeElement($tagTest)) {
            // set the owning side to null (unless already changed)
            if ($tagTest->getTest() === $this) {
                $tagTest->setTest(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }
}
