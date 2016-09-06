@extends('layouts.app')

@section('content')
    <div id="manual">
        <h1>Manuál</h1>

        <ol>
            <li>
                <strong><a href="#projekt">Projekt</a></strong>
                <ul>
                    <li>nový projekt</li>
                    <li>editace projektu</li>
                    <li>smazání projektu</li>
                </ul>
            </li>
            <li>
                <strong>Úkol</strong>
                <ul>
                    <li>nový úkol</li>
                    <li>editace úkolu</li>
                    <li>smazání úkolu</li>
                </ul>
            </li>
            <li>
                <strong>Uživatelský účet</strong>
                <ul>
                    <li>registrace</li>
                    <li>přihlášení</li>
                    <li>odhlášení</li>
                </ul>
            </li>
            <li>
                <strong>Soubory</strong>
            </li>
            <li>
                <strong>Koš</strong>
            </li>
            <li>
                <strong>Objednávky</strong>
                <ul>
                    <li>nová objednávka</li>
                    <li>seznam objednávek</li>
                    <li>platby</li>
                </ul>
            </li>
        </ol>

        <p id="projekt">
        <h2>Projekt</h2>

        </p>
    </div>
@endsection