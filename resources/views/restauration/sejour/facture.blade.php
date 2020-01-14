<!DOCTYPE html>
<html lang="fr" dir="ltr">

<head>
    <meta charset="utf-8">
    <title></title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <style >
        #invoice {
            padding: 30px;
        }

        .invoice {
            position: relative;
            background-color: #FFF;
            min-height: 680px;
            padding: 15px
        }

        .invoice header {
            padding: 10px 0;
            margin-bottom: 20px;
            border-bottom: 1px solid #3989c6
        }

        .invoice .company-details {
            text-align: right
        }

        .invoice .company-details .name {
            margin-top: 0;
            margin-bottom: 0
        }

        .invoice .contacts {
            margin-bottom: 20px
        }

        .invoice .invoice-to {
            text-align: left
        }

        .invoice .invoice-to .to {
            margin-top: 0;
            margin-bottom: 0
        }

        .invoice .invoice-details {
            text-align: right
        }

        .invoice .invoice-details .invoice-id {
            margin-top: 0;
            color: #3989c6
        }

        .invoice main {
            padding-bottom: 50px
        }

        .invoice main .thanks {
            margin-top: -100px;
            font-size: 2em;
            margin-bottom: 50px ;
            color: green
        }

        .invoice main .notices {
            padding-left: 6px;
            border-left: 6px solid #3989c6
        }

        .invoice main .notices .notice {
            font-size: 1.2em
        }

        .invoice table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 20px
        }

        .invoice table td,
        .invoice table th {
            padding: 15px;
            background: #eee;
            border-bottom: 1px solid #fff
        }

        .invoice table th {
            white-space: nowrap;
            font-weight: 400;
            font-size: 16px
        }

        .invoice table td h3 {
            margin: 0;
            font-weight: 400;
            color: #3989c6;
            font-size: 1.2em
        }

        .invoice table .qty,
        .invoice table .total,
        .invoice table .unit {
            text-align: right;
            font-size: 1.2em
        }

        .invoice table .no {
            color: #fff;
            font-size: 1.6em;
            background: #3989c6
        }

        .invoice table .unit {
            background: #ddd
        }

        .invoice table .total {
            background: #3989c6;
            color: #fff
        }

        .invoice table tbody tr:last-child td {
            border: none
        }

        .invoice table tfoot td {
            background: 0 0;
            border-bottom: none;
            white-space: nowrap;
            text-align: right;
            padding: 10px 20px;
            font-size: 1.2em;
            border-top: 1px solid #aaa
        }

        .invoice table tfoot tr:first-child td {
            border-top: none
        }

        .invoice table tfoot tr:last-child td {
            color: #3989c6;
            font-size: 1.4em;
            border-top: 1px solid #3989c6
        }

        .invoice table tfoot tr td:first-child {
            border: none
        }

        .invoice footer {
            width: 100%;
            text-align: center;
            color: #777;
            border-top: 1px solid #aaa;
            padding: 8px 0
        }

        @mediaprint {
            .invoice {
                font-size: 11px !important;
                overflow: hidden !important
            }

            .invoice footer {
                position: absolute;
                bottom: 10px;
                page-break-after: always
            }

            .invoice>div:last-child {
                page-break-before: always
            }
        }
    </style>
