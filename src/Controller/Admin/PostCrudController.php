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
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;

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
        if ($pageName == Crud::PAGE_EDIT) {
            $postRepository = new PostRepository($this->em);
            $postMetaRepository = new PostMetaRepository($this->em);
        }
        return [
            TextField::new('title'),
            TextEditorField::new('description'),
            AssociationField::new('categories'),
            ArrayField::new('features'),
            MoneyField::new('Price', 'Regular Price')
                ->setCurrency('USD')
                ->setStoredAsCents()
                ->hideOnIndex(),
            TextField::new('color')
                ->hideOnIndex(),
        ];
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->setPrice($entityInstance->Price);
        $entityInstance->setColor($entityInstance->color);
        if (null !== $entityInstance->id) {
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

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->setPermission(Action::NEW, 'ROLE_ADMIN')
            ->setPermission(Action::DELETE, 'ROLE_EDITOR')
            ->setPermission(Action::DETAIL, 'ROLE_EDITOR')
            ->setPermission(Action::EDIT, 'ROLE_ADMIN')
            ->setPermission(Action::BATCH_DELETE, 'ROLE_EDITOR')
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action)
            {
                return $action->setLabel('title')->setIcon('fa fa-star');
            });
    }

}
