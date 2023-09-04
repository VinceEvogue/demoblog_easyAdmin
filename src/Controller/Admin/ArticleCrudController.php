<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title', 'Titre'),
            TextEditorField::new('content')->onlyOnForms(),
            TextareaField::new('content', 'Contenu')->hideOnForm()->setMaxlength(20),
            DateTimeField::new('createdAt', "Date d'enregistrement")->hideOnForm()->setFormat('dd.MM.yyyy à HH:mm:ss zzz'),
            AssociationField::new('category', 'Categorie'),
            //! traitement de l'image
            //* création (new)
            ImageField::new('image')->setUploadDir('public/upload/')->setUploadedFileNamePattern('[timestamp]-[slug].[extension]')->onlyWhenCreating(),
            //* modification
            ImageField::new('image')->setUploadDir('public/upload/')->setUploadedFileNamePattern('[timestamp]-[slug].[extension]')->setFormTypeOptions(['required' => false])->onlyWhenUpdating(),
            //* Affichage
            ImageField::new('image')->setBasePath('upload/')->hideOnFOrm()
        ];
    }

    public function createEntity(string $entityFqcn)
    {
        $article = new $entityFqcn; // = $article = new Article
        $article->setCreatedAt(new \DateTime());
        return $article;
    }
    
}
