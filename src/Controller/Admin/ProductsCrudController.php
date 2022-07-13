<?php

namespace App\Controller\Admin;

use App\Entity\Products;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use App\Form\AttachmentType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
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
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ProductsCrudController extends AbstractCrudController
{
    /**
     * @var type
     *
     * It's used as an instance to work with ManagerRegistry .
     */
    private $em;

    /**
     * @var TokenStorageInterface
     *
     * It's used as an instance to work with User token .
     */
    private $tokenStorage;

    /**
     * @param ManagerRegistry $em
     * @param TokenStorageInterface $tokenStorage
     *
     * Initializing default variables.
     */
    public function __construct(ManagerRegistry $em, TokenStorageInterface $tokenStorage)
    {
        $this->em = $em;
        $this->tokenStorage = $tokenStorage;
    }

    public static function getEntityFqcn(): string
    {
        return Products::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addPanel('Product Details'),

            TextField::new('title'),

            SlugField::new('slug', 'Slug')
                ->setTargetFieldName('title')
                ->setUnlockConfirmationMessage(
                    'It is highly recommended to use the automatic slugs, but you can customize them'
                ),

            TextEditorField::new('short_content', 'Short Content (Maximum 150 characters)'),

            TextEditorField::new('content', 'Long Content'),

            ImageField::new('image_file', 'Product Image')
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

            AssociationField::new('categories'),
            AssociationField::new('tags'),

            FormField::addPanel('Product Settings'),

            ChoiceField::new('status', 'Status')
                ->setChoices(['public' => 'public', 'private' => 'private',]),

            ChoiceField::new('comment_status')
                ->setChoices(['open' => 'open', 'close' => 'close',])
                ->hideOnIndex(),

            TextField::new('password', 'Password')
                ->hideOnIndex()
                ->hideOnIndex(),

            DateTimeField::new('created_at', 'Publish Time')
                ->hideOnIndex(),

            FormField::addPanel('Product Details')->hideOnIndex(),

            MoneyField::new('Price', 'Regular Price')
                ->setCurrency('USD')
                ->setStoredAsCents()
                ->hideOnIndex(),

            MoneyField::new('discounted_price', 'Discounted Price')
                ->setCurrency('USD')
                ->setStoredAsCents()
                ->hideOnIndex(),

            NumberField::new('tax', 'Tax (Just put number. For example 10 for 10% of tax.)')
                ->hideOnIndex(),

            ChoiceField::new('StockStatus', 'Stock status')
                ->setChoices(['In stock' => '1', 'Out of stock' => '2', 'On backorder' => '3']),

            NumberField::new('ProductCount', 'Product Count')
                ->hideOnIndex(),

            ArrayField::new('features')
                ->hideOnIndex(),

            TextEditorField::new('Note', 'Note')
                ->hideOnIndex(),

        ];
    }

    /**
     * @param Actions $actions
     * @return Actions
     *
     * In this method you can change permissions and some settings product menu of admin panel.
     */
    public function configureActions(Actions $actions): Actions
    {
        return $actions->add(Crud::PAGE_INDEX, 'detail')
            //->setPermission(Action::NEW, 'ROLL_ADMIN')
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                return $action->setLabel('Edit')->setIcon('fa fa-edit');
            })
            ->update(Crud::PAGE_INDEX, Action::DETAIL, function (Action $action) {
                return $action->setLabel('View')->setIcon('fa fa-eye');
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                return $action->setLabel('Remove')->setIcon('fa fa-trash');
            });
    }

    /**
     * @param string $entityFqcn
     * @return Products|\EasyCorp\Bundle\EasyAdminBundle\Controller\string
     *
     * We need to pass userId to product object when we want to add a product.
     * You can make relation between users and product tables. If you want to do that,
     * You need to pass Users object instead of user_id to product object in the method below.
     */
    public function createEntity(string $entityFqcn)
    {
        $product = new Products();
        $request = $this->get('request_stack')->getCurrentRequest();

        if (null !== $request->request->get('Products')) {
            $user_info = $this->tokenStorage->getToken()->getUser();
            $product->setAuthorId($user_info->id);

            return $product;
        }
        return parent::createEntity($entityFqcn); // TODO: Change the autogenerated stub
    }

}
