<?php

namespace AppBundle\Security;

use AppBundle\Entity\Author;
use AppBundle\Entity\Comment;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class CommentVoter extends Voter
{
    const EDIT = 'edit';
    const DELETE = 'delete';

    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, [self::EDIT, self::DELETE])) {
            return false;
        }

        if (!$subject instanceof Comment) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $author = $token->getUser();

        if (!$author instanceof Author) {

            return false;
        }

        /**
         * @var Comment $comment
         */
        $comment = $subject;

        switch($attribute) {
            case self::EDIT:
                return $this->canEdit($comment, $author);
            case self::DELETE:
                return $this->canDelete($comment, $author);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canEdit(Comment $comment, Author $author)
    {
        return $author === $comment->getAuthor();

    }

    private function canDelete(Comment $comment, Author $author)
    {
        return $author === $comment->getAuthor();
    }
}