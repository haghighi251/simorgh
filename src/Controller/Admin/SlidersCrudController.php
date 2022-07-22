<?php

namespace App\Controller\Admin;

use App\Entity\Sliders;
use DateTime;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use Doctrine\ORM\EntityManagerInterface;


class SlidersCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Sliders::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title', 'Title (Maximum 30 characters)'),
            TextField::new('subTitle', 'Sub Title (Maximum 50 characters)'),
            TextEditorField::new('content', 'Content (Maximum 250 characters)'),
            ImageField::new('image_file', 'Image')
                ->setUploadDir('/public/uploads/images/sliders')
                ->setBasePath('/uploads/images/sliders')
                ->setUploadedFileNamePattern('[slug]-[contenthash].[extension]'),
            DateTimeField::new('createdAt', 'Publish Time')
                ->hideOnIndex(),
            BooleanField::new('status')->renderAsSwitch(true)
        ];
    }

    /**
     * @param EntityManagerInterface $entityManager
     * @param $entityInstance
     * @return void
     *
     * After each update, We need to pass DateTime for updatedAt.
     */
    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->setUpdatedAt(new DateTime);

        parent::updateEntity($entityManager, $entityInstance);
    }

}
