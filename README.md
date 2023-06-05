Tisztelt Oktatási Hivatal,

ez a megoldás EGY lehetséges megoldás, kapásból legalább 3 másik megközelítést tudnék alkalmazni.
Természetesen a lényegi kérdésekben nem különböznének kategorikusan, inkább abban, hogy mely lépések hova kerülnek.
Jelen esetben nagyon tartottam magam egy "spártaian egyszerű" felfogáshoz, azaz _minden_ számítást, gyűjtést a modell végez (vagyis az adja a kérdésekre a válaszokat), de _csak_ annyit csinál minden funckció, ami az adott részfeladathoz kell.
Vagyis maga a modell nem épít egymásra lépéseket (kivétel, ahol a a modell a saját metódusainak eredményeit használja fel), nem barkácsol, nem futtat nagyobb blokkokat - csak egy-egy konkrét gyűjtést, ellenőrzést, számítást.
Jó értelemben konzervatív módon minden "lépéssorrendet", a logikai felépítést stb a kontroller kezeli.
Amellett, hogy ez a klasszikus MVC-felfogás, magam is szeretem - még azon az áron is, hogy így picit elaprózódnak a lépések.
De mint írtam, megbeszélés kérdése, tudok alkalmazkodni a hivatalban honos felfogáshoz (meg tudok érvelni a sajátom mellett is... :D )
Nevezéktan: igyekeztem a szokásos sémát követi, azaz kostansok nagybetűsek, amúgy camelcase nevek, illetve lokális változók aláhúzással kezdődnek. A függvényneveknél is a camelcase írásmódot alkalmaztam a szokásos "get" kezdéssel akkor, ha egy metódus (függvény) egy visszatérési értéket ad (vagyis ebben a feladatban nagyjából mindegyik. :)  ).
Ha valamely elnevezésnél megbicsaklott ez a séma, akkor elnézést, de átnézem én is még.
