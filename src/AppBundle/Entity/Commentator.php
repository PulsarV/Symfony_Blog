<?php

namespace AppBundle\Entity;

use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Commentator
 *
 * @ORM\Table(name="commentator")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommentatorRepository")
 */
class Commentator
{
    /**
     * Hook timestampable behavior
     * updates createdAt, updatedAt fields
     */
    use TimestampableEntity;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=129)
     * @Assert\Length(
     *     min = 1,
     *     max = 129,
     *     minMessage = "Commentator name must be at least {{ limit }} characters long",
     *     maxMessage = "Commentator name cannot be longer than {{ limit }} characters"
     * )
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=129)
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     checkMX = true
     * )
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="commentator")
     * @Assert\Valid()
     */
    private $comments;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;


    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Commentator
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Commentator
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Commentator
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Add comment
     *
     * @param Comment $comment
     *
     * @return Commentator
     */
    public function addComment(Comment $comment)
    {
        $this->comments->add($comment);

        return $this;
    }

    /**
     * Remove comment
     *
     * @param Comment $comment
     */
    public function removeComment(Comment $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return Collection
     */
    public function getComments()
    {
        return $this->comments;
    }
}
