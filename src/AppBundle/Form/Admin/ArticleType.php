<?php

namespace AppBundle\Form\Admin;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Collection;

class ArticleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, ['label' => 'Title', 'attr' => ['placeholder' => 'Enter article title']])
            ->add('titleImage', FileType::class, ['label' => 'Select article title image'])
            ->add('content', TextAreaType::class,  ['data_class' => '', 'label' => 'Article content', 'attr' => ['placeholder' => 'Enter article text', 'rows' => 10]])
            ->add('ratingCounter', HiddenType::class, ['data' => 0])
            ->add('viewsCounter', HiddenType::class, ['data' => 0])
            ->add('author', EntityType::class, [
                'class' => 'AppBundle\Entity\Author',
                'query_builder' => function($repository) { return $repository->createQueryBuilder('a')->orderBy('a.nickname', 'ASC'); },
                'choice_label' => 'nickname',
                'label' => 'Select article\'s author',
            ])
            ->add('category', EntityType::class, [
                'class' => 'AppBundle\Entity\Category',
                'query_builder' => function($repository) { return $repository->createQueryBuilder('c')->orderBy('c.name', 'ASC'); },
                'choice_label' => 'name',
                'label' => 'Select article category',
            ])
            ->add('tags', EntityType::class, [
                'class' => 'AppBundle\Entity\Tag',
                'query_builder' => function($repository) { return $repository->createQueryBuilder('t')->orderBy('t.name', 'ASC'); },
                'choice_label' => 'name',
                'label' => 'Select article tags',
                'multiple' => true,
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => 'AppBundle\Entity\Article',
            ]
        );
    }
}
