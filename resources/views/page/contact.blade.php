@extends('layouts.app')

@section('content')
    <style>
        td{
            border-top: none!important;
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <h1>Kontakt</h1>

                <table class="table">
                    <tr>
                        <td class="col-xs-2"><strong>telefon:</strong></td>
                        <td class="col-xs-10">+420&nbsp;603&nbsp;323&nbsp;878</td>
                    </tr>
                    <tr>
                        <td><strong>email:</strong></td>
                        <td>info@toodoo.cz</td>
                    </tr>
                    <tr>
                        <td><strong>provozovatel:</strong></td>
                        <td>
                            Michal&nbsp;Nosavcov<br>
                            Nad&nbsp;Babím&nbsp;dolem&nbsp;401<br>
                            250&nbsp;64&nbsp;Měšice<br>
                            IČ:&nbsp;64845915
                        </td>
                    </tr>
                    <tr>
                        <td class="col-xs-2"><strong>číslo účtu:</strong></td>
                        <td class="col-xs-10">2301045287/2010</td>
                    </tr>
                </table>

            </div>
        </div>
    </div>
@endsection