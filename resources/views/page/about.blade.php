@extends('layouts.app')

@section('content')
    <h1>O projektu</h1>
    <p>
        Projek je vytvořený pro snadnou správu projektů a úkolů.
    </p>

    <h2>Proč TooDoo.cz?</h2>
    <p>
        Tento projekt vzniknul pro možnost snadné a jednoduché správy projektů. Neustále se dále vyvíjí s maximálním
        zaměřením co nejvíce zjednodušit a zpřehlednit uživatelské rozhraní. Pokud máte rádi jednoduché a transparentní
        ovládání určitě je pro Vás TooDoo.cz skvělá volba.
    </p>

    <h2>Bezpečnost</h2>
    <p>
        Bezpečnost je pro nás důležitá i proto běží web na https protokolu, který zajišťuje, že při komunikaci
        se
        serverem není možné data odposlouchat ani je cestou změnit.<br>
        <br>
        <strong>
            Další bezpečnostní prvek je možnost vytvořit skrytý popis u projektu i úkolu, který se nejen
            zobrazuje na vyžádání kliknutím na odkaz zobrazit, ale data ve skrytém popisu jsou v úložišti jsou
            navíc kryptována tak, že není možné je přečíst, ani rozkódovat.
        </strong>
    </p>

    <h2>Data</h2>
    <p>
        Veškerá data (s výjimkou vložených souborů) jsou 2x denně zálohována. Tím je zajištěno, že o své zadané projekty nepřijdete.
    </p>

    <h2>Cena</h2>
    <p>
        Užívání portálu a všech jeho součástí je zdarma. Místo pro Vaše soubory je však omezené a je možné
        dokoupit
        si
        další prostor. Nicméně není povinné si místo pořídit a soubory je možné vložit na jiné úložiště a do
        úkolu
        nebo
        projektu vložit odkaz na soubory popisu.
    </p>
@endsection