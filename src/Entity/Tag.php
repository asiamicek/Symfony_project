<?php
/**
 * Tag entity.
 */

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Tag.
 *
 * @ORM\Entity(repositoryClass=TagRepository::class)
 * @ORM\Table(name="tags")
 */
class Tag
{
    /**
     * Primary key.
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
     * @ORM\Column(
     *     type="string",
     *     length=64,
     * )
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
     * @ORM\ManyToMany(targetEntity=Note::class, mappedBy="tags")
     */
    private $notes;

    /**
     * Tag constructor.
     */
    public function __construct()
    {
        $this->notes = new ArrayCollection();
    }

    /**
     * Getter for Id.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter for Title.
     *
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Setter for Title.
     *
     * @param string $title
     *
     * @return void
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Getter for Notes.
     *
     * @return Collection|Note[]
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    /**
     * Add Note.
     *
     * @param Note $note
     *
     * @return void
     */
    public function addNote(Note $note): void
    {
        if (!$this->notes->contains($note)) {
            $this->notes[] = $note;
            $note->addTag($this);
        }
    }

    /**
     * Remove Note.
     *
     * @param Note $note
     *
     * @return void
     */
    public function removeNote(Note $note): void
    {
        if ($this->notes->removeElement($note)) {
            $note->removeTag($this);
        }
    }
}
