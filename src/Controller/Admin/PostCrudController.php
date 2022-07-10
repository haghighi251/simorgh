<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use App\Repository\PostMetaRepository;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class PostCrudController extends AbstractCrudController
{
    /**
     * It's used as an instance to work with ManagerRegistry .
     * @var type
     */
    private $em;

    public function __construct(ManagerRegistry $em)
    {
        $this->em = $em;
    }

    public static function getEntityFqcn(): string
    {
        return Post::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            TextEditorField::new('description'),
            AssociationField::new('categories'),
            ArrayField::new('features'),
            MoneyField::new('Price', 'Regular Price')
                ->setCurrency('USD')
                ->setStoredAsCents()
                ->hideOnIndex(),
            TextField::new('color'),
        ];
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance) :void {
        $entityInstance->setPrice($entityInstance->Price);
        $entityInstance->setColor($entityInstance->color);
        if(null !== $entityInstance->id){
            $postRepository = new PostMetaRepository($this->em);
            $postRepository->update([
                'post_id' => $entityInstance->id,
                'meta_key' => 'price',
                'meta_value' => $entityInstance->Price,
            ]);
            $postRepository->update([
                'post_id' => $entityInstance->id,
                'meta_key' => 'color',
                'meta_value' => $entityInstance->color,
            ]);
        }

        parent::updateEntity($entityManager, $entityInstance);
    }

}
