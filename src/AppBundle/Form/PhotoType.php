<?php

namespace AppBundle\Form;

use AppBundle\Entity\User;
use AppBundle\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class PhotoType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('src', FileType::class, [
            'label' => 'Wgraj zdjęcie',
            'mapped' => 'false',
            'required' => 'true',
            'constraints' => [
                new Image([
                    'maxSize' => '4096k',
                    'mimeTypes' => 'image/*'
                    ]
                )
            ],
            'attr' => [
                'class' => 'custom-file-input'
            ],
            'label_attr' => [
                'class' => 'custom-file-label'
            ],
//            'data_class' => null
        ])
//        ->add('assignedRetoucher', EntityType::class, [
//            'label' => 'Przypisz retuszera',
//            'class' => User::class,
//            'query_builder' => function (UserRepository $er)
//            {
//                return $er->createQueryBuilder('u')
//                    ->where('u.roles LIKE :user')
//                    ->setParameter('user', '%"'.'ROLE_RETOUCHER'.'"%')
//                    ->orderBy('u.username', 'ASC');
//            },
//            'choice_label' => function (User $user)
//            {
//                if ( strlen($user->getLastName()) > 0 )
//                {
//                    return $user->getFirstName().' '.$user->getLastName();
//
//                }
//                else {
//                    return $user->getUsername();
//                }
//            }
//        ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Photo'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_photo';
    }


}
