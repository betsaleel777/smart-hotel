<!DOCTYPE html>
<html lang="fr" dir="ltr">

<head>
    <meta charset="utf-8">
    <style media="screen">
        table {
            border-collapse: collapse;
            width: 90%;
            font-size: 8px
        }

        th,
        td {
            border: 1px solid black;
            width: 20%;
        }

        td {
            text-align: left ;
        }

        caption {
            font-weight: bold ;
        }

        .hotel {
            text-align: left ;
            font-size: 8px ;
        }
    </style>
    <title></title>
</head>

<body>
        <div class="hotel">
          <img src="" alt="logo_hotel">
          <strong>{{$facture->reference}}</strong><br>
          {{Carbon::now()->format('d-m-Y')}}<br>
            @if ($facture->clientLinked)
            {{$facture->clientLinked->nom.' '.$facture->clientLinked->prenom}}<br>
            Hotel Oni-sakon, Rue 600<br> Abidjan marcory, BP 654<br>
            {{-- Phone: (225) {{$facture->clientLinked->contact}}<br>
            {{$facture->clientLinked->pieceLinked->libelle}}:{{$facture->clientLinked->numero_piece}} --}}
            @else
            <strong>Client X</strong><br>
            @endif
        </div>
    @php
    $total_restauration = 0 ;
    if($facture->sejourLinked){
    $produits = $facture->sejourLinked->produits ;
    $attribution = $facture->sejourLinked->sejourLinked ;
    $etat = $facture->sejourLinked->etat ;
    $batiment = $facture->sejourLinked->batimentLinked ;
    $temps = 'Jours' ;
    }else{
    $produits = $facture->passageLinked->produits ;
    $attribution = $facture->passageLinked->passageLinked ;
    $etat = $facture->passageLinked->etat ;
    $batiment = $facture->passageLinked->batimentLinked ;
    $temps = 'Heures' ;
    }
    @endphp
    <table>
        <thead>
            <tr>
                <th>Produit</th>
                <th>Quantité</th>
                <th>Prix Unitaire</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @if ($produits)
            @foreach ($produits as $produit)
            @php
            $total_restauration += $produit->pivot->quantite*$produit->pivot->prix
            @endphp
            <tr>
                <td>{{$produit->reference}} {{$produit->libelle}}</td>
                <td>{{$produit->pivot->quantite}}</td>
                <td>{{$produit->pivot->prix}}</td>
                <td>{{$produit->pivot->quantite*$produit->pivot->prix}}</td>
            </tr>
            @endforeach
            @endif
            @php
            $cout_brut_chambre = $facture->prix_unitaire*$facture->quantite ;
            @endphp
            <tr>
                <td>{{$attribution->chambreLinked->typeLinked->libelle}} {{$attribution->chambreLinked->libelle}}</td>
                <td>{{$facture->quantite}} {{$temps}}</td>
                <td>{{$facture->prix_unitaire}}</td>
                <td>{{$cout_brut_chambre}}</td>
            </tr>
        </tbody>
        <tfoot>
        <tr>
            <td colspan="3"><b>TOTAL</b></td>
            <td>{{ $total_restauration + $cout_brut_chambre }}</td>
        </tr>
        </tfoot>
    </table>
</body>

</html>
