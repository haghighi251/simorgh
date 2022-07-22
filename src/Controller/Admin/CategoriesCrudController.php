<?php

namespace App\Controller\Admin;

use DateTime;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use App\Entity\Categories;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Doctrine\Persistence\ManagerRegistry;
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

    public function configureFields(string $pageName): iterable {
        // Getting an instance from Category entity class to have access to this class.
        $categories_repository = $this->em->getRepository(Categories::class);

        // Making a list of categories that are parents of other categories.
        $parent_array = [];
        $categories = $categories_repository->getAllparent();
        if (count($categories) > 0) {
            foreach ($categories as $c) {
                $parent_array[$c->name] = $c->id;
            }
        }

        return [
            TextField::new('name'),
            SlugField::new('slug', 'Slug')
                ->setTargetFieldName('name')
                ->setUnlockConfirmationMessage(
                    'It is highly recommended to use the automatic slugs, but you can customize them.'
                ),
            TextEditorField::new('description'),
            ChoiceField::new('type')->setChoices(['shop' => 'shop', 'blog' => 'blog', 'tag' => 'tag']),
            ChoiceField::new('parent')->setChoices($parent_array),
            ChoiceField::new('level')->setChoices(['Root' => 1, 'Child' => 2, 'Sub Child' => 3]),
            ImageField::new('image', 'Image')
                ->setUploadDir('/public/uploads/images/categories')
                ->setBasePath('/uploads/images/categories')
                ->setUploadedFileNamePattern('[slug]-[contenthash].[extension]'),
            BooleanField::new('featured')->renderAsSwitch(true)
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
                return $action->setLabel('Edit')->setIcon('fa fa-edit');
            });
    }

    public function createEntity(string $entityFqcn) {
        $category = new Categories();
        $category->setCreateAt(DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s')));
        return $category;
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void {
        $entityInstance->setUpdatedAt(DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s')));
        $entityInstance->setParent(1);
        parent::updateEntity($entityManager, $entityInstance);
    }

}
