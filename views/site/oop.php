<?php

/** @var yii\web\View $this */

$this->title = 'My Yii Application';

interface IMamal
{
    function milkFeeding(IMamal $obj);
}
interface IBird
{
    function flying(IBird $obj);
}
abstract class Animals
{
    public $hasWool = true;
    public $colorWool;
    public $voice = 'sounds';
    public $name;
    public $imageUrl;

    static int $countCreatures = 0;

    public function run()
    {
        return 'it runs';
    }
    public function voice()
    {
        return $this->voice;
    }
    public function getName()
    {
        return $this->name
            ? $this->name
            : 'This animal is nameless';
    }
    public function setName(string $name)
    {
        $this->name = $name;
    }
    public function getImage()
    {
        return $this->imageUrl;
    }
    public function getWoolColor()
    {
        return $this->colorWool
            ? $this->colorWool
            : 'it has no wool';
    }
    public function __construct($name = '', $color = '')
    {
        $this->name = $name;
        $this->colorWool = $color;
        self::$countCreatures++;
    }
}
class Mamal extends Animals implements IMamal
{
    static int $mamalCount = 0;

    public function __construct($p1, $p2)
    {
        parent::__construct($p1, $p2);
        self::$mamalCount++;
    }
    public function milkFeeding(IMamal $obj)
    {
        return 'here\'s your milk';
    }
}
class Feline extends Mamal
{
    public $voice = 'mew';
}
class Bird extends Animals implements IBird
{
    static int $birdCound = 0;
    public function __construct($p1, $p2)
    {
        parent::__construct($p1, $p2);
        self::$birdCound++;
    }
    public function Flying(IBird $obj)
    {
        return 'just flying';
    }
}
class Owl extends Bird
{
    public $voice = 'hoot';
    protected $haveSeenSomeCode;
    public function setHaveSeenSomeCode(bool $haveSeenSomeCode)
    {
        $this->haveSeenSomeCode = $haveSeenSomeCode;
        if ($haveSeenSomeCode === true) {
            $this->setName('Бухля');
        }
        $haveSeenSomeCode === true
            ? $this->imageUrl = 'https://www.meme-arsenal.com/memes/5d49f9c5317bd3547c6e6e5c0ba61667.jpg'
            : $this->imageUrl = 'https://i.pinimg.com/1200x/5c/e1/b2/5ce1b2c7473393a7b4360be900816ffb.jpg';
    }
    public function __construct($p1, $p2, $haveSeenSomeCode = false)
    {
        parent::__construct($p1, $p2);
        $this->setHaveSeenSomeCode($haveSeenSomeCode);
    }
}
class Cat extends Feline
{
    protected $isAngry;
    public function setIsAngry(bool $isAngry)
    {
        $this->isAngry = $isAngry;
        $isAngry === true
            ? $this->imageUrl = 'https://ih1.redbubble.net/image.4700075391.3184/raf,750x1000,075,t,FFFFFF:97ab1c12de.jpg'
            : $this->imageUrl = 'https://memepedia.ru/wp-content/uploads/2020/09/j9evdeijtlq_146987_6.jpg';
    }
    public function __construct($p1, $p2, $isAngry = false)
    {
        parent::__construct($p1, $p2);
        $this->setIsAngry($isAngry);
    }
}
class Canid extends Mamal
{
    public $voice = 'woof';
}
class Fox extends Canid
{
    protected $isTired;
    public function setIsTired(bool $isTired)
    {
        $this->isTired = $isTired;
        $isTired === true
            ? $this->imageUrl = 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/43/Stoned_Fox.jpg/355px-Stoned_Fox.jpg'
            : $this->imageUrl = 'https://thumbs.dreamstime.com/z/fox-%D0%B7%D0%B8%D0%BC%D1%8B-%D0%BA%D1%80%D0%B0%D1%81%D0%BD%D1%8B%D0%B9-%D0%B2-whitehorse-%D1%8E%D0%BA%D0%BE%D0%BD%D0%B5-%D0%BA%D0%B0%D0%BD%D0%B0%D0%B4%D0%B5-103643971.jpg?w=576';
    }
    public function __construct($p1, $p2, $isTired = false)
    {
        parent::__construct($p1, $p2);
        $this->setIsTired($isTired);
    }
}

