<?php

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

use Models\Lists\BookTable;
use Models\Lists\AuthorTable;
use Models\Lists\PublisherTable;
use Models\Lists\PublisherTable as Publisher;
use Models\Lists\StoreTable;
use Models\Lists\WikiprofileTable;
use Bitrix\Main\ORM;
use Bitrix\Main\Entity;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\Entity\Query\Join;

//$books = BookTable::getList(
//    [
//        "select" => [
//            "*",
//            'AUTHOR',
//            'PUBLISHER'
////            'WIKIPROFILE'
//        ],
//    'filter' => [
//        'id' => 2
//    ]
////        'runtime' => [
////            new ORM\Fields\ExpressionField('AGE_DAYS', 'DATEDIFF(NOW(), %s)', ['publish_date'])
////        ]
//
//    ]
//)->fetchObject(); //Когда получаю в виде Объекта, но никак не могу получить данные из PUBLISHER
//
//
//pr($books->getPublisher()->getName());
//
////$arr = $books->getAuthor()->getAll();
//
//foreach($books->getAuthor() as $el){
//    pr($el->getName());
//}


//foreach($arr as $el){
//    pr($el->getId());
//}
//pr($books->getAuthor());


//$q = new Entity\Query(BookTable::getEntity());
//$q->addSelect('AUTHOR');
////$q->addSelect('name');
////$q->addSelect(array('ISBN', 'name', 'publish_date'));
////$q->addSelect('publish_date', 'name');
//$q->setFilter(array('=ID' => 2));
//$result = $q->exec();
//
//foreach($result->fetchObject()->getAuthor() as $el){
//    pr($el->getName());
//}

//$result = BookTable::query()
////    ->addSelect('ISBN')
////    ->addSelect('publish_date')
////$q->addSelect('name');
//    ->setSelect(array('ISBN', 'name', 'publish_date'))
//    ->setFilter(array('=ID' => 1))
//    ->exec();
//
//
//pr($result->fetch());


//$q = new Entity\Query(BookTable::getEntity());
////$q->addSelect('AUTHOR');
////$q->addSelect('name');
////$q->addSelect(array('ISBN', 'name', 'publish_date'));
////$q->addSelect('publish_date', 'name');
////$q->setFilter(array('=ID' => 2));
//$q->registerRuntimeField(
//    'PUBLISHER',
//    [
//    'data_type' => Publisher::class,
//    'reference' => ['=this.publisher_id' => 'ref.id'],
//    'join_type' => 'INNER'
//    ]
//);
//$q->addSelect('PUBLISHER');
//$result = $q->exec()->fetchObject();
//
//pr($result->get('PUBLISHER')->getName());//Так работает
//pr($result->getPublisher()->getName());//Так не работает










//pr($books->getId());
//pr($books->getName());
//pr($books->getAgeDays());



//$authors = AuthorTable::getList(
//    [
//        "select" => ["*"]
//    ]
//)->fetchAll();
//
//pr($authors);


//$publishers = PublisherTable::getList(
//    [
//        "select" => ["*"]
//    ]
//)->fetchAll();
//
//pr($publishers);



//$stores = StoreTable::getList(
//    [
//        "select" => ["*"]
//    ]
//)->fetchAll();
//
//pr($stores);


//$wikiProfile = WikiprofileTable::getList(
//    [
//        "select" => ["*"]
//    ]
//)->fetchAll();
//
//pr($wikiProfile);











//Ошибки:
//
//$books = BookTable::getList(
//    [
//        "select" => [
//            "name",
//            "text",
//            "ISBN",
//            'publisher_id',
//            'PUBLISHER'
//        ],
////        'runtime' => [
////            new ORM\Fields\ExpressionField('AGE_DAYS', 'DATEDIFF(NOW(), %s)', ['publish_date'])
////        ]
//        'runtime' => [
//            'PUBLISHER',
//
////            (new Reference('PUBLISHER', Publisher::class, Join::on('this.publisher_id', 'ref.id')))
////                ->configureJoinType('inner')
//            [
//            'data_type' => Publisher::class,
//            'reference' => ['=this.publisher_id', 'ref.id'],
//            'join_type' => 'INNER'
//            ]
//        ]
//    ]
//)->fetchObject(); //Когда получаю в виде Объекта, но никак не могу получить данные из PUBLISHER
//
////pr($books);
////pr($books->get('PUBLISHER')->getName());
//pr($books->getPublisher()->getName());
