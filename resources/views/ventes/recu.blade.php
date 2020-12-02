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
         text-align: left;
      }

      caption {
         font-weight: bold;
      }

      .hotel {
         text-align: left;
         font-size: 8px;
      }

   </style>
   <title></title>
</head>

<body>
   <div class="hotel">
      <img src="" alt="logo_hotel">
      <strong>{{ $ventes->first()->code }}</strong><br>
      <strong>Hotel, Inc.</strong>795 Folsom Ave, Suite 600, San Francisco, CA 94107 Phone: (804) 123-5432<br>
      {{ Carbon::now()->format('d-m-Y') }}<br>
      <strong>Client X</strong><br>
      <span>à la table {{ $ventes->first()->tableLinked->numero }}</span>
   </div>
   @php
   $total = 0
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
         @foreach ($ventes as $vente)
            @php
            $total += $vente->prix*$vente->quantite
            @endphp
            <tr>
               <td>{{ $vente->produitLinked->libelle }}</td>
               <td>{{ $vente->quantite }}</td>
               <td>{{ $vente->prix }}</td>
               <td>{{ $vente->quantite * $vente->prix }}</td>
            </tr>
         @endforeach
      </tbody>
      <tfoot>
         <tr>
            <td colspan="3"><b>TOTAL</b></td>
            <td>{{ $total }}</td>
         </tr>
      </tfoot>
   </table>
</body>

</html>
