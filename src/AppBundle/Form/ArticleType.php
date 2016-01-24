<?php
//
//namespace AppBundle\Form;
//
//use Symfony\Component\Form\AbstractType;
//use Symfony\Component\Form\Extension\Core\Type\TextType;
//use Symfony\Component\Form\FormBuilderInterface;
//use Symfony\Component\OptionsResolver\OptionsResolver;
//
//class ArticleType extends AbstractType
//{
//    /**
//     * @param FormBuilderInterface $builder
//     * @param array $options
//     */
//    public function buildForm(FormBuilderInterface $builder, array $options)
//    {
//        $builder
//            ->add('title', TextType::class, ['label' => 'Title'])
//            ->add('titleImage', TextType::class)
//            ->add('content')
//            ->add('rating')
//        ;
//    }
//
//    /**
//     * @param OptionsResolver $resolver
//     */
//    public function configureOptions(OptionsResolver $resolver)
//    {
//        $resolver->setDefaults(
//            [
//                'data_class' => 'AppBundle\Entity\Article',
//            ]
//        );
//    }
//}
