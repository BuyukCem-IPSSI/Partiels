<?php

namespace App\Form;

use App\Entity\Content;
use Doctrine\DBAL\Types\Type;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContentType extends AbstractType
{
	/**
	 * @Route("/addContent", name="content_new")
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 *
	 * @return void
	 */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
			->add('title', TextType::class)
            ->add('body' , CKEditorType::class)
            ->add('creationDate')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Content::class,
        ]);
    }
}
