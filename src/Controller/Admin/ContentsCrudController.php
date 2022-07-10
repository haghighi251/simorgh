<?php

namespace App\Controller\Admin;

use App\Entity\Contents;
use App\Form\AttachmentType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use App\Entity\Categories;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use Doctrine\Persistence\ManagerRegistry;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Attachment;
use App\Form\CategoryType;
use App\Entity\ContentsCategories;
use Doctrine\ORM\EntityManagerInterface;


class ContentsCrudController extends AbstractCrudController
{
    /**
     * It's used as an instance to work with ManagerRegistry .
     * @var type
     */
    private $em;
    /**
     * @var
     */
    private $tokenStorage;

    public function __construct(ManagerRegistry $em, TokenStorageInterface $tokenStorage)
    {
        $this->em = $em;
        $this->tokenStorage = $tokenStorage;
    }

    public static function getEntityFqcn(): string
    {
        return Contents::class;
    }

    /**
     * @param string $pageName
     * @return iterable
     */
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
        $tags_array = [null];
        $tags = $categories_repository->getAllTagsCategories();
        if (count($tags) > 0) {
            foreach ($tags as $c) {
                $tags_array[$c->name] = $c->id;
            }
        }

        if ($pageName == Crud::PAGE_EDIT) {
        }

        return [
            FormField::addPanel('Content Details'),

            TextField::new('title'),

            SlugField::new('content_slug', 'Slug')
                ->setTargetFieldName('title')
                ->setUnlockConfirmationMessage(
                    'It is highly recommended to use the automatic slugs, but you can customize them'
                ),

            TextEditorField::new('ShortContent', 'Short Content (Maximum 150 characters)'),

            TextEditorField::new('content', 'Long Content'),

            ImageField::new('content_image', 'Product Image')
                ->setUploadDir('/public/uploads/images')
                ->setBasePath('/uploads/images')
                ->setUploadedFileNamePattern('[slug]-[contenthash].[extension]'),

            CollectionField::new('attachments', 'More Images')
                ->setFormTypeOption('by_reference', false)
                ->setEntryType(AttachmentType::class)
                ->onlyOnForms(),

            CollectionField::new('attachments')
                ->setTemplatePath('admin/contents/attachments.html.twig')
                ->onlyOnDetail(),

            ChoiceField::new('Categories')
                ->setChoices($categories_array)
                ->allowMultipleChoices()
                ->autocomplete(),

            ChoiceField::new('Tags')
                ->setChoices($tags_array)
                ->allowMultipleChoices()
                ->autocomplete()->hideOnIndex(),

            FormField::addPanel('Content Settings'),

            ChoiceField::new('content_status', 'Status')
                ->setChoices(['public' => 'public', 'private' => 'private',]),

            ChoiceField::new('comment_status')
                ->setChoices(['open' => 'open', 'close' => 'close',])
                ->hideOnIndex(),

            TextField::new('content_password', 'Password')
                ->hideOnIndex()
                ->hideOnIndex(),

            ChoiceField::new('content_type')
                ->setChoices(['product' => 'product', 'blog' => 'blog', 'page' => 'page',])
                ->hideOnIndex(),

            DateTimeField::new('created_at', 'Publish Time')
                ->hideOnIndex(),

            FormField::addPanel('Product Details')->hideOnIndex(),

            MoneyField::new('Price', 'Regular Price')
                ->setCurrency('USD')
                ->setStoredAsCents()
                ->hideOnIndex(),

            MoneyField::new('DiscountedPrice', 'Discounted Price')
                ->setCurrency('USD')
                ->setStoredAsCents()
                ->hideOnIndex(),

            ChoiceField::new('WeightDimension', 'Weight dimension')
                ->setChoices(['kg' => 'kg', 'gr' => 'gr', 'lb' => 'lb',])
                ->hideOnIndex(),

            TextField::new('Weight')->hideOnIndex(),

            ChoiceField::new('LengthDimension', 'Length dimension')
                ->setChoices(['m' => 'm', 'ft' => 'ft', 'cm' => 'cm', 'mm' => 'mm',])
                ->hideOnIndex(),

            TextField::new('Length')->hideOnIndex(),

            ChoiceField::new('StockStatus', 'Stock status')
                ->setChoices(['In stock' => '1', 'Out of stock' => '2', 'On backorder' => '3'])
                ->hideOnIndex(),

            TextField::new('ProductCount', 'Product Count')
                ->hideOnIndex(),

            TextEditorField::new('Note', 'Note')
                ->hideOnIndex(),

        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions->add(Crud::PAGE_INDEX, 'detail');
    }

    public function createEntity(string $entityFqcn)
    {
        /** @var AgentAccreditation $entity */
        $entity = parent::createEntity($entityFqcn);
        $content = new Contents();
        $request = $this->get('request_stack')->getCurrentRequest();

        if (null !== $request->request->get('Contents')) {
            $user_info = $this->tokenStorage->getToken()->getUser();
            $content->setAuthor($user_info);
            if (count($request->request->get('Contents')['Categories']) > 0) {
                foreach ($request->request->get('Contents')['Categories'] as $value) {
                    $ContentsCategories = new ContentsCategories();
                    $ContentsCategories->setCategory_id((integer)$value);
                    $content->addContentsCategory($ContentsCategories);
                }
            }

            return $content;
        }
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance) :void {
        //$entityInstance->setCa
dd($entityInstance);
        parent::updateEntity($entityManager, $entityInstance);
    }

    private function updateCategory($entityInstance){

    }

}
