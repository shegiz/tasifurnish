<?php
require_once __DIR__ . '/../includes/functions.php';

$company = get_company();

include __DIR__ . '/../includes/header.php';
?>

<section class="section">
    <div class="container">
        <h1 class="section-title">Rólunk - <?php echo e($company['name']); ?></h1>
        <div style="max-width: 800px; margin: 0 auto;">
            <p>Cégünk 2019 óta foglalkozik egyedi bútorok tervezésével és gyártásával, azonban a személyes, szakma iránti elköteleződésem ennél jóval régebbre nyúlik vissza. Több mint 30 éve dolgozom az egyedi bútorok világában, ahol a minőség, a precizitás és az ügyfél elképzeléseinek maradéktalan megvalósítása mindig elsődleges szempont volt. Minden általunk készített bútor egyedi tervezés eredménye, amely a funkcionalitást és az esztétikát ötvözi, legyen szó konyháról, nappaliról, hálószobáról vagy teljes belsőépítészeti megoldásról.</p>
            <p>Célunk, hogy időtálló, személyre szabott bútorokat alkossunk, amelyek hosszú távon is értéket képviselnek. Hiszünk abban, hogy az igazi minőség a részletekben rejlik. Gondos tervezés, válogatott alapanyagok és precíz kivitelezés – ezek mentén készülnek bútoraink.</p>
        </div>
    </div>
</section>
<section class="section separator v2"></section>
<section class="section">
    <div class="container">
        <h1 class="section-title">Szolgáltatási területünk</h1>
        <div style="max-width: 800px; margin: 0 auto;">
            <p>Büszkén szolgáljuk ügyfeleinket <?php echo e($company['region']); ?> területén. Műhelyünk <?php echo e($company['address']['city']); ?>en található. </p>
            
            <p>Ha az elsődleges szolgáltatási területünkön kívül van, kérjük, <a href="/contact.php">lépjen velünk kapcsolatba</a> a projekt megbeszéléséhez—lehet, hogy képesek vagyunk kielégíteni az Ön igényeit.</p>
            
            <div class="text-center mt-lg">
                <a href="/contact.php" class="btn">Kapcsolat</a>
                <a href="/portfolio.php" class="btn btn-secondary">Munkáink</a>
            </div>
        </div>
    </div>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
