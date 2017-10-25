<?php
namespace BH\SeoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;


class SeoType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {       

        $builder
            ->add('url', null, array(
                'label' => 'Url',
            ))
            ->add('route', null, array(
                'label' => 'Route',
            ))
            ->add('title', null, array(
                'label' => 'Titre',
            ))
            ->add('description', null, array(
                'label' => 'Description',
            ))
            ->add('save', SubmitType::class, array(
                'label' => 'Enregistrer',
                'attr' => array(
                    'class' => 'btn btn-success',
                    // 'formnovalidate'=> 'true' // TinyMCE stop form render
                )
            ));
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'BH\SeoBundle\Entity\Seo'
        ));
    }

    public function getBlockPrefix() {
//        return 'seo';
    }
}