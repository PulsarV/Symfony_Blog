<?php

namespace AppBundle\Entity;

use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Article
 *
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ArticleRepository")
 */
class Article
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="title_image", type="string", length=255, nullable=true)
     */
    private $titleImage;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var int
     *
     * @ORM\Column(name="rating_counter", type="bigint")
     */
    private $ratingCounter;

    /**
     * @var int
     *
     * @ORM\Column(name="views_counter", type="bigint")
     */
    private $viewsCounter;

    /**
     * @ORM\ManyToOne(targetEntity="Author", inversedBy="articles")
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="articles")
     */
    private $category;

    /**
     * @ORM\ManyToMany(targetEntity="Tag", mappedBy="articles")
     */
    private $tags;

    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="article")
     */
    private $comments;

    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;


    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Article
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set titleImage
     *
     * @param string $titleImage
     *
     * @return Article
     */
    public function setTitleImage($titleImage)
    {
        $this->titleImage = $titleImage;

        return $this;
    }

    /**
     * Get titleImage
     *
     * @return string
     */
    public function getTitleImage()
    {
        return $this->titleImage;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Article
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set ratingCounter
     *
     * @param integer $ratingCounter
     *
     * @return Article
     */
    public function setRatingCounter($ratingCounter)
    {
        $this->ratingCounter = $ratingCounter;

        return $this;
    }

    /**
     * Get ratingCounter
     *
     * @return int
     */
    public function getRatingCounter()
    {
        return $this->ratingCounter;
    }

    /**
     * Set viewsCounter
     *
     * @param integer $viewsCounter
     *
     * @return Article
     */
    public function setViewsCounter($viewsCounter)
    {
        $this->viewsCounter = $viewsCounter;

        return $this;
    }

    /**
     * Get viewsCounter
     *
     * @return int
     */
    public function getViewsCounter()
    {
        return $this->viewsCounter;
    }

    /**
     * Set category
     *
     * @param Category $category
     *
     * @return Article
     */

    /**
     * Set author
     *
     * @param Author $author
     *
     * @return Article
     */
    public function setAuthor(Author $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return Author
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set category
     *
     * @param Category $category
     *
     * @return Article
     */
    public function setCategory(Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Add comment
     *
     * @param Comment $comment
     *
     * @return Article
     */
    public function addComment(Comment $comment)
    {
        $this->comments[] = $comment;

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

    /**
     * Add tag
     *
     * @param Tag $tag
     *
     * @return Article
     */
    public function addTag(Tag $tag)
    {
        $tag->addArticle($this);
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * Remove tag
     *
     * @param Tag $tag
     */
    public function removeTag(Tag $tag)
    {
        $this->tags->removeElement($tag);
    }

    /**
     * Get tags
     *
     * @return Collection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Article
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
}