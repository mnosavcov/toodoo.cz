@extends('layouts.app')

@section('content')
    <div id="manual">
        <h1>Manuál</h1>

        <ol>
            <li>
                <strong><a href="#projekt">Projekt</a></strong>
                <ul>
                    <li><a href="#novy-projekt">nový projekt</a></li>
                    <li><a href="#editace-projektu">editace projektu</a></li>
                    <li><a href="#smazani-projektu">smazání projektu</a></li>
                </ul>
            </li>
            <li>
                <strong><a href="#ukol">Úkol</a></strong>
                <ul>
                    <li><a href="#novy-ukol">nový úkol</a></li>
                    <li><a href="#editace-ukolu">editace úkolu</a></li>
                    <li><a href="#smazani-ukolu">smazání úkolu</a></li>
                </ul>
            </li>
            <li>
                <strong><a href="#uzivatelsky-ucet">Uživatelský účet</a></strong>
            </li>
            <li>
                <strong><a href="#soubory">Soubory<a/></strong>
            </li>
            <li>
                <strong><a href="#kos">Koš</></strong>
            </li>
            <li>
                <strong><a href="#objednavky">Objednávky</a></strong>
            </li>
        </ol>

        <h2 id="projekt">Projekt</h2>
        <p>
            Projekt je kontejner obsahující jednotlivé úkoly pro úspěšné dokončení daného projektu.
        </p>
        <p>
            Projekt obsahuje údaje o počtu úkolů ke zpracování a počet úkolů rozpracovaných. Projekt je řazen dle
            priority.
            <br>
            <img src="{{ url('img/manual/projekt.png') }}">
        </p>

        <h3 id="novy-projekt">Nový projekt</h3>
        <p>
            Nový projekt vytvoříte pomocí kliknutní na "Nový projekt" v rozbalovacím menu vedle loga.
            <br>
            <img src="{{ url('img/manual/novy-projekt.png') }}">
        </p>
        <ul>
            <li>Název projektu musí být unikátní</li>
            <li>Klíč musí být unikátní</li>
            <li>další volitelné parametry jsou
                <ul>
                    <li>priorita</li>
                    <li>popis</li>
                    <li>skrytý popis
                        <ul>
                            <li>nastavuje se po rozkliknutí "Upravit skrytý popis"</li>
                            <li>
                                <strong>
                                    důležité na tomto poli je, že nejen, že je skryté, ale obsah je zakódovaný do
                                    nečitelné podoby, můžete si zde uložit informace, které namá nikdo jiný vidět
                                </strong>
                            </li>
                        </ul>
                    </li>
                    <li>soubory</li>
                </ul>
            </li>
        </ul>

        <h3 id="editace-projektu">Editace projektu</h3>
        <p>
            Projekt můžete editovat pomocí kliknutí na "Upravit" v rozbalovacím menu vpravo od názvu projektu. <strong>položky
                jsou stejné jako v případě založení nového projeku</strong><br>
            <img src="{{ url('img/manual/editace-projektu.png') }}">
        </p>

        <h3 id="smazani-projektu">Smazání projektu</h3>
        <p>
            Projekt můžete vložit do koše, kliknutím na "Detail" v rozbalovacím menu vpravo od názvu projektu.<br>
            V detailu projektu kliněte vpravo nahoře do rozbalovacího menu vedle tlačítka "upravit" a klikněte na
            "SMAZAT"<br>
            <strong>Pozor, projekt bude po 30 dnech automaticky nenávratně smazán z koše, vč. úkolů a souborů</strong>
            <br>
            <img src="{{ url('img/manual/smazani-projektu.png') }}">
            <img src="{{ url('img/manual/smazani-projektu-02.png') }}">
        </p>

        {{-- Ukoly --}}

        <h2 id="ukol">Úkol</h2>

        <h3 id="novy-ukol">Nový úkol</h3>
        <p>
            Nový úkol vytvoříte pomocí kliknutní na "Nový úkol" na nástěnce po výběru projektu
            <br>
            <img src="{{ url('img/manual/novy-ukol.png') }}">
        </p>
        <ul>
            <li>Název úkolu nemusí být unikátní</li>
            <li>další volitelné parametry jsou
                <ul>
                    <li>priorita</li>
                    <li>popis</li>
                    <li>skrytý popis
                        <ul>
                            <li>nastavuje se po rozkliknutí "Upravit skrytý popis"</li>
                            <li>
                                <strong>
                                    důležité na tomto poli je, že nejen, že je skryté, ale obsah je zakódovaný do
                                    nečitelné podoby, můžete si zde uložit informace, které namá nikdo jiný vidět
                                </strong>
                            </li>
                        </ul>
                    </li>
                    <li>soubory</li>
                </ul>
            </li>
        </ul>

        <h3 id="editace-ukolu">Editace úkolu</h3>
        <p>
            Úkol můžete editovat pomocí kliknutí na "Upravit" v rozbalovacím menu vpravo od názvu projektu. <strong>položky
                jsou stejné jako v případě založení nového projeku</strong><br>
            V rozbalovacím menu můžete editovat stav úkolu<br>
            <img src="{{ url('img/manual/editace-ukolu.png') }}">
        </p>

        <h3 id="smazani-ukolu">Smazání úkolu</h3>
        <p>
            Úkol můžete vložit do koše, kliknutím na název úkolu, čímž se zobrazí jeho detail<br>
            V detailu úkolu kliněte vpravo nahoře do rozbalovacího menu vedle tlačítka "upravit" a klikněte na
            "SMAZAT"<br>
            <strong>Pozor, úkol bude po 30 dnech automaticky nenávratně smazán z koše, vč. souborů</strong>
            <br>
            <img src="{{ url('img/manual/smazani-ukolu.png') }}">
            <img src="{{ url('img/manual/smazani-ukolu-02.png') }}">
        </p>

        {{-- Uzivatelsky ucet --}}

        <h2 id="uzivatelsky-ucet">Uživatelský účet</h2>
        <p>
            Detail uživatelského účtu zobrazíte kliknutím na "Můj účet" v rozbalovacím menu u Vašeho jména vpravo nahoře
            <br>
            <img src="{{ url('img/manual/uzivatelsky-ucet.png') }}">
        </p>
        <p>
            V detailu účtu můžete pomocí kliknutí na ikonu tužky editovat položky "Jméno", "Heslo", "Aktivní mailing" Vašeho účtu
        </p>
        <p> V detailu účtu jsou zobrazené následující položky
        </p>
        <ul>
            <li>Jméno</li>
            <li>Email</li>
            <li>Aktivní mailing</li>
            <li>Místo pro Vaše soubory</li>
            <li>Odkaz na seznam objednávek</li>
            <li>Odkaz na objednávku místa pro soubory</li>
        </ul>

        {{-- Soubory --}}

        <h2 id="soubory">Soubory</h2>
        <p>
            Seznam souborů zobrazíte pomocí kliknutní na "Soubory" v rozbalovacím menu vedle loga.
            <br>
            <img src="{{ url('img/manual/soubory.png') }}">
        </p>
        <p>
            V seznam souborů jsou vidět soubory vložené k projektům i úkolům. Zde můžete snadno jakýkoli soubor stahnout, zobrazit, nebo smazat
        </p>

        {{-- Kos --}}

        <h2 id="kos">Koš</h2>
        <p>
            Koš zobrazíte pomocí kliknutní na "Koš" v rozbalovacím menu vedle loga.
            <br>
            <img src="{{ url('img/manual/kos.png') }}">
        </p>
        <p>
            V koši jsou projekty a úkoly vložené do koše. <strong>Tyto položky jsou automaticky mazány 30 dní po vložení do koše.</strong><br>
            Položky můžete mazat, ještě před uplynutím 30 denní lhůty, nebo je můžete obnovit.
        </p>

        {{-- Objednavky --}}

        <h2 id="objednavky">Objednávky</h2>
        <p>
            Objednávku můžete vytvořit kliknutím na odkaz "Objednat více místa pro soubory" v detailu Uživatelského účtu<br>
            Zde si můžete objednat větší místo pro Vaše soubory
        </p>
    </div>
@endsection