</head>
<body>
    <div id="invoice">
        <div class="invoice overflow-auto">
            <div style="min-width: 600px">
                <header>
                    <div class="row">
                        <div class="col">
                            <a target="_blank" href="https://lobianijs.com">
                                <img src="http://lobianijs.com/lobiadmin/version/1.0/ajax/img/logo/lobiadmin-logo-text-64.png" data-holder-rendered="true" />
                            </a>
                        </div>
                        <div class="col company-details">
                            <h2 class="name">
                                <a target="_blank" href="https://lobianijs.com">
                                    Nom d'hotel
                                </a>
                            </h2>
                            <div>455 Foggy Heights, AZ 85004, US</div>
                            <div>(123) 456-789</div>
                            <div>hotel@example.com</div>
                            </div>
                        </div>
                </header>
                <main>
                    <div class="row contacts">
                        <div class="col invoice-to">
                            <div class="text-gray-light">PROFORMA POUR:</div>
                            <h2 class="to">{{$attribution->sejourLinked->clientLinked->nom.' '.$attribution->sejourLinked->clientLinked->prenom}}</h2>
                            <div class="address">{{$attribution->sejourLinked->clientLinked->pieceLinked->libelle.': '.$attribution->sejourLinked->clientLinked->numero_piece}}</div>
                            <div class="email"><a href=""></a>{{$attribution->sejourLinked->clientLinked->contact}}</div>
                        </div>
                        <div class="col invoice-details">
                            <h1 class="invoice-id">{{$attribution->encaissement->reference}}</h1>
                            <div class="date">Date de proforma: {{Carbon::now()->format('D-M-Y')}}</div>
                            <div class="date">échéance: {{$attribution->sejourLinked->fin->format('D-M-Y')}}</div>
                        </div>
                    </div>
                    <table border="0" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-left">DESCRIPTION</th>
                                <th class="text-right">PRIX UNITAIRE</th>
                                <th class="text-right">QUANTITE</th>
                                <th class="text-right">TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($attribution->produits as $key => $produit)
                              <tr>
                                  <td class="no">{{$key+1}}</td>
                                  <td class="text-left">
                                      <h3>
                                          <a target="" href="">
                                              {{$produit->libelle}}
                                          </a>
                                      </h3>
                                      <a target="" href="">
                                          {{$produit->reference}}
                                      </a>
                                      {{-- to improve your Javascript skills. Subscribe and stay tuned :) --}}
                                  </td>
                                  <td class="unit">{{$produit->pivot->prix}}</td>
                                  <td class="qty">{{$produit->pivot->quantite}}</td>
                                  <td class="total">{{$produit->pivot->prix*$produit->pivot->quantite}}</td>
                              </tr>
                            @endforeach
                            <tr>
                                <td class="no">-</td>
                                <td class="text-left">
                                    <h3>
                                        <a target="" href="">
                                            {{$attribution->sejourLinked->chambreLinked->libelle}}
                                        </a>
                                    </h3>
                                    <a target="" href="">
                                        {{$attribution->sejourLinked->chambreLinked->typeLinked->libelle}}
                                    </a>
                                    {{-- to improve your Javascript skills. Subscribe and stay tuned :) --}}
                                </td>
                                <td class="unit">{{$attribution->encaissement->prix_unitaire}}</td>
                                <td class="qty">{{$attribution->encaissement->quantite}}Jours</td>
                                <td class="total">{{$attribution->encaissement->quantite*$attribution->encaissement->prix_unitaire}}</td>
                            </tr>
                        </tbody>
                         @php
                           $brute = $attribution->encaissement->quantite*$attribution->encaissement->prix_unitaire ;
                           $remise = ($attribution->encaissement->remise/100)*$brute ;
                           $payer_chambre = (double)$brute - (double)$remise ;
                           $avance = ($attribution->encaissement->avance/100)*$brute ;
                           $reste_chambre = (double)$payer_chambre - (double)$avance ;
                           $subtotal = 0 ;
                           $grand_total = 0 ;
                           foreach ($attribution->produits as $produit) {
                              $subtotal += $produit->pivot->prix*$produit->pivot->quantite ;
                           }
                           $grand_total = $subtotal + $reste_chambre ;
                         @endphp
                        <tfoot>
                            <tr>
                                <td colspan="2"></td>
                                <td colspan="2">TOTAL ARTICLES CONSOMME</td>
                                <td>{{$subtotal.'Fcfa'}}</td>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                                <td colspan="2">COUT BRUTE CHAMBRE </td>
                                <td>{{$brute}}</td>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                                <td colspan="2">REMISE</td>
                                <td>-{{$remise.'('.$attribution->encaissement->remise.'%)'}}</td>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                                <td colspan="2">PRIX NET CHAMBRE</td>
                                <td>{{$payer_chambre}}</td>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                                <td colspan="2">AVANCE CHAMBRE</td>
                                <td>{{$avance}}</td>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                                <td colspan="2">NET A PAYER CHAMBRE</td>
                                <td>{{$reste_chambre}}</td>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                                <td colspan="2">VERSEMENT CAISSE</td>
                                <td>{{$reste_chambre}}</td>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                                <td colspan="2">TOTAL VERSEMENT</td>
                                <td>{{$grand_total}}</td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="thanks">PAYER</div>
                    <div class="notices">
                        <div>NB:</div>
                        <div class="notice">Après la date de validité si la facture est impayé, le client sera amendé de 1.5% du total par jour de retard.</div>
                    </div>
                </main>
                <footer>
                    Cette facture a été crée à l'ordinateur, une signature écrite doit y être pour confirmer sa validité
                </footer>
            </div>
            <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
            <div></div>
        </div>
    </div>
</body>
</html>
