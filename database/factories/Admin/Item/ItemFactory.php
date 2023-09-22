<?php

namespace Database\Factories\Admin\Item;

use App\Models\Admin\Item\Category;
use App\Models\Admin\Item\Item;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends Factory<\App\Models\Admin\Item\Category>
 */
class ItemFactory extends Factory
{
    protected $model = Item::class;

    private $items = [
        "Звёздная ракета",
        "Магический дракон",
        "Радужный единорог",
        "Автомагнат",
        "Пляжный дельфин",
        "Шерлок Медведь",
        "Сказочная карета",
        "Временная машина",
        "Робо-котенок",
        "Алмазная гирлянда",
        "Путешествие во времени",
        "Космический паук",
        "Динозавр-герой",
        "Ледяной пингвин",
        "Волшебный коврик",
        "Морской приключенец",
        "Воздушный акула",
        "Пиратская сокровищница",
        "Радиоуправляемый вертолет",
        "Замок принцессы",
        "Магнитный лабиринт",
        "Робот-конструктор",
        "Шумный симфония",
        "Чудо-колесо",
        "Джунглевый обитатель",
        "Весёлая летающая тарелка",
        "Аркадная игра",
        "Метеоритная охота",
        "Книга приключений",
        "Супермарио-игра",
        "Полярный медвежонок",
        "Сказочный лес",
        "Часы с приключениями",
        "Вечеринка монстров",
        "Загадочный лабиринт",
        "Робо-паук",
        "Кубик-головоломка",
        "Автогонки на солнце",
        "Сказочный мечтатель",
        "Морские пираты",
        "Летающая свинья",
        "Город будущего",
        "Загадочный бункер",
        "Робо-зверь",
        "Волшебный магазин",
        "Магнитная железная дорога",
        "Астронавт-исследователь",
        "Подводное приключение",
        "Музыкальная ракета",
        "Время приключений",
        "Подарочная коробка с сюрпризом",
        "Красочный конструктор",
        "Динозавр-исследователь",
        "Светящаяся звезда",
        "Волшебное зеркало",
        "Велосипед-время",
        "Пушистый котёнок",
        "Ледяной дворец",
        "Шкатулка с секретом",
        "Космический астронавт",
        "Аркадные приключения",
        "Шар-гигант",
        "Чудо-магнит",
        "Волшебная арфа",
        "Загадочный храм",
        "Робо-собака",
        "Конструктор будущего",
        "Путешествие на Луну",
        "Магическая палочка",
        "Временной портал",
        "Морской путешественник",
        "Замок дракона",
        "Гравитационный лабиринт",
        "Робо-пчела",
        "Кубик-головоломка 2.0",
        "Музыкальный город",
        "Летающий амфибион",
        "Сказочный корабль",
        "Загадочный остров",
        "Робо-крокодил",
        "Космическая галактика",
        "Воздушный дельфин",
        "Аркадная гонка",
        "Приключения в джунглях",
        "Загадочная мельница",
        "Шумный оркестр",
        "Чудо-прокладка",
        "Город монстров",
        "Загадочная комната",
        "Робо-тигр",
        "Магнитный конструктор",
        "Астрономический исследователь",
        "Подводный мир",
        "Звёздный корабль",
        "Ледяное приключение",
        "Волшебная рулетка",
        "Велосипед-путешественник",
        "Пушистый щенок",
        "Черепашья горка",
        "Космическая станция",
        "Загадочный лес",
        "Подземное приключение",
        "Робо-змея",
        "Астронавт-путешественник",
        "Магическая долина",
        "Время космоса",
        "Робо-совершенство",
        "Загадочное подземелье",
        "Подводная экспедиция",
        "Музыкальная феерия",
        "Замок с секретом",
        "Летающий пегас",
        "Подводная история",
        "Сказочная луна",
        "Робо-жираф",
        "Светящийся огонёк",
        "Астронавт-поисковик",
        "Подводное сокровище",
        "Секретная книга",
        "Волшебный сундук",
        "Ледяной мост",
        "Загадочный холм",
        "Робо-бульдозер",
        "Кубик-головоломка 3.0",
        "Сказочный дворец",
        "Подземный мир",
        "Магнитное приключение",
        "Летающий попугай",
        "Робо-компас",
        "Аркадный лабиринт",
        "Загадочная станция",
        "Чудо-подводник",
        "Морская одиссея",
        "Волшебный бумеранг",
        "Секретный код",
        "Робо-дельфин",
        "Загадочная гора 2.0",
        "Временная сокровищница",
        "Летающий дельфин",
        "Сказочная гора",
        "Подземная аркада",
        "Магнитный вихрь",
        "Астронавт-космонавт",
        "Подводное приключение 2.0",
        "Секретный ключ",
        "Волшебный дракон",
        "Симфония времени",
        "Робо-парк",
        "Загадочная пещера",
        "Летающий вертолет",
        "Подземный лабиринт",
        "Магическая палитра",
        "Аркадная атмосфера",
        "Загадочный портал",
        "Чудо-город",
        "Морской мир",
        "Волшебный колокол",
        "Секретная тайна",
        "Робо-серфинг",
        "Загадочная горизонталь",
        "Временной мотоцикл",
        "Летающая летающая тарелка",
        "Сказочная гавань",
        "Подземный король",
        "Магнитное сокровище",
        "Подводное приключение 3.0",
        "Секретный открытый мир",
        "Волшебный свет",
        "Симфония звёзд",
        "Робо-путешественник",
        "Загадочная космическая станция",
        "Летающий волк",
        "Подземный магазин",
        "Магнитная гирлянда",
        "Подводная атака",
        "Шумный космос",
        "Город будущего 2.0",
        "Время динозавров",
        "Магический театр",
        "Волшебный руль",
        "Конструктор мечты",
        "Динозавр-путешественник",
        "Светящийся космос",
        "Волшебный ключ",
        "Велосипед-приключение",
        "Летающий единорог",
        "Магический котёнок",
        "Загадочная шкатулка",
        "Робо-попугай",
        "Город фантазий",
        "Загадочная лагуна",
        "Робо-кролик",
        "Космический летатель",
        "Воздушный змей",
        "Аркадная атака",
        "Приключения во сне",
        "Загадочная ферма",
        "Шумный цирк",
        "Чудо-система",
        "Морской лагерь",
        "Загадочный храм 2.0",
        "Робо-панда",
        "Астрономическая симфония",
        "Подводный лабиринт",
        "Звёздный путь",
        "Ледяная забава",
        "Волшебное зелье",
        "Велосипед-фантазия",
        "Пушистый тигрёнок",
        "Черепашья гонка",
        "Космическая операция",
        "Радиоуправляемый планетарий",
        "Замок секретов",
        "Шерлок Лис",
        "Сказочный остров",
        "Космический скафандр",
        "Приключения в замке",
        "Робо-сова",
        "Загадочный фонтан",
        "Магнитная путаница",
        "Подводный барьер",
        "Шумная гонка",
        "Город футуризма",
        "Загадочная гора",
        "Робо-койот",
        "Конструктор времени",
        "Динозавр-исследователь 2.0",
        "Светящееся сокровище",
        "Волшебная скрижаль",
        "Летающая звезда",
        "Магический меч",
        "Подводный рай",
        "Музыкальное приключение",
        "Загадочный космос",
        "Робо-кенгуру",
        "Кубик-головоломка 4.0",
        "Город игр",
        "Загадочная фабрика",
        "Робо-летучая мышь",
        "Космическая сфера",
        "Загадочная долина",
        "Секретный портфель",
        "Волшебный портал",
        "Летающий ковер",
        "Подводное царство",
        "Робо-подводник",
        "Загадочный холод",
        "Магнитный лес",
        "Астронавт-путешественник 2.0",
        "Подземное сокровище",
        "Секретная карта",
        "Волшебное кольцо",
        "Симфония динозавров",
        "Робо-воздушный шар",
        "Загадочная дорога",
        "Летающий корабль",
        "Сказочный магазин",
        "Подводное сокровище 2.0",
        "Магнитный лабиринт 2.0",
        "Астронавт-исследователь 3.0",
        "Подземная галерея",
        "Секретная атмосфера",
        "Волшебное кольцо 2.0",
        "Симфония путешествий",
        "Робо-магнат",
        "Загадочный океан",
        "Летающая ракета",
        "Сказочное устройство",
        "Подводная магия",
        "Магнитная гонка",
        "Астронавт-исследователь 4.0",
        "Подземный лес",
        "Секретный корабль",
        "Волшебный лес",
        "Симфония мечты",
        "Робо-пират",
        "Загадочная звезда",
        "Летающий змей",
        "Сказочное путешествие",
        "Подводное приключение 4.0",
        "Магнитный сундук",
        "Астронавт-подразведчик",
        "Подземный рай",
        "Секретная звезда",
        "Волшебный букет",
        "Симфония вдохновения",
        "Загадочная планета",
        "Летающий ковш",
        "Сказочное приключение",
        "Подводное царство 3.0",
        "Магнитный космос",
        "Астронавт-путешественник 5.0",
        "Подземный город",
        "Секретный мост",
        "Волшебная сказка",
        "Симфония космоса",
        "Робо-космос",
        "Загадочный оркестр",
        "Летающий космонавт",
        "Сказочная гора 3.0",
        "Подводное приключение 5.0",
        "Магнитное сокровище 3.0",
        "Астронавт-исследователь 6.0",
        "Подземный путь",
        "Секретная гавань",
        "Волшебное колесо",
        "Симфония атмосферы",
        "Робо-магия",
        "Загадочная дверь",
        "Летающий динозавр",
        "Сказочный коридор",
        "Подводная атмосфера 2.0",
        "Магнитный детектив",
        "Астронавт-подразведчик 7.0",
        "Подземная сокровищница",
        "Секретный лес",
        "Волшебное крыло",
        "Симфония фантазии",
        "Робо-маяк",
        "Загадочный берег",
        "Летающий космос",
        "Сказочное сокровище",
        "Подводное приключение 6.0",
        "Магнитный рай",
        "Астронавт-путешественник 8.0",
        "Подземное царство 2.0",
        "Секретный район",
        "Волшебный ключ 2.0",
        "Симфония приключений",
        "Робо-ракета",
        "Загадочный бумеранг",
        "Летающий сфинкс",
        "Сказочная пещера",
        "Подводная лаборатория",
        "Магнитное царство",
        "Астронавт-подразведчик 9.0",
        "Подземное приключение 7.0",
        "Секретный путь",
        "Волшебное колесо 2.0",
        "Симфония путешествий 2.0",
        "Робо-сокровище",
        "Загадочный магазин 2.0",
        "Летающий лабиринт",
        "Сказочный коврик",
        "Подводное приключение 8.0",
        "Магнитный храм",
        "Астронавт-исследователь 10.0",
        "Подземное царство 3.0",
        "Секретный лабиринт",
        "Волшебный портфель",
        "Симфония велосипеда",
        "Робо-время",
        "Загадочный ключ",
        "Летающий фонтан",
        "Сказочное сокровище 2.0",
        "Подводная аркада 2.0",
        "Магнитный город",
        "Астронавт-путешественник 11.0",
        "Подземное приключение 9.0",
        "Секретный замок",
        "Волшебное колесо 3.0",
        "Симфония робота",
        "Робо-путешественник 2.0",
        "Загадочный остров 2.0",
        "Летающий вертолет 2.0",
        "Сказочный ковер 2.0",
        "Подводное приключение 10.0",
        "Магнитное устройство",
        "Астронавт-исследователь 12.0",
        "Подземное царство 4.0",
        "Секретное приключение",
        "Волшебный ключ 3.0",
        "Симфония фантазий",
        "Робо-сокровище 2.0",
        "Загадочный магазин 3.0",
        "Летающий лабиринт 2.0",
        "Сказочный коврик 2.0",
        "Подводное приключение 11.0",
        "Магнитный храм 2.0",
        "Астронавт-исследователь 13.0",
        "Подземное царство 5.0",
        "Секретный лабиринт 2.0",
        "Волшебный портфель 2.0",
        "Симфония велосипеда 2.0",
        "Робо-время 2.0",
        "Загадочный ключ 2.0"
    ];

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        //dump($this->items);
        if (count($this->items) === 0) {
            dd('!stop Items закончились');
        }

        // Выберите случайное название из массива
        $randomIndex = array_rand($this->items);
        $title = $this->items[$randomIndex];

        // Удалите выбранное название из массива
        unset($this->items[$randomIndex]);
        $this->items = array_values($this->items); // Переиндексируйте массив


        $randomCountSymbols = random_int(10, 40);
        return [
            //'title' => $this->faker->jobTitle,
            //'title' => ucfirst(implode(' ', $this->faker->words($randomCount))),
            'title' => $title,
            //'title' => $this->faker->bank(),
            //'title' => $this->faker->realText(100),
            //'note' => $this->faker->realText(5),
            'note' =>  $this->faker->randomElement([null, ucfirst($this->faker->realText($randomCountSymbols))]),
            'article_number' => $this->faker->postcode,
            'price' => $this->faker->numberBetween(50, 100),
            'min_order_amount' => $this->faker->numberBetween(10, 500),
            'img' => $this->faker->loremflickr(
                Storage::disk('uploads'),
                'items',
                300,
                350,
                'toy'
            ),
            //'img' => null,
            'is_new' => $this->faker->randomElement([true, false]),
            'is_hit' => $this->faker->randomElement([true, false]),
            'is_bestseller' => $this->faker->randomElement([true, false]),
        ];
    }
}
