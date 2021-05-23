<?php

namespace App\Form;

use App\Entity\Marque;
use App\Entity\Modele;
use App\Entity\Automobile;
use Doctrine\ORM\Query\Expr\Join;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class AutomobileType extends AbstractType
{
    private $em;
    
    /**
     * The Type requires the EntityManager as argument in the constructor. It is autowired
     * in Symfony 3.
     * 
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }




    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('n_immatriculation')
            ->add('image',FileType::class, [
                'label' => 'upload image',
                'required' => true,
                'data_class'=> null])
            ->add('proprietaire')
            ->add('cin_MF')
            ->add('n_chassis')
            ->add('puiss_fiscale')
            ->add('dpmc')
            ->add('Kilometrage')
            ->add('description', TextareaType::class)
            ->add('energie',EntityType::class, array(
                'required' => true,                
                'placeholder' => 'Select the energie',
                'class' => 'App:Energie'))
            ->add('etat',EntityType::class, array(
                'required' => true,
                'placeholder' => 'Select the etat',
                'class' => 'App:Etat'))
            ->add('categorie',EntityType::class, array(
                'required' => true,
                'placeholder' => 'Select the categorie',
                'class' => 'App:Categorie')
            
            );

        $builder->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'onPreSetData'));
        $builder->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmit'));

    }

    protected function addElementsModeles(FormInterface $form, Marque $marque = null) {

        $form->add('marque', EntityType::class, array(
            'required' => true,
            'data' => $marque,
            'placeholder' => 'Select the marque',
            'class' => 'App:Marque'
        ));

        $modele = array();

        if ($marque) {
            // Fetch Modeles of the Marque if there's a selected Marque
            $repoModele = $this->em->getRepository('App:Modele');
            
            $modele = $repoModele->createQueryBuilder("q")
                ->where("q.marque = :marqueid")
                ->setParameter("marqueid", $marque->getId())
                ->getQuery()
                ->getResult();
        }

        $form->add('modele', EntityType::class, array(
            'required' => true,
            'placeholder' => 'Select a marque first ...',
            'class' => 'App:Modele',
            'choices' => $modele
        ));

    }

    protected function addElementsYears(FormInterface $form, Modele $modele = null) {

        $year = array();

        if ($modele) {
            // Fetch Year of the Modele if there's a selected Modele
            $repoYear = $this->em->getRepository('App:Year');
            
            $year = $repoYear->createQueryBuilder("p")
            -> innerjoin("App:ModeleYear","c" , Join::WITH, "c.year_id = p.id")
            ->where("c.modele_id = :modeleid")
            ->setParameter("modeleid", $modele->getId())
            ->getQuery()
            ->getResult();
        }

        $form->add('year', EntityType::class, array(
            'required' => true,
            'placeholder' => 'Select a modele first ...',
            'class' => 'App:Year',
            'choices' => $year
        ));
    }

    function onPreSubmit(FormEvent $event) {
        $form = $event->getForm();
        $data = $event->getData();
        
        // Search for selected Marque and convert it into an Entity
        $marque = $this->em->getRepository('App:Marque')->find($data['marque']);
        
        $this->addElementsModeles($form, $marque);

        // Search for selected Modele and convert it into an Entity
        $modele = $this->em->getRepository('App:Modele')->find($data['modele']);
        
        $this->addElementsYears($form, $modele);
    }

    function onPreSetData(FormEvent $event) {
        $automobile = $event->getData();
        $form = $event->getForm();

        // When you create a new automobile, the Marque is always empty
        $marque = $automobile->getMarque() ? $automobile->getMarque() : null;
        
        $this->addElementsModeles($form, $marque);

        // When you create a new automobile, the Modele is always empty
        $modele = $automobile->getModele() ? $automobile->getModele() : null;
        
        $this->addElementsyears($form, $modele);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Automobile::class,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_automobile';
    }
}
