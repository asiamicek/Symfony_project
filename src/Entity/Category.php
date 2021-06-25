<?php
/**
 * Category entity.
 */

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class category.
 *
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 * @ORM\Table(name="categories")
 *
 * @UniqueEntity(fields={"title"})
 */
class Category
{
    /**
     * Primary key.
     *
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Title.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=64)
     *
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="3",
     *     max="64",
     * )
     */
    private $title;

    /**
     * Notes.
     *
     * @ORM\OneToMany(targetEntity=Note::class, mappedBy="category")
     */
    private $notes;

    /**
     * Registers.
     *
     * @ORM\OneToMany(targetEntity=Register::class, mappedBy="category")
     */
    private $registers;

    /**
     * Category constructor.
     */
    public function __construct()
    {
        $this->notes = new ArrayCollection();
        $this->registers = new ArrayCollection();
    }

    /**
     * Getter for Id.
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter fot Title.
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Setter for Title.
     * @param string $title
     *
     * @return void
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Getter for Note.
     *
     * @return Collection|Note[]
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    /**
     * Add Note.
     * @param Note $note
     *
     * @return void
     */
    public function addNote(Note $note): void
    {
        if (!$this->notes->contains($note)) {
            $this->notes[] = $note;
            $note->setCategory($this);
        }
    }

    /**
     * Remove note.
     *
     * @param Note $note
     *
     * @return void
     */
    public function removeNote(Note $note): void
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getCategory() === $this) {
                $note->setCategory(null);
            }
        }
    }

    /**
     * Getter for Register.
     *
     * @return Collection|Register[]
     */
    public function getRegister(): Collection
    {
        return $this->registers;
    }

    /**
     * Add register.
     *
     * @param Register $register
     *
     * @return void
     */
    public function addRegister(Register $register): void
    {
        if (!$this->register->contains($register)) {
            $this->register[] = $register;
            $register->setCategory($this);
        }
    }

    /**
     * Remove Register.
     *
     * @param Register $register
     *
     * @return void
     */
    public function removeRegister(Register $register): void
    {
        if ($this->registers->removeElement($register)) {
            // set the owning side to null (unless already changed)
            if ($register->getCategory() === $this) {
                $register->setCategory(null);
            }
        }
    }
}
