<?php

namespace App\Controller\Admin;

use App\Entity\Tables;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TablesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Tables::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'ID')->onlyOnIndex(),
            IntegerField::new('num', 'Номер стола'),
            TextField::new('description', 'Описание'),
            IntegerField::new('maxGuests', 'Макс количество человек'),
            IntegerField::new('guestsDef', 'Гостей')->onlyOnIndex(),
            IntegerField::new('guestsNow', 'Присутствуют гостей')->onlyOnIndex(),
        ];
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Столы')
            ->setPageTitle('new', 'Создать новый стол')
            ->setPageTitle('detail', 'Стол')
            ->setPageTitle('edit', 'Стол')
            ->setEntityLabelInSingular('стол')
            ->setEntityLabelInPlural('столы');
    }

    public function deleteEntity(AdminContext|\Doctrine\ORM\EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (count($entityInstance->getGuests()) > 0) {
            $guestNames = [];
            foreach ($entityInstance->getGuests() as $guest) {
                $guestNames[] = $guest->getName();
            }
            $guestList = implode(', ', $guestNames);

            $this->addFlash('error', sprintf(
                'Невозможно удалить стол %d, т.к. за ним находятся гости: %s',
                $entityInstance->getId(),
                $guestList
            ));

            // Просто выходим, чтобы удаление не произошло
            return;
        }

        // Если гостей нет — удаляем как обычно
        parent::deleteEntity($entityManager, $entityInstance);
    }
}
