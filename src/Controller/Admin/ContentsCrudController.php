<?php

namespace App\Controller\Admin;

use App\Entity\Contents;
use App\Form\AttachmentType;
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
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Attachment;

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

    public function __construct(ManagerRegistry $em, TokenStorageInterface $tokenStorage) {
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
        
        return [
            FormField::addPanel('Content Details'),
            TextField::new('title'),
            SlugField::new('content_slug','Slug')->setTargetFieldName('title')->setUnlockConfirmationMessage(
                'It is highly recommended to use the automatic slugs, but you can customize them'
            ),
            TextEditorField::new('ShortContent','Short Content (Maximum 150 characters)'),
            TextEditorField::new('content','Long Content'),
            ImageField::new('content_image','Product Image')
                ->setUploadDir('/public/uploads/images')
                ->setUploadedFileNamePattern('[slug]-[contenthash].[extension]'),
            CollectionField::new('attachments','More Images')
                ->setEntryType(AttachmentType::class)
                ->onlyOnForms(),
            ChoiceField::new('Categories')->setChoices($categories_array)->allowMultipleChoices()->autocomplete(),
            ChoiceField::new('Tags')->setChoices($tags_array)->allowMultipleChoices()->autocomplete(),

            FormField::addPanel('Content Settings'),
            ChoiceField::new('content_status','Status')->setChoices(['public' => 'public', 'private' => 'private',]),
            ChoiceField::new('comment_status')->setChoices(['open' => 'open', 'close' => 'close',]),
            TextField::new('content_password','Password'),
            ChoiceField::new('content_type')->setChoices(['product' => 'product', 'blog' => 'blog', 'page' => 'page',]),
            DateTimeField::new('created_at','Publish Time'),

            FormField::addPanel('Product Details'),
            MoneyField::new('Price','Regular Price')->setCurrency('USD')->setStoredAsCents(),
            MoneyField::new('DiscountedPrice','Discounted Price')->setCurrency('USD')->setStoredAsCents(),
            ChoiceField::new('WeightDimension','Weight dimension')->setChoices(['kg' => 'kg', 'gr' => 'gr', 'lb' => 'lb',]),
            TextField::new('Weight'),
            ChoiceField::new('LengthDimension','Length dimension')->setChoices(['m' => 'm', 'ft' => 'ft', 'cm' => 'cm', 'mm' => 'mm',]),
            TextField::new('Length'),
            ChoiceField::new('StockStatus','Stock status')
                ->setChoices(['In stock' => '1', 'Out of stock' => '2', 'On backorder' => '3']),
            TextField::new('ProductCount','Product Count'),
            TextEditorField::new('Note','Note'),

        ];
    }

    public function createEntity(string $entityFqcn) {
        /** @var AgentAccreditation $entity */
        $entity = parent::createEntity($entityFqcn);
        $content = new Contents();
        $request = $this->get('request_stack')->getCurrentRequest();

        if(null !== $request->request->get('Contents')){
            //var_dump($request->files->get('Contents')['image']['file']->get('filename'));
            //dd($request->files->get('Contents')['image']['file']);
            $user_info = $this->tokenStorage->getToken()->getUser();
            $content->setAuthor($user_info);
            $attachments = new Attachment();


            //$content->setTitle($request->request->get('Contents')['title']);

            return $content;
        }
    }


    
}
