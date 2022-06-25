<?php

namespace App\Controller\Admin;

use App\Entity\Contents;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use App\Entity\Categories;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use App\Repository\CategoriesRepository;
use Doctrine\Persistence\ManagerRegistry;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use Doctrine\ORM\EntityManagerInterface;

class ContentsCrudController extends AbstractCrudController
{
    /**
     * It's used as an instance to work with ManagerRegistry .
     * @var type
     */
    private $em;

    public function __construct(ManagerRegistry $em) {
        $this->em = $em;
    }
    
    public static function getEntityFqcn(): string
    {
        return Contents::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        // $this->getUser()->id admin user id.
        
        // Getting all shop categories.
        $categories_repository = $this->em->getRepository(Categories::class);
        $categories_array = [];
        $categories = $categories_repository->getAllShopCategories();
        if (count($categories) > 0) {
            foreach ($categories as $c) {
                $categories_array[$c->name] = $c->id;
            }
        }
        
        // Getting all tags.
        $tags_array = [];
        $tags = $categories_repository->getAllTagsCategories();
        if (count($tags) > 0) {
            foreach ($tags as $c) {
                $tags_array[$c->name] = $c->id;
            }
        }
        
        return [
            TextField::new('title'),
            TextEditorField::new('content'),
            ChoiceField::new('content_status')->setChoices(['public' => 'public', 'private' => 'private',]),
            ChoiceField::new('comment_status')->setChoices(['open' => 'open', 'close' => 'close',]),
            TextField::new('content_password'),
            ChoiceField::new('content_type')->setChoices(['product' => 'product', 'blog' => 'blog', 'page' => 'page',]),
//            ArrayField::new('parent'),
//            ChoiceField::new('Categories')->setChoices($categories_array),
//            ChoiceField::new('Tags')->setChoices($tags_array)->autocomplete(),    
        ];
    }
    
}
