<?php
require_once __DIR__ . '/../includes/functions.php';

$company = get_company();

include __DIR__ . '/../includes/header.php';
?>

<section class="section">
    <div class="container">
        <h1 class="section-title">Rólunk - <?php echo e($company['name']); ?></h1>
        
        <div style="max-width: 800px; margin: 0 auto;">
            <h2>Történetünk</h2>
            <p>A hagyományos mesterségbeliség és a modern dizájn iránti szenvedélyből alapított <?php echo e($company['name']); ?> több mint egy évtizede készít egyedi bútorokat <?php echo e($company['region']); ?> területén. Ami kis műhelyként indult, az megbízható névvé vált az egyedi asztalosmunkában, de a minőségre és a személyes szolgáltatásra való elköteleződésünk változatlan maradt.</p>
            
            <p>Úgy gondoljuk, hogy a bútorokat úgy kell készíteni, hogy tartósak legyenek—nem csak évekig, hanem generációkon át. Minden darabot részletekbe menően készítünk, időtálló illesztési technikákkal és prémium anyagokkal, amelyeket fenntartható erdőkből szerzünk be.</p>
            
            <h2>Értékeink</h2>
            <p><strong>Mesterségbeliség:</strong> Büszkék vagyunk munkánkra és soha nem vágunk sarkokat. Minden illesztést gondosan alakítunk, minden felületet kézzel finomítunk, és minden részletet figyelembe veszünk.</p>
            
            <p><strong>Fenntarthatóság:</strong> Elkötelezettek vagyunk a felelős beszerzés és a környezeti felelősségvállalás mellett. Helyi beszállítókkal dolgozunk és olyan anyagokat választunk, amelyek egyszerre szépek és fenntarthatók.</p>
            
            <p><strong>Személyes szolgáltatás:</strong> Az Ön projekte fontos számunkra. Szorosan együttműködünk Önnel az egész folyamat során, a kezdeti konzultációtól a végső kiszerelésig, biztosítva, hogy az Ön elképzelése valósággá váljon.</p>
            
            <p><strong>Minőség:</strong> Csak a legfinomabb anyagokat és időtálló hagyományos technikákat használunk. Bútorainkat arra készítjük, hogy használják, szeressék és továbbadják.</p>
            
            <h2>Mesterségbeliségünk</h2>
            <p>A <?php echo e($company['name']); ?>-nál a hagyományos asztalos technikákat modern dizájn érzékenységgel kombináljuk. Mesterembereink jártasak a következőkben:</p>
            <ul style="margin-left: var(--spacing-lg); margin-bottom: var(--spacing-md);">
                <li>Hagyományos illesztések (farkasfog, tüskés-üreges, ujjillesztés)</li>
                <li>Kézi síkolás és finomítás</li>
                <li>Egyedi hardverek és szerelvények</li>
                <li>Élő szél és természetes fa megőrzése</li>
                <li>Egyedi furnér munkák</li>
                <li>Kárpitozás és finomítás</li>
            </ul>
            
            <h2>Csapatunk</h2>
            <p>Csapatunk képzett mesteremberekből, tervezőkből és projektmenedzserekből áll, akik szenvedélyesen szeretnek szép, funkcionális bútorokat készíteni. Minden tag évek tapasztalatát és a kiválóságra való elköteleződést hozza minden projekthez.</p>
            
            <h2>Szolgáltatási területünk</h2>
            <p>Büszkén szolgáljuk ügyfeleinket <?php echo e($company['region']); ?> területén. Műhelyünk <?php echo e($company['address']['city']); ?>-ban található, ahol tervezzük és készítjük minden darabot. Konzultációs látogatásokat kínálunk otthonába vagy vállalkozásába, és kezeljük a kiszerelést és beépítést szolgáltatási területünkön.</p>
            
            <p>Ha az elsődleges szolgáltatási területünkön kívül van, kérjük, <a href="/contact.php">lépjen velünk kapcsolatba</a> a projekt megbeszéléséhez—lehet, hogy képesek vagyunk kielégíteni az Ön igényeit.</p>
            
            <div class="text-center mt-lg">
                <a href="/contact.php" class="btn">Kapcsolat</a>
                <a href="/portfolio.php" class="btn btn-secondary">Munkáink</a>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
