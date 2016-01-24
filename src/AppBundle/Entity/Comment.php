<?php

namespace AppBundle\Entity;

use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

//todo: add comment reply

/**
 * Comment
 *
 * @ORM\Table(name="comment")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommentRepository")
 */
class Comment
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
     * @ORM\Column(name="message", type="text")
     * @Assert\NotBlank(
     *     message = "Comment message cannot be empty"
     * )
     */
    private $message;

    /**
     * @ORM\ManyToOne(targetEntity="Commentator", inversedBy="comments", cascade={"persist"})
     * @Assert\Valid()
     */
    private $commentator;

    /**
     * @ORM\ManyToOne(targetEntity="Article", inversedBy="comments", cascade={"persist"})
     * @Assert\Valid()
     */
    private $article;

    /**
     * @Gedmo\Slug(fields={"message"})
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;

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
     * Set message
     *
     * @param string $message
     *
     * @return Comment
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Comment
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
     * Set commentator
     *
     * @param Commentator $commentator
     *
     * @return Comment
     */
    public function setCommentator(Commentator $commentator = null)
    {
        $this->commentator = $commentator;

        return $this;
    }

    /**
     * Get commentator
     *
     * @return Commentator
     */
    public function getCommentator()
    {
        return $this->commentator;
    }

    /**
     * Set article
     *
     * @param Article $article
     *
     * @return Comment
     */
    public function setArticle(Article $article = null)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return \AppBundle\Entity\Article
     */
    public function getArticle()
    {
        return $this->article;
    }
}
