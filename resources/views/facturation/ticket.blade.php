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
            text-align: center;
        }

        caption {
            font-weight: bold
        }

        center {
            font-size: 7px
        }
    </style>
    <title></title>
</head>

<body>
    <center>
        <img src="" alt="logo_hotel">
        <strong>{{$facture->reference}}</strong>
        <b>Date:</b>{{Carbon::now()->format('d-m-Y')}}<br>
        <strong>Nom d'hotel</strong><br>
        <strong>Adresse</strong>:<br>
        <strong>Email</strong>:<br>
        <strong>Contact</strong>:<br>
        <strong>Au client</strong>
        <adress>
            @if ($facture->clientLinked)
            {{$facture->clientLinked->nom.' '.$facture->clientLinked->prenom}}<br>
            {{-- 795 Folsom Ave, Suite 600<br> San Francisco, CA 94107<br> --}}
            Phone: (225) {{$facture->clientLinked->contact}}<br>
            {{$facture->clientLinked->pieceLinked->libelle}}:{{$facture->clientLinked->numero_piece}}
            @else
            <strong>Client X</strong><br>
            @endif
        </adress>
    </center>
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
                <th>Qte</th>
                <th>Produit</th>
                <th>PU</th>
                <th>subtototal</th>
            </tr>
        </thead>
        <tbody>
            @if ($produits)
            @foreach ($produits as $produit)
            @php
            $total_restauration += $produit->pivot->quantite*$produit->pivot->prix
            @endphp
            <tr>
                <td>{{$produit->pivot->quantite}}</td>
                <td><b>{{$produit->reference}}</b> {{$produit->libelle}}</td>
                <td>{{$produit->pivot->prix}}</td>
                <td>{{$produit->pivot->quantite*$produit->pivot->prix}}</td>
            </tr>
            @endforeach
            @endif
            @php
            $cout_brut_chambre = $facture->prix_unitaire*$facture->quantite ;
            @endphp
            <tr>
                <td>{{$facture->quantite}} {{$temps}}</td>
                <td>{{$attribution->chambreLinked->libelle}}:{{$attribution->chambreLinked->typeLinked->libelle}},<em>{{$batiment->libelle}}</em></td>
                <td>{{$facture->prix_unitaire}}</td>
                <td>{{$cout_brut_chambre}}</td>
            </tr>
        </tbody>
    </table>
</body>

</html>
