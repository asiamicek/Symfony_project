<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 * @ORM\Table(name="categories")
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $category_name;

    /**
     * @ORM\OneToMany(targetEntity=Note::class, mappedBy="category")
     */
    private $notes;

    /**
     * @ORM\OneToMany(targetEntity=Register::class, mappedBy="category")
     */
    private $registers;

    public function __construct()
    {
        $this->notes = new ArrayCollection();
        $this->registers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getcategory_name(): ?string
    {
        return $this->category_name;
    }

    public function setCategoryName(string $category_name): self
    {
        $this->category_name = $category_name;

        return $this;
    }

    /**
     * @return Collection|Note[]
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Note $note): self
    {
        if (!$this->notes->contains($note)) {
            $this->notes[] = $note;
            $note->setCategory($this);
        }

        return $this;
    }

    public function removeNote(Note $note): self
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getCategory() === $this) {
                $note->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Register[]
     */
    public function getRegister(): Collection
    {
        return $this->registers;
    }

    public function addRegister(Register $register): self
    {
        if (!$this->register->contains($register)) {
            $this->register[] = $register;
            $register->setCategory($this);
        }

        return $this;
    }

    public function removeRegister(Register $register): self
    {
        if ($this->registers->removeElement($register)) {
            // set the owning side to null (unless already changed)
            if ($register->getCategory() === $this) {
                $register->setCategory(null);
            }
        }

        return $this;
    }
}
