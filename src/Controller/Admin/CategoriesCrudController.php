<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use App\Entity\Categories;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use App\Repository\CategoriesRepository;
use Doctrine\Persistence\ManagerRegistry;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;

class CategoriesCrudController extends AbstractCrudController {

    /**
     * It's used as an instance to work with ManagerRegistry .
     * @var type
     */
    private $em;

    public function __construct(ManagerRegistry $em) {
        $this->em = $em;
    }

    public static function getEntityFqcn(): string {
        return Categories::class;
    }

    /*
      public function configureFields(string $pageName): iterable
      {
      return [
      IdField::new('id'),
      TextField::new('title'),
      TextEditorField::new('description'),
      ];
      }
     */

    public function configureFields(string $pageName): iterable {
        $categories_repository = $this->em->getRepository(Categories::class);
        $parent_array = [];
        $categories = $categories_repository->getAllparent();
        if (count($categories) > 0) {
            foreach ($categories as $c) {
                $parent_array[$c->name] = $c->id;
            }
        }

        return [
            TextField::new('name'),
            TextEditorField::new('description'),
            ChoiceField::new('type')->setChoices(['shop' => 'shop', 'blog' => 'blog', 'tag' => 'tag']),
            ChoiceField::new('parent')->setChoices($parent_array),
            ChoiceField::new('level')->setChoices(['Root' => 1, 'Child' => 2, 'Sub Child' => 3]),
            TextField::new('slug'),
        ];
    }

    public function configureCrud(Crud $crud): Crud {
        return $crud
                        ->setSearchFields(['name', 'description', 'parent'])
                        ->setPaginatorPageSize(20);
    }
    
     public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->setPermission(Action::NEW, 'ROLE_ADMIN')
            ->setPermission(Action::DELETE, 'ROLE_ADMIN')
            ->setPermission(Action::DETAIL, 'ROLE_ADMIN')
            ->setPermission(Action::EDIT, 'ROLE_ADMIN')
            ->setPermission(Action::BATCH_DELETE, 'ROLE_ADMIN')
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action)
            {
                return $action->setLabel('Borrow')->setIcon('fa fa-star');
            });
    }

    public function createEntity(string $entityFqcn) {
        $category = new Categories();
        $category->setCreateAt(\DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s')));
        return $category;
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void {
        $entityInstance->setUpdatedAt(\DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s')));
        $entityInstance->setParent(1);
        parent::updateEntity($entityManager, $entityInstance);
    }

}