class Dog extends Canid
{
    protected $isGoodBoy;
    public function setIsGoodBoy(bool $isGoodBoy)
    {
        $this->isGoodBoy = $isGoodBoy;
        $isGoodBoy === true
            ? $this->imageUrl = 'https://pngimg.com/uploads/doge_meme/doge_meme_PNG7.png'
            : $this->imageUrl = 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQS8GPPc8GI8kyIeifBxVSNgNE9jtQSKxAJVw&usqp=CAU';
    }
    public function __construct($p1, $p2, $isGoodBoy = false)
    {
        parent::__construct($p1, $p2);
        $this->setIsGoodBoy($isGoodBoy);
    }
}
$arr = [];
array_push($arr, new Owl('Букля', 'white', false));
// $arr[0]->setHaveSeenSomeCode(true);
array_push($arr, new Fox('Foxy', 'red', false));
// $arr[1]->setIsTired(true);
array_push($arr, new Dog('Doge', 'beige', false));
// $arr[2]->setIsGoodBoy(true);
array_push($arr, new Cat('barsik', 'red', false));
// $arr[3]->setIsAngry(true);
// array_push($arr, new Animals('sharik', 'white'));   
?>
<div class="site-index">

    <div class="body-content">

        <?php foreach ($arr as $animal) : ?>
            <div class="card mb-3 border-0">
                <div class="row g-0 align-items-center">
                    <div class="col-md-2">
                        <img src="<?= $animal->getImage() ?>" class="img-fluid rounded-start" alt="...">
                    </div>
                    <div class="col-md-2">
                        <div class="card-body font-monospace">
                            <h5 class="card-title mb-4">instance of <b><?= $animal::class ?></b></h5>
                            <p class="card-text">
                                name:
                                <span class="text-danger">
                                    <?= $animal->getName() ?>
                                </span>
                            </p>
                            <p class="card-text">
                                wool:
                                <span class="text-danger">
                                    <?= $animal->getWoolColor() ?>
                                </span>
                            </p>
                            <p class="card-text">
                                voice:
                                <span class="text-danger">
                                    <?= strtoupper($animal->voice()) ?>
                                </span>
                            </p>
                            <?= "
                    <a class='btn btn-dark mt-4' href=https://en.wikipedia.org/wiki/" . $animal::class . ">" . $animal::class . " documentation</a>
                    " ?>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <?php
                        dump($animal);
                        ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <div class="row align-items-center font-monospace">
            <p class="fs-1 col-md-4">
                total Animals count: <span class="text-danger"><b><?= Animals::$countCreatures ?></b></span>
            </p>
            <div class="col-md-8">
                <?php
                dump(new ReflectionClass('Animals'));
                ?>
            </div>
        </div>
        <div class="row align-items-center font-monospace">
            <p class="fs-1 col-md-4">
                MAMALS count: <span class="text-danger"><b><?= Mamal::$mamalCount ?></b></span>
            </p>
            <div class="col-md-8">
                <?php
                dump(new ReflectionClass('Mamal'));
                ?>
            </div>
        </div>
        <div class="row align-items-center font-monospace">
            <p class="fs-1 col-md-4">
                BIRD count: <span class="text-danger"><b><?= Bird::$birdCound ?></b></span>
            </p>
            <div class="col-md-8">
                <?php
                dump(new ReflectionClass('Bird'));
                ?>
            </div>
        </div>
        <div class="row justify-md-center align-items-center">
            <code class="col-md-4 h2">$<span class="text-muted">owl</span>-><span class="text-info">flying</span><span class="text-warning">()</span></code>
            <div class="col-md-8">
                <?php
                $new_owl = new Owl(null, null);
                dump($new_owl->flying($new_owl));
                ?>
            </div>
        </div>
        <div class="row justify-md-center align-items-center">
            <code class="col-md-4 h2">$<span class="text-muted">cat</span>-><span class="text-info">run</span><span class="text-warning">()</span></code>
            <div class="col-md-8">
                <?php
                $new_cat = new Cat(null, null);
                dump($new_cat->run());
                ?>
            </div>
        </div>
        <div class="row justify-md-center align-items-center">
            <code class="col-md-4 h2"> $<span class="text-muted">dog</span>-><span class="text-info">milkFeeding</span><span class="text-warning">()</span></code>
            <div class="col-md-8">
                <?php
                $new_dog = new Dog(null, null);
                dump($new_dog->milkFeeding($new_dog));
                ?>
            </div>
        </div>
    </div>

</div>